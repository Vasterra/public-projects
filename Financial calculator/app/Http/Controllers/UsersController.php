<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\OfficeController;

class UsersController extends Controller {

    public function index() {

    	$db_users = DB::table('users')
    				->join('role_user','users.id','=','role_user.user_id')
    				->join('roles','role_user.role_id','=','roles.id')    				
    				->where(
		    					[
									['users.name', '!=', '[User deleted]'],
									['roles.slug', '=', 'user']									
								]
							)
    				->select('users.id','users.name','users.email','users.created_at')
    				->orderBy('users.name', 'asc')
    				->paginate(config('app.options.admin_count_paginate_users'));

    	$users = $db_users ? $db_users : [];

    	foreach ($users as $key => $item) {

    	   	$users[$key]->count_comments = $this->getusercountcomments($item->id);
    	   	$users[$key]->count_forecasts = $this->getusercountforecasts($item->id);
    	   	
    	   	$users[$key]->date = date('d-m-Y', strtotime($item->created_at));
    	}   				

    	return view('users', ['users' => $users]);
    }

    public function getusercountforecasts($user_id) {

    	$count_forecasts = DB::table('forecasts')
    	   						->where('user_id', $user_id)
    	   						->count();

    	return $count_forecasts;
    }

    public function getusercountcomments($user_id) {

	   	$count_comments = DB::table('comments')
	   						->where(
	    	   							[
		    	   							['comment', '!=', '**_add_forecast_**'],
		    	   							['user_id', '=', $user_id],
		    	   						]
		    	   					)
	   						->count();

    	return $count_comments;
    }

    public function userprofile($user_id) {    	

    	$user = User::find($user_id);

    	$user->date = date('F j, Y', strtotime($user->created_at));
    	$user->count_comments = $this->getusercountcomments($user_id);
    	$user->count_forecasts = $this->getusercountforecasts($user_id);

    	return view('user-profile', ['user' => $user]);
    }

    public function deleteuser(Request $request) {    	

    	$user_id = $request->input('id');

    	if($request->input('delete_account_confirm')) {
    		
    		$office = new OfficeController();
    		$office->removeaccount($user_id);

    		return redirect()->route('users')->with('success-delete', 'User account deleted.');
    	} else {

    		return redirect()->route('userprofile', ['user' => $user_id]);
    	}
    }

    public function userforecasts($user_id) {

    	$office = new OfficeController();
    	$forecasts = $office->getforecasts($user_id);

    	return view('user-forecasts', ['forecasts' => $forecasts, 'user' => User::find($user_id)]);
    }

    public function userforecast($id, $user_id) {

    	$office = new OfficeController();
    	$forecast = $office->getforecast($id, $user_id, $type = 'admin');

    	return view('user-forecast', ['forecast' => $forecast, 'user' => User::find($user_id)]);    	
    }

    public function deleteforecast(Request $request) {
    	
    	$id = $request->input('id');
    	$user_id = $request->input('user');

    	if($request->input('delete_forecast_confirm')) {

    		$office = new OfficeController();
    		$office->removeforecast($id, $user_id);
    		return redirect()->route('userforecasts', ['user' => $user_id])->with('success-delete', 'User forecast deleted.');
    	} else {
    		return redirect()->route('userforecast', ['id' => $id, 'user' => $user_id]);
    	}

    }

    public function usercomments($user_id) {

        $office = new OfficeController();
        $comments = $office->getcomments($user_id, $type = 'admin');

        return view('user-comments', ['comments' => $comments, 'user' => User::find($user_id)]);
    }

    public function usercomment($id, $user_id) {

        $office = new OfficeController();
        $comment = $office->getcomment($id, $user_id);

        return view('user-comment', ['comment' => $comment, 'user' => User::find($user_id)]);
    }

    public function deletecomment(Request $request) {

        $id = $request->input('id');
        $user_id = $request->input('user');

        if($request->input('delete_comment_confirm')) {

            $office = new OfficeController();
            $office->removecomment($id, $user_id);
            return redirect()->route('usercomments', ['user' => $user_id])->with('success-delete', 'User comment deleted.');
        } else {
            return redirect()->route('usercomment', ['id' => $id, 'user' => $user_id]);
        }
    }


}
