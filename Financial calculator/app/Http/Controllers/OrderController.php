<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index() {

    	return view('order');
    }

    public function orderdata($company) {

    	$data = [];

    	$f_data = DB::table('formulas')
    						->where('company_id', $company)
    						->first();
    	$formula_data = $f_data ? json_decode($f_data->formula, true) : [];

    	if(isset($formula_data['formula'])) {
    		foreach ($formula_data['formula'] as $key => $value) {
    			if($value && !empty($value)) {
    				$data['formula'][] = [
    					'type' => 'formula',
    					'value' => $key,
    					'name' => $formula_data['name'][$key],
    					'style' => 1,
    					'stylebold' => 1,
    					'styleitalic' => 1,
    					'styleboldvalue' => 0,
    					'styleitalicvalue' => 0,
    				];
    			}
    		}
    	}

    	
    	$i_data = DB::table('company_data')
    						->where('company_id', $company)
    						->first();
    	$arr_indicator = json_decode($i_data->indicator, true);

    	$indicators_data = DB::table('indicators')->get();
    	$indicators = [];
    	foreach ($indicators_data as $key => $value) {
    		$indicators[$value->id] = $value->name;
    	}

    	foreach ($arr_indicator as $value) {
    	  	$data['indicator'][] = [
    	  		'type' => 'indicator',
    	  		'name' => $indicators[$value],
    	  		'value' => $value,
    	  		'style' => 1,
    	  		'stylebold' => 1,
    	  		'styleitalic' => 1,
    	  		'styleboldvalue' => 0,
    	  		'styleitalicvalue' => 0,
    	  	];	
    	}

    	$o_data = DB::table('order')
    						->where('company_id', $company)
    						->first();
    	$data['order'] = $o_data ? json_decode($o_data->order, true) : [];  	

    	return $data;
    }

    public function ordersave($company, $data) {

    	DB::table('order')
    		->updateOrInsert(
    			['company_id' => $company ],
    			['order' => $data],
    		);

    	return 1;
    }

}
