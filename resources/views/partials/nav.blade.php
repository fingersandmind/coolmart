<div class="admin-navbar" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fa fa-home"></i>
                    <span> DASHBOARD</span>
                </a>
            </li>
            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::routeIs('transactions*') ? 'active' : '' }}" href="#"><i class="fa fa-snowflake-o"></i> <span>Transactions</span></a>
                <div class="sub-item">
                    <ul>
                        <li><a href="#">Transaction</a></li>
                        <li><a href="{{ route('transaction.history') }}">History</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('brands*') ? 'active' : '' }}" href="{{ route('brands.index') }}"><i class="fa fa-steam"></i> <span>Brands</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('models*') ? 'active' : '' }}" href="{{ route('models.index') }}"><i class="fa fa-snowflake-o"></i> <span>Model</span></a>
            </li>

            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::routeIs(['categories*','types*']) ? 'active' : '' }}" href="#"><i class="fa fa-cogs"></i> <span>Settings</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{{ route('categories.index') }}">Categories</a>
                        </li>
                        <li>
                            <a href="{{ route('types.index') }}">Types</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>