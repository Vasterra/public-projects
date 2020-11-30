<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    public function index() {

    	$db_comments = DB::table('comments')
    					->join('companies','comments.company_id', '=', 'companies.id')
    					->join('users','comments.user_id', '=', 'users.id')
    					->where([
    						['comments.visible', '=', '1'],
    					])
    					->select('comments.*', 'companies.name as company_name', 'users.name as user_name')
    					->orderBy('checked', 'asc')
    					->orderBy('created_at', 'desc')
    					->paginate(config('app.options.admin_count_paginate_comments'));

    	$comments = $db_comments ? $db_comments : [];
    	foreach ($comments as $key => $item) {
    		$comments[$key]->date = date('F j, Y', strtotime($item->created_at));
    	}

    	return view('comments', ['comments' => $comments]);
    }

    public function acceptcomment($id) {

    	DB::table('comments')
    		->where('id', $id)
    		->update(['checked' => '1']);

    	return 1;
    }

    
}
