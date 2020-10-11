

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-2">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                Ledger
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                <div class="dropdown-divider"></div>
            </div>
        </li>






        <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                Dropdown
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
    </ul>
</div>
<div class="d-inline">
    @if(auth()->check())
        <div class="btn-group">
            <a href="#" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                User
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <button class="dropdown-item" type="button">Action</button>
                <button class="dropdown-item" type="button">Another action</button>
                <button class="dropdown-item" type="button">Something else here</button>
            </div>
        </div>
    @else
        <a href="{{ route('login.index') }}">Sign In</a>
    @endif
</div>
