L.mapbox.accessToken = 'pk.eyJ1IjoibHVkby1hdXJnIiwiYSI6IjE0QzlVekkifQ.FK86sgWfTNbDC-Z-O-hTww';

//url
var url = location.href;
var tinyurl = location.protocol + '//' + location.hostname + location.pathname;
var searchurl = tinyurl.replace('/search','');



//Couches rasters
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
//Cluster des poles
var markers = new L.MarkerClusterGroup({
    animateAddingMarkers:true,
    disableClusteringAtZoom:18

});
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
 

$.post(url, function(data) {
    var geojson = L.geoJson(data, {
        onEachFeature: function (feature, layer) {
            markers.addLayer(layer);
            haveMarkers[L.Util.stamp(layer)] = true;
            layer.on('click', function (e) {
                $.post(tinyurl+'/popup/'+feature.properties.id, function(data) {
                    
                    
                    var link = searchurl + '/' + feature.properties.id;

                    var commun =  '     <div class="row text-center">\
                                            <h3>' + data.post.title + '</h3>\
                                            <div class="col-xs-6">\
                                                <div><i class="fa fa-institution fa-2x"></i></div>' + data.terms.commune + '\
                                            </div>\
                                            <div class="col-xs-6">\
                                                <div><i class="fa fa-cube fa-2x"></i></div>' + data.post.total + ' cellules commerciales\
                                            </div>\
                                            <div class="col-xs-6">\
                                                <div><i class="fa fa-suitcase fa-2x"></i></div>' + ((parseInt(data.post.content.cat_0_1)+parseInt(data.post.content.cat_0_2))/data.post.total*100).toFixed(1) + '% de locaux vacants\
                                            </div>';
                    if(data.post.sftotal === 0){
                        var specifique = '  <div class="col-xs-6">\
                                                <div><i class="fa fa-hand-paper-o fa-2x fa-rotate-90"></i></div>' + (data.post.secteur/data.post.total*100).toFixed(1) + ' % de services\
                                            </div>\
                                            <div class="text-right"><a href="'+ link +'"target="_blank">En savoir plus...</a></div>\
                                        </div>';
                    } else{
                        var specifique = '  <div class="col-xs-6">\
                                                <div><i class="fa fa-shopping-cart fa-2x"></i></div>' + data.post.sftotal + ' m² de grandes surfaces\
                                            </div>\
                                            <div class="col-xs-6">\
                                                <div><i class="fa fa-credit-card fa-2x"></i></div>' + (data.post.content.vente_3+data.post.content.vente_4) + ' Commerces traditionnels\
                                            </div>\
                                            <div class="col-xs-6">\
                                                <div><i class="fa fa-coffee fa-2x"></i></div>' + (data.post.restau) + ' Cafés / restaurants\
                                            </div>\
                                            <div class="text-right"><a href="'+ link +'"target="_blank">En savoir plus...</a></div>\
                                        </div>';
                    }
                    layer.bindPopup(commun+specifique).openPopup();
                },'json');
            });
        },
        style: function (feature) {
            return {weight: 3,
                opacity: 1,
                color: '#007798',
                dashArray: '4',
                fillOpacity: 0.3,
                fillColor: '#666'};
        }
    });
    
    // CONSTRUCT THE MAP
    function menu(layer, name, zIndex) {
        layer.setZIndex(zIndex).addTo(map);
        // Create a simple layer switcher that toggles layers on
        // and off.
        var ui = document.getElementById('map-ui');
        var item = document.createElement('li');
        var link = document.createElement('a');
        var check = document.createElement('i');
        var text = document.createElement('span');
        link.href = '#';
        check.className = 'fa fa-check-circle-o';
        text.innerHTML = name;

        link.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (map.hasLayer(layer)) {
                map.removeLayer(layer);
                check.className = 'fa fa-circle-o';
            } else {
                map.addLayer(layer);
                check.className = 'fa fa-check-circle-o';
            }
        };
        link.appendChild(check);
        link.appendChild(text);
        item.appendChild(link);
        ui.appendChild(item);
    };

    $('.container-full .alert').show();
    $('.results').html($.map(haveMarkers, function(n, i) { return i; }).length + ' résultat(s) pour cette recherche');
    $('#loading').hide();
    var map = L.mapbox.map('map').fitBounds(markers.getBounds());
    var output = document.getElementById('output');
    markers.addTo(map);
    menu(markers, 'Pôles commerciaux', 1);
    menu(markerscom, 'Commerces', 2);
     
    
    // Initialize the geocoder control and add it to the map.
    var geocoderControl = L.mapbox.geocoderControl('mapbox.places');
    geocoderControl.addTo(map);

    // Listen for the `found` result and display the first result
    // in the output container. For all available events, see
    // https://www.mapbox.com/mapbox.js/api/v2.1.8/l-mapbox-geocodercontrol/#section-geocodercontrol-on
    geocoderControl.on('found', function(res) {
        output.innerHTML = JSON.stringify(res.results.features[0]);
    });
    osm.addTo(map);
    map.addControl(new L.Control.Layers( {'OSM':osm, 'Google':ggl}, {}));
   
},'json');





















