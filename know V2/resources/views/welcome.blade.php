@extends('layouts.app')

@section('menu')
    <div class="top-right links">
        <a sh href="/">Главная</a>
        <a href="/templates/{{$id}}">Показать</a>
    </div>
@endsection

@section('content')
    <div class="content" ng-app="knowModule" ng-controller="TaskController" ng-init="loadVaribles({{$id}})">
        <div ng-repeat="block in blocks | orderBy: 'sort'">
            <div ng-switch on="block.type_id">
                @foreach($bt as $block)
                    <div ng-switch-when="{{$block['id']}}">
                        <div class="row">
                            <div class="col-11">
                                <my-h1 value1=block.valer typer="{{$block['template_edition']}}" sort=block.sort></my-h1>
                            </div>
                            <div class="col-1">
                                <edit value1=block.id typer="{{$block['template_edition']}}" sort=block.sort></edit>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div style="height: 150px; width: 200px"></div>
        <div class="container fixedComponentsAdd">
            <div class="row">
                <div class="col-4">
                    <select ng-model="selectedCategory">
                        <option ng-repeat="categoryBlok in blockCategory " value="@{{categoryBlok.id}}">
                            @{{categoryBlok.name}}</option>
                    </select>
                </div>
                <div class="col-4">
                    <select ng-model="selectedType" ng-show="selectedCategory">
                        <option
                            ng-repeat="block in blockType | filter:{category_id:selectedCategory}" value="@{{block.id}}">
                            @{{block.name}}</option>
                    </select>
                </div>
                <div class="col-4">
                    <button ng-click="store(selectedType, {{$id}}, 'add')">add</button>
                    <button ng-click="store(blocks, 0, 'save')">save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
