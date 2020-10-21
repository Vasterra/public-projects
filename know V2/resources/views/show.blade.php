@extends('layouts.app')

@section('menu')
    <div class="top-right links">
        <a sh href="/">Главная</a>
        @if(Auth::user())
            <a href="/templates/{{$id}}/edit">Редактировать</a>
        @endif
    </div>
@endsection

@section('content')
    <div class="content" ng-app="knowShow" ng-controller="ShowController" ng-init="loadVaribles({{$id}})"
         style="margin-bottom: 150px;">
        <div ng-repeat="block in blocks | orderBy: 'sort'">
            <div ng-switch on="block.type_id">
                @foreach($bt as $block)
                    <div ng-switch-when="{{$block['id']}}">
                        <div class="row">
                            <div class="col-12">
                                <my-h1 value1=block.valer typer="{{$block['template_production']}}"
                                       sort=block.sort></my-h1>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
