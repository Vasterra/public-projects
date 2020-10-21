<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call( 'UsersTableSeeder' );
        $this->call( 'AnimalCategoryTableSeeder' );
        $this->call( 'AnimalsViewsTableSeeder' );
        $this->call( 'AnimalsSeeder' );
    }
}


class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table( 'users' )->insert( [ 'name' => 'Арнольд ЩварцНегр', 'email' => 't1@mail.ru', 'password' => Hash::make( '123' ), 'email_verified_at' => date( 'Y-m-d' ), 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'users' )->insert( [ 'name' => 'Тимати Диджей Дли', 'email' => 't2@mail.ru', 'password' => Hash::make( '123' ), 'email_verified_at' => date( 'Y-m-d' ), 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
    }

}


class AnimalCategoryTableSeeder extends Seeder
{

    public function run()
    {
        DB::table( 'animal_categories' )->insert( [ 'name' => 'Рыбы', 'slug' => 'fish', 'description' => 'Плаваю, что то там делают под водой. Очень не вкусные в кулинарии, кроме красных пород.', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animal_categories' )->insert( [ 'name' => 'Птицы', 'slug' => 'bird', 'description' => 'Некоторые летают, некоторые не умеют. Вообщем животные которые имеют крылья, перья и чаще всего умеют летать.', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animal_categories' )->insert( [ 'name' => 'Рептилии', 'slug' => 'reptile', 'description' => 'Очень не изученный мною как настоятелем зоопарка вид. Сказать о них можно только одно -"Я их боюсь". ', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
    }

}


class AnimalsViewsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table( 'animal_views' )->insert( [ 'name' => 'Белые акулы', 'slug' => 'sharks_whites', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animal_views' )->insert( [ 'name' => 'Акулы молоты', 'slug' => 'sharks_hummers', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animal_views' )->insert( [ 'name' => 'Пингвины', 'slug' => 'penguins', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animal_views' )->insert( [ 'name' => 'Страусы эму', 'slug' => 'emu', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animal_views' )->insert( [ 'name' => 'Обычная курица', 'slug' => 'chikcens', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animal_views' )->insert( [ 'name' => 'Змеи', 'slug' => 'snakes', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
    }

}


class AnimalsSeeder extends Seeder
{

    public function run()
    {
        DB::table( 'animals' )->insert( [ 'name' => 'Рыбка моя', 'description' => 'Маленькая моя рыбка.', 'id_wiew' => '1', 'id_category' => '1', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animals' )->insert( [ 'name' => 'Джамшуд', 'description' => 'Рыба гастарбайтер. Прибыла работать из будущего на благо рыб.', 'id_wiew' => '1', 'id_category' => '1', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animals' )->insert( [ 'name' => 'Перфаратор', 'description' => 'Осторожно эта рыба очень часто долбиться головой об стенки аквариума. Уже 2 раза его ломала.', 'id_wiew' => '2', 'id_category' => '1', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animals' )->insert( [ 'name' => 'Папа римский', 'description' => 'Он у нас один и так похож на священнослужителя в своем бело-черном цвете.', 'id_wiew' => '3', 'id_category' => '2', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animals' )->insert( [ 'name' => 'Дорожный бегун', 'description' => 'Он все же убежал от хитрого кайота. Но попал за решетку в наш зоопарк. А хитрого кайота убил Перфоратор когда второй раз сломал аквариум.', 'id_wiew' => '4', 'id_category' => '2', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animals' )->insert( [ 'name' => 'Легион', 'description' => 'Что то мне подсказывает. Что наш сторож стер надпись калибри и посадил своих курей с тучами цеплят. Предполагается что мы не знаем, что он этим самым экономит бюджет своего хозяйства. Все не решаюсь спросить где каллибри?  ', 'id_wiew' => '5', 'id_category' => '2', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animals' )->insert( [ 'name' => 'Вроде как кобра', 'description' => 'По виду кобра и помоему очковая. Спрашивать у кого времени нет, а подходить разглядывать чет я очкую', 'id_wiew' => '6', 'id_category' => '3', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animals' )->insert( [ 'name' => 'Не жив ни мертв', 'description' => 'Вроде как питон, да фиг его знает. Огромная гадина, жду когда полностью умрет и разложиться. Чем больше змея тем больше в нее яда может поместица. А эта прям бочка яда. И гадина перелетающих через забор кур ест и не умерает.', 'id_wiew' => '6', 'id_category' => '3', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'animals' )->insert( [ 'name' => 'Не входить', 'description' => 'Вробе бы мелкая змейка, но лучше не входить и не кормить. В тихом омуте...', 'id_wiew' => '6', 'id_category' => '3', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
    }
}
