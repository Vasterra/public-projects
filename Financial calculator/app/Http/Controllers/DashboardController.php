<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {

    public function index() {

    	$companies_count = DB::table('companies')->count();
    	$indicators_count = DB::table('indicators')->count();
    	$users_count = DB::table('users')
		    				->join('role_user','users.id','=','role_user.user_id')
		    				->join('roles','role_user.role_id','=','roles.id')
		    				->where(
				    					[
											['users.name', '!=', '[User deleted]'],
											['roles.slug', '=', 'user']
										]
									)
		    				->count();
    	$forecasts_count = DB::table('forecasts')->count();
        $forecasts_count_new = DB::table('forecasts')
                                    ->where('checked', '0')
                                    ->count();
    	$comments_count = DB::table('comments')
		   						->where([['comment', '!=', '**_add_forecast_**']])
		   						->count();
        $comments_count_new = DB::table('comments')
                                ->where([
                                    ['comment', '!=', '**_add_forecast_**'],
                                    ['checked', '=', '0']
                                ])
                                ->count();
        $comments_count_new = $comments_count_new ? $comments_count_new : 0;


    	$data = [
    		[
    			'title' => 'Companies',
    			'title_2' => 'Number of companies:',
    			'count' => $companies_count,
    			'route' => 'companies',
    			'btn_text' => 'Companies &rarr;',
    		],
    		// [
    		// 	'title' => 'Forecast data',
    		// 	'title_2' => 'Number of forecast data:',
    		// 	'count' => $indicators_count,
    		// 	'route' => 'indicators',
    		// 	'btn_text' => 'Forecast data &rarr;',
    		// ],
    		[
    			'title' => 'Users',
    			'title_2' => 'Number of users:',
    			'count' => $users_count,
    			'route' => 'users',
    			'btn_text' => 'Users &rarr;',
    		],
    		[
    			'title' => 'Forecasts',
    			'title_2' => 'Number of forecasts:',
    			'count' => $forecasts_count,
    			'route' => 'forecasts',
    			'btn_text' => 'Forecasts &rarr;',
                'new' => $forecasts_count_new,
    		],
    		[
    			'title' => 'Comments',
    			'title_2' => 'Number of comments:',
    			'count' => $comments_count,
    			'route' => 'comments',
    			'btn_text' => 'Comments &rarr;',
                'new' => $comments_count_new,
    		],
    	];

    	return view('dashboard', ['data' => $data]);
    	
    }

}
