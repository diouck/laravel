@extends('template.back.main')
@include('acl::admin.sidebar')
@section('title')
<title>Périmètres</title>
@endsection

@section('header')
	{!! HTML::style('assets/css/menu.css') !!}
@endsection

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Périmètres</h1>
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
								<th class="sorting_desc">{!!Lang::get('acl::admin/perimeters.table.id')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/perimeters.table.com')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/perimeters.table.epci')!!}</th>
								<th></th>
								<th></th>
								<th></th>
								
							</tr>
						</thead>
						<tbody>
							@foreach ($perimeters as $perimeter)
							<tr>
								<td>{{ $perimeter->id }}</td>
								<td>{{$perimeter->nom_com}} ({{$perimeter->com}})</td>
								<td>{{$perimeter->nom_epci}} ({{$perimeter->epci}})</td>
								
								<td>{!! link_to_route('perimeter.show', trans('acl::admin/commons.button.see'), [$perimeter->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
								<td>{!! link_to_route('perimeter.edit', trans('acl::admin/commons.button.edit'), [$perimeter->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
								<td>
									{!! Form::open(['method' => 'DELETE', 'route' => ['perimeter.destroy', $perimeter->id]]) !!}
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