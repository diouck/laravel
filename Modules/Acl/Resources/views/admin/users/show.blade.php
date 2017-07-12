@extends('template.back.main')
@include('acl::admin.sidebar')
@section('title')
<title>Utilisateurs</title>
@endsection

@section('header')
@endsection

{{-- Content --}}
@section('content')
    <section class="content-header">
        <h1 class="page-header">{{$user->username}}</h1>
    </section>
    <section class="content">
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @foreach($errors->all() as $error)
                                <p class="alert alert-warning">{{ $error }}</p>
                            @endforeach
                            <div class="row">
                                {!! csrf_field() !!}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Prénom</label>
                                        <p class="form-control-static">{{$user->firstname}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <p class="form-control-static">{{$user->name}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Adresse mail</label>
                                        <p class="form-control-static">{{$user->email}}</p>
                                    </div>
                       				@if(!empty($user->admin))
	                                    <div class="form-group">
	                                        <label class="checkbox-inline">
	                                            <input name="admin" type="checkbox" checked>administrateur
	                                        </label>
	                                    </div>
                                    @endif
                                    <div class="col-lg-3">
                                        {!! link_to_route('user.edit','modifier', [$user->id],['class' => 'btn btn-success btn-block btn']) !!}
                                    </div>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    <label>Module(s) disponible(s)</label>
                                    <div class="dataTable_wrapper">
                                        <table class="table table-striped table-hover" >
                                            <thead>
                                                <tr>
                                                    <th class="sorting_desc">Module</th>
                                                    <th class="sorting_desc">Rôle</th>
                                                    <th class="sorting_desc">Périmètre(s)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user->authorizations as $authorization)
                                                <tr>
                                                    <td>{!! link_to_route('module.show',$authorization->module->name, [$authorization->module_id]) !!}</td>
                                                    <td>{!! link_to_route('role.show',$authorization->role->name, [$authorization->role_id]) !!}</td>
                                                    <td>
                                                        <ul>
                                                        @foreach ($authorization->perimeters as $perimeter)
                                                        {!! link_to_route('perimeter.show',$perimeter->nom_com, [$perimeter->id]) !!}
                                                        @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        
	</section>
@endsection
@section('footer')
@endsection