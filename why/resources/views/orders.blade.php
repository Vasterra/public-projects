@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <form action="{{ url('/orders/deletelist') }}" method="post">
                    <input class="btn btn-default" type="submit" style="color: white; background: orange; border-color: black; padding: 5px; margin-bottom: 20px; width: 100%;" value="Delete this list." />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="col-6">
                <form action="{{ url('/orders/cancellall') }}" method="post">
                    <input class="btn btn-default" type="submit" style="color: white; background: red; border-color: black; padding: 5px; margin-bottom: 20px; width: 100%;" value="Cancel ALL" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="col-12">
                <div class="accordion" id="accordionTM">
                    @php  $i=0; @endphp
                    @foreach($orders as $order)
                        @php  $i++;  @endphp
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <div class="table-responsive">
                                        <table class="table"
                                            @if($order->status=="Compleate")
                                               style="background: greenyellow"
                                            @endif
                                        >
                                            <thead>
                                            <tr>
                                                <th scope="col" style="width: 2%">#</th>
                                                <th scope="col" style="width: 20%">№ / Customer</th>
                                                <th scope="col" style="width: 20%">Delivery address</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Delete Record</th>
                                                <th scope="col">Cancel order</th>
                                                <th scope="col">Compliate order</th>
                                                <th scope="col">created at</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="width: 2%">{{$i}}</td>
                                                <td style="width: 20%">{{$order->order_number}} / {{$order->customer}} <br> Total price: {{$order->total_price}}</td>
                                                <td style="width: 20%">{{$order->billing_address}}</td>
                                                <td>{{$order->status}} <br> @if($order->error) <b style="color: red; font-size: 10px;">Why not in road warriar: </b> <br>@endif <b style=" font-size: 12px;">{{$order->error}}</b></td>
                                                <td>
                                                    <button onclick="window.location.href='/orders/deleterecord/{{$order->order_number}}'" style="color: white; background: orange; border-color: orange; padding: 5px;" > Delete</button>
                                                </td>
                                                <td>
                                                    <button onclick="window.location.href='/orders/{{$order->order_number}}'" style="color: white; background: red; border-color: black; padding: 5px;" > Cancel</button>
                                                </td>

                                                <td>
                                                    <form action="{{ url('/orders', ['id' => $order->order_number]) }}" method="post">
                                                        <input class="btn btn-default" type="submit" style="color: white; background: green; border-color: black; padding: 5px" value="Compleate" />
                                                        <input type="hidden" name="_method" value="delete" />
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    </form>
                                                </td>
                                                <td>{{date("d.m.Y", strtotime($order->created_at))}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </h2>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
