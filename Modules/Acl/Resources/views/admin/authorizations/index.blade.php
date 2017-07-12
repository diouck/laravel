@extends('template.back.main')
@include('acl::admin.sidebar')
@section('title')
<title>Autorisations</title>
@endsection

@section('header')
	{!! HTML::style('assets/css/menu.css') !!}
@endsection

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Autorisations</h1>
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
								<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.id')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.application')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.role')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.perimeters')!!}</th>
								<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.users')!!}</th>
								<th></th>
								<th></th>
								<th></th>
								
							</tr>
						</thead>
						<tbody>
							@foreach ($authorizations as $authorization)
							<tr>
								<td>{{$authorization->id }}</td>
								<td>{{$authorization->application->name}}</td>
								<td>{{$authorization->role->name}}</td>
								<td>
									<ul>
									<?php $i = 1; ?>
		                            @foreach ($authorization->perimeters as $perimeter)
		                                <li>{{$perimeter->nom_com}}</li>
		                                @if($i == 5)
		                                	<li>...</li>
		                                	 <?php break; ?>
		                                @endif
		                                <?php $i++; ?>
		                            @endforeach
		                            </ul>
		                        </td>
								<td>
									<ul>
									<?php $i = 1; ?>
									@foreach ($authorization->users as $user)
										<li>{{$user->username}}</li>
										@if($i == 5)
		                                	<li>...</li>
		                                	 <?php break; ?>
		                                @endif
		                                <?php $i++; ?>
									@endforeach
									</ul>
								</td>
								
								
								<td>{!! link_to_route('authorization.show', trans('acl::admin/commons.button.see'), [$authorization->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
								<td>{!! link_to_route('authorization.edit', trans('acl::admin/commons.button.edit'), [$authorization->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
								<td>
									{!! Form::open(['method' => 'DELETE', 'route' => ['authorization.destroy', $authorization->id]]) !!}
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