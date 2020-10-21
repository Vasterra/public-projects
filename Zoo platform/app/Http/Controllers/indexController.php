<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\animal;
use App\animal_view;
use App\animal_category;

class indexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view( 'index', [] );
    }
}
