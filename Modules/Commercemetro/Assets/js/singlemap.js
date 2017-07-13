L.mapbox.accessToken = 'pk.eyJ1IjoibHVkby1hdXJnIiwiYSI6IjE0QzlVekkifQ.FK86sgWfTNbDC-Z-O-hTww';
var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        "subdomains": 'abc',
        "attribution": " &copy; OpenStreetMap"
    }
);
var ggl = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});
var url = location.href;


//couche Grandes surfaces
var gss = L.mapbox.featureLayer().loadURL('/modules/commercemetro/geojson/gsa-gss.geojson')
            .on('ready', function() {
                gss.eachLayer(function(layer) {
                var content = '<h2>Grande surface<\/h2>' +
                    '<p> Enseigne: ' + layer.feature.properties.enseigne + '<br \/>  \
                    Secteur d\'activité : '+ layer.feature.properties.activite + '<br \/>  \
                    Catégorie d\'activité : '+ layer.feature.properties.categorie + '<br \/>  \
                    Surface de vente : '+ layer.feature.properties.cat_sfvent + '<\/p>';
                layer.bindPopup(content);
                if (layer.feature.properties.codeact === 0) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#000',
                        'marker-symbol': 'commercial'  
                    }));
                }
                else if (layer.feature.properties.codeact === 1) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#C01717',
                        'marker-symbol': 'grocery'  
                    }));
                }
                else if (layer.feature.properties.codeact === 2) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#F2E500',
                        'marker-symbol': 'clothing-store'  
                    }));
                }
                else if (layer.feature.properties.codeact === 3) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#28A951',
                        'marker-symbol': 'village'
                    }));
                }
                else if (layer.feature.properties.codeact === 4) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#E26B0A',
                        'marker-symbol': 'art-gallery'  
                    }));
                }
                else if (layer.feature.properties.codeact === 5) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#D89593',
                        'marker-symbol': 'hospital'
                    }));
                }
                else if (layer.feature.properties.codeact === 6) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#27ACE5',
                        'marker-symbol': 'hairdresser'  
                    }));
                }
                else if (layer.feature.properties.codeact === 7) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#212C56',
                        'marker-symbol': 'place-of-worship'  
                    }));
                }
                else if (layer.feature.properties.codeact === 8) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#E52175',
                        'marker-symbol': 'restaurant'  
                    }));
                }
                else if (layer.feature.properties.codeact === 9) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#974706',
                        'marker-symbol': 'car'
                    }));
                }
                else if (layer.feature.properties.codeact === 10) {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#A5A5A5',
                        'marker-symbol': 'land-use'  
                    }));
                }
                else{
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#ffffff'  
                    }));
                }
            });
    });

//couche marchés
var marche = L.mapbox.featureLayer().loadURL('/modules/commercemetro/geojson/marche.geojson')
            .on('ready', function() {
                marche.eachLayer(function(layer) {
                var content = '<h2>Marché<\/h2>' +
                    '<p> Nom : ' + layer.feature.properties.Nom + '<br \/>  \
                    Type : '+ layer.feature.properties.Type_marché + '<br \/>  \
                    Horaire : '+ layer.feature.properties.Horaires + '<br \/>  \
                    Nb de points de vente : '+ layer.feature.properties.Nb_point_vente + '<\/p>';
                layer.bindPopup(content);
                layer.setIcon(L.mapbox.marker.icon({
                    'marker-color': '#00c64f',
                    'marker-symbol': 'farm'  
                }));
            });
    });




//Cluster des commerces
var markerscom = new L.MarkerClusterGroup({
    animateAddingMarkers:true,
    disableClusteringAtZoom:17,
    iconCreateFunction: function(cluster) {
        return new L.DivIcon({           
            html: '<h2><span class="label bg-navy">' + cluster.getChildCount() + '</span></h2>'
        });
    }
});


var haveMarkers = {};

//couche commerce
var commerce = L.mapbox.featureLayer().loadURL('/modules/commercemetro/geojson/commerce.geojson')
            .on('ready', function() {
                commerce.eachLayer(function(layer) {
                    markerscom.addLayer(layer);
                var content = '<p> Enseigne: ' + layer.feature.properties.enseigne_ou_derniere_enseigne + '<br \/>  \
                    Adresse : '+ layer.feature.properties.adresse + '<br \/>  \
                    Secteur d\'activité : '+ layer.feature.properties.commentaires_activite + '<br \/>  \
                    Catégorie d\'activité : '+ layer.feature.properties.status + '<br \/>  \
                    Surface de vente couverte : '+ layer.feature.properties.surface_de_vente_couverte + '<br \/>  \
                    Surface de vente extérieure : '+ layer.feature.properties.surface_de_vente_exterieure + '<\/p>';
                layer.bindPopup(content);
                if (layer.feature.properties.status === 'LOCAL VACANT') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#000',
                        'marker-symbol': 'commercial'  
                    }));
                }
                else if (layer.feature.properties.status === 'ALIMENTAIRE') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#C01717',
                        'marker-symbol': 'grocery'  
                    }));
                }
                else if (layer.feature.properties.status === 'EQ PERSONNE') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#F2E500',
                        'marker-symbol': 'clothing-store'  
                    }));
                }
                else if (layer.feature.properties.status === 'SOLDERIE/BAZAR') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#f49542',
                        'marker-symbol': 'shop'  
                    }));
                }
                else if (layer.feature.properties.status === 'EQ MAISON') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#28A951',
                        'marker-symbol': 'village'
                    }));
                }
                else if (layer.feature.properties.status === 'CULTURE LOISIRS') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#E26B0A',
                        'marker-symbol': 'art-gallery'  
                    }));
                }
                else if (layer.feature.properties.status === 'SERVICES A LA PERSONNE') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#D89593',
                        'marker-symbol': 'hospital'
                    }));
                }
                else if (layer.feature.properties.status === 'BEAUTE SANTE') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#27ACE5',
                        'marker-symbol': 'hairdresser'  
                    }));
                }
                else if (layer.feature.properties.status === 'SERVICES IMMATERIELS') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#212C56',
                        'marker-symbol': 'place-of-worship'  
                    }));
                }
                else if (layer.feature.properties.status === 'RESTAURATION') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#E52175',
                        'marker-symbol': 'restaurant'  
                    }));
                }
                else if (layer.feature.properties.status === 'AUTO') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#974706',
                        'marker-symbol': 'car'
                    }));
                }
                else if (layer.feature.properties.status === 'AUTRES LC') {
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#A5A5A5',
                        'marker-symbol': 'land-use'  
                    }));
                }
                else{
                    layer.setIcon(L.mapbox.marker.icon({
                        'marker-color': '#ffffff'  
                    }));
                }
            });
    });
 

$.post( url, function( data ) {
	var featureLayer = L.mapbox.featureLayer(data);
	var map = L.mapbox.map('singlemap').fitBounds(featureLayer.getBounds());
	var coords = featureLayer.getBounds().getCenter();
    var position = new google.maps.LatLng(coords.lat,coords.lng);
	var panoramaOptions = {
	    position: position,
	    pov: {
	      heading: 34,
	      pitch: 10
	    }
	  };
 	var panorama = new  google.maps.StreetViewPanorama(document.getElementById('pano'),panoramaOptions);
	featureLayer.addTo(map);
	osm.addTo(map);
	//gss.addTo(map);
	//marche.addTo(map);
    markerscom.addTo(map); 
    
	map.addControl(new L.Control.Layers( {'OSM':osm, 'Google':ggl}, {}));
},'json');
