<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Helpclasses\Memory;
use App\Http\Controllers\Indicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Master;

class CompaniesController extends Controller {

    public function index() {

    	$companies = DB::table('companies')
                        ->orderBy('name', 'asc')
                        ->paginate(config('app.options.admin_count_paginate_companies'));

        $arr_currency = config('app.currency');
        foreach ($companies as $key => $_item) {
            $companies[$key]->currency_symbol = $arr_currency[$_item->currency];
        }
        $arr_units = config('app.units');
        foreach ($companies as $key => $_item) {
            $companies[$key]->units_symbol = $arr_units[$_item->units];
        }               

    	return view('companies', [
            'companies' => $companies            
        ]);
    	
    }

    public function companies($search = null) {

        if($search) {
            $companies = DB::table('companies')
                            ->where('name', 'like', '%'.$search.'%')
                            ->get();
        } else {
            $companies = DB::table('companies')->get();
        }        

        return $companies;
    }

    public function searchcompanies($search) {

        $companies = $this->companies($search);

        return $companies;
    }

    public function add($id = null) {

        if($id) {

            $company = DB::table('companies')
                        ->where('id', $id)
                        ->first();

            $title = 'Edit company';
            $company->name = old('name') ? old('name') : $company->name;
            $company->currency = old('currency') ? old('currency') : $company->currency;
            $selected_currency = $company->currency;
            $company->units = old('units') ? old('units') : $company->units;
            $company->visible = old('visible') ? old('visible') : $company->visible;
            $selected_units = $company->units;
            $selected_yearfinish = $company->yearfinish;

            $company_data = DB::table('company_data')
                                ->where(['company_id' => $id])
                                ->first();

            $memory = new Memory();            
            $memory->checkindicators = $company_data->indicator;
            $period = json_decode($company_data->period);            
            $memory->periodicity = $period->periodicity;
            $memory->yearstart = $period->yearstart;
            $memory->yearend = $period->yearend;
            $memory->periodstart = $period->periodstart;
            $memory->periodend = $period->periodend;            

            DB::table('memory')
                ->updateOrInsert(
                    ['name' => 'memory'],
                    ['data' => json_encode($memory)]
                );
            
            DB::table('memory')
                ->updateOrInsert(
                    ['name' => 'tabledata'],
                    ['data' => $company_data->table]
                );            
        
        } else {

            $company = new Company();
            $title = 'Add company';
            $company->name = old('name');
            $company->visible = old('visible');            
            $selected_currency = old('currency');
            $selected_units = old('units');
            $selected_yearfinish = old('yearfinish');

            $memory = new Memory();            
            $memory->checkindicators = old('indicators') ? old('indicators') : [];     
            $memory->periodicity = old('periodicity');
            $memory->yearstart = old('yearstart');
            $memory->yearend = old('yearend');
            $memory->periodstart = old('periodstart');
            $memory->periodend = old('periodend');

            DB::table('memory')
                ->updateOrInsert(
                    ['name' => 'memory'],
                    ['data' => json_encode($memory)]
                );

        }

    	$addcompany = [];

        $currency_options = Master::getoptions(config('app.currency'), $value = 'key', $text = 'key', $start = config('app.select_start.currency'), $selected = $selected_currency);
        $units_options = Master::getoptions(config('app.units'), $value = 'key', $text = 'key', $start = config('app.select_start.units'), $selected = $selected_units);

        $yearfinish_options = Master::getoptions(range(date('Y') + 1, date('Y') + config('app.years.delta_finish')), $value = 'value', $text = 'value', $start = null, $selected = $selected_yearfinish);
        
        
        $addcompany['titles']['indicators'] = str_replace(' ', '&nbsp;', config('app.titles.indicators'));       
        $addcompany['titles']['periodicity'] = str_replace(' ', '&nbsp;', config('app.titles.periodicity'));

        $arr_periodicity = [];
        foreach (config('app.periodicity') as $arr_item) {
            foreach ($arr_item as $key => $value) {
                $arr_item[$key] = str_replace(' ', '&nbsp;', $value);
            }
            $arr_periodicity[] = $arr_item;  
        }      
        $addcompany['options']['periodicity'] = $arr_periodicity;
        

        return view('add-company', ['currency_options' => $currency_options, 'units_options' => $units_options, 'yearfinish_options' => $yearfinish_options, 'addcompany' => json_encode($addcompany), 'title' => $title, 'company' => $company]);
    }

