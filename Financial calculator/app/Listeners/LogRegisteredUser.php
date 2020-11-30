<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class LogRegisteredUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $role = DB::table('roles')->where('slug', config('app.roleUser'))->first();        
        DB::table('role_user')->insert(
            ['user_id' => $event->user->id, 'role_id' => $role->id]
        );        
    }
}
