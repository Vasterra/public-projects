<?php

namespace App\Http\Controllers;

use App\Template;
use App\TemplateCategory;
use Illuminate\Http\Request;

class TemplateCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TemplateCategory::with('templ')->get()->toArray();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        switch($request->operation)
        {
            case 'add': return $this->saveBlock($request->id, $request->name); break;
            case 'save': return $this->updateBlocksEdits($request->blocks); break;
        }
    }

    public function updateBlocksEdits($blocks)
    {
        foreach($blocks as $block)
        {
            $flightBlock = TemplateCategory::where('id', '=', $block['id'])->get()[0];
            $flightBlock->name = $block['name'];
            $flightBlock->save();
            foreach($block['templ'] as $vale)
            {
                $val=Template::where('id', '=', $vale["id"])->get()[0];
                $val->name=$vale['name'];
                $val->save();
            }
        }
        return $this->index();
    }


    public function saveBlock($id, $name)
    {
        $block = new TemplateCategory();
        $block->parent_id=$id;
        $block->name=$name;
        $block->created_at = date( "Y-m-d" );
        $block->updated_at = date( "Y-m-d" );
        $block->save();
        return $block;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
