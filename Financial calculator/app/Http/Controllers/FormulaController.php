<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Master;

class FormulaController extends Controller
{
    public function index() {

    	return view('formula');

    }

    public function signs() {

    	return config('app.signs');
    }

    public function formula($company) {        

    	$db_data = DB::table('formulas')
    						->where('company_id', $company)
    						->first();

    	$indicators_data = DB::table('indicators')->get();
    	$indicators = [];
    	foreach ($indicators_data as $key => $value) {
    		$indicators[$value->id] = $value->name;
    	}

    	if($db_data) {            
            $arr_formula = json_decode($db_data->formula, true);
            if(isset($arr_formula['formula'])) {
                $data = Master::setformulavalue($arr_formula['formula'], $indicators, config('app.signs'));
            } else {
                $data = [];
            }
    	} else {
    		$data = [];
    	}    	
    	
        return $data;
    }    

    public function pastedata($company, $formula, $data) {

    	$data = json_decode($data, true);

    	$formula_old = DB::table('formulas')
    						->where('company_id', $company)
    						->first();
    	$formuladata = $formula_old ? json_decode($formula_old->formula, true) : [];

    	if($data['type'] == 'formula') {

    		$formula_copy = DB::table('formulas')
    							->where('company_id', $data['company'])
    							->first();
    		$f_copy = $formula_copy ? json_decode($formula_copy->formula, true) : [];
    		$formuladata['formula'][$formula] = isset($f_copy['formula'][$data['formula']]) ? $f_copy['formula'][$data['formula']] : [];
    		
    	} else {
    		$add = [
    				$data['type'] => 1,
    				'value' => $data['data'],
    			];
    		if(isset($formuladata['formula'][$formula])) {
    			array_push($formuladata['formula'][$formula], $add);
    		} else {
    			$formuladata['formula'][$formula][] = $add;
    		}
    	}    	

    	$_formula = json_encode($formuladata);    	

    	DB::table('formulas')
    		->updateOrInsert(
    			['company_id' => $company],
    			['formula' => $_formula]
    		);

    	return $formuladata;
    }

    public function deleteitem($company, $formula) {

    	$data = DB::table('formulas')
    						->where('company_id', $company)
    						->first();
    	$formuladata = $data ? json_decode($data->formula, true) : [];

    	if(isset($formuladata['formula'][$formula])) {
    		array_pop($formuladata['formula'][$formula]);
    	}

    	DB::table('formulas')
    		->where('company_id', $company)
    		->update(['formula' => json_encode($formuladata)]);

    	return 1;
    }

    public function names($company) {

    	$data = DB::table('formulas')
    						->where('company_id', $company)
    						->first();

    	$_formula = $data ? json_decode($data->formula, true) : [];
    	
    	$names = isset($_formula['name']) ? $_formula['name'] : [];

    	return $names;    	
    }

    public function setname($company, $formula, $name) {

    	$data = DB::table('formulas')
    						->where('company_id', $company)
    						->first();
    	$_formula = $data ? json_decode($data->formula, true) : [];
    	$names = isset($_formula['name']) ? $_formula['name'] : [];

    	if($name == '*_*_*') {
    		$names[$formula] = '';
    	} else {
    		$names[$formula] = $name;
    	}

    	$_formula['name'] = $names;    	

    	DB::table('formulas')
    		->updateOrInsert(
    			['company_id' => $company],
    			['formula' => json_encode($_formula)],
    		);

    	return 1;
    }

    public function percent($company) {

    	$data = DB::table('formulas')
    						->where('company_id', $company)
    						->first();

    	$_formula = $data ? json_decode($data->formula, true) : [];					
		$percent = isset($_formula['percent']) ? $_formula['percent'] : [];

    	return $percent;
    }

    public function setpercent($company, $datapercent) {

    	$data = DB::table('formulas')
    						->where('company_id', $company)
    						->first();
    	$_formula = $data ? json_decode($data->formula, true) : [];   	

    	$_formula['percent'] = json_decode($datapercent, true);

    	DB::table('formulas')
    		->updateOrInsert(
    			['company_id' => $company],
    			['formula' => json_encode($_formula)]
    		);

    	return 1;
    }


}