    public function addcompanystart() {

        $companystart['titles'] = config('app.titles');
        $companystart['indicators'] = DB::table('indicators')->orderBy('order', 'asc')->get();
        $companystart['periodicity'] = config('app.periodicity');        
        $companystart['yearsstart'] = range(date('Y') - config('app.years.delta_start'), date('Y'));
        $companystart['yearsend'] = range(date('Y'), date('Y') + config('app.years.delta_end'));
        $companystart['yearstart'] = date('Y');
        $companystart['yearend'] = date('Y') + 1;        
        return $companystart;

    }

    public function startdata() {
        $data = DB::table('memory')
                    ->where(['name' => 'memory'])
                    ->first();
        return json_decode($data->data, true);
    } 

    public function period($id) {

        $periodicity_items = config('app.periodicity_items');
        return count($periodicity_items[$id]) > 1 ? $periodicity_items[$id] : 0;
    }

    public function addcompanytable($data) {
        
        $table = [];

        $table_data = DB::table('memory')
                        ->where('name', 'tabledata')
                        ->first();
        $tabledata = json_decode($table_data->data, true);



        $arr_year_period = [];
        $error = 0;
        $data = json_decode($data, false);        

        $checkindicators = $data->checkindicators;
        $periodicity = $data->periodicity;
        $yearstart = $data->yearstart;
        $yearend = $data->yearend;
        $periodstart = $data->periodstart;
        $periodend = $data->periodend;

        if($yearstart > $yearend) {
            $yearend = $yearstart;
        }
        if($yearstart == $yearend) {
            if($periodstart > $periodend) {
                $periodend = $periodstart;
            }
        }        

        $arr_years = range($yearstart, $yearend);

        $periodicity_items = config('app.periodicity_items');
        
        if($periodicity < 12) {
            if($yearstart == $yearend) {
                if($periodstart == $periodend) {
                    $arr_year_period[] = [
                        'year' => $yearstart,
                        'period' => $periodstart,
                        'periodicity' => $periodicity,
                    ];
                }
                if($periodstart < $periodend) {
                    $periodicity_items_slice = array_slice($periodicity_items[$periodicity], 0, $periodend + 1, true);
                    $periodicity_items_slice = array_slice($periodicity_items_slice, $periodstart, count($periodicity_items_slice) - $periodstart, true);
                    foreach ($periodicity_items_slice as $_key => $_period) {
                        $arr_year_period[] = [
                            'year' => $yearstart,
                            'period' => $_key,
                            'periodicity' => $periodicity,
                        ];
                    }
                }
            }
            if($yearstart < $yearend) {
                foreach ($arr_years as $key => $_year) {
                    if($key == 0) {
                        $periodicity_items_start = array_slice($periodicity_items[$periodicity], $periodstart,count($periodicity_items[$periodicity]) - $periodstart, true);
                        foreach ($periodicity_items_start as $_key => $_period) {
                            $arr_year_period[] = [
                                'year' => $_year,
                                'period' => $_key,
                                'periodicity' => $periodicity,
                            ];
                        }                         
                    } else {
                        if($key < count($arr_years) - 1 ) {
                            foreach ($periodicity_items[$periodicity] as $_key => $_period) {
                                $arr_year_period[] = [
                                    'year' => $_year,
                                    'period' => $_key,
                                    'periodicity' => $periodicity,
                                ];
                            }
                        } else {
                            $periodicity_items_end = array_slice($periodicity_items[$periodicity], 0, $periodend + 1);
                            foreach ($periodicity_items_end as $_key => $_period) {
                                $arr_year_period[] = [
                                    'year' => $_year,
                                    'period' => $_key,
                                    'periodicity' => $periodicity,
                                ];
                            }
                        }
                    }
                }
            }
        }

        if($periodicity == 12) {
            foreach ($arr_years as $key => $value) {
                $arr_year_period[] = [
                    'year' => $value,
                    'period' => 0,
                    'periodicity' => $periodicity,
                ];
            }
        }        
        
        $indicators = DB::table('indicators')
            ->whereIn('id', $checkindicators)
            ->orderBy('order', 'asc')
            ->get();               

        for( $row = 0; $row <= count($indicators); $row ++ ) {
            for( $col = 0; $col <= count($arr_year_period); $col ++ ) {
                if($row == 0) {
                    if($col == 0) {
                        $table[$row][$col] = '';
                    } else {
                        $table[$row][$col] = [
                            'year' => 1,
                            'year_value' => $arr_year_period[$col-1]['year'],
                            'period' => ($periodicity < 12) ? 1 : 0,
                            'period_value' => $periodicity_items[$periodicity][$arr_year_period[$col-1]['period']],
                        ];
                    }   
                }
                if($row > 0) {
                    if($col == 0) {
                        $table[$row][$col] = [
                            'indicator' => 1,
                            'indicator_name' => $indicators[$row-1]->name,
                            'indicator_id' => $indicators[$row-1]->id,                            
                        ];                        
                    } else {
                        $input_value = '';
                        if( isset($tabledata[$indicators[$row-1]->id][$arr_year_period[$col-1]['year']][$periodicity][$arr_year_period[$col-1]['period']]) ) {
                            $input_value = $tabledata[$indicators[$row-1]->id][$arr_year_period[$col-1]['year']][$periodicity][$arr_year_period[$col-1]['period']];
                        }
                        $table[$row][$col] = [
                            'input' => 1,
                            'input_value' => $input_value,                            
                            'disabled' => 0,
                            'year_value' => $arr_year_period[$col-1]['year'],
                            'period' => ($periodicity < 12) ? 1 : 0,
                            'periodicity_id' => $periodicity,
                            'period_id' => $arr_year_period[$col-1]['period'],
                            'indicator_id' => $indicators[$row-1]->id,
                        ];
                    }
                }               
            }
        }        
        
        return $table;

    }

