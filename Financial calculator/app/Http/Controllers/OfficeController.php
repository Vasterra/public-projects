<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Master;

class OfficeController extends Controller
{
    public function index() {

    	return view('office.profile', ['title' => 'Profile']);    	
    }

    public function updateinfo(Request $request) {  	

    	$valid = $request->validate([
    	    'name' => 'required|string|min:2|max:255',
    	    'email' => 'required|email' 
    	]);

    	$user = Auth::user();
    	$user->name = $request->input('name');
    	$user->email = $request->input('email');
    	$user->save();    	

    	return redirect()->route('office')->with('success-info', 'Data saved successfully.');
    }

    public function updatepassword(Request $request) {

    	$valid = $request->validate([
    	    'password' => 'required|min:8|confirmed'    	     
    	]);
    	
    	$user = Auth::user();  	
    	$user->password = Hash::make($request->input('password'));
    	$user->save();

    	return redirect()->route('office');
    }

    public function deleteaccount(Request $request) {

    	if($request->input('delete_account_confirm')) {

    		$this->removeaccount(Auth::id());

			return redirect()->route('home');
    	} else {

    		return redirect()->route('office');
    	}    	
    }

    public function removeaccount($user_id) {

        DB::table('comments')
            ->where('user_id', $user_id)
            ->update(['comment' => '**_delete_comment_**']);
        DB::table('forecasts')->where('user_id', $user_id)->delete();
        DB::table('users')
            ->where('id', $user_id)
            ->update([
                'name' => '[User deleted]',
                'email' => time().'@gmail-delete.com',
                'password' => Hash::make(time())
            ]);
    }


    public function comments() {
    	
    	$user_id = Auth::id();
    	
        $comments = $this->getcomments($user_id);

    	return view('office.comments', ['title' => 'Comments', 'comments' => $comments]);
    }

    public function getcomments($user_id, $type = 'office') {

        if($type == 'admin') {
            $db_comments = DB::table('comments')
                                ->join('companies','comments.company_id', '=', 'companies.id')
                                ->where(
                                    [
                                        ['comments.user_id', '=', $user_id],
                                        ['comments.visible', '=', '1']
                                    ] 
                                )
                                ->select('comments.*', 'companies.name as company_name')
                                ->orderBy('checked', 'asc')
                                ->orderBy('comments.created_at', 'desc')
                                ->paginate(config('app.options.office_count_paginate_comments'));
        } else {
            $db_comments = DB::table('comments')
                                ->join('companies','comments.company_id', '=', 'companies.id')
                                ->where(
                                    [
                                        ['comments.user_id', '=', $user_id],
                                        ['comments.visible', '=', '1']
                                    ] 
                                )
                                ->select('comments.*', 'companies.name as company_name')
                                ->orderBy('comments.created_at', 'desc')
                                ->paginate(config('app.options.office_count_paginate_comments'));
        }
        

        $comments = $db_comments ? $db_comments : [];
        foreach ($comments as $key => $item) {
            $comments[$key]->date = date('F j, Y', strtotime($item->created_at));
        }
        return $comments;
    }

    public function editcomment($id) {

    	$comment = $this->getcomment($id, Auth::id());

    	return view('office.comment-edit', ['title' => 'Comments → Edit Comment', 'comment' => $comment]);
    }

    public function getcomment($id, $user_id) {

        $comment = DB::table('comments')
                            ->join('companies','comments.company_id', '=', 'companies.id')
                            ->where(['comments.id' => $id, 'comments.user_id' => $user_id])
                            ->select('comments.*', 'companies.name as company_name')
                            ->first();      
        $comment->date = date('F j, Y', strtotime($comment->created_at));

        return $comment;
    }
    
    public function updatecomment(Request $request) {
    	  	
		$valid = $request->validate([
		    'comment' => 'required|string|min:2|max:1000'
		]);

		$comment = $request->input('comment');
		$user_id = Auth::id();
		$id = $request->input('id');

    	DB::table('comments')
			->where(['id' => $id, 'user_id' => $user_id])    						
			->update(['comment' => $comment, 'updated_at' => NOW()]);    	

    	return redirect()->route('office-comment-edit', ['id' => $id])->with('success', 'Data saved successfully.');
    }

    public function deletecomment(Request $request) {

    	$user_id = Auth::id();
    	$id = $request->input('id');

    	if($request->input('delete_comment_confirm')) {
    		$this->removecomment($id, $user_id);    		
	    	return redirect()->route('office-comments')->with('success-delete-comment', 'Comment deleted.');
    	} else {
    		return redirect()->route('office-comment-edit', ['id' => $id]);
    	}
    }

