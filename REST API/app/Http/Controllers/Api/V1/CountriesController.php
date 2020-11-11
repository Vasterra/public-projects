<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CountryAll()
    {
        return Country::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CreateCountry(Request $request)
    {
        $this->validate($request, [
            'country_name' => 'required',
            'country_code' => 'required',
        ]);
        $country= new Country;
        $country->country_name=$request->country_name;
        $country->country_code=$request->country_code;
        if (isset($request->country_image_flag)) $country->country_image_flag=$request->country_image_flag;
        $country->save();
        return $country;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetCountryById(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        $id= (int)$request->id;
        return Country::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetCountryByName(Request $request)
    {
        $this->validate($request, [
            'country_name' => 'required',
        ]);
        $name=$request->country_name;
        return Country::where('country_name', $name)->get()[0];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetCountryIsoCode(Request $request)
    {
        $this->validate($request, [
            'country_code' => 'required',
        ]);
        $country_code=$request->country_code;
        return Country::where('country_code', $country_code)->get()[0];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCountry(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        $id= (int)$request->id;
        $country= Country::find($id);
        if (isset($request->country_name)) $country->country_name=$request->country_name;
        if (isset($request->country_code)) $country->country_code=$request->country_code;
        if (isset($request->country_image_flag)) $country->country_image_flag=$request->country_image_flag;
        $country->save();
        return $country;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCountry(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        $id= (int)$request->id;
        Country::find($id)->delete();
        return json_encode("ok");
    }
}
