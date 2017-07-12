@extends('template.back.main')
@include('acl::admin.sidebar')
@section('title')
<title>Utilisateurs</title>
@endsection

@section('header')
	{!! HTML::style('assets/css/menu.css') !!}
@endsection

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Utilisateurs</h1>
    </section>
    <section class="content">
        <!-- Notifications -->
			@include('template.back.notifications')
		<!-- ./ notifications -->
        <div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body">
			        <table class="table table-bordered table-hover dataTables">
						<thead>
							<tr>
								<th>{!!Lang::get('acl::admin/users.table.id')!!}</th>
								<th >{!!Lang::get('acl::admin/users.table.firstname')!!}</th>
								<th>{!!Lang::get('acl::admin/users.table.name')!!}</th>
								<th>{!!Lang::get('acl::admin/users.table.username')!!}</th>
								<th>{!!Lang::get('acl::admin/users.table.email')!!}</th>
								<th>{!!Lang::get('acl::admin/users.table.applications')!!}</th>
								<th></th>
								<th></th>
								<th></th>
								
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
							<tr>
								<td>{{ $user->id }}</td>
								<td>{{ $user->firstname }}</td>
								<td>{{ $user->name }}</td>
								<td>{{ $user->username }}</td>
								<td>{{ $user->email }}</td>
								<td>
									<ul>
										@foreach ($user->authorizations as $authorization)
											<li> {{$authorization->role->name}} {{$authorization->application->name}} </li>
										@endforeach
									</ul>
								</td>
								<td>{!! link_to_route('user.show', trans('acl::admin/commons.button.see'), [$user->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
								<td>{!! link_to_route('user.edit', trans('acl::admin/commons.button.edit'), [$user->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
								<td>
									{!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]) !!}
									{!! Form::submit(trans('acl::admin/commons.button.destroy'), ['class' => 'btn btn-danger btn-block']) !!}
									{!! Form::close() !!}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
@section('footer')
	<script>
		$(document).ready(function() {
		    $('.dataTables').DataTable({
		    	paging:true,
		        responsive: true,
		        "autoWidth": true,
		        "ordering": true,
		        "language": {
		                "url": "/assets/json/datatables.json"
		            }
		    });
		});
	</script>
@endsection