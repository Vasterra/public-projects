<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- Styles -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    <style>
        h2, .h2 {
            font-size: 1.0rem;
        }
        p {
            margin-top: 0;
            margin-bottom: 0;
        }
        .steps{
            padding: 10px;
        }
        div.breakNow { page-break-inside:avoid; page-break-after:always; }
    </style>

    <title>{{ $title }}</title>
</head>
<body>
@foreach($order as $orderC)
<div>
    <div style="text-align: center;"><img src="logo.jpg"></div>
    <h3 style="position: absolute; top: 0px">#{{$orderC[0]}}</h3>
    <h3 style="text-align: center">
        {{$orderC[1]}}
    </h3>
</div>
<div>
    <p>
        {!! $orderC[2] !!}
    </p>
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
    @foreach($orderC[3] as $product)
        <tr>
            <th scope="row">{{$product['name']}}</th>
            <td>{{$product['quantity']}}</td>
            <td>{{$product['price']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<h5 style="text-align: right">
    Delivery price: 12
</h5>
<h4 style="text-align: right">
    Total price: {{$orderC[4]}}
</h4>
<div class="breakNow"></div>
@endforeach

</body>
</html>
