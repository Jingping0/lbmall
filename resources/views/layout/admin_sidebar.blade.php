<div class="sidebar">
    <a href="{{ route('home') }}">
        <img src="{{ asset('img/small_logo.png') }}" alt="Logo" style="width: 180px; height: 100px; margin-left: 35px; margin-top: 20px;; margin-bottom: 20px;">
    </a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge me-3"></i>Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('product_items.showProductList') }}"><i class="fa-solid  fa-shop me-3"></i>Product</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.showOrderList') }}"><i class="fa-solid fa-shopping-cart me-3"></i>Order</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.showPaymentList') }}"><i class="fa-solid fa-money-check-dollar me-3"></i>Payment</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('contact.showCustomerServiceList') }}"><i class="fa-solid fa-comment me-3"></i>Customer Service</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pusher.index') }}"><i class="fa-solid fa-comment me-3"></i>Live Chat</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.showDeliveryList') }}"><i class="fa-solid fa-truck me-3"></i>Delivery</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.showReturnList') }}"><i class="fa-solid fa-sync-alt me-3"></i>Return and Refund</a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#collapseUser"><i class="fa-solid fa-user me-3"></i>User Maintenance</a>
            <div class="collapse" id="collapseUser">
                <a class="nav-link" href="{{ route('admin.showUserList') }}"><i class="" style="margin-left: 35px;"></i>User</a>
                <a class="nav-link" href="{{ route('admin.showCustomerList') }}"><i class="" style="margin-left: 35px;"></i>Customer</a>
                <a class="nav-link" href="{{ route('admin.showStaffList') }}"><i class="" style="margin-left: 35px;"></i>Staff</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#collapseReport">
                <i class="fa-solid fa-chart-bar me-3"></i>Report
            </a>
            <div class="collapse" id="collapseReport">
                <a class="nav-link" href="{{ route('salesReport') }}"><i class="" style="margin-left: 35px;"></i>Sales Report</a>
                <a class="nav-link" href="{{ route('returnReport') }}"><i class="" style="margin-left: 35px;"></i>Refund Report</a>
                <a class="nav-link" href="{{ route('reviewReport') }}"><i class="" style="margin-left: 35px;"></i>Review Report</a>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"><i class="fa-solid fa-sign-out-alt me-3"></i>Logout</a>
        </li>
    </ul>
</div>