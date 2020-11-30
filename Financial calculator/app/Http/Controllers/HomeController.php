<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\User;
use Master;

class HomeController extends Controller
{
    public function index() {

    	return view('home');
    }

    public function currentuser() {

        $user = Auth::user();
        $user->role = $user ? $user->getRole() : '';        

        return $user;
    }

    public function gettable($company_id, $user_user = null, $type = '') {

        $id = $company_id;
        $data = [];

        $db_company = DB::table('companies')
                            ->where('id', $id)
                            ->first();
        $db_company_data = DB::table('company_data')
                            ->where('company_id', $id)
                            ->first();
        $db_order = DB::table('order')
                            ->where('company_id', $id)
                            ->first();
        $db_formula = DB::table('formulas')
                            ->where('company_id', $id)
                            ->first();
        $indicators_data = DB::table('indicators')->get();
        $indicators = [];
        foreach ($indicators_data as $key => $value) {
            $indicators[$value->id] = $value->name;
        }

        $arr_order = $db_order ? json_decode($db_order->order, true) : [];
        $year_finish = $db_company->yearfinish;
        $currency = $db_company->currency;
        $units = $db_company->units;
        $arr_units = config('app.units');
        $arr_currency = config('app.currency');

        $period_data = $db_company_data ? json_decode($db_company_data->period, true) : [];
        $indicator_data = $db_company_data ? json_decode($db_company_data->indicator, true) : [];
        $s_table_data = session('tabledata-'.$type.$id);

        $db_table_data = $db_company_data ? json_decode($db_company_data->table, true) : [];
        if(isset($s_table_data) && !empty($s_table_data)) {
            $table_data = $s_table_data;
        } else {
            $table_data = $db_table_data;
        }

        $formula_data = $db_formula ? json_decode($db_formula->formula, true) : [];

        $periodicity = $period_data['periodicity'];
        $yearstart = $period_data['yearstart'];
        $yearend = $period_data['yearend'];        
        $periodstart = $period_data['periodstart'];        
        $periodend = $period_data['periodend'];

        $arr_years = range($yearstart, $year_finish);
        $periodicity_items = config('app.periodicity_items');

        $arr_year_period = [];

        if(Auth::user()) {
            if(Auth::user()->hasRole(config('app.roleAdmin'))) {
                $is_admin = 1;
            } else {
                $is_admin = 0;
            }
        } else {
           $is_admin = 0; 
        }

        foreach ($arr_years as $key => $_year) {
            if($key == 0) {
                if($periodicity < 12) {
                    $periodicity_items_start = array_slice($periodicity_items[$periodicity], $periodstart,count($periodicity_items[$periodicity]) - $periodstart, true);
                    foreach ($periodicity_items_start as $_key => $_period) {
                        $arr_year_period[] = [
                            'year' => $_year,
                            'period' => $_key,
                            'periodicity' => $periodicity,
                        ];
                    }
                }
                if($periodicity == 12) {
                    $arr_year_period[] = [
                        'year' => $_year,
                        'period' => 0,
                        'periodicity' => $periodicity,
                    ];
                }
            } else {
                foreach ($periodicity_items[$periodicity] as $_key => $_period) {
                    $arr_year_period[] = [
                        'year' => $_year,
                        'period' => $_key,
                        'periodicity' => $periodicity,
                    ];
                }
            }
        }

        $_table_data = [];

        for($row = 0; $row <= count($arr_order); $row ++) {
            for($col = 0; $col <= count($arr_year_period); $col ++) {               

                if($row != 0 && $col != 0) {

                    if($arr_order[$row-1]['type'] == 'indicator') {
                        if(isset($table_data[$arr_order[$row-1]['value']][$arr_year_period[$col-1]['year']][$arr_year_period[$col-1]['periodicity']][$arr_year_period[$col-1]['period']])) {
                            $_table_data[$arr_order[$row-1]['value']][$arr_year_period[$col-1]['year']][$arr_year_period[$col-1]['periodicity']][$arr_year_period[$col-1]['period']] = $table_data[$arr_order[$row-1]['value']][$arr_year_period[$col-1]['year']][$arr_year_period[$col-1]['periodicity']][$arr_year_period[$col-1]['period']];
                            $_value = $table_data[$arr_order[$row-1]['value']][$arr_year_period[$col-1]['year']][$arr_year_period[$col-1]['periodicity']][$arr_year_period[$col-1]['period']];                                                            
                        } else {
                            $_table_data[$arr_order[$row-1]['value']][$arr_year_period[$col-1]['year']][$arr_year_period[$col-1]['periodicity']][$arr_year_period[$col-1]['period']] = $_value;
                        }
                    }
                }
            }
        }

        for($row = 0; $row <= count($arr_order); $row ++) {
            for($col = 0; $col <= count($arr_year_period); $col ++) {
                if($row == 0) {
                    if($col == 0) {
                        $data[$row][$col] = [
                            'type' => 'year',
                            'year' => 1,
                            'show' => 0
                        ];
                    } else {
                        if($arr_year_period[$col-1]['periodicity'] < 12) {
                            $periodvalue = $periodicity_items[$arr_year_period[$col-1]['periodicity']][$arr_year_period[$col-1]['period']];
                        } else {
                            $periodvalue = '';
                        }                        
                        $data[$row][$col] = [
                            'type' => 'year',
                            'show' => 1,
                            'year' => 1,
                            'yearvalue' => $arr_year_period[$col-1]['year'],
                            'period' => $arr_year_period[$col-1]['period'],
                            'periodvalue' => $periodvalue,
                            'currency' => $arr_currency[$currency],
                            'units' => $arr_units[$units],
                        ];
                    }
                } else {
                    if($col == 0) {
                        if($arr_order[$row-1]['type'] == 'empty') {
                            $data[$row][$col] = [
                                'type' => 'empty',
                                'show' => 0,
                                'style' => 0,
                                'styleboldvalue' => 0,
                                'styleitalicvalue' => 0,
                            ];
                        }
                        if($arr_order[$row-1]['type'] == 'indicator') {
                            $data[$row][$col] = [
                                'type' => 'indicator',
                                'show' => 1,
                                'indicator' => 1,
                                'indicatorvalue' => $arr_order[$row-1]['value'],
                                'indicatorname' => $indicators[$arr_order[$row-1]['value']],
                                'style' => $arr_order[$row-1]['style'],
                                'styleboldvalue' => $arr_order[$row-1]['styleboldvalue'],
                                'styleitalicvalue' => $arr_order[$row-1]['styleitalicvalue'],
                            ];
                        }
                        if($arr_order[$row-1]['type'] == 'formula') {
                            $data[$row][$col] = [
                                'type' => 'formula',
                                'show' => 1,
                                'formula' => 1,
                                'formulavalue' => $arr_order[$row-1]['value'],
                                'formulaname' => $arr_order[$row-1]['name'],
                                'style' => $arr_order[$row-1]['style'],
                                'styleboldvalue' => $arr_order[$row-1]['styleboldvalue'],
                                'styleitalicvalue' => $arr_order[$row-1]['styleitalicvalue'],
                            ];
                        }                        
                    } else {
                        if($arr_order[$row-1]['type'] == 'empty') {
                            $data[$row][$col] = [
                                'type' => 'empty',
                                'show' => 0,
                                'style' => 0,
                                'styleboldvalue' => 0,
                                'styleitalicvalue' => 0,
                            ];
                        }
                        if($arr_order[$row-1]['type'] == 'indicator') {
                            if(isset($table_data[$arr_order[$row-1]['value']][$arr_year_period[$col-1]['year']][$arr_year_period[$col-1]['periodicity']][$arr_year_period[$col-1]['period']])) {
                                $inputvalue = $table_data[$arr_order[$row-1]['value']][$arr_year_period[$col-1]['year']][$arr_year_period[$col-1]['periodicity']][$arr_year_period[$col-1]['period']];
                                $_inputvalue = $inputvalue;
                                if(isset($db_table_data[$arr_order[$row-1]['value']][$arr_year_period[$col-1]['year']][$arr_year_period[$col-1]['periodicity']][$arr_year_period[$col-1]['period']])) {
                                    $readonly = 1;
                                } else {
                                    $readonly = 0;
                                }                                
                            } else {
                                $inputvalue = $_inputvalue;
                                $readonly = 0;
                            }
                            if($user_user === 0 || $user_user === -1) {
                                $readonly = 1;
                            }
                            if($is_admin === 1) {
                                $readonly = 1;
                            }
                            $data[$row][$col] = [
                                'type' => 'input',
                                'show' => 1,
                                'input' => 1,
                                'indicatorvalue' => $arr_order[$row-1]['value'],
                                'yearvalue' => $arr_year_period[$col-1]['year'],
                                'periodicity' => $arr_year_period[$col-1]['periodicity'],
                                'period' => $arr_year_period[$col-1]['period'],
                                'inputvalue' => $inputvalue,
                                'readonly' => $readonly,                                
                                'style' => $arr_order[$row-1]['style'],
                                'styleboldvalue' => $arr_order[$row-1]['styleboldvalue'],
                                'styleitalicvalue' => $arr_order[$row-1]['styleitalicvalue'],
                            ];
                        }
                        if($arr_order[$row-1]['type'] == 'formula') {
                            $data[$row][$col] = [
                                'type' => 'formula',
                                'show' => 1,
                                'formularesult' => 1,
                                'formula' => $arr_order[$row-1]['value'],
                                'formularesult' => Master::formularesult($arr_order[$row-1]['value'], $formula_data, $_table_data, $arr_year_period[$col-1]['year'], $arr_year_period[$col-1]['periodicity'], $arr_year_period[$col-1]['period']),
                                'style' => $arr_order[$row-1]['style'],
                                'styleboldvalue' => $arr_order[$row-1]['styleboldvalue'],
                                'styleitalicvalue' => $arr_order[$row-1]['styleitalicvalue'],
                            ];
                        }
                    } 
                }
            }
        }

        session(['tabledata-'.$type.$id => $_table_data]);

        return $data;
    }


