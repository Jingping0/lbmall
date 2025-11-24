@extends('layout.admin_layout')

@section('title', 'Dashboard')

@section('css')



@endsection

<head>   
   
    <title>Lb | Dashboard</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
    <link href="{{ asset('css/icon.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

    <style>
        .dasboard_logo{
            height: 60px;
        }

        .dataTables_length{
            padding: 0px 15px
        }

        .dataTables_filter{
            margin: 0px 20px
        }

        .dropdown-menu .dropdown-menu-lg .dropdown-menu-end{
            margin: 1010px
        }

        .navbar-brand-box{
            text-align: center;
            justify-content: center;
            align-items: center;
        }
        .status-color {
            padding: 8px;
            border-radius: 5px;
            text-align: center
        }

        .status-Preparing {
            border-radius: 40px;
            background-color: #fff494;
            padding: 8px 38px;
        }

        .status-Shipping {
            border-radius: 40px;
            background-color: #6fcaea;
            padding: 8px 38px;
        }

        .status-Receiving {
            border-radius: 40px;
            background-color: #ffad3a;
            padding: 8px 38px;
        }

        .status-Completed {
            border-radius: 40px;
            background-color: #86e49a;
            color: #006b21;
            padding: 8px 30px;
        }

        .status-Cancelled {
            border-radius: 40px;
            background-color: #f5c6cb;
            color: #b30021;
            padding: 8px 35px;
        }

        .status-ReturnAndRefund {
            border-radius: 40px;
            background-color: #e3b7eb;
        }
        
        .col-md-4 .card{
            margin-bottom: 3rem;
        }

        .col-xl-4 .card{
            margin-bottom: 1rem;
        }

    </style>
</head>

@section('content')
<body>
<div class="col-12 mt-4 content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1 overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Number of Sales</p>
                                        <h4 class="mb-0">{{ $totalOrders }}</h4>
                                    </div>
                                    <div class="text-primary ms-auto">
                                        <i class='bx bx-layer font-size-24'></i>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-top py-3">
                                <div class="text-truncate">
                                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i>  </span>
                                    <span class="text-muted ms-2"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1 overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Sales Revenue</p>
                                        <h4 class="mb-0">RM {{ $totalRevenue }}</h4>
                                    </div>
                                    <div class="text-primary ms-auto">
                                        <i class='bx bx-store font-size-24' ></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-top py-3">
                                <div class="text-truncate">
                                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i>  </span>
                                    <span class="text-muted ms-2"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-1 overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Average Price</p>
                                        <h4 class="mb-0">RM {{ number_format($totalRevenue / $totalOrders, 2) }}</h4>
                                    </div>
                                    <div class="text-primary ms-auto">
                                        <i class='bx bx-briefcase-alt-2 font-size-24'></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-top py-3">
                                <div class="text-truncate">
                                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i></span>
                                    <span class="text-muted ms-2"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="height: 545px;">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Revenue Analytics</h4>
                        <div>
                            <div id="line-column-chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>

                    <div class="card-body border-top text-center">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="d-inline-flex">
                                    <h5 class="me-2">RM {{ $totalRevenue }}</h5>
                                </div>
                                <p class="text-muted text-truncate mb-0">This Year</p>
                            </div>

                            <div class="col-sm-4">
                                <div class="mt-4 mt-sm-0">
                                    <p class="mb-2 text-muted text-truncate"><i class="bx bxs-circle text-primary font-size-10 me-1"></i> This Month :</p>
                                    <div class="d-inline-flex">
                                        <h5 class="mb-0 me-2">RM {{ $thisMonth }}</h5>
                                        <div class="text-success">
                                            <i class="mdi mdi-menu-up font-size-14"> </i>2.1 %
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mt-4 mt-sm-0">
                                    <p class="mb-2 text-muted text-truncate"><i class="bx bxs-circle text-success font-size-10 me-1"></i> Previous Month :</p>
                                    <div class="d-inline-flex">
                                        <h5 class="mb-0">RM {{ $previousMonth }}</h5>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end">
                            <select class="form-select form-select-sm">
                                <option selected>Apr</option>
                                <option value="1">Mar</option>
                                <option value="2">Feb</option>
                                <option value="3">Jan</option>
                            </select>
                        </div>
                        <h4 class="card-title mb-4">Payment Method</h4>
                        <div id="donut-chart" class="apex-charts"></div>
                        <div class="row"> 
                            @foreach($paymentMethods as $method => $percentage)
                            
                            <div class="col-4">
                                <div class="text-center mt-4">
                                    <p class="mb-2 text-truncate">
                                        @if($method === 'Paypal')
                                            <i class="bx bxs-circle text-primary font-size-10 me-1"></i> Paypal
                                        @elseif($method === 'Cash')
                                            <i class="bx bxs-circle text-success font-size-10 me-1"></i> Cash
                                        @elseif($method === 'Online Banking')
                                            <i class="bx bxs-circle text-info font-size-10 me-1"></i> Online Banking
                                        @elseif($method === 'E-Wallet')
                                            <i class="bx bxs-circle text-warning font-size-10 me-1"></i> E-Wallet
                                        @elseif($method === 'Credit Card')
                                            <i class="bx bxs-circle text-danger font-size-10 me-1"></i> Credit Card
                                        @else
                                            <i class="bx bxs-circle text-dark font-size-10 me-1"></i> Unknown
                                        @endif
                                    </p>
                                    <h5>{{ number_format($percentage, 2) }} %</h5>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                        <h4 class="card-title mb-4">Earning Reports</h4>
                        <div class="text-center">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <div class="mb-3">
                                            <div id="radialchart-1" class="apex-charts"></div>
                                        </div>

                                        <p class="text-muted text-truncate mb-2">Today Earnings</p>
                                        <h5 class="mb-0">RM {{ $todaySales }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mt-5 mt-sm-0">
                                        <div class="mb-3">
                                            <div id="radialchart-2" class="apex-charts"></div>
                                        </div>

                                        <p class="text-muted text-truncate mb-2">Yesterday Earnings</p>
                                        <h5 class="mb-0">RM {{ $yesterdaySales }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           
            <div class="col-lg-8">
                <div class="card" style="width: 1300px;">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>

                        <h4 class="card-title mb-4">Latest Transactions</h4>

                        <div class="table-responsive" style="padding: 12px;">
                            <table class="table table-centered datatable dt-responsive nowrap" data-bs-page-length="5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-light">
                                    <tr style="text-align: center">
                                        <th style="width: 20px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="ordercheck">
                                                <label class="form-check-label mb-0" for="ordercheck">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Order ID</th>
                                        <th>Customer ID</th>
                                        <th>Total Amount</th>
                                        <th>Staff ID</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr style="text-align: center" class="table_status">
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="ordercheck1">
                                                <label class="form-check-label mb-0" for="ordercheck1">&nbsp;</label>
                                            </div>
                                        </td>
                                        
                                        <td><a href="javascript: void(0);" class="text-dark fw-bold">{{ $order->order_id }}</a> </td>
                                        <td>{{ $order->customer_id }}</td>
                                        <td>RM{{ $order->totalAmount }}</td>
                                        <td>{{ $order->staff_id }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->updated_at }}</td>
                                        <td>
                                            <span class="status-color {{
                                                $order->status === 'Preparing' ? 'status-Preparing' :
                                                ($order->status === 'Shipping' ? 'status-Shipping' :
                                                ($order->status === 'Receiving' ? 'status-Receiving' :
                                                ($order->status === 'Completed' ? 'status-Completed' :
                                                ($order->status === 'Cancelled' ? 'status-Cancelled' :
                                                ($order->status === 'ReturnAndRefund' ? 'status-ReturnAndRefund' : ''))))) }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    
