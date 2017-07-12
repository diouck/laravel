@extends('template.back.main')
@include('webmap::admin.sidebar')
@section('title')
<title>Administration commerce</title>
@endsection

@section('header')
@stop

{{-- Content --}}
@section('content')

	<section class="content-header">
        <h1 class="page-header">Administration</h1>
    </section>
    <section class="content">
    	<div class="row">
        	<div class="col-lg-3 col-md-6">
			    <div class="panel bg-green">
			        <div class="panel-heading">
			            <div class="row">
			                <div class="col-xs-3">
			                    <span class="fa fa-map fa-5x"></span>
			                </div>
			                <div class="col-xs-9 text-right">
			                <div class="huge">{{$nb_posts}}</div>
			                <div>Zone(s) et pôle(s) validé(s)</div>
			                </div>
			            </div>
			        </div>
			        <a href="/webmap/admin/posts">
			        <div class="panel-footer">
			            <span class="pull-left">tout voir</span>
			            <span class="pull-right fa fa-arrow-circle-right"></span>
			            <div class="clearfix"></div>
			        </div>
			        </a>
			    </div>
			</div>
			<div class="col-lg-3 col-md-6">
			    <div class="panel bg-orange">
			        <div class="panel-heading">
			            <div class="row">
			                <div class="col-xs-3">
			                    <span class="fa fa-cube fa-5x"></span>
			                </div>
			                <div class="col-xs-9 text-right">
			                <div class="huge">{{$nb_revisions}}</div>
			                <div>Zone(s) et pôle(s) en attente</div>
			                </div>
			            </div>
			        </div>
			        <a href="/webmap/admin/revisions">
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