@extends('template.back.main')
@include('acl::admin.sidebar')
@section('title')
<title>Tableau de bord</title>
@endsection

@section('header')
@stop

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Tableau de bord</h1>
    </section>
    <section class="content">
        <div class="row">
        	<div class="col-lg-3 col-md-6">
			    <div class="panel bg-red">
			        <div class="panel-heading">
			            <div class="row">
			                <div class="col-xs-3">
			                    <span class="fa fa-tasks fa-5x"></span>
			                </div>
			                <div class="col-xs-9 text-right">
			                <div class="huge">{{ $nb_applications }}</div>
			                <div>Module(s)</div>
			                </div>
			            </div>
			        </div>
			        <a href="/admin/application">
			        <div class="panel-footer">
			            <span class="pull-left">tout voir</span>
			            <span class="pull-right fa fa-arrow-circle-right"></span>
			            <div class="clearfix"></div>
			        </div>
			        </a>
			    </div>
			</div>
			<div class="col-lg-3 col-md-6">
			    <div class="panel bg-light-blue">
			        <div class="panel-heading">
			            <div class="row">
			                <div class="col-xs-3">
			                    <span class="fa fa-legal fa-5x"></span>
			                </div>
			                <div class="col-xs-9 text-right">
			                <div class="huge">{{ $nb_roles }}</div>
			                <div>Rôle(s)</div>
			                </div>
			            </div>
			        </div>
			        <a href="/admin/role">
			        <div class="panel-footer">
			            <span class="pull-left">tout voir</span>
			            <span class="pull-right fa fa-arrow-circle-right"></span>
			            <div class="clearfix"></div>
			        </div>
			        </a>
			    </div>
			</div>
			<div class="col-lg-3 col-md-6">
			    <div class="panel bg-green">
			        <div class="panel-heading">
			            <div class="row">
			                <div class="col-xs-3">
			                    <span class="fa fa-object-ungroup fa-5x"></span>
			                </div>
			                <div class="col-xs-9 text-right">
			                <div class="huge">{{ $nb_perimeters }}</div>
			                <div>Périmètre(s)</div>
			                </div>
			            </div>
			        </div>
			        <a href="/admin/perimeter">
			        <div class="panel-footer">
			            <span class="pull-left">tout voir</span>
			            <span class="pull-right fa fa-arrow-circle-right"></span>
			            <div class="clearfix"></div>
			        </div>
			        </a>
			    </div>
			</div>
			<div class="col-lg-3 col-md-6">
			    <div class="panel bg-yellow">
			        <div class="panel-heading">
			            <div class="row">
			                <div class="col-xs-3">
			                    <span class="fa fa-users fa-5x"></span>
			                </div>
			                <div class="col-xs-9 text-right">
			                <div class="huge">{{ $nb_users }}</div>
			                <div>Utilisateur(s)</div>
			                </div>
			            </div>
			        </div>
			        <a href="/admin/user">
			        <div class="panel-footer">
			            <span class="pull-left">tout voir</span>
			            <span class="pull-right fa fa-arrow-circle-right"></span>
			            <div class="clearfix"></div>
			        </div>
			        </a>
			    </div>
			</div>
        </div>
	</section>
@stop
@section('footer')
@stop