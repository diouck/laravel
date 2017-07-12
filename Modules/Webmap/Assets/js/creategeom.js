L.mapbox.accessToken = 'pk.eyJ1IjoibHVkby1hdXJnIiwiYSI6IjE0QzlVekkifQ.FK86sgWfTNbDC-Z-O-hTww';

var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
var ggl = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

var currenturl = location.href;
var url = currenturl.replace('/create','');


  var featureLayer = L.mapbox.featureLayer();
  var map = L.mapbox.map('editmap').setView([45.2, 5.7], 16);
  featureLayer.addTo(map);
  osm.addTo(map);

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
                   url: url+'/creategeom', 
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
                   url: url+'/creategeom', 
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
                 url: url+'/creategeom', 
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

  map.addControl(new L.Control.Layers( {'OSM':osm, 'Google':ggl}, {}));