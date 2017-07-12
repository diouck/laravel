L.mapbox.accessToken = 'pk.eyJ1IjoibHVkby1hdXJnIiwiYSI6IjE0QzlVekkifQ.FK86sgWfTNbDC-Z-O-hTww';
var map = L.mapbox.map('editmap');


function custom_layer(link) {
    var temp = null;
    $.ajax({
      type: "POST",
      url: link,
      dataType: 'json',
      success: function (data) {
        temp = data;
      }, 
      async: false // <- this turns it into synchronous
    })
    return temp;
};

var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
var ggl = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

var currenturl = location.href;
var url = currenturl.replace('/edit','');


var edit = custom_layer(url+'/editgeom');
var featureLayer = L.mapbox.featureLayer(edit);
map.fitBounds(featureLayer.getBounds());
featureLayer.addTo(map);
osm.addTo(map);
var shape = JSON.stringify(featureLayer.toGeoJSON());
var ajax = $.ajax({
             type: "POST",
             url: url+'/updategeom', 
             data: 'shape='+shape,
             dataType: "json", 
             encode: true 
        });
ajax.done(function(data) {
  var typegeoms = ["Point","Polygon","LineString"];
  $("#geom").empty();  
  $.each(typegeoms, function(key, val) {
    if (typeof data[val] !== 'undefined') {
      $("#geom").append('<input type="hidden" name="'+val.toLowerCase()+'" value="'+data[val].geom+'" />');
    }
  });
});

var drawControl = new L.Control.Draw({
  draw: {
    rectangle: false,
    circle: false,
    marker: true
  },
  edit: {
    featureGroup: featureLayer
  }
}).addTo(map);

map.on('draw:created', function(e) {
    var layer = e.layer;
    featureLayer.addLayer(layer);
    var shape = JSON.stringify(featureLayer.toGeoJSON());
    var ajax = $.ajax({
                 type: "POST",
                 url: url+'/updategeom', 
                 data: 'shape='+shape,
                 dataType: "json", 
                 encode: true
            })
    ajax.done(function(data) {
      var typegeoms = ["Point","Polygon","LineString"];
      $("#geom").empty();  
      $.each(typegeoms, function(key, val) {
        if (typeof data[val] !== 'undefined') {
          $("#geom").append('<input type="hidden" name="'+val.toLowerCase()+'" value="'+data[val].geom+'" />');
        }
      });
    });
});

map.on('draw:edited', function(e) {
  var layers = e.layers;
  layers.eachLayer(function (layer) {
    var shape = JSON.stringify(layers.toGeoJSON());
    var ajax = $.ajax({
                 type: "POST",
                 url: url+'/updategeom', 
                 data: 'shape='+shape,
                 dataType: "json", 
                 encode: true
            })
    ajax.done(function(data) {
      var typegeoms = ["Point","Polygon","LineString"];
      $("#geom").empty();  
      $.each(typegeoms, function(key, val) {
        if (typeof data[val] !== 'undefined') {
          $("#geom").append('<input type="hidden" name="'+val.toLowerCase()+'" value="'+data[val].geom+'" />');
        }
      });
    });
  });
});

map.on('draw:deleted', function(e) {
  var layer = e.layer;
  featureLayer.removeLayer(layer);
  var shape = JSON.stringify(featureLayer.toGeoJSON());
  var ajax = $.ajax({
               type: "POST",
               url: url+'/updategeom', 
               data: 'shape='+shape,
               dataType: "json", 
               encode: true
          })
  ajax.done(function(data) {
    var typegeoms = ["Point","Polygon","LineString"];
    $("#geom").empty();  
    $.each(typegeoms, function(key, val) {
      if (typeof data[val] !== 'undefined') {
        $("#geom").append('<input type="hidden" name="'+val.toLowerCase()+'" value="'+data[val].geom+'" />');
      }else{
        $("#geom").append('<input type="hidden" name="'+val.toLowerCase()+'" value="empty" />');
      }
    });
  });
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
var commerce = L.mapbox.featureLayer().loadURL('/modules/webmap/geojson/commerce.geojson')
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
markerscom.addTo(map);

map.addControl(new L.Control.Layers( {'OSM':osm, 'Google':ggl}, {}));
