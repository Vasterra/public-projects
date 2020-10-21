<?php

namespace App\Http\Controllers;

use App\BlocksValues;
use App\BlockType;
use Illuminate\Http\Request;
use App\Block;
use App\Classes\Security;

class BlockController extends Controller
{
    public function index()
    {
        return Block::select( "id", "sort", "class", "type_id", 'template_id' )->with( "typer" )->with( "valer" )->get()->toJson();
    }

    public function show($id)
    {
        return Block::select( "id", "sort", "class", "type_id", 'template_id' )->with( "typer" )->with( "valer" )->where('id', $id)->get()[0];
    }

    public function edit($id)
    {
        return Block::select( "id", "sort", "class", "type_id", 'template_id' )->with( "typer" )->with( "valer" )->where('template_id', '=', $id)->get()->toJson();
    }

    public function saveBlock($id, $temp_id)
    {
        $blockType = BlockType::find( $id );
        $block = new Block();
        $block->sort=1000;
        $block->class='default';
        $block->type_id=$id;
        $block->template_id=$temp_id;
        $block->created_at = date( "Y-m-d" );
        $block->updated_at = date( "Y-m-d" );
        $block->save();
        for($i=0; $i<$blockType->field_count; $i++)
        {
            $blockVals=new BlocksValues();
            $blockVals->block_id=$block->id;
            $blockVals->value_editing='Пример';
            $blockVals->created_at = date( "Y-m-d" );
            $blockVals->updated_at = date( "Y-m-d" );
            $blockVals->save();
        }
        return $this->show($block->id);
    }

    public function updateBlocksEdits($blocks)
    {
        $arrayBlocks=array();
        foreach($blocks as $block)
        {
            $flightBlock = Block::find($block['id']);
            $flightBlock->sort = $block['sort'];
            $flightBlock->save();
            foreach($block['valer'] as $vale)
            {
                $val=BlocksValues::find($vale["id"]);
                $val->value_editing=Security::cleanString($vale['value_editing']);
                $val->save();
            }
            array_push($arrayBlocks, $this->show($block['id']));
        }
        return json_encode($arrayBlocks);
    }

    public function store( Request $request )
    {
        switch($request->operation)
        {
            case 'add': return $this->saveBlock($request->type_id, $request->template_id); break;
            case 'save': return $this->updateBlocksEdits($request->blocks); break;
        }
    }

    public function destroy( $id )
    {
        $block = Block::with( "valer" )->where('id', $id)->get()[0];//->delete();
        foreach($block["valer"] as $val)
        {
            BlocksValues::find( $val['id'] )->delete();
        }
        Block::find( $block['id'] )->delete();
        return $this->index();
    }
}
