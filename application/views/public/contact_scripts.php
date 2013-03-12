<script type="text/javascript" src="../assets/lib/openlayers/2.12/OpenLayers.js"></script>
<script type="text/javascript">
    var map, layer;
    function init(){
        map = new OpenLayers.Map( 'map');
        layer = new OpenLayers.Layer.OSM( "Simple OSM Map");
        map.addLayer(layer);
        map.setCenter(
            new OpenLayers.LonLat(-3.65056682912, 40.5295153215).transform(
                new OpenLayers.Projection("EPSG:4326"),
                map.getProjectionObject()
            ), 12
        );    
    }
    window.onload  = init;
</script>