<?php

namespace App\Http\Controllers;

use App\animal;
use App\Animal\AnimalClass;
use App\AnimalView;
use Illuminate\Http\Request;

class AnimalViewController extends Controller
{
    /**
     * Взять все виды животных
     */
    public function index()
    {
        return AnimalView::all()->toJson();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        //
    }


    /**
     * Поиск животных по короткому названию вида
     */
    public function show( $id )
    {
        $Animals = new AnimalClass();
        if( (int)$id !== 0 ) {
            return $Animals->selectAllRecords()->where( "id_wiew", $id )->get()->toJson();
        } else {
            return $Animals->selectAllRecords()->get()->toJson();
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
