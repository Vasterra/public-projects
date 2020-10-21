<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateCategory extends Model
{
    protected $table='template_categories';

    public function templ()
    {
        return $this->hasMany(Template::class, 'category_id', 'id');
    }
}
