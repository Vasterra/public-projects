<?php
use App\Products\Products;
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Wholistically Healthy</title>
    <!-- Styles -->
    <style>.cl_850269 body {
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            margin-left: 0px;
        }
        @media (max-width: 600px) {
            .cl_850269 .container_mr_css_attr {
                width: 94% !important;
            }
            .cl_850269 .main-action-cell_mr_css_attr {
                float: none !important;
                margin-right: 0px !important;
            }
            .cl_850269 .secondary-action-cell_mr_css_attr {
                text-align: center;
                width: 100%;
            }
            .cl_850269 .header_mr_css_attr {
                margin-top: 20px !important;
                margin-bottom: 2px !important;
            }
            .cl_850269 .shop-name__cell_mr_css_attr {
                display: block;
            }
            .cl_850269 .order-number__cell_mr_css_attr {
                display: block;
                text-align: left !important;
                margin-top: 20px;
            }
            .cl_850269 .button_mr_css_attr {
                width: 100%;
            }
            .cl_850269 .or_mr_css_attr {
                margin-right: 0px !important;
            }
            .cl_850269 .apple-wallet-button_mr_css_attr {
                text-align: center;
            }
            .cl_850269 .customer-info__item_mr_css_attr {
                display: block;
                width: 100% !important;
            }
            .cl_850269 .spacer_mr_css_attr {
                display: none;
            }

            .cl_850269 .subtotal-spacer_mr_css_attr {
                display: none;
            }
        }
    </style>
</head>
<body>
<table class="row_mr_css_attr" style="width: 100%;border-spacing: 0;border-collapse: collapse;">
    <tbody>
    <tr>
        <td width="20%"></td>
        <td width="60%" class="shop-name__cell_mr_css_attr" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;">
            <img src="{{$message->embed(asset('logo.png'))}}" alt="Wholistically Healthy" style="margin: 10px;" width="300">
            <span class="order-number__text_mr_css_attr" style="font-size: 16px; float: right; margin-top: 30px;">  Order #{{$body->order_number}}</span>
        </td>
        <td width="20%"></td>
    </tr>

    <tr>
        <td width="20%"></td>
        <td width="60%" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;">
            <h2 style="font-weight: normal;font-size: 24px;margin: 20px 0 10px; ">
                Your order has been delivered. Have a nice day!
            </h2>
        </td>
        <td width="20%"></td>
    </tr>

    <tr>
        <td width="20%"></td>
        <td width="60%">
            <table style="float: left; margin-right: 15px;">
                <tbody>
                <tr>
                    <td class="button__cell_mr_css_attr"
                        style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;border-radius: 4px;"
                        align="center"
                        bgcolor="#f3987f">
                        <a href="{{$body->order_status_url}}"
                           class="button__text_mr_css_attr"
                           style="font-size: 16px;text-decoration: none;display: block;color: #fff;padding: 20px 25px;"
                           target="_blank"
                           rel=" noopener noreferrer">View
                            your
                            order</a>
                    </td>
                </tr></tbody>
            </table>
            <div style="float: left; margin-top: 20px;">or <a
                    href="https://whly.com.au"
                    style="font-size: 16px;text-decoration: none;color: #f3987f;"
                    target="_blank"
                    rel=" noopener noreferrer">Visit
                    our
                    store</a>
            </div>
        </td>
        <td width="20%"></td>
    </tr>
    </tbody>
</table>

<hr width="100%">

<table class="row_mr_css_attr" style="width: 100%;border-spacing: 0;border-collapse: collapse;">
    <tbody>
    <tr>
        <td width="20%"></td>
        <td width="60%">
            <h3> Items in the shipment.</h3>
        </td>
        <td width="20%"></td>
    </tr>
    </tbody>
</table>

<table class="row_mr_css_attr" style="width: 100%;border-spacing: 0;border-collapse: collapse;">
    <tbody>
    @foreach($body->line_items as $product)
        <tr>
            <td width="20%"></td>
            <td width="60%">
                <table>
                    <tbody>
                    <tr>
                        <td width="10%"><img src="{{Products::getimagesProduct($product->product_id)->images[0]->src}}" style="width: 50px;"></td>
                        <td><h5> <b>{{$product->title}} x {{$product->quantity}}</b></h5></td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td width="20%"></td>
        </tr>
    @endforeach
    </tbody>
</table>

<hr width="100%">


<table class="row_mr_css_attr" style="width: 100%;border-spacing: 0;border-collapse: collapse;">
    <tbody>
    <tr>
        <td width="20%"></td>
        <td width="60%">
            <p> If you have questions, reply to this email or contact us at hello@whly.com.au.</p>
        </td>
        <td width="20%"></td>
    </tr>
    </tbody>
</table>

</body>
</html>
