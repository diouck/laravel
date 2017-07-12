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
        <h1 class="page-header">Ajouter un utilisateur</h1>
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
                                <form role="form" action="/admin/user" method="post">
                                    {!! csrf_field() !!}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Prénom</label>
                                            <input name="firstname" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input name="name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nom d'utilisateur</label>
                                            <input name="username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Adresse mail</label>
                                            <input name="email" class="form-control" placeholder="email@example.com">
                                        </div>
                                        <div class="form-group">
                                            <label>Mot de passe</label>
                                            <input name="password" class="form-control" type="password">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirmation du mot de passe</label>
                                            <input name="password_confirmation" class="form-control" type="password">
                                        </div>
                                        <div class="form-group">
                                            <label class="checkbox-inline">
                                                <input name="admin" type="checkbox"  value="1">administrateur
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-default">Envoyer</button>
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                    </div>
                                </form>
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