<div class="nk-sidebar">           
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('warehouse.dashboard') }}">
                    <i class="ti-dashboard menu-icon" ></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('warehouse.product') }}">
                    <i class="ti-package menu-icon"></i><span class="nav-text">Inventory Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('warehouse.order') }}">
                    <i class="ti-shopping-cart menu-icon"></i><span class="nav-text">Order Management</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
.nk-sidebar .menu-icon {
    font-size: 18px;
    width: 24px;
    height: 24px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.menu-icon {
    max-width: 24px;
    max-height: 24px;
}
</style>
