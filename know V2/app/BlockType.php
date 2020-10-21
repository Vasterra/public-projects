<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BlockCategory;

class BlockType extends Model
{
    protected $table="block_types";

    public function category()
    {
        return $this->hasOne( BlockCategory::class, "id", "category_id" );
    }
    //
}