    public function changetable($data, $id, $type = '') {

        $data = json_decode($data, true);
        $line = 0;

        $_data = session('tabledata-'.$type.$id);

        foreach ($_data as $indicator_key => $item) {
            foreach ($item as $year_key => $_item) {
                foreach ($_item as $periodicity_key => $arr) {
                    foreach ($arr as $period_key => $item_arr) {
                        if($indicator_key == $data['indicator'] && $year_key == $data['year'] && $periodicity_key == $data['periodicity'] && $period_key == $data['period']) {                            
                            $line = 1;
                        }
                        if($indicator_key == $data['indicator'] && $line == 1) {
                            $_data[$indicator_key][$year_key][$periodicity_key][$period_key] = $data['value'];
                        }
                    }
                }
            }
        }

        session(['tabledata-'.$type.$id => $_data]);
        
        $user_user = ($type == 'office') ? $user_user = 1 : null;

        $data = $this->gettable($id, $user_user, $type);

        return $data;
    }

    public function zerotable($id, $type = '') {

        session(['tabledata-'.$type.$id => []]);
        $data = $this->gettable($id);

        return $data;
    }

    public function createforecast($id) {

        $user_id = Auth::id();
        if(!$user_id) {
            return 0;
        }

        return $user_id;
    }

    public function saveforecast($data, $id, $type = '') {

        $user_id = Auth::id();
        
        $table = json_encode(session('tabledata-'.$type.$id));
        $overview = $data;

        DB::table('forecasts')
            ->updateOrInsert(
                ['user_id' => $user_id, 'company_id' => $id],
                ['table' => $table, 'overview' => $overview, 'created_at' => NOW(), 'updated_at' => NOW()]
            );

        $this->addcomment('**_add_forecast_**', $parent = 0, $id, $update = 1, $visible = 0);

        return 1;
    }

