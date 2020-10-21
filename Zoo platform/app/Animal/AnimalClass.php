<?php
namespace App\Animal;

use App\Animal;
use Illuminate\Http\Request;

class AnimalClass
{

    public function selectAllRecords()
    {
        return Animal::with( 'category' )->with( 'view' );
    }

    public function __construct()
    {
    }
}


?>
