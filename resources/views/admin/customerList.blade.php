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
            <span class="content-title">Customer</span>
        </div>
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
            <a href="createCustomer" class="btn btn-primary">New Customer</a>
            
        </div>

        @if($customers->isNotEmpty())
        <table class="table" style="text-align: center">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Password</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            @foreach($customers as $customer)
            <tr style="text-align: center">
                <td>{{ $customer->user_id }}</td>
                <td>{{ $customer->username }}</td>
                <td>{{ substr($customer->password, 0, 10) }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>
                    <button class="btn">
                        <a href="{{ route('admin.editCustomer', ['user_id' => $customer->user_id]) }}">
                            <i class="fas fa-edit" style="font-size: 1.5em;"></i>
                        </a>
                    </button>
                    <button class="btn" onclick="openDeleteModal({{ $customer->user_id }})" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal">
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