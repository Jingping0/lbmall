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
            <span class="content-title">Product</span>
        </div>
        <div class="operation-container">
            <div class="search-container">
                <select id="categoryFilter" class="form-select search-select" aria-label="Default select example">
                    <option value="">All</option>
                    <option value="9001">Materials</option>
                    <option value="9002">Panels & Surface Finishes</option>
                    <option value="9003">Hardware & Tools</option>
                    <option value="9004">Coatings & Chemicals</option>
                    <option value="9005">Plumbing & Electrical</option>
                </select>

                <form id="searchForm" action="#" method="post">
                    <div class="input-group">
                        <input id="productNameSearch" class="form-control search" type="search" value="" placeholder="Search..." style="outline: none;" />
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>

            </div>
            <a href="createProductItem" class="btn btn-primary">New Product</a>
        </div>

        @if($productItems->isNotEmpty())
        <table class="table" style="text-align: center">
            <tr>
                <th>#</th>
                <th></th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Measurement</th>
                <th>Availability</th>
                <th>Action</th>
            </tr>
            @foreach($productItems as $productItem)
            <tr  class="product-row" data-category="{{ $productItem->category_id }}" style="text-align: center">
                <td>{{ $productItem->product_item_id }}</td>
                @php($product_image =  $productItem['product_image'])
            
                <td><img src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" style : width="150px"; height="150px"/> </td>
                <td>{{ $productItem->product_name }}</td>
                <td>RM {{ number_format($productItem->product_price, 2) }}</td>
                <td>
                    @if ($productItem->category_id == 9001)
                        Materials
                    @elseif ($productItem->category_id == 9002)
                        Panels & Surface Finishes
                    @elseif ($productItem->category_id == 9003)
                        Hardware & Tools
                    @elseif ($productItem->category_id == 9004)
                        Coatings & Chemicals
                    @elseif ($productItem->category_id == 9005)
                        Plumbing & Electrical
                    @elseif ($productItem->category_id == 9006)
                        Others
                    @else
                        Unknown Category
                    @endif
                </td>
                <td>{{ $productItem->product_measurement }}cm</td>
                <td>{{ $productItem->available }}</td>
                <td>
                    <button class="btn">
                        <a href="{{ route('product_items.editProductItem', ['product_item_id' => $productItem->product_item_id]) }}">
                            <i class="fas fa-edit" style="font-size: 1.5em;"></i>
                        </a>
                    </button>
                    <button class="btn" onclick="openDeleteModal({{ $productItem->product_item_id }})" data-bs-toggle="modal" data-bs-target="#deleteProductModal">
                        <i class="fas fa-trash" style="font-size: 1.5em;"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <div class="empty-container">
            {{-- <img class="fas fa-box me-2" alt="Empty Product"> --}}
            <i class="fas fa-box me-2"></i>
            <span class="empty-text">No Product</span>
        </div>
        @endif

    </div>
</div>

<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Product?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Product?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteProductForm" method="post">
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
        var deleteForm = document.getElementById('deleteProductForm');
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));

        var deleteButtons = document.querySelectorAll('.btn[data-bs-target="#deleteProductModal"]');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var productId = button.dataset.productId;

                // Update the form action with the correct product ID using Blade syntax
                deleteForm.action = '/' + productId;

                // Show the modal
                deleteModal.show();
            });
        });
    });
</script> --}}

<script>
    function openDeleteModal(id) {

        const routeUrl = "{{ route('product_items.destroy', ['product_item_id' => ':id']) }}".replace(':id', id);


        // Update form action dynamically
        document.getElementById('deleteProductForm').action = routeUrl;
        console.log(document.getElementById('deleteProductForm'));
        console.log(routeUrl);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var categoryFilter = document.getElementById('categoryFilter');
        var productNameSearch = document.getElementById('productNameSearch');
        var searchForm = document.getElementById('searchForm');

        categoryFilter.addEventListener('change', filterProducts);
        productNameSearch.addEventListener('input', filterProducts);
        searchForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission
            filterProducts();
        });

        function filterProducts() {
            var selectedCategory = categoryFilter.value;
            var productName = productNameSearch.value.toLowerCase();

            document.querySelectorAll('.product-row').forEach(function (row) {
                var categoryMatches = selectedCategory === '' || row.dataset.category === selectedCategory;
                var nameMatches = row.querySelector('td:nth-child(3)').textContent.toLowerCase().includes(productName);

                row.style.display = categoryMatches && nameMatches ? 'table-row' : 'none';
            });
        }
    });
</script>
@endsection