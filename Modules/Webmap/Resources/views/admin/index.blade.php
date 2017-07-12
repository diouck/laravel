@extends('template.back.main')
@include('webmap::admin.sidebar')
@section('title')
<title>Administration commerce</title>
@endsection

@section('header')
@endsection

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Zones et pôles commerciaux en attente de validation</h1>
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
								<th class="sorting_desc">Code</th>
								<th class="sorting_desc">Nom</th>
								<th class="sorting_desc">Date</th>
								<th></th>
								<th></th>
								<th></th>
								
							</tr>
						</thead>
						<tbody>
							@foreach ($revisions as $revision)
							<tr>
								<td>{{$revision->slug}}</td>
								<td>{{$revision->title}}</td>
								<td>{{$revision->created_at}}</td>								
								<td>{!! link_to_route('commercerevision.show', trans('acl::admin/commons.button.see'), [$revision->id], ['class' => 'btn btn-info btn-block btn']) !!}</td>
								<td>
									{!! Form::open(['method' => 'POST', 'route' => ['commercerevision.update', $revision->id]]) !!}
									{!! Form::submit(trans('acl::admin/commons.button.publish'), ['class' => 'btn btn-success btn-block']) !!}
									{!! Form::close() !!}
								</td>
								<td>
									{!! Form::open(['method' => 'DELETE', 'route' => ['commercerevision.destroy', $revision->id]]) !!}
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