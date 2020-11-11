<?php

namespace App\Http\Controllers;

use App\Mail\DemoEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function companyPage()
    {
        return view('companyall');
    }

    public function companyShowUsers($id)
    {
        return view('company_users');
    }


    public function sendMail(Request $request)
    {
        $user=User::find($request->id);
        switch($user->role_id)
        {
            case 1: $role='admin'; break;
            case 2: $role='manager'; break;
            case 3: $role='user'; break;
            default:
            {
                $role="user";
            }
        }
        $token = $user->createToken('MyApp', [$role])->accessToken;
        $string=$token;
        $details = [
            'to' => $user->email,
            'from' => ['address' => env('MAIL_USERNAME', 'tmuralev777999@yandex.kz'), 'name' => env('APP_NAME', 'Invation')],
            'subject' => 'Invate',
            'title' => 'Invate ',
            "body"  => $string
        ];

        Mail::to($user->email)->send(new \App\Mail\DemoEmail($details));
        return $token;
    }
}
