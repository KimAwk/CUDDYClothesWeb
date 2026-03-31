<div id="layoutSidenav_nav">
    
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Chức năng chính</div>
                <a class="nav-link" href="permissions.php"> <!-- Chỉnh sửa đây -->
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Quyền
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Quản lí sản phẩm
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="list-products.php">Danh mục sản phẩm</a>
                        <a class="nav-link" href="product.php">Sản phẩm</a>
                    </nav>
                </div>
                <a class="nav-link" href="donhang.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Đơn hàng
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Quản lí tài khoản
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link" href="user.php">
                            Khách hàng
                        </a>
                        <a class="nav-link" href="admin.php">
                            Admin
                        </a>
                    </nav>
                </div>
                <a class="nav-link" href="revenue.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-dollar-sign"></i></div>
                    Doanh thu
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Đăng nhập với tư cách:</div>
            Admin
        </div>
    </nav>
</div>