    public function removecomment($id, $user_id) {

		$has_child_comment = DB::table('comments')
							->where('parent', $id)
							->first();

		if($has_child_comment) {
			DB::table('comments')
	    		->where(['user_id' => $user_id, 'id' => $id])
	    		->update(['comment' => '**_delete_comment_**', 'visible' => '0']);
		} else {
			DB::table('comments')->where('id', $id)->delete();
		}		

    }

    public function forecasts() {
    	
        $forecasts = $this->getforecasts(Auth::id());

    	return view('office.forecasts', ['title' => 'Forecasts', 'forecasts' => $forecasts]);
    }

    public function getforecasts($user_id) {

        $db_forecasts = DB::table('forecasts')
                            ->join('companies', 'forecasts.company_id', '=', 'companies.id')
                            ->select('forecasts.id', 'forecasts.overview', 'forecasts.created_at', 'companies.name as company_name')
                            ->where('forecasts.user_id', $user_id)
                            ->orderBy('forecasts.created_at', 'desc')
                            ->paginate(config('app.options.office_count_paginate_forecasts'));

        $forecasts = $db_forecasts ? $db_forecasts : [];

        foreach ($forecasts as $key => $item) {
            $forecasts[$key]->date = date('F j, Y', strtotime($item->created_at));
            $forecasts[$key]->overview = Master::shorttext(str_replace('<br>', ' ', $item->overview), 100);
        }

        return $forecasts;
    }

    public function editforecasts($id) {

    	$user_id = Auth::id();

        $forecast = $this->getforecast($id, $user_id);    			

    	return view('office.forecast-edit', ['title' => 'Forecasts → Edit Forecast', 'forecast' => $forecast]);
    }

    public function getforecast($id, $user_id, $type = 'office') {

        $forecast = DB::table('forecasts')
                            ->join('companies', 'forecasts.company_id', '=', 'companies.id')
                            ->select('companies.name as company_name', 'forecasts.id', 'forecasts.overview', 'forecasts.checked', 'forecasts.created_at', 'forecasts.company_id', 'forecasts.user_id')
                            ->where(['forecasts.user_id' => $user_id, 'forecasts.id' => $id])
                            ->first();

        $forecast->date = date('F j, Y', strtotime($forecast->created_at));
        $forecast->overview = str_replace("<br>", "\n", $forecast->overview);
        $forecast->type = $type;

        return $forecast;
    }

    public function updateforecast(Request $request) {

    	$user_id = Auth::id();
    	$id = $request->input('id');
    	
		$valid = $request->validate([
		    'overview' => 'required|string|min:2'
		]);    		
		$overview = str_replace("\n", "<br>", $request->input('overview'));
		DB::table('forecasts')
			->where(['user_id' => $user_id, 'id' => $id])
			->update(['overview' => $overview]);    	

    	return redirect()->route('office-forecast-edit', ['id' => $id])->with('success', 'Data saved successfully.'); 
    }

    public function tableforecast($company_id, $user_id) {
    	
    	$type = 'office';

    	$db_data = DB::table('forecasts')
    					->where(['user_id' => $user_id, 'company_id' => $company_id ])
    					->select('forecasts.table')
    					->first();

    	session(['tabledata-'.$type.$company_id => json_decode($db_data->table, true)]);

    	$home = new HomeController();
    	$data = $home->gettable($company_id, $user_user = 1, $type);

    	return $data;
    }

    public function changetable($data, $company_id) {

    	$type = 'office';
    	$home = new HomeController();
    	
    	return $home->changetable($data, $company_id, $type);
    }

    public function zerotable($company_id) {

        $type = 'office';

        session(['tabledata-'.$type.$company_id => []]);

        $home = new HomeController();
        $data = $home->gettable($company_id, $user_user = 1, $type);

        return $data;
    }

    public function updatetable($company_id) {

        $type = 'office';
        $id = $company_id;

        $user_id = Auth::id();
        
        $table = json_encode(session('tabledata-'.$type.$id));        

        DB::table('forecasts')
        	->where(['user_id' => $user_id, 'company_id' => $id])
            ->update(['table' => $table, 'updated_at' => NOW()]);        

        return 1;        
    }

    public function deleteforecast(Request $request) {

    	$user_id = Auth::id();
    	$id = $request->input('id');

        if($request->input('delete_forecast_confirm')) {
    	
            $this->removeforecast($id, $user_id);
	    	return redirect()->route('office-forecasts')->with('success-delete-forecast', 'Forecast deleted.');
    	} else {
    		return redirect()->route('office-forecast-edit', ['id' => $id]);
    	}
        
    }

    public function removeforecast($id, $user_id) {
        
        $db_comment = DB::table('comments')
            ->where(['user_id' => $user_id, 'comment' => '**_add_forecast_**'])
            ->first();
        
        if($db_comment) {
            $this->removecomment($db_comment->id, $user_id);
        }        
        
        DB::table('forecasts')
            ->where(['user_id' => $user_id, 'id' => $id])
            ->delete();        
    }


}
