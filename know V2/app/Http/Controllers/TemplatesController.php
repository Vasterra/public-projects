<?php

namespace App\Http\Controllers;

use App\Block;
use App\BlocksValues;
use App\Template;
use App\TemplateCategory;
use App\BlockType;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    public function index()
    {
        return Template::all()->toArray();
    }


    public function store( Request $request )
    {
        switch( $request->operation ) {
            case 'add':
                return $this->saveBlock( $request->id, $request->name );
                break;
        }
    }


    public function saveBlock( $id, $name )
    {
        $block              = new Template();
        $block->category_id = $id;
        $block->name        = $name;
        $block->created_at  = date( "Y-m-d" );
        $block->updated_at  = date( "Y-m-d" );
        $block->save();
        return $block;
    }


    public function destroy( $id )
    {
        $blocks = Block::where( 'template_id', $id )->get();
        foreach( $blocks as $block ) {
            BlocksValues::where( 'block_id', $block->id )->delete();
        }
        Block::where( 'template_id', $id )->delete();
        Template::where( 'id', $id )->delete();
    }


    public function edit( $id )
    {
        $bt = BlockType::all()->toArray();
        return view( 'welcome', [ 'id' => $id, 'bt' => $bt ] );
    }


    public function show( $id )
    {
        $bt = BlockType::all()->toArray();
        return view( 'show', [ 'id' => $id, 'bt' => $bt ] );
    }

}
