@extends('template.back.main')
@include('acl::admin.sidebar')
@section('title')
<title>Périmètres</title>
@endsection

@section('header')
@endsection

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Editer un périmètre</h1>
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
                                {!! Form::model($perimeter, ['route' => ['perimeter.update', $perimeter->id], 'method' => 'put', 'class' => 'form']) !!}
                                    {!! csrf_field() !!}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Code commune</label>
                                            <input name="com" class="form-control" value="{{ Input::old('com', $perimeter->com) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Nom de la commune</label>
                                            <input name="nom_com" class="form-control"value="{{ Input::old('nom_com', $perimeter->nom_com) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Code EPCI</label>
                                            <input name="epci" class="form-control" value="{{ Input::old('epci', $perimeter->epci) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Nom de l'EPCI</label>
                                            <input name="nom_epci" class="form-control"value="{{ Input::old('nom_epci', $perimeter->nom_epci) }}">
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
        
	</div>
@endsection
@section('footer')
@endsection