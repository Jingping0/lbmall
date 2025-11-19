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
            <span class="content-title">User</span>
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
            <a href="createUser" class="btn btn-primary">New User</a>
        </div>

        @if($users->isNotEmpty())
        <table class="table" style="text-align: center">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Password</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            @foreach($users as $user)
            <tr style="text-align: center">
                <td>{{ $user->user_id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ substr($user->password, 0, 10) }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <button class="btn">
                        <a href="{{ route('admin.editUser', ['user_id' => $user->user_id]) }}">
                            <i class="fas fa-edit" style="font-size: 1.5em;"></i>
                        </a>
                    </button>
                    <button class="btn" onclick="openDeleteModal({{ $user->user_id }})" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
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
            <span class="empty-text">No User</span>
        </div>
        @endif

    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this User?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteUserForm" method="post">
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
        var deleteForm = document.getElementById('deleteUserForm');
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));

        var deleteButtons = document.querySelectorAll('.btn[data-bs-target="#deleteUserModal"]');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var userId = button.dataset.userId;

                // Update the form action with the correct User ID using Blade syntax
                deleteForm.action = '/' + userId;

                // Show the modal
                deleteModal.show();
            });
        });
    });
</script> --}}

<script>
    function openDeleteModal(id) {

        const routeUrl = "{{ route('admin.destroyUser', ['user_id' => ':id']) }}".replace(':id', id);


        // Update form action dynamically
        document.getElementById('deleteUserForm').action = routeUrl;
        console.log(document.getElementById('deleteUserForm'));
        console.log(routeUrl);
    }
</script>
@endsection