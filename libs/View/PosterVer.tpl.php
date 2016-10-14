<?php
$this->assign('title','FIND MY PET | Publicacion');
$this->assign('nav','Publicacion');
$this->display('_Header.tpl.php');
?>
<style>
    #googleMap{
        height: 300px;
        overflow: hidden;
        position: relative;
    }
</style>

<div class="row">
    <div class="col-xs-4">
        <h1>
            <?php echo $this->poster->Mascota_nombre ?>
            <span class=
                  <?php if (!$this->poster->Mascota_estado) { ?>
                  "badge bg-danger">Perdido
                <?php }else{ ?>
                    "badge bg-success">Encontrado
                <?php } ?>
            </span>
        </h1>
    </div>
</div>

<div class="row row-sm">
    <div class="col-sm-4">
        <div class="panel panel-card">
            <a href="<?php echo $this->poster->Imagen ?>" target="_blank">
                <div class="r-t pos-rlt waves-effect" md-ink-ripple="" style="background:url(<?php echo $this->poster->Imagen ?>) center center; background-size:cover; display: block">
                    <div class="bg-white-overlay text-center r-t">
                        <img src="<?php echo $this->poster->Imagen ?>" style="width: 70%;">
                    </div>
                </div>
            </a>
            <div class="list-group no-radius no-border">
                <a class="list-group-item">
                    <span class="pull-right badge"><?php echo $this->poster->Usuario_nombre ?></span>Dueño
                </a>
                <a class="list-group-item">
                    <span class="pull-right badge"><?php echo $this->poster->TipoMascota_nombre ?></span>Tipo de mascota
                </a>
                <a class="list-group-item">
                    <span class="pull-right badge"><?php echo $this->poster->Raza_nombre ?></span>Raza
                </a>
                <a class="list-group-item">
                    <span class="pull-right badge"><?php echo $this->poster->Mascota_tamano ?></span>Tamaño
                </a>
            </div>
            <div class="p">
                <p>Descripcion</p>
                <p><?php echo $this->poster->Descripcion ?></p>
                <div class="m-v">
                    <a href="https://www.facebook.com/<?php echo $this->poster->Usuario_id_facebook ?>" target="_blank" class="btn waves-effect indigo-800"><i class="fa fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="panel panel-card">
            <textarea class="form-control no-border" rows="3" placeholder="Comunícate con su dueño!..." style="resize: vertical; max-height: 200px"></textarea>
            <div class="lt p">
                <button class="btn btn-info pull-right btn-sm p-h font-bold waves-effect">Enviar</button>
                <ul class="nav nav-pills nav-sm">

                </ul>
            </div>
        </div>
        <div class="panel panel-card clearfix" >
            <ul class="nav nav-md nav-tabs nav-lines b-info">
                <li class="active">
                    <a href="" data-toggle="tab" data-target="#tab_1" aria-expanded="true">Mapa</a>
                </li>
                <li class="">
                    <a href="" data-toggle="tab" data-target="#tab_2" aria-expanded="false">Imagenes</a>
                </li>
            </ul>
            <div class="tab-content p m-b-md b-t b-t-2x">
                <div role="tabpanel" class="tab-pane animated fadeIn active" id="tab_1">
                    <div id='googleMap'></div>
                </div>
                <div role="tabpanel" class="tab-pane animated fadeIn" id="tab_2">
                    En construccion
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgSePuD5fwaC1pDJlv3MkmdC9SHTMmkCA"></script>
<script>
    $(document).ready(function() {
        InicializarMapa(<?php echo $this->poster->Latitud ?>, <?php echo $this->poster->Longitud ?>);//Inicializar mapa con la ciudad de La Paz por defecto
    });

    function InicializarMapa(latitud,longitud){
        var infowindow = new google.maps.InfoWindow();

        var mapProp = {
            center:new google.maps.LatLng(latitud,longitud),
            zoom:15,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

        var marker = new google.maps.Marker({
            position:{lat: latitud, lng: longitud},
            map:map,
            draggable:false
        });

        // Add circle overlay and bind to marker
        var circle = new google.maps.Circle({
            map: map,
            radius: 200,    // distancia en metros
            fillColor: '#AA0000'
        });
        circle.bindTo('center', marker, 'position');

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });

        google.maps.event.addListener(marker,'dragend',function(){
            setLatLong(infowindow,map,marker,marker.getPosition().lat(), marker.getPosition().lng());
        });

        google.maps.event.addListener(map, 'click', function(event) {
            //marker.setPosition(event.latLng);
            //setLatLong(infowindow,map,marker,event.latLng.lat(),event.latLng.lng());
        });

        //Resize Function
        google.maps.event.addDomListener(window, "resize", function() {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        });

        setLatLong(infowindow,map,marker,marker.getPosition().lat(), marker.getPosition().lng());
    }

    function setLatLong(infowindow, map, marker, latitud, longitud){
        infowindow.setContent('Latitud: ' + latitud + '<br>Longitud: ' + longitud);
        infowindow.open(map,marker);
        $("#latitud").attr("value", latitud);
        $("#longitud").attr("value", longitud);
    }
</script>

<?php
$this->display('_Footer.tpl.php');
?>