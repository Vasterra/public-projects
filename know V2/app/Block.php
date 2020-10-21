<?php

namespace App;

use App\BlocksValues;
use Illuminate\Database\Eloquent\Model;
use App\BlockType;
class Block extends Model
{
    protected $table="bloks";

    public function typer()
    {
        return $this->hasOne( BlockType::class, "id", "type_id" );
    }

    public function valer()
    {
        return $this->hasMany(BlocksValues::class, 'block_id', 'id');
    }
}
