@extends('voyager::master')
@section('content')
    @php
        use Illuminate\Support\Facades\Auth;
        use App\Models\User;
        $idUser=Auth::user()->id;
        $roleUser=Auth::user()->role_id;
        $name=Auth::user()->name;
        $email=Auth::user()->email;
        $users=User::where('is_company', 0)->where('activated', 0)->get()->sortBy('activated');
        $companies=User::where('is_company', 1)->where('activated', 0)->get()->sortBy('activated');

        function check_role($role)
        {
            switch ($role)
            {
            case 1: return "Administrator";
            case 2: return "Company";
            case 3: return "User";
            }
        }
    @endphp
    <div class="page-content">
        <br>
        <h1 style="text-align: center">Invite Company</h1>
        <table class="table table-hover dataTable no-footer" style="width: 90%; margin: 50px;">
            @foreach($companies as $user)
                <tr class="odd" style="border: 1px solid;">
                    <td style="padding: 10px;">{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{check_role($user->role_id)}}</td>
                    <td>
                        <form action="/mail" method="post">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <input type="hidden" name="email" value="{{$user->email}}">
                            <input type="hidden" name="id" value="{{$user->id}}">
                            @php
                                if ($user->activated>0) $color="green"; else $color="orange";
                            @endphp
                            <input type="submit" class="btn btn-sm btn-warning pull-right view" style="margin: 10px; background: {{$color}}" value="Send Invation" />
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        <h1 style="text-align: center">Invite Employer</h1>
        <table class="table table-hover dataTable no-footer" style="width: 90%; margin: 50px;">
        @foreach($users as $user)
                <tr class="odd" style="border: 1px solid;">
                    <td style="padding: 10px;">{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{check_role($user->role_id)}}</td>
                    <td>
                        <form action="/mail" method="post">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <input type="hidden" name="email" value="{{$user->email}}">
                            <input type="hidden" name="id" value="{{$user->id}}">
                            @php
                            if ($user->activated>0) $color="green"; else $color="orange";
                            @endphp
                            <input type="submit" class="btn btn-sm btn-warning pull-right view" style="margin: 10px; background: {{$color}}" value="Send Invation" />
                        </form>
                    </td>
                </tr>
        @endforeach
        </table>
    </div>
@stop