    public function forecasts($id) {        

        $data = [];

        $db_data = DB::table('users')
            ->join('forecasts', 'forecasts.user_id', '=', 'users.id')
            ->select('users.name as user_name', 'users.id as user_id', 'forecasts.id as forecast_id', 'forecasts.overview as forecast_overview', 'forecasts.created_at as forecast_date')
            ->where('forecasts.company_id', $id)
            ->orderBy('forecasts.created_at', 'desc')          
            ->get();

        if($db_data) {
            foreach ($db_data as $key => $item) {
                $db_data[$key]->forecast_overview = Master::shorttext(str_replace('<br>', ' ', $item->forecast_overview), 26);
                $db_data[$key]->forecast_date = 'created on '.date('j F Y', strtotime($item->forecast_date));
                $db_data[$key]->stylebold = 0;
            }
        }        

        return $db_data;
    }

    public function forecast($user, $company_id, $type = '') {

        $current_user = Auth::id();
        if(!$current_user) {
           $user_user = -1; 
        } 
        if($current_user && $current_user == $user) {
            $user_user = 1;
        }
        if($current_user && $current_user != $user) {
            $user_user = 0;
        }
        
        $db_data = DB::table('forecasts')
                        ->where(['user_id' => $user, 'company_id' => $company_id])
                        ->first();
        session(['tabledata-'.$type.$company_id => json_decode($db_data->table, true)]);

        $data['table'] = $this->gettable($company_id, $user_user, $type);
        $data['overview'] = $db_data->overview;

        return $data;
    }

