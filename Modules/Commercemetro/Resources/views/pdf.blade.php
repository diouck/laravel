@extends('template.front.pdfmain')

@section('title')
<title>{{ $post->slug }}</title>
@endsection
@section('header')
		{!! HTML::style('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css') !!}
		{!! HTML::style('/modules/commercemetro/css/map.css', array('media' => 'all')) !!}
		{!! HTML::style('https://api.mapbox.com/mapbox.js/v3.0.1/mapbox.css', array('media' => 'all')) !!}
		{!! HTML::style('https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.css', array('media' => 'all')) !!}
@endsection


@section('content')
	<?php $content = json_decode($post->content); ?>
<div class="container">
	<img class="img-responsive" src="http://www.avizon.fr/images/logo_avizon_moyen.png">
	<br>
	<section class="content-header">
		@if (isset($post->title))
			<h1>{{ $post->title }}<small>{{ $post->slug }}</small></h1>
		@else	
			<h1>{{ $post->slug }}</h1>
		@endif
	</section>
	<section class="content">
		<div class="tab-content">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-orange">
							<i class="fa fa-institution"></i>
						</span>
						<div class="info-box-content">
							<span class="info-box-text">Commune</span>
							<span class="info-box-number">{{$other['terms']['commune']}}</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-orange">
							<i class="fa fa-user"></i>
						</span>
						<div class="info-box-content">
							<span class="info-box-text">Contributeur</span>
							<span class="info-box-number">@if(!empty($content->contributeur)){{$content->contributeur}} @else NR @endif</span>
							<span class="progress-description"> le @if(!empty($content->date)){{$content->date}} @else NR @endif</span>

						</div>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-orange">
							<i class="fa fa-cubes"></i>
						</span>
						<div class="info-box-content">
							<span class="info-box-text">Cellule(s) commerciale(s)</span>
							<span class="info-box-number">{{$other['post']['total']}}</span>								
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-orange">
							<i class="fa fa-suitcase"></i>
						</span>
						<div class="info-box-content">
							<span class="info-box-text">Locaux vacants</span>
							<span class="info-box-number">@if(!empty($content->cat_0_1)){{CommerceHelper::sum_cat('#^cat_0_#', (array)$content)}} @else NR @endif</span>
							@if(!empty($content->cat_0_2))<span class="progress-description">dont {{$content->cat_0_2}} en travaux</span>@endif
						</div>
					</div>
				</div>				
			</div> 
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Localisation du pôle et des commerces</h3>
						</div>
						<div class="box-body singlemap" id="singlemap" style="width:880px; height:350px"></div>
					</div>
				</div>
			</div>
		</div> 
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Typologie des commerces</h3>
					</div>
					<div class="box-body">
						<div id="typo_commerce" class="chart" style="width: 400px; height: 400px;"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-orange">
						<i class="fa fa-cubes"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Nb de cellule(s)</span>
						<span class="info-box-number">{{$other['post']['total']}}</span>								
					</div>
				</div>
			</div>	
			<div class="col-md-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-orange">
						<i class="fa fa-hand-paper-o fa-rotate-90"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Service(s)</span>
						<span class="info-box-number">{{round(($other['post']['secteur']/$other['post']['total'])*100,1)}}%</span>								
					</div>
				</div>
			</div>				
		</div>
		<br><br><br><br><br><br>
		<div class="row">
		<div class="box-header with-border">
						<h3 class="box-title">Typologie des commerces (suiite)</h3>
					</div><hr>
		@if (CommerceHelper::sum_cat('#^cat_1_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Alimentaire : {{CommerceHelper::sum_cat('#^cat_1_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_1_1))<li class="list-group-item">Hypermarché (> 2500 m²)<span class="badge">{{$content->cat_1_1}}</span></li>@endif
							@if (isset($content->cat_1_2))<li class="list-group-item">Supermarché (>400 et < 2500 m²)<span class="badge">{{$content->cat_1_2}}</span></li>@endif
							@if (isset($content->cat_1_3))<li class="list-group-item">Epicerie (< 400 m²)<span class="badge">{{$content->cat_1_3}}</span></li>@endif
							@if (isset($content->cat_1_4))<li class="list-group-item">Multi-service<span class="badge">{{$content->cat_1_4}}</span></li>@endif
							@if (isset($content->cat_1_5))<li class="list-group-item">Grand magasin à dominante alimentaire<span class="badge">{{$content->cat_1_5}}</span></li>@endif
							@if (isset($content->cat_1_6))<li class="list-group-item">Boulangerie / Pâtisserie<span class="badge">{{$content->cat_1_6}}</span></li>@endif
							@if (isset($content->cat_1_7))<li class="list-group-item">Chocolatier / Pâtisserie / vente thé / café<span class="badge">{{$content->cat_1_7}}</span></li>@endif
							@if (isset($content->cat_1_8))<li class="list-group-item">Point chaud<span class="badge">{{$content->cat_1_8}}</span></li>@endif
							@if (isset($content->cat_1_9))<li class="list-group-item">Boucherie / Charcuterie / Traiteur<span class="badge">{{$content->cat_1_9}}</span></li>@endif
							@if (isset($content->cat_1_10))<li class="list-group-item">Traiteur (hors boucherie / charcuterie)<span class="badge">{{$content->cat_1_10}}</span></li>@endif
							@if (isset($content->cat_1_11))<li class="list-group-item">Poissonnerie<span class="badge">{{$content->cat_1_11}}</span></li>@endif
							@if (isset($content->cat_1_12))<li class="list-group-item">Caviste<span class="badge">{{$content->cat_1_12}}</span></li>@endif
							@if (isset($content->cat_1_13))<li class="list-group-item">Primeur / Fruits et légumes<span class="badge">{{$content->cat_1_13}}</span></li>@endif
							@if (isset($content->cat_1_14))<li class="list-group-item">Fromagerie / Crémerie<span class="badge">{{$content->cat_1_14}}</span></li>@endif
							@if (isset($content->cat_1_15))<li class="list-group-item">Surgelés<span class="badge">{{$content->cat_1_15}}</span></li>@endif
							@if (isset($content->cat_1_16))<li class="list-group-item">Produits bio<span class="badge">{{$content->cat_1_16}}</span></li>@endif
							@if (isset($content->cat_1_17))<li class="list-group-item">Produits régionaux<span class="badge">{{$content->cat_1_17}}</span></li>@endif
							@if (isset($content->cat_1_18))<li class="list-group-item">Produits exotiques<span class="badge">{{$content->cat_1_18}}</span></li>@endif
							@if (isset($content->cat_1_19))<li class="list-group-item">produits alimentaires spécialisés<span class="badge">{{$content->cat_1_19}}</span></li>@endif
							@if (isset($content->cat_1_20))<li class="list-group-item">Drive<span class="badge">{{$content->cat_1_20}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		@if (CommerceHelper::sum_cat('#^cat_2_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Equipement de la personne : {{CommerceHelper::sum_cat('#^cat_2_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_2_1))<li class="list-group-item">Grand magasin à dominante équipement de la personne<span class="badge">{{$content->cat_2_1}}</span></li>@endif
							@if (isset($content->cat_2_2))<li class="list-group-item">Prêt-à-porter spécialisé (homme, femme, enfant)<span class="badge">{{$content->cat_2_2}}</span></li>@endif
							@if (isset($content->cat_2_3))<li class="list-group-item">Prêt-à-porter mixte<span class="badge">{{$content->cat_2_3}}</span></li>@endif
							@if (isset($content->cat_2_4))<li class="list-group-item">Chaussures spécialisé (homme, femme, enfant)<span class="badge">{{$content->cat_2_4}}</span></li>@endif
							@if (isset($content->cat_2_5))<li class="list-group-item">Chaussures mixte<span class="badge">{{$content->cat_2_5}}</span></li>@endif
							@if (isset($content->cat_2_6))<li class="list-group-item">Prêt-à-porter (50%) et chaussures (50%)<span class="badge">{{$content->cat_2_6}}</span></li>@endif
							@if (isset($content->cat_2_7))<li class="list-group-item">Puériculture / pré-maman<span class="badge">{{$content->cat_2_7}}</span></li>@endif
							@if (isset($content->cat_2_8))<li class="list-group-item">Lingerie féminine <span class="badge">{{$content->cat_2_8}}</span></li>@endif
							@if (isset($content->cat_2_9))<li class="list-group-item">Sport (vêtement, chaussures)<span class="badge">{{$content->cat_2_9}}</span></li>@endif
							@if (isset($content->cat_2_10))<li class="list-group-item">Maroquinerie / Chapellerie / Ganterie<span class="badge">{{$content->cat_2_10}}</span></li>@endif
							@if (isset($content->cat_2_11))<li class="list-group-item">Mercerie / Laine / Tissus habillement<span class="badge">{{$content->cat_2_11}}</span></li>@endif
							@if (isset($content->cat_2_12))<li class="list-group-item">Bijouterie / Horlogerie<span class="badge">{{$content->cat_2_12}}</span></li>@endif
							@if (isset($content->cat_2_13))<li class="list-group-item">Bijouterie fantaisie<span class="badge">{{$content->cat_2_13}}</span></li>@endif
							@if (isset($content->cat_2_14))<li class="list-group-item">Accessoires de mode<span class="badge">{{$content->cat_2_14}}</span></li>@endif
							@if (isset($content->cat_2_15))<li class="list-group-item">Optique / audition<span class="badge">{{$content->cat_2_15}}</span></li>@endif
							@if (isset($content->cat_2_16))<li class="list-group-item">Parfumerie<span class="badge">{{$content->cat_2_16}}</span></li>@endif
							@if (isset($content->cat_2_17))<li class="list-group-item">Produits de beauté spécialisés<span class="badge">{{$content->cat_2_17}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		@if (CommerceHelper::sum_cat('#^cat_3_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Equipement de la maison : {{CommerceHelper::sum_cat('#^cat_3_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_3_1))<li class="list-group-item">Cuisiniste (avec ou sans électroménager)<span class="badge">{{$content->cat_3_1}}</span></li>@endif
							@if (isset($content->cat_3_2))<li class="list-group-item">Électroménager mixte (blanc, noir, gris)<span class="badge">{{$content->cat_3_2}}</span></li>@endif
							@if (isset($content->cat_3_3))<li class="list-group-item">Electroménager spécialisé : TV / Hifi / Vidéo / Ordi<span class="badge">{{$content->cat_3_3}}</span></li>@endif
							@if (isset($content->cat_3_4))<li class="list-group-item">Electroménager mono : mach. à coudre, aspirateur<span class="badge">{{$content->cat_3_4}}</span></li>@endif
							@if (isset($content->cat_3_5))<li class="list-group-item">Vaisselle / Art de la table / Linge de maison<span class="badge">{{$content->cat_3_5}}</span></li>@endif
							@if (isset($content->cat_3_6))<li class="list-group-item">Décoration / Tissus ameublement / Encadrement<span class="badge">{{$content->cat_3_6}}</span></li>@endif
							@if (isset($content->cat_3_7))<li class="list-group-item">Bricolage généraliste / quincaillerie<span class="badge">{{$content->cat_3_7}}</span></li>@endif
							@if (isset($content->cat_3_8))<li class="list-group-item">Bricolage spécialisé : peinture, papier peint / Sol<span class="badge">{{$content->cat_3_8}}</span></li>@endif
							@if (isset($content->cat_3_9))<li class="list-group-item">Mobilier et équipement généraliste<span class="badge">{{$content->cat_3_9}}</span></li>@endif
							@if (isset($content->cat_3_10))<li class="list-group-item">Mobilier spécialisé : luminaires,  literie, salon<span class="badge">{{$content->cat_3_10}}</span></li>@endif
							@if (isset($content->cat_3_11))<li class="list-group-item">Equipement spécialisé: fenêtres / stores / cheminées<span class="badge">{{$content->cat_3_11}}</span></li>@endif
							@if (isset($content->cat_3_12))<li class="list-group-item">Antiquité / Brocante <span class="badge">{{$content->cat_3_12}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		@if (CommerceHelper::sum_cat('#^cat_4_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Culture / Loisirs / Cadeaux : {{CommerceHelper::sum_cat('#^cat_4_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_4_1))<li class="list-group-item">Librairie / BD / Papeterie / loisirs créatifs<span class="badge">{{$content->cat_4_1}}</span></li>@endif
							@if (isset($content->cat_4_2))<li class="list-group-item">Grand magasin à dominante culture et loisirs<span class="badge">{{$content->cat_4_2}}</span></li>@endif
							@if (isset($content->cat_4_3))<li class="list-group-item">Cadeaux / Souvenir<span class="badge">{{$content->cat_4_3}}</span></li>@endif
							@if (isset($content->cat_4_4))<li class="list-group-item">Gadget / Bazar  / Cartes<span class="badge">{{$content->cat_4_4}}</span></li>@endif
							@if (isset($content->cat_4_5))<li class="list-group-item">Presse (avec ou sans librairie)<span class="badge">{{$content->cat_4_5}}</span></li>@endif
							@if (isset($content->cat_4_6))<li class="list-group-item">Tabac (avec ou sans presse)<span class="badge">{{$content->cat_4_6}}</span></li>@endif
							@if (isset($content->cat_4_7))<li class="list-group-item">Cigarette électronique<span class="badge">{{$content->cat_4_7}}</span></li>@endif
							@if (isset($content->cat_4_8))<li class="list-group-item">Fleuriste / Jardinage<span class="badge">{{$content->cat_4_8}}</span></li>@endif
							@if (isset($content->cat_4_9))<li class="list-group-item">Téléphonie<span class="badge">{{$content->cat_4_9}}</span></li>@endif
							@if (isset($content->cat_4_10))<li class="list-group-item">Article de sports (hors vêtement et chaussures)<span class="badge">{{$content->cat_4_10}}</span></li>@endif
							@if (isset($content->cat_4_11))<li class="list-group-item">Jeux / Jouets<span class="badge">{{$content->cat_4_11}}</span></li>@endif
							@if (isset($content->cat_4_12))<li class="list-group-item">Disques, CD, DVD<span class="badge">{{$content->cat_4_12}}</span></li>@endif
							@if (isset($content->cat_4_13))<li class="list-group-item">Instrument de musique<span class="badge">{{$content->cat_4_13}}</span></li>@endif
							@if (isset($content->cat_4_14))<li class="list-group-item">Photographe<span class="badge">{{$content->cat_4_14}}</span></li>@endif
							@if (isset($content->cat_4_15))<li class="list-group-item">Galerie d'art / Beaux arts<span class="badge">{{$content->cat_4_15}}</span></li>@endif
							@if (isset($content->cat_4_16))<li class="list-group-item">Animalerie<span class="badge">{{$content->cat_4_16}}</span></li>@endif
							@if (isset($content->cat_4_17))<li class="list-group-item">Armurerie / Pêche / Chasse<span class="badge">{{$content->cat_4_17}}</span></li>@endif
							@if (isset($content->cat_4_18))<li class="list-group-item">Location vidéo<span class="badge">{{$content->cat_4_18}}</span></li>@endif
							@if (isset($content->cat_4_19))<li class="list-group-item">Articles funéraires<span class="badge">{{$content->cat_4_19}}</span></li>@endif
							@if (isset($content->cat_4_20))<li class="list-group-item">Sex shop<span class="badge">{{$content->cat_4_20}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		@if (CommerceHelper::sum_cat('#^cat_5_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Santé : {{CommerceHelper::sum_cat('#^cat_5_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_5_1))<li class="list-group-item">Pharmacie / Parapharmacie<span class="badge">{{$content->cat_5_1}}</span></li>@endif
							@if (isset($content->cat_5_2))<li class="list-group-item">Laboratoire analyses médicales<span class="badge">{{$content->cat_5_2}}</span></li>@endif
							@if (isset($content->cat_5_3))<li class="list-group-item">Activités médicales (kiné, infirmier,...)<span class="badge">{{$content->cat_5_3}}</span></li>@endif
							@if (isset($content->cat_5_4))<li class="list-group-item">Vétérinaires<span class="badge">{{$content->cat_5_4}}</span></li>@endif
							@if (isset($content->cat_5_5))<li class="list-group-item">Matériel médical<span class="badge">{{$content->cat_5_5}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		@if (CommerceHelper::sum_cat('#^cat_6_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Services commerciaux : {{CommerceHelper::sum_cat('#^cat_6_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_6_1))<li class="list-group-item">Salon de coiffure<span class="badge">{{$content->cat_6_1}}</span></li>@endif
							@if (isset($content->cat_6_2))<li class="list-group-item">Institut de beauté / SPA / massage<span class="badge">{{$content->cat_6_2}}</span></li>@endif
							@if (isset($content->cat_6_3))<li class="list-group-item">Salle de sport<span class="badge">{{$content->cat_6_3}}</span></li>@endif
							@if (isset($content->cat_6_4))<li class="list-group-item">Salon de tatouage / piercing<span class="badge">{{$content->cat_6_4}}</span></li>@endif
							@if (isset($content->cat_6_5))<li class="list-group-item">Laverie / Pressing / Teinturier<span class="badge">{{$content->cat_6_5}}</span></li>@endif
							@if (isset($content->cat_6_6))<li class="list-group-item">Cordonnerie / Clef minute / Gravure<span class="badge">{{$content->cat_6_6}}</span></li>@endif
							@if (isset($content->cat_6_7))<li class="list-group-item">Auto-école<span class="badge">{{$content->cat_6_7}}</span></li>@endif
							@if (isset($content->cat_6_8))<li class="list-group-item">Toiletteur canin<span class="badge">{{$content->cat_6_8}}</span></li>@endif
							@if (isset($content->cat_6_9))<li class="list-group-item">Retouche vêtements<span class="badge">{{$content->cat_6_9}}</span></li>@endif
							@if (isset($content->cat_6_10))<li class="list-group-item">Photocopie / secrétariat / imprimerie<span class="badge">{{$content->cat_6_10}}</span></li>@endif
							@if (isset($content->cat_6_11))<li class="list-group-item">Dépôt vente<span class="badge">{{$content->cat_6_11}}</span></li>@endif
							@if (isset($content->cat_6_12))<li class="list-group-item">Dépannage / maintenance informatique, électricité,…<span class="badge">{{$content->cat_6_12}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		@if (CommerceHelper::sum_cat('#^cat_7_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Services non commerciaux : {{CommerceHelper::sum_cat('#^cat_7_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_7_1))<li class="list-group-item">Banque<span class="badge">{{$content->cat_7_1}}</span></li>@endif
							@if (isset($content->cat_7_2))<li class="list-group-item">Assurance / mutuelle<span class="badge">{{$content->cat_7_2}}</span></li>@endif
							@if (isset($content->cat_7_3))<li class="list-group-item">Courtier / organisme de crédit<span class="badge">{{$content->cat_7_3}}</span></li>@endif
							@if (isset($content->cat_7_4))<li class="list-group-item">Mutuelle<span class="badge">{{$content->cat_7_4}}</span></li>@endif
							@if (isset($content->cat_7_5))<li class="list-group-item">Agence immobilière<span class="badge">{{$content->cat_7_5}}</span></li>@endif
							@if (isset($content->cat_7_6))<li class="list-group-item">Agende de voyage<span class="badge">{{$content->cat_7_6}}</span></li>@endif
							@if (isset($content->cat_7_7))<li class="list-group-item">Agence d'intérim<span class="badge">{{$content->cat_7_7}}</span></li>@endif
							@if (isset($content->cat_7_8))<li class="list-group-item">Location de voitures<span class="badge">{{$content->cat_7_8}}</span></li>@endif
							@if (isset($content->cat_7_9))<li class="list-group-item">Aide à domicile<span class="badge">{{$content->cat_7_9}}</span></li>@endif
							@if (isset($content->cat_7_10))<li class="list-group-item">Bureau de change, achat d'or<span class="badge">{{$content->cat_7_10}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		@if (CommerceHelper::sum_cat('#^cat_8_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Café / Hôtel / Restaurant : {{CommerceHelper::sum_cat('#^cat_8_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_8_1))<li class="list-group-item">Café, salon de thé (avec/sans restauration)<span class="badge">{{$content->cat_8_1}}</span></li>@endif
							@if (isset($content->cat_8_2))<li class="list-group-item">Hôtel (avec/sans restauration)<span class="badge">{{$content->cat_8_2}}</span></li>@endif
							@if (isset($content->cat_8_3))<li class="list-group-item">Bar / Tabac / Jeux<span class="badge">{{$content->cat_8_3}}</span></li>@endif
							@if (isset($content->cat_8_4))<li class="list-group-item">Restaurant traditionnel / Brasserie<span class="badge">{{$content->cat_8_4}}</span></li>@endif
							@if (isset($content->cat_8_5))<li class="list-group-item">Pizzeria, crêperie<span class="badge">{{$content->cat_8_5}}</span></li>@endif
							@if (isset($content->cat_8_6))<li class="list-group-item">Restaurant régional, spécialités étrangères<span class="badge">{{$content->cat_8_6}}</span></li>@endif
							@if (isset($content->cat_8_7))<li class="list-group-item">Glacier, yaourt…<span class="badge">{{$content->cat_8_7}}</span></li>@endif
							@if (isset($content->cat_8_8))<li class="list-group-item">Fast-food / Snack / Kebab<span class="badge">{{$content->cat_8_8}}</span></li>@endif
							@if (isset($content->cat_8_9))<li class="list-group-item">Vente à emporter uniquement<span class="badge">{{$content->cat_8_9}}</span></li>@endif
							@if (isset($content->cat_8_10))<li class="list-group-item">Boite de nuit / Bar de nuit<span class="badge">{{$content->cat_8_10}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		@if (CommerceHelper::sum_cat('#^cat_9_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Automobile / Moto / Cycle : {{CommerceHelper::sum_cat('#^cat_9_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_9_1))<li class="list-group-item">Concessionnaire auto, moto<span class="badge">{{$content->cat_9_1}}</span></li>@endif
							@if (isset($content->cat_9_2))<li class="list-group-item">Garage (avec/sans stat. serv.)<span class="badge">{{$content->cat_9_2}}</span></li>@endif
							@if (isset($content->cat_9_3))<li class="list-group-item">Station services<span class="badge">{{$content->cat_9_3}}</span></li>@endif
							@if (isset($content->cat_9_4))<li class="list-group-item">Lavage voiture<span class="badge">{{$content->cat_9_4}}</span></li>@endif
							@if (isset($content->cat_9_5))<li class="list-group-item">Vente de pièces détachées, casse-auto<span class="badge">{{$content->cat_9_5}}</span></li>@endif
							@if (isset($content->cat_9_6))<li class="list-group-item">Eq de la pers. auto / moto<span class="badge">{{$content->cat_9_6}}</span></li>@endif
							@if (isset($content->cat_9_7))<li class="list-group-item">Cycles - vente et atelier réparation<span class="badge">{{$content->cat_9_7}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		@if (CommerceHelper::sum_cat('#^cat_10_#', (array)$content) > 0)
			<div class="col-md-6 col-xs-12">
				<div class="box box-default ">
					<div class="box-header with-border">
						<h3 class="box-title">Autres activités : {{CommerceHelper::sum_cat('#^cat_10_#', (array)$content)}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" type="button">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<ul class="list-group">
							@if (isset($content->cat_10_1))<li class="list-group-item">Artisan avec magasin<span class="badge">{{$content->cat_10_1}}</span></li>@endif
							@if (isset($content->cat_10_2))<li class="list-group-item">Artisan sans magasin<span class="badge">{{$content->cat_10_2}}</span></li>@endif
							@if (isset($content->cat_10_3))<li class="list-group-item">Bureau d'étude / Architecte / Local politique<span class="badge">{{$content->cat_10_3}}</span></li>@endif
							@if (isset($content->cat_10_4))<li class="list-group-item">Taxi / Ambulance<span class="badge">{{$content->cat_10_4}}</span></li>@endif
							@if (isset($content->cat_10_5))<li class="list-group-item">Administration, service public<span class="badge">{{$content->cat_10_5}}</span></li>@endif
							@if (isset($content->cat_10_6))<li class="list-group-item">La Poste<span class="badge">{{$content->cat_10_6}}</span></li>@endif
							@if (isset($content->cat_10_7))<li class="list-group-item">Association<span class="badge">{{$content->cat_10_7}}</span></li>@endif
							@if (isset($content->cat_10_8))<li class="list-group-item">Organisme de formation, soutien scolaire, cours<span class="badge">{{$content->cat_10_8}}</span></li>@endif
							@if (isset($content->cat_10_9))<li class="list-group-item">Cinéma / Culture/ loisirs (bowling, laser game,…)<span class="badge">{{$content->cat_10_9}}</span></li>@endif
							@if (isset($content->cat_10_10))<li class="list-group-item">Logement<span class="badge">{{$content->cat_10_10}}</span></li>@endif
							@if (isset($content->cat_10_11))<li class="list-group-item">Grossiste<span class="badge">{{$content->cat_10_11}}</span></li>@endif
							@if (isset($content->cat_10_12))<li class="list-group-item">Location de salle de mariage,salle des fêtes<span class="badge">{{$content->cat_10_12}}</span></li>@endif
							@if (isset($content->cat_10_13))<li class="list-group-item">Location de matériel spécialisé et garde-meuble<span class="badge">{{$content->cat_10_13}}</span></li>@endif
							@if (isset($content->cat_10_14))<li class="list-group-item">Transporteur<span class="badge">{{$content->cat_10_14}}</span></li>@endif
							@if (isset($content->cat_10_15))<li class="list-group-item">Construction,entretien maison, BTP<span class="badge">{{$content->cat_10_15}}</span></li>@endif
							@if (isset($content->cat_10_16))<li class="list-group-item">Production et conception de l'industrie<span class="badge">{{$content->cat_10_16}}</span></li>@endif
							@if (isset($content->cat_10_99))<li class="list-group-item">Autres<span class="badge">{{$content->cat_10_99}}</span></li>@endif
						</ul>
					</div>
				</div>
			</div>
		@endif
		</div>
		@if (CommerceHelper::sum_cat('#^vente_#', (array)$content) > 0)
		<div class="row">
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Formes de ventes</h3>
					</div>
					<div class="box-body">
						<table class="table table-bordered table-striped table-hover" style="height:330px;">
							<thead>
								<tr>
									<th>Type</th>
									<th>Nombre</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Vacants</td>
									<td>@if(!empty($content->vente_0))<span class="badge" style="background-color:#000;"> {{$content->vente_0}} </span> @else <span class="badge" style="background-color:#000;"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Surface de + de 1000m²</td>
									<td>@if(!empty($content->vente_1))<span class="badge bg-teal"> {{$content->vente_1}} </span> @else <span class="badge bg-teal"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Surface entre 300 et 999m²</td>
									<td>@if(!empty($content->vente_2))<span class="badge bg-teal"> {{$content->vente_2}} </span> @else <span class="badge bg-teal"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Commerce traditionnel</td>
									<td>@if(!empty($content->vente_3))<span class="badge bg-teal"> {{$content->vente_3}} </span> @else <span class="badge bg-teal"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Commerce trad. en galerie marchande</td>
									<td>@if(!empty($content->vente_4))<span class="badge bg-teal"> {{$content->vente_4}} </span> @else <span class="badge bg-teal"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Drive</td>
									<td>@if(!empty($content->vente_5))<span class="badge" style="background-color:#c01717;"> {{$content->vente_5}} </span> @else <span class="badge" style="background-color:#c01717;"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Commerce en kiosque</td>
									<td>@if(!empty($content->vente_6))<span class="badge" style="background-color:#e26b0a;"> {{$content->vente_6}} </span> @else <span class="badge" style="background-color:#e26b0a;"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Food truck</td>
									<td>@if(!empty($content->vente_7))<span class="badge" style="background-color:#e52175;"> {{$content->vente_7}} </span> @else <span class="badge" style="background-color:#e52175;"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Guichet automatique</td>
									<td>@if(!empty($content->vente_8))<span class="badge" style="background-color:#212c56;"> {{$content->vente_8}} </span> @else <span class="badge" style="background-color:#212c56;"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Concessionnaire et garage</td>
									<td>@if(!empty($content->vente_10))<span class="badge" style="background-color:#974706;"> {{$content->vente_10}} </span> @else <span class="badge" style="background-color:#974706;"> 0 </span> @endif</td>
								</tr>
								<tr>
									<td>Autres</td>
									<td>@if(!empty($content->vente_9))<span class="badge" style="background-color:#a5a5a5;"> {{$content->vente_9}} </span> @else <span class="badge" style="background-color:#a5a5a5;"> 0 </span> @endif</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>	
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-orange">
						<i class="fa  fa-object-ungroup"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Surface totale</span>
						<span class="info-box-number">{{$other['post']['sftotal']}} m²</span>								
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Surfaces par catégories</h3>
					</div>
					<div class="box-body">
						<div id="typo_surface" class="chart" style="width: 400px; height: 300px;"></div>
					</div>
				</div>
			</div>
		</div>
		@endif
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Appréciation</h3>
					</div>
					<div class="box-body">
						<ul class="list-group">
							<li class="list-group-item"><b>Densité de l'offre</b>{{CommerceHelper::appreciation($content->appreciation_densite)}}</li>
							<li class="list-group-item"><b>Diversité de l'offre</b>{{CommerceHelper::appreciation($content->appreciation_diversite)}}</li>
							<li class="list-group-item"><b>Dynamique commerciale</b>{{CommerceHelper::appreciation($content->appreciation_dynamique)}}@if (isset($content->appreciation_dyn_com))<p>{{$content->appreciation_dyn_com}}</p>@endif</li>
							<li class="list-group-item"><b>Organisation urbaine</b>{{CommerceHelper::appreciation($content->appreciation_urbaine)}}@if (isset($content->orga_urbaine))<p>{{$content->orga_urbaine}}</p>@endif</li>
							<li class="list-group-item"><b>Qualité des linéaires / façades</b>{{CommerceHelper::appreciation($content->appreciation_lineaire)}}@if (isset($content->qualite_lineaire))<p>{{$content->qualite_lineaire}}</p>@endif</li>
							<li class="list-group-item"><b>Qualité des espaces publics</b>{{CommerceHelper::appreciation($content->appreciation_espace_public)}}@if (isset($content->qualite_espace_public))<p>{{$content->qualite_espace_public}}</p>@endif</li>
							<li class="list-group-item"><b>Accessibilité routière / Stationnement</b>{{CommerceHelper::appreciation($content->appreciation_acces_routier)}}@if (isset($content->acces_routier))<p>{{$content->acces_routier}}</p>@endif</li>
							<li class="list-group-item"><b>Desserte TC / modes actifs</b>{{CommerceHelper::appreciation($content->appreciation_desserte_tc)}}@if (isset($content->desserte_tc))<p>{{$content->desserte_tc}}</p>@endif</li>
							@if (isset($content->autre_appreciation))<li class="list-group-item"><b>Autres appréciations</b><p>{{$content->autre_appreciation}}</p></li>@endif
						</ul>
					</div>
				</div>
			</div>
			@if (isset($content->nom_union_commerciale) || isset($content->projet_commerciaux))
			<div class="col-md-6 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Dynamique</h3>
					</div>
					<div class="box-body">
						<ul class="list-group">						
							@if (isset($content->nom_union_commerciale))<li class="list-group-item"><b>Union commerciale :</b><span class="label label-info">{{$content->nom_union_commerciale}} </span></li>@endif
							@if (isset($content->nb_adherent_union))<li class="list-group-item"><b>Nombre d'adhérents à l'union commerciale :</b><span class="label label-info">{{$content->nb_adherent_union}} </span></li>@endif
							@if (isset($content->projet_commerciaux))<li class="list-group-item"><b>Projets commerciaux connus à court, moyen terme</b><p>{{$content->projet_commerciaux}}</p></li>@endif
						</ul>
					</div>
				</div>
			</div>
			@endif
			@if (isset($content->enjeux))
			<div class="col-md-6 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Enjeux</h3>
					</div>
					<div class="box-body">
						<p>{{$content->enjeux}}</p>
					</div>
				</div>
			</div>
			@endif
		</div>
	</section>
</div>
@stop
@section('footer')
        {!! HTML::script('https://api.mapbox.com/mapbox.js/v3.0.1/mapbox.js') !!}
        {!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/leaflet.markercluster.js') !!}
        {!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js')!!}
        {!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js')!!} 
        <script type="text/javascript">
        	//map
        	L.mapbox.accessToken = 'pk.eyJ1IjoibHVkby1hdXJnIiwiYSI6IjE0QzlVekkifQ.FK86sgWfTNbDC-Z-O-hTww';
			var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
			    {
			        "subdomains": 'abc',
			        "attribution": " &copy; OpenStreetMap"
			    }
			);
			
			
			var json = <?php echo $geojson; ?>;
			var datamarche = <?php echo file_get_contents('http://192.168.0.136/modules/commercemetro/geojson/commerce.geojson'); ?>;
			var featureLayer = L.mapbox.featureLayer(json);
  			var map = L.mapbox.map('singlemap').fitBounds(featureLayer.getBounds());
  			featureLayer.addTo(map);
  			osm.addTo(map);

  			//Desactiver les cluster
/*
  			//Cluster des commerces
var markerscom = new L.MarkerClusterGroup({
    animateAddingMarkers:true,
    disableClusteringAtZoom:18,
    iconCreateFunction: function(cluster) {
        return new L.DivIcon({           
            html: '<h2><span class="label bg-navy">' + cluster.getChildCount() + '</span></h2>'
        });
    }
});

*/ 

  			var marche = L.mapbox.featureLayer(datamarche);
  			marche.on('ready', function() {
	            marche.eachLayer(function(layer) {
	                layer.setIcon(L.mapbox.marker.icon({
	                    'marker-color': '#00c64f',
	                    'marker-symbol': 'farm'  
	                }));
	            });
	    	});
	    	marche.addTo(map);


  			//graph
		  	var typo_commerce = [{'label':'Vacants','value':{{CommerceHelper::sum_cat('#^cat_0_#', (array)$content)}}},{'label':'Alimentaire','value':{{CommerceHelper::sum_cat('#^cat_1_#', (array)$content)}}},{'label':'Equipement de la personne','value':{{CommerceHelper::sum_cat('#^cat_2_#', (array)$content)}}},{'label':'Equipement de la maison','value':{{CommerceHelper::sum_cat('#^cat_3_#', (array)$content)}}},{'label':'Culture / Loisirs','value':{{CommerceHelper::sum_cat('#^cat_4_#', (array)$content)}}},{'label':'Santé','value':{{CommerceHelper::sum_cat('#^cat_5_#', (array)$content)}}},{'label':'Services commerciaux','value':{{CommerceHelper::sum_cat('#^cat_6_#', (array)$content)}}},{'label':'Services non commerciaux','value':{{CommerceHelper::sum_cat('#^cat_7_#', (array)$content)}}},{'label':'Restauration','value':{{CommerceHelper::sum_cat('#^cat_8_#', (array)$content)}}},{'label':'Automobile','value':{{CommerceHelper::sum_cat('#^cat_9_#', (array)$content)}}},{'label':'Autres','value':{{CommerceHelper::sum_cat('#^cat_10_#', (array)$content)}}}];
		    var typo_surface = [{'label':'Alimentaire','value':@if(!empty($content->sf_1)){{$content->sf_1}}@else 0 @endif},{'label':'Equipement de la personne','value':@if(!empty($content->sf_2)){{$content->sf_2}}@else 0 @endif},{'label':'Equipement de la maison','value':@if(!empty($content->sf_3)){{$content->sf_3}}@else 0 @endif},{'label':'Culture / Loisirs','value':@if(!empty($content->sf_4)){{$content->sf_4}}@else 0 @endif},{'label':'Services commerciaux','value':@if(!empty($content->sf_6)){{$content->sf_6}}@else 0 @endif},{'label':'Hôtellerie / Restauration','value':@if(!empty($content->sf_8)){{$content->sf_8}}@else 0 @endif},{'label':'Cycle','value':@if(!empty($content->sf_9)){{$content->sf_9}}@else 0 @endif}];
			Morris.Donut({
				  element: 'typo_commerce',
				  data: typo_commerce,
				  colors:['#000000','#c01717', '#f2e500', '#28a951', '#e26b0a', '#d89593', '#27ace5', '#212c56', '#e52175', '#974706', '#a5a5a5'],
				  hideHover: 'auto',
			      resize: true,
			      formatter: function (value, data) { return value + ' (' +(value/<?php echo $other['post']['total'];?> *100).toFixed(1) + '%)'; }
			});
			Morris.Donut({
				  element: 'typo_surface',
				  data: typo_surface,
				  colors:['#c01717', '#f2e500', '#28a951', '#e26b0a', '#27ace5', '#e52175', '#974706'],
				  hideHover: 'auto',
			      resize: true,
			      formatter: function (value, data) { return value + ' m² (' +(value/<?php echo $other['post']['sftotal'];?> *100).toFixed(1) + '%)'; }
			});
		</script>     
@stop