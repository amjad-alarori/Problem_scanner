<div class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link mx-3">
                <i class="fas fa-bars" style="transform: translateY(5px);" onclick="collapseSidebar()"></i>
            </a>
        </li>
    </ul>
    <div class="navbar-nav">
        <li class="nav-item">
            <img src="https://orange-eyes-images.s3.eu-central-1.amazonaws.com/logos/logo.png"
                 class="logo logo-light">
        </li>
    </div>
    <form class="navbar-search">
        <input type="text" name="q" id="autoComplete" spellcheck=false autocorrect="off" autocomplete="off"
               autocapitalize="off" maxlength="2048" tabindex="1" class="navbar-search-input w-100"
               placeholder="Search...">
    </form>
    <li class="nav-item dropdown mr-2">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
            {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item text-danger"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
</div>
