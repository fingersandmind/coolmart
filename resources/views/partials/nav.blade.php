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
                <a class="nav-link {{ Request::routeIs('transactions*') ? 'active' : '' }}" href="#"><i class="fa fa-spin fa-history"></i> <span>Transactions</span></a>
                <div class="sub-item">
                    <ul>
                        <li><a href="#">Transaction</a></li>
                        <li><a href="{{ route('transaction.history') }}">History</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::routeIs(['brands*', 'items*', 'categories*', 'types*']) ? 'active' : '' }}" href="#"><i class="fa fa-spin fa-snowflake-o"></i> <span>Air-Conditioning</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{{ route('brands.index') }}">Brands</a>
                        </li>
                        <li>
                            <a href="{{ route('items.index') }}">Items</a>
                        </li>
                        <li class="sub-with-sub">
                            <a href="#">Setting <i class="fa fa-spin fa-cog"></i></a>
                            <ul>
                                <li><a href="{{ route('categories.index') }}">Categories</a></li>
                                <li><a href="{{ route('types.index') }}">Types</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::routeIs(['faqs*', 'terms*']) ? 'active' : '' }}" href="#"><i class="fa fa-spin fa-cogs"></i> <span>Settings</span></a>
                <div class="sub-item">
                    <ul>
                        <li><a href="{{ route('faqs.index') }}">FAQ</a></li>
                        <li><a href="{{ route('terms.index') }}">Terms</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>