<!DOCTYPE html>
<html>
<head>
    <title>Sales Orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Dropdown menu -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Date Picker CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css"/>

    <!-- Date Picker JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
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
                <a class="navbar-brand" href="#">Brand</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Sold Orders <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Purchased Orders</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
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
                        <th>Order Date</th>
                        <th>Invoice Number</th>
                        <th>Pharmacy Name</th>
                        <th>Contact Number</th>
                        <th>Order Status</th>
                        <th>Actual Price</th>
                        <th>Payable Price</th>
                        <th>Discount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td id="date">{{ date('d-m-Y', strtotime($order['order_date'])) }}</td>
                            <td>{{ $order['invoice_number'] }}</td>
                            <td>{{ $order['pharmacy_name'] }}</td>
                            <td>{{ $order['chemist_mobile_number'] }}</td>
                            <td>{{ $order['order_status'] }}</td>
                            <td>{{ $order['total_actual_price'] }}</td>
                            <td>{{ $order['total_payable_price'] }}</td>
                            <td>{{ $order['discount'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
<script>
    $(document).ready(function () {
        $('#salesOrderTable').DataTable();
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

</script>
</html>