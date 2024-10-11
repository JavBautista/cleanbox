 <div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.index') }}"><i class="icon-home"></i> Home</a>
            </li>
            <!--<li class="nav-item">
                < !--{ { route('superadmin.shops') }}- ->
                <a href="#" class="nav-link"> Tiendas </a>
            </li>
            -->


            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon icon-bag"></i> Admin. Tienda</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.categories')}}"> Categorias  </a>
                        <a class="nav-link" href="{{route('superadmin.products')}}"> Productos  </a>
                        <a class="nav-link" href="{{route('superadmin.customers')}}"> Clientes  </a>
                        <a class="nav-link" href="{{route('superadmin.suppliers')}}"> Proveedores  </a>
                    </li>
                </ul>
            </li>




        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>