</body>
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard.init.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var paymentMethodsData = <?php echo json_encode(array_values($paymentMethods)); ?>;
        var paymentMethodNames = <?php echo json_encode(array_keys($paymentMethods)); ?>;
    
        var donutOptions = {
            series: paymentMethodsData,
            chart: {
                height: 250,
                type: "donut"
            },
            labels: paymentMethodNames,
            plotOptions: {
                pie: {
                    donut: {
                        size: "75%"
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ["#5664d2", "#1cbb8c", "#0366d6", "#ffcc57", "#ff6c5f"]
        };
    
        var donutChart = new ApexCharts(document.querySelector("#donut-chart"), donutOptions);
        donutChart.render();

        // Assuming $monthlySalesData is an array passed from the controller
        var monthlySalesData = <?php echo json_encode($monthlySalesData['series'][0]); ?>;

        var options = {
            series: [
                { name: "Monthly Sales", type: "column", data: monthlySalesData },
                { name: "2019", type: "line", data: monthlySalesData }
            ],
            chart: {
                height: 280,
                type: "line",
                toolbar: { show: false }
            },
            stroke: { width: [0, 3], curve: "smooth" },
            plotOptions: { bar: { horizontal: false, columnWidth: "20%" } },
            dataLabels: { enabled: false },
            legend: { show: false },
            colors: ["#5664d2", "#1cbb8c"],
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        };

        var chart = new ApexCharts(document.querySelector("#line-column-chart"), options);
        chart.render();

        
        var radialoptions1 = {
            series: [72],
            chart: {
                type: "radialBar",
                width: 60,
                height: 60,
                sparkline: { enabled: true }
            },
            dataLabels: { enabled: false },
            colors: ["#5664d2"],
            stroke: { lineCap: "round" },
            plotOptions: {
                radialBar: {
                    hollow: { margin: 0, size: "70%" },
                    track: { margin: 0 },
                    dataLabels: { show: false }
                }
            }
        };

        var radialchart1 = new ApexCharts(document.querySelector("#radialchart-1"), radialoptions1);
        radialchart1.render();

        var radialoptions2 = {
            series: [65],
            chart: {
                type: "radialBar",
                width: 60,
                height: 60,
                sparkline: { enabled: true }
            },
            dataLabels: { enabled: false },
            colors: ["#1cbb8c"],
            stroke: { lineCap: "round" },
            plotOptions: {
                radialBar: {
                    hollow: { margin: 0, size: "70%" },
                    track: { margin: 0 },
                    dataLabels: { show: false }
                }
            }
        };

        var radialchart2 = new ApexCharts(document.querySelector("#radialchart-2"), radialoptions2);
        radialchart2.render();
    </script>
    
    </div>

</div>

@endsection

    {{-- <footer id="footer" class="footer">
        <div class="copyright">
            
        </div>
        <div class="credits">
            Designed by <a href="">Lb Sdn Bhd</a>
        </div>
    </footer> --}}  