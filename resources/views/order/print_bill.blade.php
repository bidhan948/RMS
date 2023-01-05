<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>PRINT::BILL</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
        }

        /*#receipt_heading {*/
        /*    padding-left: 20px;*/
        /*}*/

        /*.ml-105 {*/
        /*    margin-left: 55px !important;*/
        /*}*/

        /*.ml-110 {*/
        /*    margin-left: 20px !important;*/
        /*}*/
    </style>
</head>
<div class="container-fluid my-2">
    <div class="row">
        {{-- <!--<div class="col-4">-->
            <!--<p class="font-weight-bold mb-0">-->
            <!--    <strong>-->
            <!--        @for ($i = 0; $i < 5; $i++)-->
            <!--            *-->
            <!--        @endfor-->
            <!--    </strong>-->
            <!--</p>--> --}}
            <p style="text-align:center; font-size:0.6rem;font-weight:bold; ">The Coffe Bar</p>
            <span style="text-align:center; font-size:0.5rem;" style="">Kanchanbari, Biratnagar</span><br>
            <span style="text-align:center; font-size:0.5rem;">Estimate Bill</span>
            {{-- <!--<p class="font-weight-bold mb-0">-->
            <!--    <strong>-->
            <!--        @for ($i = 0; $i < 5; $i++)-->
            <!--            *-->
            <!--        @endfor-->
            <!--    </strong>-->
            <!--</p>--> --}}
            <span id="receipt_heading" class="mb-0" style="font-size:0.3rem; text-align:center;">
                {{ date('Y-m-d H:i:s') }}
            </span>
            {{-- <!--<p class="font-weight-bold mb-0 mt-0">-->
            <!--    <strong>-->
            <!--        @for ($i = 0; $i < 5; $i++)-->
            <!--            --->
            <!--        @endfor-->
            <!--    </strong><br>-->
            <!--    <strong>-->
            <!--        @for ($i = 0; $i < 5; $i++)-->
            <!--            --->
            <!--        @endfor-->
            <!--    </strong>-->
            <!--</p>--> --}}
            <table class="table table-borderless" style="margin-top:-2px !important;">
                <thead style="font-size:0.5rem;">
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody style="font-size:0.4rem !important;">
                    @foreach ($orders as $order)
                        <tr style="font-size:0.4rem;">
                            <td >{{$order->Item->name}}</td>
                            <td >{{$order->quantity}}</td>
                            <td >{{$order->total}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="2" >Discount :</td>
                        <td >{{$orders[0]->discount .' %'}}</td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="2" >Total :</td>
                        <td >{{$orders[0]->paid_amount}}</td>
                    </tr>
                </tbody>
            </table>
            {{-- <!--<p class="font-weight-bold mb-0">-->
            <!--    <strong>-->
            <!--        @for ($i = 0; $i < 3; $i++)-->
            <!--            *-->
            <!--        @endfor-->
            <!--        THANK YOU-->
            <!--        @for ($i = 0; $i < 3; $i++)-->
            <!--            *-->
            <!--        @endfor-->
            <!--    </strong>-->
            <!--</p>-->
        <!--</div>--> --}}
    </div>
</div>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
