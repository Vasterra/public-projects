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
    </style>

</head>
<body>
    <h3 style="text-align: center">
        {{$DateOrder}}
    </h3>
<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Quantity</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $product)
        <tr>
            <th scope="row">{{$product["name"]}}</th>
            <td>{{$product["quantity"]}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
