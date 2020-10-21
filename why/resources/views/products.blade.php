@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @php $j=0; @endphp
            @foreach($products as $product)
                @php $j++; @endphp
                <div class="col-5" style="margin-top: 20px; border: 1px dashed; padding: 20px;">
                    <a href="/products/{{$product["id"]}}"><h2 style="font-size: 20px">{{$j}}) {{$product["name"]}}</h2></a>
                </div>
                <div class="col-5" style="margin-top: 20px; border: 1px dashed; padding: 20px;">
                    @php $i=0; @endphp
                    @foreach($product["consist"] as $consist)
                        <h2><b>{{++$i}}.</b> {{$consist['name']}}</h2>
                    @endforeach
                </div>
                <div class="col-2" style="margin-top: 20px; border: 1px dashed; padding: 20px; text-align: center">
                    <h2>If it is not a kit, press the button.</h2>
                    <button onclick="window.location.href='/products/{{$product["id"]}}/edit'">Take away</button>
                </div>
            @endforeach
        </div>
    </div>
@endsection
