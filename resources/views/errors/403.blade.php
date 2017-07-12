@extends('template.front.main')
{{-- Web site Title --}}
@section('title')
<title>Erreur 404</title>
@endsection
Désolé, cette page n'existe pas !
@stop

{{-- Content --}}
@section('content')

<div class="jumbotron">
  <div class="container">
    <h1>Erreur 403</h1>
    <p>Désolé, l'accès à cette page est interdit !</p>
  </div>
</div> 
@stop