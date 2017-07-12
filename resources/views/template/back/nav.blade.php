<!-- Navbar -->
    <header class="main-header">
        <a class="logo" rel="home" title="AVIZON" href="/">
            <span class="logo-lg"><img class="img-responsive" src="/images/logo_avizon.png"></span>
        </a>
		<nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i><i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @if (Auth::user()->isAdmin())
                            <li><a href="/admin"><i class="fa fa-gear"></i> Tableau de bord</a></li>
                            @endif
                            <li class="divider"></li>
                            <li><a href="/logout"><i class="fa fa-sign-out"></i> Déconnexion</a></li>
                        </ul>
                  </li>              
                </ul>
            </div>
        </nav>
    </header>
    @yield('sidebar')
