@extends('layout.admin_layout')

@section('css')

<style>
    .operation-container{
       display: flex;
       justify-content: space-between;
    }

    .operation-container .btn-delete{
        color: red;
    }

    .main{
        padding: 15px;
    }

    .empty-container{
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .empty-container img{
      max-width: 15rem;
      max-height: 15rem;
      height: auto;
    }

    .empty-text{
        font-size: 23px;
    }

    .search{
        width: 300px;
    }

    .search-container{
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .search-select{
        width: 100px;
    }

    .totalSubtotal{
        font-weight: 900;
        font-size: 15px;
    }

</style>

@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<!-- Main Content -->
<head>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}" type="text/css">
</head>
<div class="main">
    <div class="main-content">

        <div class="operation-container">
            <div class="search-container">
                <select class="form-select search-select" aria-label="Default select example">
                    <option selected>All</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>

                <form action="#" method="post">
                    <div class="input-group">
                        <input class="form-control search" type="search" value="" placeholder="Search..." style="outline: none;" />
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
        <div class="tt" style="text-align: center;">
            <span class="content-title" style="font-size:30px;">Sales Report</span>
        </div>
        


        @if($orders->isNotEmpty())
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <!-- Add more columns as needed -->
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Subtotal</th>
                    <th>Service Tax</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <!-- Add more columns as needed -->
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->customer_id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->status }}</td>
                        <td>RM{{ $order->subtotal }}</td>
                        <td>RM{{ $order->serviceTax }}</td>
                        <td>RM{{ $order->totalAmount }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td class="totalSubtotal">Summary</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="totalSubtotal">RM{{ $totalSubtotal }}</td>
                        <td class="totalSubtotal">RM{{ $totalServiceTax }}</td>
                        <td class="totalSubtotal">RM{{ $totalSales }}</td>
                    </tr>
                </tbody>
        </table>
        @else
        <div class="empty-container">
            {{-- <img class="fas fa-box me-2" alt="Empty User"> --}}
            <i class="fas fa-box me-2"></i>
            <span class="empty-text">No Customer</span>
        </div>
        @endif

    </div>
</div>

<!-- Delete Customer Modal -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Customer?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Customer?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteCustomerForm" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteForm = document.getElementById('deleteCustomerForm');
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteCustomerModal'));

        var deleteButtons = document.querySelectorAll('.btn[data-bs-target="#deleteCustomerModal"]');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var customerId = button.dataset.customerId;

                // Update the form action with the correct User ID using Blade syntax
                deleteForm.action = '/' + customerId;

                // Show the modal
                deleteModal.show();
            });
        });
    });
</script> --}}

<script>
    function openDeleteModal(id) {

        const routeUrl = "{{ route('admin.destroyCustomer', ['user_id' => ':id']) }}".replace(':id', id);


        // Update form action dynamically
        document.getElementById('deleteCustomerForm').action = routeUrl;
        console.log(document.getElementById('deleteCustomerForm'));
        console.log(routeUrl);
    }
</script>
@endsection