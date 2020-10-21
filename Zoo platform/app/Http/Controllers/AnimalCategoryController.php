<?php

namespace App\Http\Controllers;

use App\Animal;
use App\AnimalCategory;
use App\Animal\AnimalClass;
use Illuminate\Http\Request;

class AnimalCategoryController extends Controller
{
    /**
     * @return string
     */
    public function index()
    {
        return AnimalCategory::all()->toJson();
    }


    /**
     *
     */
    public function create()
    {
        //
    }


    /**
     * @param Request $request
     */
    public function store( Request $request )
    {
        //
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function show( $id )
    {
        $animals = new AnimalClass();
        if( (int)$id !== 0 ) {
            return $animals->selectAllRecords()->where( "id_category", $id )->get()->toJson();
        } else {
            return $animals->selectAllRecords()->get()->toJson();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        //
    }
}
