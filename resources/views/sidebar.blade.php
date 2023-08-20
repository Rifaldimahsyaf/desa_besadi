@extends('dashboard')
@section('sidebar')
    <!-- Main -->
    <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>

    <li class="nav-item">
        <a href="/purchase" class="nav-link {{ request()->is('subject') || request()->is('subject*') ? 'active' : ''  }}">
            <i class="icon-cart-add2"></i>
            <span>
                PURCHASE
            </span>
        </a>
    </li>

    <li class="nav-item">
        <a href="/order" class="nav-link {{ request()->is('ulasan*') ? 'active' : ''  }}">
            <i class="
            icon-cart-remove"></i>
            <span>
                ORDERS
            </span>
        </a>
    </li>

    <li class="nav-item">
        <a href="/supplier" class="nav-link {{ request()->is('alumni*') ? 'active' : ''  }}">
            <i class="icon-users4"></i>
            <span>
                SUPPLIER
            </span>
        </a>
    </li>

    <li class="nav-item">
        <a href="/stock" class="nav-link {{ request()->is('alumni*') ? 'active' : ''  }}">
            <i class="icon-store"></i>
            <span>
                STOCK
            </span>
        </a>
    </li>

    <li class="nav-item">
        <a href="/invoice" class="nav-link {{ request()->is('alumni*') ? 'active' : ''  }}">
            <i class="icon-price-tag"></i>
            <span>
                INVOICE
            </span>
        </a>
    </li>

@endsection
