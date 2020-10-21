<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consist extends Model
{
    protected $table = 'product_recipes';

    /**
     * @param $id
     * @return mixed
     */
    public static function getProductsConsists($id)
    {
        return self::where("id_product", $id)->join('products', 'products.id', '=', 'id_consists')->get()->toArray();
    }
}
