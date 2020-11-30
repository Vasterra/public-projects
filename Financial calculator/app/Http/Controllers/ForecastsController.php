<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Master;

class ForecastsController extends Controller
{
    public function index() {

    	$db_forecasts = DB::table('forecasts')
    					->join('companies','forecasts.company_id', '=', 'companies.id')
    					->join('users','forecasts.user_id', '=', 'users.id')    					
    					->select('forecasts.overview', 'forecasts.id', 'forecasts.user_id', 'forecasts.created_at', 'forecasts.checked', 'companies.name as company_name', 'users.name as user_name')
    					->orderBy('checked', 'asc')
    					->orderBy('created_at', 'desc')
    					->paginate(config('app.options.office_count_paginate_forecasts'));

    	$forecasts = $db_forecasts ? $db_forecasts : [];
    	foreach ($forecasts as $key => $item) {
    		$forecasts[$key]->date = date('F j, Y', strtotime($item->created_at));
    		$forecasts[$key]->overview = Master::shorttext(str_replace('<br>', ' ', $item->overview), 100);
    	}    	

    	return view('forecasts', ['forecasts' => $forecasts]);
    }

    public function acceptforecast($id) {

    	DB::table('forecasts')
    		->where('id', $id)
    		->update(['checked' => '1']);

    	return 1;
    }

}
