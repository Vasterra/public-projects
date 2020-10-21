@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                @if(count($Orders)>0)
                    <h1 style="text-align: center">Some Routes not added to Road Warriar service.</h1>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Error</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i=0; @endphp
                        @foreach($Orders as $order)
                            @php $i++; @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$order["Name"]}}</td>
                                <td>{{$order["Address"]}}</td>
                                <td>{{$order["Email"]}}</td>
                                <td>{{$order["Phone"]}}</td>
                                <td>{{$order["Error"]}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h1 style="text-align: center">All Routes added to Road Warriar service successfully.</h1>
                @endif
            </div>
        </div>
    </div>

@endsection
