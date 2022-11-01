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

        #receipt_heading {
            padding-left: 120px;
        }
        .ml-105{
            margin-left:105px !important;
        }
        .ml-110{
            margin-left:110px !important;
        }
    </style>
</head>
<div class="container-fluid my-2">
    <div class="row">
        <div class="col-4">
            <p class="font-weight-bold mb-0">
                <strong>
                    @for ($i = 0; $i < 32; $i++)
                        *
                    @endfor
                </strong>
            </p>
            <h4 id="receipt_heading">RECEIPT</h4>
            <p class="font-weight-bold mb-0">
                <strong>
                    @for ($i = 0; $i < 32; $i++)
                        *
                    @endfor
                </strong>
            </p>
            <span id="receipt_heading" class="mb-0">
                {{ date('Y-m-d') }}
            </span>
            <p class="font-weight-bold mb-0 mt-0">
                <strong>
                    @for ($i = 0; $i < 34; $i++)
                        -
                    @endfor
                </strong><br>
                <strong>
                    @for ($i = 0; $i < 34; $i++)
                        -
                    @endfor
                </strong>
            </p>
        </div>
    </div>
</div>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