    public function addcomment($data, $parent = 0, $id, $update = 0, $visible = 1) {

        $user_id = Auth::id();

        $_visible = $visible ? '1' : '0'; 

        if($update) {
            DB::table('comments')
                ->updateOrInsert(
                    [
                        'company_id' => $id,
                        'user_id' => $user_id,
                        'parent' => $parent,
                        'comment' => $data,
                    ],
                    [                        
                        'visible' => $_visible,
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ]
                );
        } else {
            DB::table('comments')
                ->insert(
                    [
                        'company_id' => $id,
                        'user_id' => $user_id,
                        'parent' => $parent,
                        'comment' => $data,
                        'visible' => $_visible,
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ]
                );
        }       

        return 1;
    }

    public function comments($id) {        

        $db_comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->join('role_user', 'comments.user_id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('users.name as user_name', 'users.id as user_id', 'comments.id', 'comments.parent', 'comments.comment', 'comments.created_at as date', 'role_user.role_id', 'roles.name as role_name', 'roles.slug as role_slug')            
            ->orderBy('comments.created_at', 'desc')
            ->where('comments.company_id', $id)
            ->get();
        foreach ($db_comments as $key => $item) {
            if($db_comments[$key]->role_slug == 'admin') {
                $db_comments[$key]->user_name = $db_comments[$key]->user_name.' ('.$db_comments[$key]->role_name.')';
            }
            $db_comments[$key]->date = date('F j, Y', strtotime($item->date));
            $db_comments[$key]->reply = 0;
            $db_comments[$key]->alertreplyshow = 0;
            if($db_comments[$key]->comment == '**_add_forecast_**') {
                $arr_comment = explode('___', $db_comments[$key]->comment);
                $db_comments[$key]->save_forecast = 1;
                $db_comments[$key]->save_forecast_user = $db_comments[$key]->user_id;
            } else {
                $db_comments[$key]->save_forecast = 0;
                $db_comments[$key]->save_forecast_user = '';
            }
            if($db_comments[$key]->comment == '**_delete_comment_**') {            
                $db_comments[$key]->comment = config('app.options.text_delete_comment');
            }           
        }

        $arr_comments = [];
        $data = [];        
        $arr_parent = [];
        foreach($db_comments as $item) {
            $arr_comments[$item->parent][] = $item;
            if(!in_array($item->parent, $arr_parent) && $item->parent != 0) {
                $arr_parent[] = $item->parent;
            }
        }        

        session(['comments' => []]);
        $this->outTree(0, 0, $arr_comments, $arr_parent);

        return session('comments');        
    }

    public function outTree($parent_id, $level, $arr_comments, $arr_parent) {
        if (isset($arr_comments[$parent_id])) {
            foreach ($arr_comments[$parent_id] as $value) {                
                $value->level = $level;
                $data = session('comments');
                array_push($data, $value);
                session(['comments' => $data]);                
                if(in_array($value->id, $arr_parent)) {                    
                    $level = $level + 1;
                    $arr_parent = array_diff($arr_parent, [$value->id]);
                    $this->outTree($value->id, $level, $arr_comments, $arr_parent);
                    $level = $level - 1;
                }                               
            }                        
        }        
    }
    
}
