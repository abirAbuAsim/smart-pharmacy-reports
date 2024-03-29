<!DOCTYPE html>
<html>
<head>
    <title>Sales Orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Dropdown menu -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Date Picker CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css"/>

    <!-- Date Picker JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


</head>
<style>
</style>
<body>

<div id="app">
    <nav class="navbar navbar-default navbar-inverse">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">AFC</a>
            </div>

        </div><!-- /.container-fluid -->
    </nav>

    <main class="py-4">
        <div class="container ">
            <div class="panel panel-default ">
                <div class="panel-heading">Search Sold Orders</div>
                <div class="panel-body">

                    <form class="form-inline" method="post" action="{{action('SalesOrderController@showSearchResult')}}">
                        @csrf
                        <label>From: </label>
                        <div id="fromDatePicker" class="input-group date" data-date-format="yyyy-mm-dd"
                             style="margin: 20px;">
                            <input type="text" class="form-control" id="fromDatePickerInput" name="fromDatePickerInput" value="Date" readonly/>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                        <label>To: </label>
                        <div id="toDatePicker" class="input-group date" data-date-format="yyyy-mm-dd" style="margin: 20px;">
                            <input type="text" class="form-control" id="toDatePickerInput" name="toDatePickerInput" value="Date" readonly/>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>

                        <div class="form-group" style="margin: 20px;">
                            <label for="selectedPharmacy">Select Pharmacy Name:</label>
                            <select class="form-control" id="selectedPharmacy" name="selectedPharmacy">
                                <option value=""> Please Choose Pharmacy</option>
                                @foreach ($pharmacyList as $pharmacy)
                                    <option value="{{$pharmacy['pharmacy_id']}}">{{$pharmacy['pharmacy_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-default">Search</button>
                    </form>
                </div>
            </div>

            {{ csrf_field() }}
            <div class="table-responsive text-center">
                <table id="salesOrderTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th class="text-center">Order Date</th>
                        <th class="text-center">Invoice Number</th>
                        <th class="text-center">Pharmacy Name</th>
                        <th class="text-center">Contact Number</th>
                        <th class="text-right">Actual Price</th>
                        <th class="text-right">Payable Price</th>
                        <th class="text-right">Discount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <?php

                        $orderArray = array(
                            "order_details_list"         => $order['order_details_list'],
                            "company_list"         => $companyArray
                        );

                        $order_json = json_encode($orderArray);
                        ?>

                        <tr>
                            <td class="text-center" id="date">{{ date('d-m-Y', strtotime($order['order_date'])) }}</td>
                            <td class="text-center">
                            <button type="button" style="text-decoration: none;" class="btn btn-link"
                                    onclick='getOrderDetailsData(<?php echo $order_json; ?>)' data-orderId="{{$order['invoice_number'] }}" data-toggle="modal" data-target="#myModal">
                                {{ $order['invoice_number'] }}</button>
                            </td>
                            <td class="text-center">{{ $order['pharmacy_name'] }}</td>
                            <td class="text-center">{{ $order['chemist_mobile_number'] }}</td>
                            <td class="text-right">{{ $order['total_actual_price'] }}</td>
                            <td class="text-right">{{ $order['total_payable_price'] }}</td>
                            <td class="text-right">{{ $order['discount'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>



                <!-- Modal -->
                <div class="example-modal">
                <div class="modal fade modal" id="reg_usr_details_modal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">Invoice View</h4>
                            </div> -->
                            <div class="modal-body">
                                <section class="invoice">
                                    <h2>Order Details</h2>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h2 id="modalHeaderTitle"></h2>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Company Name</th>
                                                        <th class="text-center">Medicine Name</th>
                                                        <th class="text-right">Quantity</th>
                                                        <th class="text-right">Price</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="rxRowSpan" class="text-center">

                                                    </tbody>


                                                </table>
                                            </div>

                                        </div><!-- /.col -->


                                        <!-- <div class="col-xs-6">
                                          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                            N:B - Demo text demo text demo text, Demo text demo text.
                                          </p>
                                        </div> -->
                                    </div>

                                    <!-- this row will not appear when printing -->
                                    <div class="row no-print">
                                        <div class="col-xs-12">
                                            <!-- <a href="#" target="_blank" class="btn btn-default pull-right" onclick="printDiv('myModal');"><i class="fa fa-print"></i> Print</a> -->
                                            <!-- <button class="btn btn-primary pull-right" onclick="printInvoice('myModal');" > <i class="fa fa-print" ></i> Print  </button> -->
                                            <!-- <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit</button> -->
                                            <!-- <button class="btn btn-primary pull-right" id="cmd" style="margin-right: 5px;"><i class="fa fa-download"></i> PDF</button> -->
                                            <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </section><!-- /.content -->
                                <div class="clearfix"></div>
                            </div>
                            <!-- <div class="modal-footer"> -->
                            <!-- <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Close</button> -->
                            <!-- <button type="button" class="btn btn-success">Ok</button> -->
                            <!-- </div> -->
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div><!-- /.example-modal -->


            </div>
        </div>
    </main>
</div>
</body>
<script>
    $(document).ready(function () {
        $('#salesOrderTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'print'
            ]
        } );
    });

    $(function () {
        $("#fromDatePicker").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update', new Date());

        $("#toDatePicker").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update', new Date());
    });

    $('#myModal').on('show', function(e) {
        var clickedRow = $(e.relatedTarget);
        var orderId = clickedRow.data('orderId');
        var modal = $(this);
        modal.find('.modal-title').html('Order ID: ' + orderId);
    });

    function getOrderDetailsData(order) {
        orderList = order['order_details_list'];
        companyList = order['company_list'];
        lengthOfArray = orderList.length;
        tableRow = "<tr>";
        for (i = 0; i < lengthOfArray; i++) {

            $companyName = 'Unknown';
            if(orderList[i]['manufacturer_id']) {
                $companyName = companyList[orderList[i]['manufacturer_id']];
            }

            tableRow += "<td>" + $companyName + "</td>";
            tableRow += "<td>" + orderList[i]['medicine_name'] + "</td>";
            tableRow += "<td class='text-right'>" + orderList[i]['quantity'] + "</td>";
            tableRow += "<td class='text-right'>" + orderList[i]['price'] + "</td></tr>";

            $('.example-modal').find('.modal-body tbody')
                .append(tableRow);

            tableRow = "<tr>";
        }
        $('#reg_usr_details_modal').modal('toggle');
    }
</script>
<style>
    div.dt-buttons {
        float: left;
    }
</style>
</html>