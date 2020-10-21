@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2 col-sm-12">
            </div>
            <div class="col-md-12 col-sm-12">
                <h2 style="text-align: center; width: 100%;">Please enter the name of Route if you don't will be default name.</h2>
            </div>
            <div class="col-4 col-sm-12 d-flex justify-content-center">
                <input type="text" id="edrout" style="width: 300px; margin-bottom: 20px; border: 1px solid;">
            </div>
            <div class="col-md-2 col-sm-12">
            </div>

            <div class="col-md-12 col-sm-12 d-flex justify-content-center" style="margin: 10px;">
                <button  onclick="window.location.href='/roadwarriarAll/'+document.getElementById('edrout').value" style="width: 300px; height: 60px;"> Route All</button>
            </div>
            <div class="col-md-12 col-sm-12 d-flex justify-content-center" style="margin: 10px;">
                <button  onclick="window.location.href='/roadwarriarCurrent/'+document.getElementById('edrout').value" style="width: 300px; height: 60px;"> Route This Week <br> {{date("d.m.Y H:i", strtotime($dt1))}} - {{date("d.m.Y H:i", strtotime($dt2))}}</button>
            </div>
            <div class="col-md-12 col-sm-12 d-flex justify-content-center" style="margin: 10px;">
                <button  onclick="window.location.href='/roadwarriarNext/'+document.getElementById('edrout').value" style="width: 300px; height: 60px;"> Route Next Week <br> {{date("d.m.Y H:i", strtotime($dt2))}} - {{date("d.m.Y H:i", strtotime($dt3))}}</button>
            </div>
        </div>
    </div>

@endsection
