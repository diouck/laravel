@extends('template.back.main')
@include('acl::admin.sidebar')
@section('title')
<title>Autorisations</title>
@endsection

@section('header')
@endsection

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Editer une autorisation</h1>
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
                                {!! Form::model($authorization, ['route' => ['authorization.update', $authorization->id], 'method' => 'put', 'class' => 'form']) !!}
                                    {!! csrf_field() !!}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Application</label>
                                            {!!Form::select('application', $applications , $authorization->application_id,['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Rôle</label>
                                            {!!Form::select('role', $roles , $authorization->role_id,['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Commune(s)</label>
                                            {!!Form::select('com[]', $communes , $authorization->perimeters->pluck('id')->all(),['class' => 'form-control multiselect','multiple' => true]) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>EPCI(s)</label>
                                            {!!Form::select('epci[]', $epcis , null,['class' => 'form-control multiselect','multiple' => true]) !!}
                                        </div>
                                         <div class="form-group">
                                            <label>Département(s)</label>
                                            {!!Form::select('dep[]', $deps , null,['class' => 'form-control multiselect','multiple' => true]) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Utilisateur(s)</label>
                                            {!!Form::select('user[]', $users , $authorization->users->pluck('id')->all(),['class' => 'form-control multiselect','multiple' => true]) !!}
                                        </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-default">Envoyer</button>
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                    </div>
                                {!! Form::close() !!}
                                <!-- /.col-lg-6 (nested) -->
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