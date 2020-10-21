@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
                <div class="col-6" style="margin-top: 20px; border: 1px dashed; padding: 20px;">
                    <h2 style="font-size: 20px">{{$product["name"]}}</h2>
                </div>
                <div class="col-6" style="margin-top: 20px; border: 1px dashed; padding: 20px;">
                    @php $i=0; @endphp
                    @foreach($product["consist"] as $consist)
                        <h2><b>{{++$i}}.</b> ({{$consist["quantity"]}}) {{$consist['name']}}</h2>
                    @endforeach
                    <button onclick="window.location.href='/products/{{$product["id"]}}'">Refresh</button>
                </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            @foreach($products as $productAll)
                @php $x=1; @endphp
                @if($productAll["id"]==$product["id"])
                @php continue; @endphp
                @endif
                <div class="col-3" style="margin-top: 20px; border: 1px dashed; padding: 20px; ">
                    <table>
                        <tr>
                            <td style="vertical-align: top;">
                                <input id="id{{$productAll["id"]}}" type="checkbox" onclick='forgotpass("{{$productAll["id"]}}");'
                                @foreach($product["consist"] as $consist)
                                    @if(in_array($consist["id_consists"], $productAll, true))
                                    @php $x=$consist["quantity"]; @endphp
                                        checked
                                    @endif
                                @endforeach
                                >
                            </td>
                            <td>
                                <label for="id1" style="margin-left: 10px; margin-right: 22px;">{{$productAll["name"]}}</label>
                                <input id="number{{$productAll["id"]}}" oninput="forgotpass('{{$productAll["id"]}}')" type="number" value="{{$x}}" style="text-align: center; position: absolute; right: 3px; top: 5px; width: 40px;">
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        function forgotpass(id) {
            var cbox=document.getElementById('id'+id);
            var number=document.getElementById('number'+id);
            var sendnumber=number.value;
            if (cbox.checked)
            {
                axios.get('/products/addconsist/{{$product["id"]}}/'+id+'/'+sendnumber).then(response => (console.log(response.data)));
            }
            else
            {
                axios.get('/products/delete/{{$product["id"]}}/'+id).then(response => (console.log(response.data)));
            }
        }


    </script>

@endsection
