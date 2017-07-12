@extends('template.back.main')
@include('commercemetro::admin.sidebar')
@section('title')
<title>Administration commerce</title>
@endsection

@section('header')
@endsection

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Zones et pôles commerciaux validés</h1>
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
							@foreach ($posts as $post)
							<tr>
								<td>{{$post->slug}}</td>
								<td>{{$post->title}}</td>
								<td>{{$post->created_at}}</td>								
								<td>{!! link_to_route('commerce.show', trans('acl::admin/commons.button.see'), [$post->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
								<td>{!! link_to_route('commerce.edit', trans('acl::admin/commons.button.edit'), [$post->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
								<td>
									{!! Form::open(['method' => 'DELETE', 'route' => ['commerce.destroy', $post->id]]) !!}
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