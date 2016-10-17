<?php
$this->assign('title','FIND MY PET | Afiliados');
$this->assign('nav','afiliados');
$this->display('_Header.tpl.php');
?>
<style>
    #googleMap{
        height: 300px;
        overflow: hidden;
        position: relative;
    }
</style>

<script type="text/javascript">
    $LAB.script("libs/View/scripts/afiliados.js").wait(function(){
        $(document).ready(function(){
            page.init();
        });

        // hack for IE9 which may respond inconsistently with document.ready
        setTimeout(function(){
            if (!page.isInitialized) page.init();
        },1000);
    });
</script>

<button id="newAfiliadoButton" class="md-btn md-fab md-fab-bottom-right pos-fix blue waves-effect"><i class="mdi-content-add i-24"></i></button>
<div class="row">
    <div class="col-xs-4">
        <h3><?php echo strtoupper($this->nav) ?></h3>
    </div>
    <div class="col-xs-4 col-xs-offset-4">
        <div class="input-group">
            <div class="md-form-group float-label ">
                <input class="md-input" id='filter' type="text"/>
                <label> Buscar</label>
            </div>
    <span class="input-group-btn">
        <button class="md-btn md-flat text-primary waves-effect" type="button"><i class="mdi-action-search i-24"></i></button>
    </span>
        </div>
    </div>
</div>

<!-- underscore template for the collection -->
<script type="text/template" id="afiliadoCollectionTemplate">
    <%=  view.getPaginationHtml(page) %>
    <div class="table-responsive">
        <table class="collection table table-bordered table-hover">
            <thead>
            <tr>
                <th id="header_Pkafiliado">Pkafiliado<% if (page.orderBy == 'Pkafiliado') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                <th id="header_Nombre">Nombre<% if (page.orderBy == 'Nombre') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                <th id="header_Direccion">Direccion<% if (page.orderBy == 'Direccion') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                <th id="header_Latitud">Latitud<% if (page.orderBy == 'Latitud') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                <th id="header_Longitud">Longitud<% if (page.orderBy == 'Longitud') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Telefono">Telefono<% if (page.orderBy == 'Telefono') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Descripcion">Descripcion<% if (page.orderBy == 'Descripcion') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Fkusuario">Fkusuario<% if (page.orderBy == 'Fkusuario') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Plan">Plan<% if (page.orderBy == 'Plan') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
            </tr>
            </thead>
            <tbody>
            <% items.each(function(item) { %>
                <tr id="<%= _.escape(item.get('pkafiliado')) %>">
                    <td><%= _.escape(item.get('pkafiliado') || '') %></td>
                    <td><%= _.escape(item.get('nombre') || '') %></td>
                    <td><%= _.escape(item.get('direccion') || '') %></td>
                    <td><%= _.escape(item.get('latitud') || '') %></td>
                    <td><%= _.escape(item.get('longitud') || '') %></td>
                    <td><%= _.escape(item.get('telefono') || '') %></td>
                    <td><%= _.escape(item.get('descripcion') || '') %></td>
                    <td><%= _.escape(item.get('fkusuario') || '') %></td>
                    <td><%= _.escape(item.get('plan') || '') %></td>
                </tr>
            <% }); %>
            </tbody>
        </table>
    </div>
</script>

<!-- underscore template for the model -->
<script type="text/template" id="afiliadoModelTemplate">
    <form onsubmit="return false;">
        <fieldset>
            <span class="hidden" id="pkafiliado"><%= _.escape(item.get('pkafiliado') || '') %></span>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre" value="<%= _.escape(item.get('nombre') || '') %>">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Direccion</label>
                        <input type="text" class="form-control" id="direccion" placeholder="Direccion" value="<%= _.escape(item.get('direccion') || '') %>">
                        <span class="help-inline"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Telefono</label>
                        <input type="text" class="form-control" id="telefono" placeholder="Telefono" value="<%= _.escape(item.get('telefono') || '') %>">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea class="form-control" id="descripcion" placeholder="Descripcion" style="resize: vertical; max-height: 200px"><%= _.escape(item.get('descripcion') || '') %></textarea>
                        <span class="help-inline"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Usuario</label>
                        <select class="form-control" id="fkusuario"></select>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Plan</label>
                        <input type="text" class="form-control" id="plan" placeholder="Plan" value="<%= _.escape(item.get('plan') || '') %>">
                        <span class="help-inline"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Latitud</label>
                        <input type="text" class="form-control" id="latitud" placeholder="Latitud" value="<%= _.escape(item.get('latitud') || '') %>">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>Longitud</label>
                        <input type="text" class="form-control" id="longitud" placeholder="Longitud" value="<%= _.escape(item.get('longitud') || '') %>">
                        <span class="help-inline"></span>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

    <!-- delete button is is a separate form to prevent enter key from triggering a delete -->
    <form id="deleteAfiliadoButtonContainer" class="form-horizontal" onsubmit="return false;">
        <fieldset>
            <div class="control-group dropdown">
                <button type="button" class="btn btn-fw btn-danger waves-effect" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-trash fa-fw"></i> Eliminar</button>
                <ul class="dropdown-menu animated fadeIn">
                    <li><a href="#" id="confirmDeleteAfiliadoButton"><i class="fa fa-check"></i></a></li>
                    <li><a href="#" id="cancelDeleteAfiliadoButton"><i class="fa fa-times"></i></a></li>
                </ul>
            </div>
        </fieldset>
    </form>
</script>

<!-- modal edit dialog -->
<div class="modal fade" id="afiliadoDetailDialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">&times;</a>
                <h3>
                    <i class="icon-edit"></i> Editar Afiliado
                    <span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
                </h3>
            </div>
            <div class="modal-body">
                <div id="modelAlert"></div>
                <div id="afiliadoModelContainer">
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div id='googleMap'></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button md-ink-ripple="" class="btn btn-fw btn-default waves-effect waves-effect" data-dismiss="modal"><i class="fa fa-ban fa-fw"></i> Cancelar</button>
                <button md-ink-ripple="" id="saveAfiliadoButton" class="btn btn-fw btn-success waves-effect waves-effect"><i class="fa fa-floppy-o fa-fw"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div id="collectionAlert"></div>

<div id="afiliadoCollectionContainer" class="collectionContainer">
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgSePuD5fwaC1pDJlv3MkmdC9SHTMmkCA"></script>
<script>
    function InicializarMapa(latitud,longitud){
        var infowindow = new google.maps.InfoWindow();

        var mapProp = {
            center:new google.maps.LatLng(latitud,longitud),
            zoom:12,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

        var marker = new google.maps.Marker({
            position:{lat: latitud, lng: longitud},
            map:map,
            draggable:true
        });

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });

        google.maps.event.addListener(marker,'dragend',function(){
            setLatLong(infowindow,map,marker,marker.getPosition().lat(), marker.getPosition().lng());
        });

        google.maps.event.addListener(map, 'click', function(event) {
            marker.setPosition(event.latLng);
            setLatLong(infowindow,map,marker,event.latLng.lat(),event.latLng.lng());
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
