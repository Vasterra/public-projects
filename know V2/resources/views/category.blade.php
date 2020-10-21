@extends('layouts.app')

@section('menu')
    <div class="top-right links">
        <a sh href="/">Главная</a>
        @if(Auth::user())
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="float: right">@csrf
                <input type="Submit" value="Выход"/>
            </form>
        @else
            <a href="{{ route('login') }}" style="float: right">Авторизация</a>
        @endif
    </div>
@endsection

@section('content')
    <div class="content" ng-app="knowIndex" ng-controller="IndexController" ng-init="loadVaribles()"
         style="margin-bottom: 150px;">
        <div class="row">
            <div class="col-12" ng-repeat="cat in category | orderBy: 'name' | filter:{parent_id:0}:true">
                <h1 ng-model="cat.name" contentEditable="@{{ ckCategory }}" class="titleCategory"></h1>
                <table style="width: 100%; margin-bottom: 10px; margin-top: 10px;">
                    <tr ng-repeat="temp in cat.templ | orderBy: 'name'" style="border-bottom: 1px solid;">
                        <td style="text-align: left">
                            <a href="/templates/@{{ temp.id }}" style="font-size: 20px;">-> </a><span
                                ng-model="temp.name" contentEditable="@{{ ckCategory }}"></span>
                        </td>
                        @if(Auth::user())
                            <td style="width: 230px;">
                                <a href="/templates/@{{ temp.id }}/edit">Редкактировать</a>
                            </td>
                            <td style="width: 30px;">
                                <button ng-click="storeTemplate(temp.id, '', 'delete')" class="buttonZZ">X</button>
                            </td>
                        @endif
                    </tr>
                </table>
                <div class="row">
                    <div class="col-6" ng-repeat="catx in category | filter:{parent_id:cat.id}:true | orderBy: 'name'">
                        <div class="d9">
                            <h3 ng-model="catx.name" contentEditable="@{{ ckCategory }}"></h3>
                        </div>
                        <table style="width: 100%; margin-bottom: 10px; margin-top: 10px;">
                            <tr ng-repeat="temp in catx.templ | orderBy: 'name'" style="border-bottom: 1px solid;">
                                <td style="text-align: left">
                                    <a href="/templates/@{{ temp.id }}" style="font-size: 20px;">-> </a><span
                                        ng-model="temp.name" contentEditable="@{{ ckCategory }}"></span>
                                </td>
                                @if(Auth::user())
                                    <td style="width: 230px;">
                                        <a href="/templates/@{{ temp.id }}/edit">Редкактировать</a>
                                    </td>
                                    <td style="width: 30px;">
                                        <button ng-click="storeTemplate(temp.id, '', 'delete')" class="buttonZZ">X
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        </table>
                        <div class="row">
                            <div class="col-12"
                                 ng-repeat="catv in category | filter:{parent_id:catx.id}:true | orderBy: 'name'">
                                <h5 class="titlesubcategory"
                                    ng-model="catv.name" contentEditable="@{{ ckCategory }}"></h5>
                                <table style="width: 100%; margin-bottom: 10px; margin-top: 10px;">
                                    <tr ng-repeat="temp in catv.templ | orderBy: 'name'"
                                        style="border-bottom: 1px solid;">
                                        <td style="text-align: left">
                                            <a href="/templates/@{{ temp.id }}" style="font-size: 20px;">-> </a><span
                                                ng-model="temp.name" contentEditable="@{{ ckCategory }}"></span>
                                        </td>
                                        @if(Auth::user())
                                            <td style="width: 230px;">
                                                <a href="/templates/@{{ temp.id }}/edit">Редкактировать</a>
                                            </td>
                                            <td style="width: 30px;">
                                                <button ng-click="storeTemplate(temp.id, '', 'delete')"
                                                        class="buttonZZ">X
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::user())
            <div class="container fixedComponentsAdd">
                <div class="row">
                    <div class="col-5">
                        <div class="row">
                            <div class="col-6">
                                <select ng-model="selectedCategory" class="inpx">
                                    <option value="0">Родительская</option>
                                    <option
                                        ng-repeat="ct in category | orderBy: 'name' | filter:{parent_id:0}:true" value="@{{ct.id}}">
                                        @{{ct.name}}
                                    </option>
                                </select>
                                <select ng-model="selectedCategory2" class="inpx">
                                    <option
                                        ng-repeat="ct in category | orderBy: 'name' | filter:{parent_id:toNumVal(selectedCategory)}:true"
                                        ng-if="(selectedCategory) && (ct.parent_id>0)" value="@{{ct.id}}">
                                        @{{ct.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input ng-model="ctname" class="inpx">
                                <button
                                    ng-click="store(checkAddCat(selectedCategory, selectedCategory2), ctname, 'add')"
                                    class="standButton">Добавить категорию
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <input type="checkbox" ng-model="ckCategory" id="chcat" style="font-size: 10px"> <label
                            for="chcat"
                            style="vertical-align: text-top; font-size: 10px">Редактировать</label>
                        <button ng-click="store(1, category, 'save')" class="standButton">Сохранить
                        </button>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-6">
                                <select ng-model="selectedTemCat" class="inpx">
                                    <option
                                        ng-repeat="ct in category | orderBy: 'name' | filter:{parent_id:0}:true " value="@{{ct.id}}">
                                        @{{ct.name}}
                                    </option>
                                </select>
                                <select ng-model="selectedTemCat1" class="inpx">
                                    <option
                                        ng-repeat="ct in category | orderBy: 'name' | filter:{parent_id:toNumVal(selectedTemCat)}:true "
                                        ng-if="selectedTemCat" value="@{{ct.id}}">
                                        @{{ct.name}}
                                    </option>
                                </select>
                                <select ng-model="selectedTemCat2" class="inpx">
                                    <option
                                        ng-repeat="ct in category | orderBy: 'name' | filter:{parent_id:toNumVal(selectedTemCat1)}:true "
                                        ng-if="selectedTemCat1" value="@{{ct.id}}">
                                        @{{ct.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input ng-model="temname" class="inpx">
                                <button
                                    ng-click="storeTemplate(checkAdd( selectedTemCat, selectedTemCat1, selectedTemCat2 ), temname, 'add')"
                                    class="standButton">Добавить шаблон
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
