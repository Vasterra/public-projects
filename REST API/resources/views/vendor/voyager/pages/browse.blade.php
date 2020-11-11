@extends('voyager::master')
@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))
@php
$company=\App\Models\User::where('is_company', 1)->get();
function workSt($status_id)
{
    switch ($status_id)
    {
        case 1: return "Full-time";
        case 2: return "Contractor";
        case 3: return "Contractor + Full-time";
    }
    return "0";
}
@endphp

@section('page_header')
    <div class="container-fluid">
        <h1 style="text-align: center">Companies</h1>
        <table class="table table-hover dataTable no-footer" style="width: 90%; margin: 50px;">
            @foreach($company as $user)
                <tr class="odd" style="border: 1px solid;">
                    <td style="padding: 10px;">{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{ workSt($user->work_status)}}</td>
                    <td>{{ $user->created_at}}</td>
                    <td>
                        <form action="pages/{{$user->id}}" method="get">
                            <input type="submit" class="btn btn-sm btn-warning pull-right view" style="margin: 10px;" value="Company Users" />
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div><!-- /.modal -->
@stop
