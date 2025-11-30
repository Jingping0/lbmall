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

    .status-color{
        padding: 8px;
        border-radius: 5px;
        text-align: center;
    }

    .status-pending{
        border-radius: 40px;
        background-color: #ffad3a;
        padding: 8px 38px;
    }

    .status-rejected{
        border-radius: 40px;
        background-color: #f5c6cb;
        color: #b30021;
        padding: 8px 38px;
    }

    .status-approved{
        border-radius: 40px;
        background-color: #86e49a;
        color: #006b21;
        padding: 8px 38px;
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
            <span class="content-title">Return and Refund</span>
        </div>
        <div class="operation-container">
            <div class="search-container">
                <select id="categoryFilter" class="form-select search-select" aria-label="Default select example">
                    <option value="" selected>All</option>
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
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

        @if($returns->isNotEmpty())
        <table class="table" style="text-align: center">
            <tr>
                <th>#</th>
                <th>Order Id</th>
                <th>Customer Id</th>
                <th>Request Date</th>
                <th>Reason</th>
                {{-- <th>Description</th>
                <th>Evidence</th> --}}
                <th>Status</th>
                <th>Action</th>
            </tr>
            @foreach($returns as $return)
            <tr style="text-align: center">
                <td>{{ $return->returnAndRefund_id }}</td>
                <td>{{ $return->order_id }}</td>
                <td>{{ $return->customer_id }}</td>
                <td>{{ $return->created_at }}</td>
                <td>{{ $return->reason }}</td>
                <td>
                    <span class="status-color {{
                        $return->status === 'approved' ? 'status-approved' :
                        ($return->status === 'pending' ? 'status-pending' :
                        ($return->status === 'rejected' ? 'status-rejected' : '')) }}">
                        {{ $return->status }}
                    </span>
                </td>
                <td>
                    <button class="btn">
                        <a href="{{ route('admin.editReturn', ['returnAndRefund_id' => $return->returnAndRefund_id]) }}">
                            <i class="fas fa-edit" style="font-size: 1.5em;"></i>
                        </a>
                    </button>
                    <button class="btn" onclick="openDeleteModal({{ $return->returnAndRefund_id }})" data-bs-toggle="modal" data-bs-target="#deleteReturnModal">
                        <i class="fas fa-trash" style="font-size: 1.5em;"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <div class="empty-container">
            {{-- <img class="fas fa-box me-2" alt="Empty User"> --}}
            <i class="fas fa-box me-2"></i>
            <span class="empty-text">No Return and Refund record</span>
        </div>
        @endif

    </div>
</div>

<!-- Delete Return Modal -->
<div class="modal fade" id="deleteReturnModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Return and Refund record?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Return and Refund record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteReturnForm" method="post">
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

        const routeUrl = "{{ route('admin.destroyRefund', ['returnAndRefund_id' => ':id']) }}".replace(':id', id);


        // Update form action dynamically
        document.getElementById('deleteReturnForm').action = routeUrl;
        console.log(document.getElementById('deleteReturnForm'));
        console.log(routeUrl);
    }
</script>

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