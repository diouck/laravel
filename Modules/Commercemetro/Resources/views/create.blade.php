@extends('template.front.main')
@include('commercemetro::search')
@section('title')
<title>Créer un pole commercial</title>
@endsection

@section('header')
    {!! HTML::style('https://api.mapbox.com/mapbox.js/v3.0.1/mapbox.css', array('media' => 'all')) !!}
    {!! HTML::style('/modules/commercemetro/css/map.css', array('media' => 'all')) !!}
    {!! HTML::style('https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.2/leaflet.draw.css', array('media' => 'all')) !!}

@endsection

{{-- Content --}}
@section('content')
<div class="container">
    <section class="content-header">
            <h1>Créer un pôle ou une zone commerciale</h1>
    </section>
    <section class="content">
        <div class="row">
            @foreach($errors->all() as $error)
                <p class="alert alert-warning">{{ $error }}</p>
            @endforeach
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#situation" role="tab" data-toggle="tab">Situation</a></li>
                        <li ><a class="activite" href="#activite" role="tab" data-toggle="tab">Secteurs d'activités</a></li>
                        <li ><a class="formevente" href="#formevente" role="tab" data-toggle="tab">Formes de ventes</a></li>
                        <li ><a class="appreciation" href="#appreciation" role="tab" data-toggle="tab">Appréciation, dynamique et enjeux</a></li>

                        <li><a class="catgauran" href="#catgauran" role="tab" data-toggle="tab">Autres catégories AURAN</a></li>


                    </ul>
                </div>
            </div>
        </div>
        {!! Form::model(['route' => ['commerce.new'], 'method' => 'post']) !!}
        {!! csrf_field() !!}
        <div class="tab-content">
            <div class="tab-pane active" id="situation">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Identifiant</label>
                                    <input name="slug" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Nom</label>
                                    <input name="title" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Commune</label>
                                    {!!Form::select('com', $communes , Input::old('com'),['class' => 'form-control multiselect']) !!}
                                </div>
                                <div class="form-group">
                                    <label>Contributeur</label>
                                    <input name="content[contributeur]" class="form-control" value="">
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Type de zone</label>
                                    <select name="content[type]" class="form-control">
                                      <option>pôle commercial</option>
                                      <option>zone commerciale</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date de collecte de l'information</label>
                                    <input name="content[date]" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Locaux vacants</label>
                                    <input name="content[cat_0_1]" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Locaux en travaux</label>
                                    <input name="content[cat_0_2]" class="form-control" value="">
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                 <div class="map">
                                     <div id="editmap"></div>
                                </div>
                                <div id="geom">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="activite">
                 <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#alimentaire" role="tab" data-toggle="tab">Alimentaire</a></li>
                            <li><a href="#equip-personne" role="tab" data-toggle="tab">Equipements de la personne</a></li>
                            <li><a href="#equip-maison" role="tab" data-toggle="tab">Equipements de la maison</a></li>
                            <li><a href="#activ-loisir" role="tab" data-toggle="tab">Culture / Loisirs / Cadeaux</a></li>
                            <li><a href="#activ-sante" role="tab" data-toggle="tab">Santé</a></li>
                            <li><a href="#activ-service-com" role="tab" data-toggle="tab">Services commerciaux</a></li>
                            <li><a href="#activ-service-non-com" role="tab" data-toggle="tab">Services non commerciaux</a></li>
                            <li><a href="#activ-restau" role="tab" data-toggle="tab">Café / Hôtel / Restaurant</a></li>
                            <li><a href="#activ-auto" role="tab" data-toggle="tab">Automobile / Moto / Cycle</a></li>
                            <li><a href="#activ-autre" role="tab" data-toggle="tab">Autres activités</a></li> 
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="alimentaire">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Alimentaire</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Hypermarché (> 2500 m²)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Supermarché (>400 et < 2500 m²)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Epicerie (< 400 m²)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Multi-service</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Grand magasin à dominante alimentaire</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Boulangerie / Pâtisserie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Chocolatier / Pâtisserie / vente thé / café</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Point chaud</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Boucherie / Charcuterie / Traiteur</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-inline">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Traiteur (hors boucherie / charcuterie)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_10]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Poissonnerie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_11]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Caviste</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_12]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                 <div class="list-group-item">
                                                    <span class="col-md-6">Primeur / Fruits et légumes</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_13]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Fromagerie / Crémerie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_14]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Surgelés</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_15]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Produits bio</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_16]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Produits régionaux</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_17]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Produits exotiques</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_18]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Produits alimentaires spécialisés</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_19]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Drive</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_1_20]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="equip-personne">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Equipements de la personne</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Grand magasin à dominante équipement de la personne</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Prêt-à-porter spécialisé (homme, femme, enfant)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Prêt-à-porter mixte</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Chaussures spécialisé (homme, femme, enfant)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Chaussures mixte</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Prêt-à-porter (50%) et chaussures (50%)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Puériculture / pré-maman</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Lingerie féminine</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-inline">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Sport (vêtement, chaussures)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Maroquinerie / Chapellerie / Ganterie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_10]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Mercerie / Laine / Tissus habillement</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_11]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Bijouterie / Horlogerie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_12]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                 <div class="list-group-item">
                                                    <span class="col-md-6">Bijouterie fantaisie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_13]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Accessoires de mode</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_14]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Optique / audition</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_15]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Parfumerie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_16]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Produits de beauté spécialisés</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_2_17]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                              
                        </div>
                    </div>
                    <div class="tab-pane" id="equip-maison">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Equipements de la maison</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Cuisiniste (avec ou sans électroménager)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Électroménager mixte (blanc, noir, gris)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Electroménager spécialisé : TV / Hifi / Vidéo / Ordi</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Electroménager mono : mach. à coudre, aspirateur</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Vaisselle / Art de la table / Linge de maison</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Décoration / Tissus ameublement / Encadrement</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Bricolage généraliste / quincaillerie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Bricolage spécialisé : peinture, papier peint / Sol</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Mobilier et équipement généraliste</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Mobilier spécialisé : luminaires, literie, salon</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_10]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Equipement spécialisé: fenêtres / stores / cheminées</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_11]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Antiquité / Brocante</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_3_12]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="activ-loisir">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Culture / Loisirs / Cadeaux</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Librairie / BD / Papeterie / loisirs créatifs</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Grand magasin à dominante culture et loisirs</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Cadeaux / Souvenir</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Gadget / Bazar  / Cartes</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Presse (avec ou sans librairie)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Tabac (avec ou sans presse)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Cigarette électronique</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Fleuriste / Jardinage</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Téléphonie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Article de sports (hors vêtement et chaussures)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_10]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Jeux / Jouets</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_11]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Disques, CD, DVD</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_12]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Instrument de musique</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_13]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Photographe</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_14]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Galerie d'art / Beaux arts</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_15]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Animalerie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_16]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Armurerie / Pêche / Chasse</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_17]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Location vidéo</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_18]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Articles funéraires</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_19]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Sex shop</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_4_20]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="activ-sante">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Santé</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Pharmacie / Parapharmacie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_5_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Laboratoire analyses médicales</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_5_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Activités médicales (kiné, infirmier,...)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_5_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Vétérinaires</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_5_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Matériel médical</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_5_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="activ-service-com">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Services commerciaux</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Salon de coiffure</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Institut de beauté / SPA / massage</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Salle de sport</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Salon de tatouage / piercing</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Laverie / Pressing / Teinturier</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Cordonnerie / Clef minute / Gravure</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                         <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Auto-école</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Toiletteur canin</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Retouche vêtements</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Photocopie / secrétariat / imprimerie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_10]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Dépôt vente</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_11]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Dépannage / maintenance informatique, électricité,…</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_6_12]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="activ-service-non-com">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Service non commerciaux</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Banque</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Assurance</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Courtier / organisme de crédit</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Mutuelle</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Agence immobilière</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                         <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Agende de voyage</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Agence d'intérim</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Location de voitures</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Aide à domicile</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Bureau de change, achat d'or</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_7_10]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="activ-restau">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Café / Hôtel / Restaurant</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Café, salon de thé (avec/sans restauration)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Hôtel (avec/sans restauration)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Bar / Tabac / Jeux</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Restaurant traditionnel / Brasserie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Pizzeria, crêperie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Restaurant régional, spécialités étrangères</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Glacier, yaourt…</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Fast-food / Snack / Kebab</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Vente à emporter uniquement</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Boite de nuit / Bar de nuit</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_8_10]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="activ-auto">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Automobile / Moto / Cycle</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Concessionnaire auto, moto</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_9_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Garage (avec/sans stat. serv.)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_9_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Station services</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_9_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Lavage voiture</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_9_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Vente de pièces détachées, casse-auto</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_9_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Eq de la pers. auto / moto</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_9_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Cycles - vente et atelier réparation</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_9_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="activ-autre">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h2 class="box-title">Autres activités</h2>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Artisan avec magasin</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Artisan sans magasin</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Bureau d'étude / Architecte / Local politique</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Taxi / Ambulance</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Administration, service public</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">La Poste</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Associations</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Organisme de formation, soutien scolaire, cours</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 form-inline">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Cinéma / Culture/ loisirs (bowling, laser game,…)</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Logement</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_10]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Grossiste</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_11]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Location de salle de mariage, salle de fêtes,…</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_12]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Location de matériel spécialisé et garde-meuble</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_13]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Transporteur</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_14]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Construction, entretien maison, BTP</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_15]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Production et conception de l’industrie</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_16]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <span class="col-md-6">Autres</span>
                                                    <div class="input-group col-md-6">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                                        <input name="content[cat_10_99]" type="text" class="form-control text-center" maxlength="3" value="0">
                                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="formevente">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h2 class="box-title">Formes</h2>
                            </div>
                            <div class="box-body">
                                <div class="list-group-item">
                                    <span class="col-md-6">Vacant</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_0]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Grande surface de + de 1000 m²</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Moyenne surface entre 300 et 999 m²</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Commerce traditionnel</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Commerce traditionnel en galerie marchande</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Drive</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_5]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Commerce en kiosque</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Food truck</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_7]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Guichet automatique</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Autres activités non marchandes</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <span class="col-md-6">Concessionnaire et garage</span>
                                    <div class="input-group col-md-6">
                                        <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                        <input name="content[vente_10]" type="text" class="form-control text-center" maxlength="3" value="0">
                                        <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h2 class="box-title">Surfaces (en m²)</h2>
                            </div>
                            <div class="list-group-item">
                                <span class="col-md-6">Alimentaire</span>
                                <div class="input-group col-md-6">
                                    <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                    <input name="content[sf_1]" type="text" class="form-control text-center" maxlength="3" value="0">
                                    <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <span class="col-md-6">Equipement de la personne</span>
                                <div class="input-group col-md-6">
                                    <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                    <input name="content[sf_2]" type="text" class="form-control text-center" maxlength="3" value="0">
                                    <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <span class="col-md-6">Equipement de la maison</span>
                                <div class="input-group col-md-6">
                                    <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                    <input name="content[sf_3]" type="text" class="form-control text-center" maxlength="3" value="0">
                                    <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <span class="col-md-6">Culture / Loisirs</span>
                                <div class="input-group col-md-6">
                                    <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                    <input name="content[sf_4]" type="text" class="form-control text-center" maxlength="3" value="0">
                                    <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <span class="col-md-6">Services commerciaux</span>
                                <div class="input-group col-md-6">
                                    <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                    <input name="content[sf_6]" type="text" class="form-control text-center" maxlength="3" value="0">
                                    <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <span class="col-md-6">Hôtellerie / Restauration</span>
                                <div class="input-group col-md-6">
                                    <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                    <input name="content[sf_8]" type="text" class="form-control text-center" maxlength="3" value="0">
                                    <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <span class="col-md-6">Cycle</span>
                                <div class="input-group col-md-6">
                                    <span class="input-group-btn"><button class="btn btn-default btn-minuse" type="button">-</button></span>
                                    <input name="content[sf_9]" type="text" class="form-control text-center" maxlength="3" value="0">
                                    <span class="input-group-btn"><button class="btn btn-default btn-pluss" type="button">+</button></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="appreciation">
                <?php $appreciation = ['Très satisfaisant'=>'Très satisfaisant','Assez satisfaisant'=>'Assez satisfaisant','Peu satisfaisant'=>'Peu satisfaisant','Pas du tout satisfaisant'=>'Pas du tout satisfaisant'];?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h2 class="box-title">Appréciation</h2>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Densité de l'offre</label>
                                    {!!Form::select('content[appreciation_densite]', $appreciation ,'',['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label>Diversité de l'offre</label>
                                    {!!Form::select('content[appreciation_diversite]', $appreciation ,'',['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label>Dynamique commerciale</label>
                                    {!!Form::select('content[appreciation_dynamique]', $appreciation ,'', ['class' => 'form-control']) !!}
                                    <label>Commentaire sur la dynamique commerciale</label>
                                    <textarea name="content[appreciation_dyn_com]" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Organisation urbaine</label>
                                    {!!Form::select('content[appreciation_urbaine]', $appreciation ,'',['class' => 'form-control']) !!}
                                    <label>Commentaire sur l'organisation urbaine</label>
                                    <textarea name="content[orga_urbaine]" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Qualité des linéaires / façades</label>
                                    {!!Form::select('content[appreciation_lineaire]', $appreciation ,'',['class' => 'form-control']) !!}
                                    <label>Commentaire sur la qualité des linéaires / façades</label>
                                    <textarea name="content[qualite_lineaire]" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Qualité des espaces publics</label>
                                    {!!Form::select('content[appreciation_espace_public]', $appreciation ,'',['class' => 'form-control']) !!}
                                    <label>Commentaire sur la qualité des espaces publics</label>
                                    <textarea name="content[qualite_espace_public]" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Accessibilité routière / Stationnement</label>
                                    {!!Form::select('content[appreciation_acces_routier]', $appreciation ,'',['class' => 'form-control']) !!}
                                    <label>Commentaire sur l'accessibilité routière / stationnement</label>
                                    <textarea name="content[acces_routier]" class="form-control" rows="3"></textarea>
                                </div> 
                                <div class="form-group">
                                    <label>Desserte TC / modes actifs</label>
                                    {!!Form::select('content[appreciation_desserte_tc]', $appreciation ,'',['class' => 'form-control']) !!}
                                    <label>Commentaire sur la desserte TC / modes actifs</label>
                                    <textarea name="content[desserte_tc]" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>                               
                    </div>
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h2 class="box-title">Dynamique</h2>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Union commerciale</label>
                                    <input name="content[nom_union_commerciale]" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Nombre d'adhérents à l'union commerciale</label>
                                    <input name="content[nb_adherent_union]" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Projets commerciaux connus à court, moyen terme</label>
                                    <textarea name="content[projet_commerciaux]" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h2 class="box-title">Enjeux</h2>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <textarea name="content[enjeux]" class="form-control" rows="3"></textarea>
                                </div>  
                            </div>
                        </div>                            
                    </div>
                </div>
            </div>



            <div class="tab-pane" id="catgauran">        
                <div class="row">
                  
                    <div class="col-md-6">
                       
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h2 class="box-title">Commentaires</h2>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <textarea name="content[com_auran]" class="form-control" rows="3"></textarea>
                                </div>  
                            </div>
                        </div>                            
                    </div>
                </div>
            </div>



            
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-default">Envoyer</button>
                    <button type="reset" class="btn btn-default">Annuler</button>
                </div>
            </div>
        </div>  
        {!! Form::close() !!}      
    </div>
@endsection
@section('scripts')
    {!! HTML::script('https://api.mapbox.com/mapbox.js/v3.0.1/mapbox.js') !!}
    {!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.2/leaflet.draw.js') !!}
    {!! HTML::script('http://maps.google.com/maps/api/js?v=3') !!}
    {!! HTML::script('/modules/commercemetro/js/google.js') !!}
    {!! HTML::script('/modules/commercemetro/js/creategeom.js') !!}
    <script>
        $('.btn-minuse').on('click', function(e){
            // Stop acting like a button
            e.preventDefault();
            // Get its current value
            var currentVal = parseInt($(this).parent().siblings('input').val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                $(this).parent().siblings('input').val(currentVal - 1);
            } else {
                // Otherwise put a -1 there
                $(this).parent().siblings('input').val(-1);
            }
        });
        $('.btn-pluss').on('click', function(e){
            // Stop acting like a button
            e.preventDefault();
            // Get its current value
            var currentVal = parseInt($(this).parent().siblings('input').val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                $(this).parent().siblings('input').val(currentVal + 1);
            } else {
                // Otherwise put a 1 there
                $(this).parent().siblings('input').val(1);
            }
        });
    </script>
@endsection           