<?php

namespace App\Http\Controllers;

use App\BlockType;
use Illuminate\Http\Request;

class BlockTypeController extends Controller
{
    public function index()
    {
        return BlockType::with("category")->get()->toArray();
    }
}
