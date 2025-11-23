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
        text-align: center
    }


    .status-open{
        border-radius: 40px;
        background-color: #6fcaea;
        padding: 8px 38px;
    }

    .status-progress{
        border-radius: 40px;
        background-color: #ffad3a;
        padding: 8px 20px;
    }

    .status-resolved{
        border-radius: 40px;
        background-color: #86e49a;
        color: #006b21;
        padding: 8px 25px;
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
            <span class="content-title">Customer Service</span>
        </div>
        <div class="operation-container">
            <div class="search-container">
                <select id="categoryFilter" class="form-select search-select" aria-label="Default select example">
                    <option value="" selected>All</option>
                    <option value="Open">Open</option>
                    <option value="In-Progress">In Progress</option>
                    <option value="Resolved">Resolved</option>
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

        @if($requests->isNotEmpty())
        <table class="table" style="text-align: center">
            <tr>
                <th>Customer Service ID</th>
                <th>Customer ID</th>
                <th>Issue Type</th>
                <th>Desciption</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
            @foreach($requests as $request)
            <tr style="text-align: center">
                <td>{{ $request->cust_service_id }}</td>
                <td>{{ $request->customer_id }}</td>
                <td>{{ $request->issue_type }}</td>
                <td>{{ $request->cust_service_desc }}</td>
         
                
                <td>
                    <span class="status-color {{
                        $request->status === 'Open' ? 'status-open' :
                        ($request->status === 'In Progress' ? 'status-progress' :
                        ($request->status === 'Resolved' ? 'status-resolved' : '')) }}">
                        {{ $request->status }}
                    </span>
                </td>
                <td>
                    <button class="btn">
                        <a href="{{ route('contact.editCustomerService', ['cust_service_id' =>$request->cust_service_id]) }}">
                            <i class="fas fa-edit" style="font-size: 1.5em;"></i>
                        </a>
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
            <span class="empty-text">No Records</span>
        </div>
        @endif

    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Record?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Record?</p>
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
            var statusMatches = selectedCategory === '' || status.classList.contains('status-' + selectedCategory.toLowerCase());
            status.parentElement.parentElement.style.display = statusMatches ? 'table-row' : 'none';
        });
        }
    });
</script>
@endsection