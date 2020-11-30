<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Indicator;

class IndicatorsController extends Controller
{
    public function index() {

    	$indicators = DB::table('indicators')->orderBy('order', 'asc')->get();
    	return view('indicators', ['indicators' => $indicators]);

    }    

    public function save(Request $request) {

    	$valid = $request->validate([
    		'name' => 'required|string|unique:indicators|min:2|max:255',
    		'order' => 'required|numeric|integer|between:0,999',    		
    	]);        

    	$indicator = new Indicator();
    	$indicator->name = $request->input('name');
    	$indicator->order = $request->input('order');        
        // $indicator->format = json_encode($request->input('format'));
    	$indicator->save();

    	return redirect()->route('indicators')->with('success', 'Data added successfully.');

    }
    
    public function edit($id) {
        
        $indicator = DB::table('indicators')
                        ->where('id', $id)
                        ->first();

        return view('edit-indicator', ['indicator' => $indicator]);
    }

    public function update(Request $request) {

        $valid = $request->validate([
            'name' => 'required|string|min:4|max:255',
            'order' => 'required|numeric|integer|between:0,999',            
        ]);

        DB::table('indicators')
                  ->where('id', $request->input('id'))
                  ->update([ 
                    'name' => $request->input('name'),
                    'order' => $request->input('order'),                    
                ]);

        return redirect()->route('edit-indicator', $request->input('id'))->with('success', 'Data updated successfully.');               

    }

    public function delete(Request $request) {

        DB::table('indicators')->where('id', $request->input('id'))->delete();

        return redirect()->route('indicators')->with('success-delete', 'Data deleted.');

    }

    public function companyindicators($id) {

        $company_data = DB::table('company_data')
            ->where('company_id', $id)
            ->first();

        $indicators_arr = json_decode($company_data->indicator);

        $indicators_data = DB::table('indicators')
            ->whereIn('id', $indicators_arr)
            ->orderBy('order', 'asc')
            ->get();

        return $indicators_data;

    }

}
