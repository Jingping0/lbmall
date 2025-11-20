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

    .search-container {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .search-select {
        width: 200px;
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
            <span class="content-title">Order</span>
        </div>
        <div class="operation-container">
            <div class="search-container">
                <select id="categoryFilter" class="form-select search-select" aria-label="Default select example">
                    <option value="" selected>All</option>
                    <option value="Preparing">Preparing</option>
                    <option value="Shipping">Shipping</option>
                    <option value="Receiving">Receiving</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="ReturnAndRefund">Return & Refund</option>
                </select>
            </div>
            
        </div>

        @if($orders->isNotEmpty())
        <table class="table" style="text-align: center">
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Total Amount</th>
                <th>Staff ID</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
            @foreach($orders as $order)
            <tr style="text-align: center">
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->customer_id }}</td>
                <td>RM {{ $order->totalAmount }}</td>
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
                <td>
                    <button class="btn">
                        <a href="{{ route('admin.editOrder', ['order_id' => $order->order_id]) }}">
                            <i class="fas fa-edit" style="font-size: 1.5em;"></i>
                        </a>
                    </button>
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <div class="empty-container">
            <i class="fas fa-box me-2"></i>
            <span class="empty-text">No Order</span>
        </div>
        @endif

    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Order?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Order?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteOrderForm" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Order?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Order?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteOrderForm" method="post">
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

        categoryFilter.addEventListener('change', filterOrders);

        function filterOrders() {
            var selectedCategory = categoryFilter.value;

            document.querySelectorAll('.status-color').forEach(function (status) {
                var statusMatches = selectedCategory === '' || status.classList.contains('status-' + selectedCategory);
                status.parentElement.parentElement.style.display = statusMatches ? 'table-row' : 'none';
            });
        }
    });
</script>
@endsection