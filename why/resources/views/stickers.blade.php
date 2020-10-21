@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="accordion" id="accordionTM">
                    <h1>Current orders: {{date("d.m.Y H:i", strtotime($dt1))}} - {{date("d.m.Y H:i", strtotime($dt2))}} </h1>
                    @php  $i=0; @endphp
                @foreach($orders->orders as $order)
                        @php  $i++;  @endphp
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col" style="width: 2%">#</th>
                                                <th scope="col" style="width: 10%">№</th>
                                                <th scope="col" style="width: 20%">Customer</th>
                                                <th scope="col" style="width: 30%">Delivery address</th>
                                                <th scope="col">total price</th>
                                                <th scope="col">action</th>
                                                <th scope="col">created at</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row" style="width: 2%">{{$i}}</th>
                                                <th scope="row" style="width: 10%">{{$order->order_number}}</th>
                                                <td style="width: 20%">{{$order->billing_address->name}}</td>
                                                <td style="width: 30%">
                                                    {{$order->billing_address->city}} |
                                                    {{$order->billing_address->address1}} {{$order->billing_address->address2}}
                                                </td>
                                                <td>{{$order->total_price}}</td>
                                                <td><a href="{{route('pdf', ['id' => $order->id])}}" target="_blank">Print</a></td>
                                                <td>{{date("d.m.Y H:i", strtotime($order->created_at))}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($order->billing_address->latitude==null)
                                        <div style="background: red">
                                    @endif
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                                                MORE
                                                @if ($order->billing_address->latitude==null)
                                                   <span style="color: white"> There is no latitude and longitude, so this order cannot be added to Road Warriar.</span>
                                                @endif
                                            </button>
                                    @if ($order->billing_address->latitude==null)
                                        </div>
                                    @endif
                                </h2>
                            </div>
                            <div id="collapse{{$i}}" class="collapse" aria-labelledby="headingThree" data-parent="#accordionTM">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-7">
                                            <h3>Delivery address</h3>
                                            <p>
                                                <b>country:</b> {{$order->billing_address->country}}({{$order->billing_address->country_code}}) &nbsp;
                                                <b>province:</b> {{$order->billing_address->province}}({{$order->billing_address->province_code}}) &nbsp;
                                                <b>city:</b> {{$order->billing_address->city}}
                                            </p>
                                            <p>
                                                <b>address1:</b> {{$order->billing_address->address1}}  &nbsp;
                                                <b>address2:</b> {{$order->billing_address->address2}}
                                            </p>
                                            <p>
                                            @if ($order->billing_address->latitude==null)
                                                <div style="background: red">
                                            @endif
                                                <b>latitude:</b> {{$order->billing_address->latitude}}  &nbsp;
                                                <b>longitude:</b> {{$order->billing_address->longitude}}
                                            @if ($order->billing_address->latitude==null)
                                                </div>
                                            @endif
                                            </p>
                                            <p>
                                                <b>phone:</b> {{$order->billing_address->phone}} &nbsp;
                                                <b>zip:</b> {{$order->billing_address->zip}}
                                            </p>
                                        </div>
                                        <div class="col-5" style="background: #5a6268; color: white">
                                            <b>email: {{$order->email}}</b> <br>
                                            <b>created at: {{date("d.m.Y H:i", strtotime($order->created_at))}}</b> <br>
                                            gateway: {{$order->gateway}} <br>
                                            <b>status:</b> {{$order->financial_status}} <br>
                                            <h3>total price: {{$order->total_price}} {{$order->currency}}</h3>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->line_items as $product)
                                            <tr>
                                                <th scope="row">{{$product->name}}</th>
                                                <td>{{$product->price}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="accordion" id="accordionTM">
                    <br><br><br>
                    <h1>Next orders: {{date("d.m.Y H:i", strtotime($dt2))}} - {{date("d.m.Y H:i", strtotime($dt3))}} </h1>
                    @php  $i=0; @endphp
                    @foreach($ordersNext->orders as $order)
                        @php  $i++;  @endphp
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col" style="width: 2%">#</th>
                                                <th scope="col" style="width: 10%">№</th>
                                                <th scope="col" style="width: 20%">Customer</th>
                                                <th scope="col" style="width: 30%">Delivery address</th>
                                                <th scope="col">total price</th>
                                                <th scope="col">action</th>
                                                <th scope="col">created at</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row" style="width: 2%">{{$i}}</th>
                                                <th scope="row" style="width: 10%">{{$order->order_number}}</th>
                                                <td style="width: 20%">{{$order->billing_address->name}}</td>
                                                <td style="width: 30%">
                                                    {{$order->billing_address->city}} |
                                                    {{$order->billing_address->address1}} {{$order->billing_address->address2}}
                                                </td>
                                                <td>{{$order->total_price}}</td>
                                                <td><a href="{{route('pdf', ['id' => $order->id])}}" target="_blank">Print</a></td>
                                                <td>{{date("d.m.Y H:i", strtotime($order->created_at))}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($order->billing_address->latitude==null)
                                        <div style="background: red">
                                            @endif
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                                                MORE
                                                @if ($order->billing_address->latitude==null)
                                                    <span style="color: white"> There is no latitude and longitude, so this order cannot be added to Road Warriar.</span>
                                                @endif
                                            </button>
                                            @if ($order->billing_address->latitude==null)
                                        </div>
                                    @endif
                                </h2>
                            </div>
                            <div id="collapse{{$i}}" class="collapse" aria-labelledby="headingThree" data-parent="#accordionTM">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-7">
                                            <h3>Delivery address</h3>
                                            <p>
                                                <b>country:</b> {{$order->billing_address->country}}({{$order->billing_address->country_code}}) &nbsp;
                                                <b>province:</b> {{$order->billing_address->province}}({{$order->billing_address->province_code}}) &nbsp;
                                                <b>city:</b> {{$order->billing_address->city}}
                                            </p>
                                            <p>
                                                <b>address1:</b> {{$order->billing_address->address1}}  &nbsp;
                                                <b>address2:</b> {{$order->billing_address->address2}}
                                            </p>
                                            <p>
                                            @if ($order->billing_address->latitude==null)
                                                <div style="background: red">
                                                    @endif
                                                    <b>latitude:</b> {{$order->billing_address->latitude}}  &nbsp;
                                                    <b>longitude:</b> {{$order->billing_address->longitude}}
                                                    @if ($order->billing_address->latitude==null)
                                                </div>
                                                @endif
                                                </p>
                                                <p>
                                                    <b>phone:</b> {{$order->billing_address->phone}} &nbsp;
                                                    <b>zip:</b> {{$order->billing_address->zip}}
                                                </p>
                                        </div>
                                        <div class="col-5" style="background: #5a6268; color: white">
                                            <b>email: {{$order->email}}</b> <br>
                                            <b>created at: {{date("d.m.Y H:i", strtotime($order->created_at))}}</b> <br>
                                            gateway: {{$order->gateway}} <br>
                                            <b>status:</b> {{$order->financial_status}} <br>
                                            <h3>total price: {{$order->total_price}} {{$order->currency}}</h3>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->line_items as $product)
                                            <tr>
                                                <th scope="row">{{$product->name}}</th>
                                                <td>{{$product->quantity}}</td>
                                                <td>{{$product->price}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
