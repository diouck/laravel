		<header class="main-header">
			<nav class="navbar navbar-static-top">
				<div class="container">
			        <div class="navbar-header">
				        @if(Request::path() != '/')
							<a class="navbar-brand" rel="home" title="AVIZON" href="/">
								<img class="img-responsive" src="/images/logo_avizon.png">
							</a>
						@endif
				        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
				        	<i class="fa fa-bars"></i>
				        </button>
			        </div>
			        <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
				        @yield('searchbar')
				        <ul class="nav navbar-nav">
				        	@if (Auth::check())
					        	<li class="dropdown ">
				                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
				                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
				                    </a>
				                    <ul class="dropdown-menu dropdown-user pull-right">
				                        @if (Auth::user()->isAdmin())
				                        <li><a href="/admin"><i class="fa fa-gear fa-fw"></i> Tableau de bord</a>
				                        </li>
				                        @endif
				                        <li class="divider"></li>
				                        <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Déconnexion</a>
				                        </li>
				                    </ul>
				                    <!-- /.dropdown-user -->
				                </li>
							@else
								<li {!! (Request::is('login') ? 'class="active"' : '') !!}>{!! HTML::link(route('login'),'S\'identifier') !!}</li>
							@endif
				        </ul><!--/.nav-collapse -->
				       
				    </div>
				</div>
		    </nav>
		</header>