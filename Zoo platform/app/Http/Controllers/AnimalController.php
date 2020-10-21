<?php

namespace App\Http\Controllers;

use App\Animal;
use App\Animal\AnimalClass;
use App\Http\Requests\AnimalRequest;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $animals = new AnimalClass();
        return $animals->selectAllRecords()->get()->toJson();
    }


    /**
     *
     */
    public function create()
    {
    }


    /**
     * @param Request $request
     *
     * @return mixed\
     */
    public function store( AnimalRequest $request )
    {
        Animal::create( $request->all() );
        return $this->index();
    }


    /**
     * @param $id
     */
    public function show( $id )
    {
    }


    /**
     * @param $id
     */
    public function edit( $id )
    {
    }


    /**
     * @param Request $request
     * @param         $id
     *
     * @return mixed
     */
    public function update( AnimalRequest $request, $id )
    {
        Animal::find( $id )->update( $request->all() );
        return $this->index();
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy( $id )
    {
        Animal::find( $id )->delete();
        return $this->index();
    }
}
