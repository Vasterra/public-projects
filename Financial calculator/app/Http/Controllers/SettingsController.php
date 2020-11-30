<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Indicator;

class SettingsController extends Controller {

    public function index() {

    	$indicators = DB::table('indicators')
    					->orderBy('order', 'asc')
    					->get();

    	$formulas = DB::table('formulas')->get();   					
    	$order = DB::table('settings')
    				->where('name', 'order')
    				->first(); 
        $years = DB::table('settings')
                    ->where('name', 'years')
                    ->first();

    	$arr_order = explode('|', $order->value);
    	$order->value = implode("\r\n", $arr_order);

    	return view( 'settings', [ 'indicators' => $indicators, 'formulas' => $formulas, 'order' => $order, 'years' => json_decode($years->value) ] );
    	
    }

    public function save_order(Request $request) {

    	$value = $request->input('value') ? $request->input('value') : '';

    	if($value != '') {
    		$value = str_replace("\r\n", '|', $value);
    	}

    	DB::table('settings')
    		->where('id', $request->input('id'))
    		->update(['value' => $value]);

    	return redirect()->route('settings')->with('success', 'Order updated successfully.');

    }

    public function save_formulas(Request $request) {

    	foreach ($request->input('formulas') as $key => $item) {
    		$value = $item['value'] ? $item['value'] : '';
    		DB::table('formulas')
    			->where('id', $key)
    			->update(['name' => $item['name'], 'value' => $value]);
    	}

    	return redirect()->route('settings')->with('success', 'Formulas updated successfully.');

    }

    public function save_years(Request $request) {
        
        $years = json_encode( $request->input('years') );

        DB::table('settings')
                ->where('name', 'years')
                ->update(['value' => $years]);

        return redirect()->route('settings')->with('success', 'Years updated successfully.');

    }

}
