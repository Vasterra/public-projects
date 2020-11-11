<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table( 'roles' )->insert( [ 'name' => 'admin', 'display_name'=> 'Administrator', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'roles' )->insert( [ 'name' => 'company', 'display_name'=> 'company', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'roles' )->insert( [ 'name' => 'user', 'display_name'=> 'User', 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'users' )->insert( [ 'name' => 'administrator', 'email' => 'admin@admin.com', 'password' => Hash::make( '{2JSD%Tgt*6W0WC<o' ), 'email_verified_at' => date( 'Y-m-d' ), 'role_id' =>1, 'activated' => 1, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'users' )->insert( [ 'name' => 'managerTest', 'email' => 'manager@manager.com', 'password' => Hash::make( '12345678' ), 'email_verified_at' => date( 'Y-m-d' ), 'role_id' =>2, 'activated' => 1, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'users' )->insert( [ 'name' => 'userTest', 'email' => 'user@user.com', 'password' => Hash::make( '12345678' ), 'email_verified_at' => date( 'Y-m-d' ), 'role_id' =>3, 'activated' => 1, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'users' )->insert( [ 'name' => 'userTest', 'email' => 'user11@user.com', 'password' => Hash::make( '12345678' ), 'email_verified_at' => date( 'Y-m-d' ), 'role_id' =>3, 'activated' => 1, 'owner_id' => 2, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'users' )->insert( [ 'name' => 'userTest', 'email' => 'user22@user.com', 'password' => Hash::make( '12345678' ), 'email_verified_at' => date( 'Y-m-d' ), 'role_id' =>3, 'activated' => 1, 'owner_id' => 2, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'users' )->insert( [ 'name' => 'userTest', 'email' => 'user33@user.com', 'password' => Hash::make( '12345678' ), 'email_verified_at' => date( 'Y-m-d' ), 'role_id' =>3, 'activated' => 1, 'owner_id' => 2, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'users' )->insert( [ 'name' => 'userTest', 'email' => 'user44@user.com', 'password' => Hash::make( '12345678' ), 'email_verified_at' => date( 'Y-m-d' ), 'role_id' =>3, 'activated' => 1, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'users' )->insert( [ 'name' => 'userTest', 'email' => 'user55@user.com', 'password' => Hash::make( '12345678' ), 'email_verified_at' => date( 'Y-m-d' ), 'role_id' =>3, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'userinformations' )->insert( [ 'user_id' => 1, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'userinformations' )->insert( [ 'user_id' => 2, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'userinformations' )->insert( [ 'user_id' => 3, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'userinformations' )->insert( [ 'user_id' => 4, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'userinformations' )->insert( [ 'user_id' => 5, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'userinformations' )->insert( [ 'user_id' => 6, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'userinformations' )->insert( [ 'user_id' => 7, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
        DB::table( 'userinformations' )->insert( [ 'user_id' => 8, 'created_at' => date( 'Y-m-d' ), 'updated_at' => date( 'Y-m-d' ) ] );
    }


}