    public function save(Request $request) {

        $id = $request->input('id');

        $tabledata = $request->input('tabledata');
        $indicators = $request->input('indicators');
        $indicator = json_encode($indicators);
        $perioddata = [];
        $perioddata['periodicity'] = $request->input('periodicity');
        $perioddata['yearstart'] = $request->input('yearstart');
        $perioddata['yearend'] = $request->input('yearend');
        $perioddata['periodstart'] = (int)$request->input('periodstart');
        $perioddata['periodend'] = (int)$request->input('periodend');
        $period_data = json_encode($perioddata);

        $table_data = json_encode($tabledata);

        // сохраняем, если не пройдет валидация, чтобы подставить в таблицу
        DB::table('memory')
            ->updateOrInsert(
                ['name' => 'tabledata'],
                ['data' => $table_data]
            );                

        // валидация
        $valid = $request->validate([
            'name' => 'required|string|min:4|max:255',
            'currency' => 'required',
            'units' => 'required',
        ]);       
        
        if($id) {                       
            DB::table('companies')
                ->where('id', $id)
                ->update(
                    [
                        'name' => $request->input('name'),
                        'currency' => $request->input('currency'),
                        'units' => $request->input('units'),
                        'yearfinish' => $request->input('yearfinish'),
                        'visible' => $request->input('visible') ? $request->input('visible') : '0',
                    ]
            );
            $company_id = $id;            
        } else {
            $company = new Company();
            $company->name = $request->input('name');
            $company->currency = $request->input('currency');
            $company->units = $request->input('units');            
            $company->yearfinish = $request->input('yearfinish');            
            $company->visible = $request->input('visible') ? $request->input('visible') : '0';
            $company->save();
            $company_id = $company->id;
        }               

        DB::table('company_data')
            ->updateOrInsert(
                [
                    'company_id' => $company_id,                    
                ],
                [
                    'indicator' => $indicator,
                    'period' => $period_data,
                    'table' => $table_data,
                ]
            );

        session(['tabledata-'.$id => []]);        
    	
        return redirect()->route('edit-company', ['id' => $company_id])->with('success', 'Data saved successfully.');

    }    

    public function update(Request $request) {

        $valid = $request->validate([
            'name' => 'required|string|min:4|max:255',
        ]);

        DB::table('companies')
                  ->where('id', $request->input('id'))
                  ->update(['name' => $request->input('name')]);

        foreach ($request->input('indicators') as $key => $val) {
            if(!$val) {
                $val = 0;
            }
            DB::table('company_indicators')
                  ->where('id', $key)
                  ->update(['indicator_value' => str_replace(',', '.', $val)]);
        }

        return redirect()->route('edit-company', $request->input('id'))->with('success', 'Company updated successfully.');

    }

    public function delete(Request $request) {

        DB::table('companies')->where('id', $request->input('id'))->delete();
        DB::table('company_data')->where('company_id', $request->input('id'))->delete();
        DB::table('formulas')->where('company_id', $request->input('id'))->delete();       

        return redirect()->route('companies')->with('success-delete', 'Company removed.');
    }
    

}
