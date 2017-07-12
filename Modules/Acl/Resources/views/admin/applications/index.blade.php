@extends('template.back.main')
@include('acl::admin.sidebar')
@section('title')
<title>Applications</title>
@endsection

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Applications</h1>
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
								<th class="sorting_desc">{!!Lang::get('acl::admin/applications.table.id')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/applications.table.slug')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/applications.table.name')!!}</th>
								<th>{!!Lang::get('acl::admin/applications.table.users')!!}</th>
								<th></th>
								<th></th>
								<th></th>
								
							</tr>
						</thead>
						<tbody>
							@foreach ($applications as $application)
							<tr>
								<td>{{ $application->id }}</td>
								<td>{{ $application->slug }}</td>
								<td>{{ $application->name }}</td>
								<td>
									<ul>
										<?php $i = 1; ?>
										@foreach ($application->authorizations as $authorization)
											@foreach ($authorization->users as $user)
												<li>{!! link_to_route('user.show', $user->username, [$user->id]) !!}</li>
												@if($i == 5)
				                                	<li>...</li>
				                                	 <?php break; ?>
				                                @endif
			                                	<?php $i++; ?>
											@endforeach
			                            @endforeach
									</ul>
								</td>
								<td>{!! link_to_route('application.show', trans('acl::admin/commons.button.see'), [$application->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
								<td>{!! link_to_route('application.edit', trans('acl::admin/commons.button.edit'), [$application->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
								<td>
									{!! Form::open(['method' => 'DELETE', 'route' => ['application.destroy', $application->id]]) !!}
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