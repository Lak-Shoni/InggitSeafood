<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice {
            max-width: 800px;
            margin: auto;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .invoice h2 {
            text-align: center;
        }

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .invoice table,
        .invoice th,
        .invoice td {
            border: 1px solid #000;
        }

        .invoice th,
        .invoice td {
            padding: 8px;
            text-align: left;
        }
    </style>
    <link rel="stylesheet" href="invoice.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <div class="container bootdey">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="widget-box">
                    <div class="widget-header widget-header-large">
                        <h3 class="widget-title grey lighter">
                            <i class="ace-icon fa fa-leaf green"></i>
                            Invoice
                        </h3>

                        <div class="widget-toolbar no-border invoice-info">
                            <span class="invoice-info-label">Invoice:</span>
                            <span class="red">#{{ $order->id }}</span>

                            <br>
                            <span class="invoice-info-label">Date:</span>
                            <span class="blue">{{ $order->created_at->format('d/m/Y') }}</span>
                        </div>

                        <div class="widget-toolbar hidden-480">
                            <a href="#" onclick="window.print();">
                                <i class="ace-icon fa fa-print"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-24">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                            <b>Company Info</b>
                                        </div>
                                    </div>

                                    <div>
                                        <ul class="list-unstyled spaced">
                                            <li>
                                                <i class="ace-icon fa fa-caret-right blue"></i>Street, City
                                            </li>

                                            <li>
                                                <i class="ace-icon fa fa-caret-right blue"></i>Zip Code
                                            </li>

                                            <li>
                                                <i class="ace-icon fa fa-caret-right blue"></i>State, Country
                                            </li>

                                            <li>
                                                <i class="ace-icon fa fa-caret-right blue"></i>
                                                Phone:
                                                <b class="red">111-111-111</b>
                                            </li>

                                            <li class="divider"></li>

                                            <li>
                                                <i class="ace-icon fa fa-caret-right blue"></i>
                                                Payment Info
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- /.col -->

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                            <b>Customer Info</b>
                                        </div>
                                    </div>

                                    <div>
                                        <ul class="list-unstyled  spaced">
                                            <li>
                                                <i class="ace-icon fa fa-caret-right green"></i>{{ $user->name }}
                                            </li>
                                            <li>
                                                <i class="ace-icon fa fa-caret-right green"></i>{{ $order->address }}
                                            </li>
                                            <li>
                                                <i class="ace-icon fa fa-caret-right green"></i>{{ $user->email }}
                                            </li>

                                            <li class="divider"></li>

                                            <li>
                                                <i class="ace-icon fa fa-caret-right green"></i>
                                                Contact Info
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.row -->

                            <div class="space"></div>

                            <div>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>Item</th>
                                            <th class="hidden-xs">Description</th>
                                            <th class="hidden-480">Price</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($carts as $index => $cart)
                                        <tr>
                                            <td class="center">{{ $index + 1 }}</td>
                                            <td>{{ $cart->item_name }}</td>
                                            <td class="hidden-xs">{{ $cart->description }}</td>
                                            <td>{{ number_format($cart->price, 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="hr hr8 hr-double hr-dotted"></div>

                            <div class="row">
                                <div class="col-sm-5 pull-right">
                                    <h4 class="pull-right">
                                        Total amount :
                                        <span class="red">Rp. {{ number_format($order->total_price, 2, ',', '.') }}</span>
                                    </h4>
                                </div>
                                <div class="col-sm-7 pull-left"> Additional Information </div>
                            </div>

                            <div class="space-6"></div>
                            <div class="well">
                                Thank you for choosing our services.
                                We believe you will be satisfied by our services.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
