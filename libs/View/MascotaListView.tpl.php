<?php
$this->assign('title','FIND MY PET | Mascotas');
$this->assign('nav','mascotas');
$this->display('_Header.tpl.php');
?>

    <script type="text/javascript">
        $LAB.script("libs/View/scripts/mascotas.js").wait(function(){
            $(document).ready(function(){
                page.init();
            });

            // hack for IE9 which may respond inconsistently with document.ready
            setTimeout(function(){
                if (!page.isInitialized) page.init();
            },1000);
        });
    </script>

    <button id="newMascotaButton" class="md-btn md-fab md-fab-bottom-right pos-fix blue waves-effect"><i class="mdi-content-add i-24"></i></button>
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
    <script type="text/template" id="mascotaCollectionTemplate">
        <%=  view.getPaginationHtml(page) %>
        <div class="table-responsive">
            <table class="collection table table-bordered table-hover">
                <thead>
                <tr>
                    <th id="header_Pkmascota">Pkmascota<% if (page.orderBy == 'Pkmascota') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Nombre">Nombre<% if (page.orderBy == 'Nombre') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Nombre">Genero<% if (page.orderBy == 'Genero') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Tamano">Tamano<% if (page.orderBy == 'Tamano') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Color">Color<% if (page.orderBy == 'Color') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_FktipoMascota">Fktipo Mascota<% if (page.orderBy == 'FktipoMascota') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Fkraza">Fkraza<% if (page.orderBy == 'Fkraza') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Estado">Estado<% if (page.orderBy == 'Estado') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                </tr>
                </thead>
                <tbody>
                <% items.each(function(item) { %>
                    <tr id="<%= _.escape(item.get('pkmascota')) %>">
                        <td><%= _.escape(item.get('pkmascota') || '') %></td>
                        <td><%= _.escape(item.get('nombre') || '') %></td>
                        <td><%= _.escape(item.get('genero') || '') %></td>
                        <td><%= _.escape(item.get('tamano') || '') %></td>
                        <td><%= _.escape(item.get('color') || '') %></td>
                        <td><%= _.escape(item.get('fktipoMascota') || '') %></td>
                        <td><%= _.escape(item.get('fkraza') || '') %></td>
                        <td><%= _.escape(item.get('estado') || '') %></td>
                    </tr>
                <% }); %>
                </tbody>
            </table>
        </div>
    </script>

    <!-- underscore template for the model -->
    <script type="text/template" id="mascotaModelTemplate">
        <form onsubmit="return false;">
            <fieldset>
                <span class="hidden" id="pkmascota"><%= _.escape(item.get('pkmascota') || '') %></span>
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
                            <label>Genero</label>
                            <select class="form-control" id="genero"></select>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Tamaño</label>
                            <select class="form-control" id="tamano"></select>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" class="form-control" id="color" placeholder="Color" value="<%= _.escape(item.get('color') || '') %>">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Tipo Mascota</label>
                            <select class="form-control" id="fktipoMascota"></select>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Raza</label>
                            <select class="form-control" id="fkraza"></select>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- delete button is is a separate form to prevent enter key from triggering a delete -->
        <form id="deleteMascotaButtonContainer" class="form-horizontal" onsubmit="return false;">
            <fieldset>
                <div class="control-group dropdown">
                    <button type="button" class="btn btn-fw btn-danger waves-effect" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-trash fa-fw"></i> Eliminar</button>
                    <ul class="dropdown-menu animated fadeIn">
                        <li><a href="#" id="confirmDeleteMascotaButton"><i class="fa fa-check"></i></a></li>
                        <li><a href="#" id="cancelDeleteMascotaButton"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
            </fieldset>
        </form>
    </script>

    <!-- modal edit dialog -->
    <div class="modal fade" id="mascotaDetailDialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">&times;</a>
                    <h3>
                        <i class="icon-edit"></i> Editar Mascota
                        <span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
                    </h3>
                </div>
                <div class="modal-body">
                    <div id="modelAlert"></div>
                    <div id="mascotaModelContainer"></div>
                </div>
                <div class="modal-footer">
                    <button md-ink-ripple="" class="btn btn-fw btn-default waves-effect waves-effect" data-dismiss="modal"><i class="fa fa-ban fa-fw"></i> Cancelar</button>
                    <button md-ink-ripple="" id="saveMascotaButton" class="btn btn-fw btn-success waves-effect waves-effect"><i class="fa fa-floppy-o fa-fw"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="collectionAlert"></div>

    <div id="mascotaCollectionContainer" class="collectionContainer">
    </div>


<?php
$this->display('_Footer.tpl.php');
?>