@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12" style="margin-top: 20px; border: 1px dashed; padding: 20px; text-align: center;">
            <h2 style="font-size: 25px">{{$DateOrder}}</h2>
                <a href="/cookpdf/{{$list}}" style="text-align: center; font-size: 15px">Export to PDF</a>
            </div>
            @foreach($Orders as $product)
                <div class="col-8" style="margin-top: 20px; border: 1px dashed; padding: 20px;">
                    <h2 style="font-size: 20px">{{$product["name"]}}</h2>
                </div>
                <div class="col-4" style="margin-top: 20px; border: 1px dashed; padding: 20px;">
                    <h2 style="font-size: 20px; text-align: center">{{$product["quantity"]}}</h2>
                </div>
            @endforeach
        </div>
    </div>
@endsection


