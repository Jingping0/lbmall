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

    .status-Collected{
        border-radius: 40px;
        background-color: #ffad3a;
        padding: 8px 30px;
    }

    .status-Shipping{
        border-radius: 40px;
        background-color: #6fcaea;
        padding: 8px 30px;
    }

    .status-OutOfShipping{
        border-radius: 40px;
        background-color: #f5c6cb;
        color: #b30021;
    }

    .status-Arrival{
        border-radius: 40px;
        background-color: #86e49a;
        color: #006b21;
        padding: 8px 40px;
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
            <span class="content-title">Delivery</span>
        </div>
        <div class="operation-container">
            <div class="search-container">
                <select class="form-select search-select" aria-label="Default select example">
                    <option selected>All</option>
                    <option value="Collected">Collected</option>
                    <option value="Shipping">Shipping</option>
                    <option value="OutOfShipping">Out Of Shipping</option>
                    <option value="Arrival">Arrival</option>
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

        @if($deliverys->isNotEmpty())
        <table class="table" style="text-align: center">
            <tr>
                <th>Delivery ID</th>
                <th>Order ID</th>
                <th>Address ID</th>
                <th>Username</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
            @foreach($deliverys as $delivery)
            <tr style="text-align: center">
                <td>{{ $delivery->delivery_id }}</td>
                <td>{{ $delivery->order_id }}</td>
                <td>{{ $delivery->address_id }}</td>
                <td>{{ $delivery->username }}</td>
                <td>{{ $delivery->street }},{{ $delivery->area }},{{ $delivery->postcode }}</td>
                <td>{{ $delivery->phone }}</td>
                
                <td>
                    <span class="status-color {{
                        $delivery->status === 'Collected' ? 'status-Collected' :
                        ($delivery->status === 'Shipping' ? 'status-Shipping' :
                        ($delivery->status === 'OutOfShipping' ? 'status-OutOfShipping' :
                        ($delivery->status === 'Arrival' ? 'status-Arrival' : ''))) }}">
                        {{ $delivery->status }}
                    </span>
                </td>
                <td>
                    <button class="btn">
                        <a href="{{ route('admin.editDelivery', ['delivery_id' =>$delivery->delivery_id]) }}">
                            <i class="fas fa-edit" style="font-size: 1.5em;"></i>
                        </a>
                    </button>
                    <button class="btn" onclick="openDeleteModal({{ $delivery->delivery_id }})" data-bs-toggle="modal" data-bs-target="#deleteDeliveryModal">
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
            <span class="empty-text">No Delivery</span>
        </div>
        @endif

    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteDeliveryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Delivery?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Delivery?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteDeliveryForm" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(id) {

        const routeUrl = "{{ route('admin.destroyDelivery', ['delivery_id' => ':id']) }}".replace(':id', id);

        // Update form action dynamically
        document.getElementById('deleteDeliveryForm').action = routeUrl;
        console.log(document.getElementById('deleteDeliveryForm'));
        console.log(routeUrl);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var categoryFilter = document.querySelector('.search-select');
        var searchInput = document.querySelector('.search');
        var statusColors = document.querySelectorAll('.status-color');

        categoryFilter.addEventListener('change', filterDeliveries);
        searchInput.addEventListener('input', filterDeliveries);

        function filterDeliveries() {
            var selectedCategory = categoryFilter.value.toLowerCase();
            var searchValue = searchInput.value.toLowerCase();

            statusColors.forEach(function (status) {
                var statusText = status.textContent.toLowerCase();
                var statusMatches = selectedCategory === 'all' || statusText.includes(selectedCategory);

                var deliveryRow = status.parentElement.parentElement;
                var deliveryData = deliveryRow.innerText.toLowerCase();

                var searchMatches = deliveryData.includes(searchValue);

                deliveryRow.style.display = statusMatches && searchMatches ? 'table-row' : 'none';
            });
        }
    });
</script>
@endsection