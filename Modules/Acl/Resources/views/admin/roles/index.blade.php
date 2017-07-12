@extends('template.back.main')
@include('acl::admin.sidebar')
@section('title')
<title>Rôles</title>
@endsection

@section('header')
	{!! HTML::style('assets/css/menu.css') !!}
@endsection

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Rôles</h1>
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
								<th class="sorting_desc">{!!Lang::get('acl::admin/roles.table.id')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/roles.table.slug')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/roles.table.name')!!}</th>
								<th></th>
								<th></th>
								<th></th>
								
							</tr>
						</thead>
						<tbody>
							@foreach ($roles as $role)
							<tr>
								<td>{{ $role->id }}</td>
								<td>{{ $role->slug }}</td>
								<td>{{ $role->name }}</td>
								
								<td>{!! link_to_route('role.show', trans('acl::admin/commons.button.see'), [$role->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
								<td>{!! link_to_route('role.edit', trans('acl::admin/commons.button.edit'), [$role->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
								<td>
									{!! Form::open(['method' => 'DELETE', 'route' => ['role.destroy', $role->id]]) !!}
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
	</div>
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