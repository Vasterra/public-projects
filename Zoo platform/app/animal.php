<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AnimalCategory;
use App\AnimalView;

class animal extends Model
{
    protected $fillable = [
        'name', 'description', 'id_category', 'id_wiew',
    ];


    public function category()
    {
        return $this->hasOne( AnimalCategory::class, "id", "id_category" );
    }


    public function view()
    {
        return $this->hasOne( AnimalView::class, "id", "id_wiew" );
    }

}
