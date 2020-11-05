<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-2">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                記帳
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('bookkeeping.ledger.index') }}">帳本</a>
                <a class="dropdown-item" href="{{ route('dashboard') }}">消費統計</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                投資
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('bookkeeping.ledger.index') }}">統計</a>
                <a class="dropdown-item" href="{{ route('dashboard') }}">歷史權益</a>
            </div>
        </li>


    <!--
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
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
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
        -->
    </ul>
</div>
<div class="d-inline">
    @auth
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
    @endauth

    @guest
        <a href="{{ route('login.index') }}">Sign In</a>
    @endguest
</div>
