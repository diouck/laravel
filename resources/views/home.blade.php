@extends('template.front.main')
@section('title')
<title>AVIZON</title>
@stop

@section('header')
@stop

{{-- Content --}}
@section('content')
<div class="jumbotron avizon">
    <div class="container">
        <img class="center-block img-responsive" src="/images/logo_avizon_full.png">  
    </div>
</div>
@endsection
@section('footer')
<footer class="main-footer">
    <div id="credit" class="text-center">
        Copyright © 2011-2017
        <a rel="home" title="AURG" href="http://www.aurg.org/">AURG</a>
        | Tous droits réservés |
        <a href="http://www.aurg.org/mentions-legales/">mentions légales</a>
    </div>
</footer>
@endsection
