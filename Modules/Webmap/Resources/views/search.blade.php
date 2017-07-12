@section('searchbar')
@if (Auth::check())
<ul class="nav navbar-nav">
	@if (session()->get('auth.webmap.moderator')) 
		<li>
			<a href="/webmap/admin" class="dropdown-toggle"  role="button" target="_blank">Administration</a>
		</li>
	@endif
	@if (session()->get('auth.webmap.contributor') || session()->get('auth.webmap.moderator')) 
		<li>
			<a href="/webmap/create" class="dropdown-toggle"  role="button" target="_blank">Ajouter un pôle</a>
		</li>
	@endif
	@if(Request::path() == 'webmap')
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Couches <span class="caret"></span></a>
		<ul id="map-ui" class="dropdown-menu">
        </ul>
	</li>
	@endif
	@if( !Request::is('webmap') && !Request::is('webmap/create') && !Request::is('webmap/*/edit'))
	<li>
		<a href="{{Request::url()}}/pdf" target="_blank"><i class="fa fa-file-pdf-o fa-fw fa-lg"></i>PDF</a>
	</li>
	@endif
</ul>
@endif
@endsection