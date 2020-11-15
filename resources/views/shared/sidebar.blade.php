<aside class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand">
                {{ config('app.name', 'Asha Victoria Enterprises') }}
            </div>
        </div>
        <nav class="menu">
            <ul class="sidebar-menu metismenu" id="sidebar-menu">
                <li class="active">
                    {{--  <a href="{{ url('/') }}">  --}}
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i> Inicio </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}">
                        <i class="fas fa-users"></i> Categorias
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}">
                        <i class="fas fa-clipboard-list"></i> Productos
                    </a>
                </li>
                <li class="d-none">
                    <a href="{{ route('purchases.index') }}">
                        <i class="fas fa-clipboard-list"></i> Compras
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}">
                        <i class="fas fa-cart-plus"></i> Ordenes
                    </a>
                </li>
                {{--
                <li>
                    <a href="{{ route('sales.historymonth', ['all' => 0, 'month' => \Carbon\Carbon::now()->month]) }}">
                        <i class="fas fa-shopping-cart"></i> Historial Ventas
                    </a>
                </li> --}}
            </ul>
        </nav>
    </div>
</aside>
