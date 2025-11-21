@extends('layout.admin_layout')

@section('css')
<style>
    .operation-container {
        display: flex;
        justify-content: space-between;
    }

    .operation-container .btn-delete {
        color: red;
    }

    .main {
        padding: 15px;
    }

    .empty-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .empty-container img {
        max-width: 15rem;
        max-height: 15rem;
        height: auto;
    }

    .empty-text {
        font-size: 23px;
    }

    .search {
        width: 300px;
    }

    .search-container {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .search-select {
        width: 100px;
    }

    .status-color {
        padding: 8px;
        border-radius: 5px;
    }

    .status-Preparing {
        border-radius: 40px;
        background-color: #fff494;
    }

    .status-Shipping {
        border-radius: 40px;
        background-color: #6fcaea;
    }

    .status-Receiving {
        border-radius: 40px;
        background-color: #ffad3a;
    }

    .status-Completed {
        border-radius: 40px;
        background-color: #86e49a;
        color: #006b21;
    }

    .status-Cancelled {
        border-radius: 40px;
        background-color: #f5c6cb;
        color: #b30021;
    }

    .status-ReturnAndRefund {
        border-radius: 40px;
        background-color: #e3b7eb;
    }

    .status-PayPal {
        border-radius: 40px;
        background-color: #0070ba;
        color: #ffffff;
    }

    .status-CreditCard {
        border-radius: 40px;
        background-color: #1a1a1a;
        color: #ffffff;
    }

    .status-BankTransfer {
        border-radius: 40px;
        background-color: #0066b2;
        color: #ffffff;
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
<div class="main">
    <div class="main-content">
        <div class="tt">
            <span class="content-title">Payment</span>
        </div>
        <div class="operation-container">
            <div class="search-container">
                <select id="categoryFilter" class="form-select search-select" aria-label="Default select example">
                    <option selected>All</option>
                    <option value="53201">Cash</option>
                    <option value="53202">Online Banking</option>
                    <option value="53203">E-Wallet</option>
                    <option value="53204">Credit Card</option>
                    <option value="53205">Paypal</option>
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

        @if($payments->isNotEmpty())
        <table class="table" style="text-align: center">
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Payment Date</th>
                <th>Payment Method</th>
                <th>Status</th>
            </tr>
            @foreach($payments as $payment)
            <tr style="text-align: center">
                <td>{{ $payment->transaction_id }}</td>
                <td>{{ $payment->order_id }}</td>
                <td>RM {{ $payment->amount }}</td>
                <td>{{ $payment->payment_date }}</td>
                <td>{{ $payment->paymentMethod->payment_method }}</td>
                <td>
                    <span class="status-color status-{{ str_replace(' ', '', $payment->status) }}">
                        {{ $payment->status }}
                    </span>
                </td>
                <td>
                    <button class="btn">
                        {{-- <a href="{{ route('admin.editOrder', ['order_id' =>$order->order_id]) }}">
                            <i class="fas fa-edit" style="font-size: 1.5em;"></i>
                        </a> --}}
                    </button>
                    {{-- <button class="btn" onclick="openDeleteModal({{ $order->order_id }})" data-bs-toggle="modal" data-bs-target="#deleteOrderModal">
                        <i class="fas fa-trash" style="font-size: 1.5em;"></i>
                    </button> --}}
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <div class="empty-container">
            {{-- <img class="fas fa-box me-2" alt="Empty User"> --}}
            <i class="fas fa-box me-2"></i>
            <span class="empty-text">No Payment</span>
        </div>
        @endif

    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deletePaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Payment?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Payment?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deletePaymentForm" method="post">
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
        var deleteForm = document.getElementById('deleteStaffForm');
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteStaffModal'));

        var deleteButtons = document.querySelectorAll('.btn[data-bs-target="#deleteStaffModal"]');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var staffId = button.dataset.staffId;

                // Update the form action with the correct User ID using Blade syntax
                deleteForm.action = '/' + staffId;

                // Show the modal
                deleteModal.show();
            });
        });
    });
</script> --}}

{{-- <script>
    function openDeleteModal(id) {

        const routeUrl = "{{ route('admin.destroyCustomer', ['user_id' => ':id']) }}".replace(':id', id);


        // Update form action dynamically
        document.getElementById('deleteOrderForm').action = routeUrl;
        console.log(document.getElementById('deleteOrderForm'));
        console.log(routeUrl);
    }
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var categoryFilter = document.getElementById('categoryFilter');
        var searchInput = document.querySelector('.search');

        categoryFilter.addEventListener('change', filterPayments);
        searchInput.addEventListener('input', filterPayments);

        function filterPayments() {
            var selectedCategory = categoryFilter.value.toLowerCase();
            var searchValue = searchInput.value.toLowerCase();

            document.querySelectorAll('.status-color').forEach(function (status) {
                var statusText = status.textContent.toLowerCase();
                var statusMatches = selectedCategory === 'all' || statusText.includes(selectedCategory);

                var paymentRow = status.closest('tr');
                var paymentData = paymentRow.innerText.toLowerCase();

                var searchMatches = paymentData.includes(searchValue);

                paymentRow.style.display = statusMatches && searchMatches ? 'table-row' : 'none';
            });
        }
    });
</script>   
@endsection