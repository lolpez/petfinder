<?php
$this->assign('title','FIND MY PET | Notificaciones');
$this->assign('nav','notificaciones');
$this->display('_Header.tpl.php');
?>

    <script type="text/javascript">
        $LAB.script("libs/View/scripts/notificaciones.js").wait(function(){
            $(document).ready(function(){
                page.init();
            });

            // hack for IE9 which may respond inconsistently with document.ready
            setTimeout(function(){
                if (!page.isInitialized) page.init();
            },1000);
        });
    </script>

    <button id="newNotificacionButton" class="md-btn md-fab md-fab-bottom-right pos-fix blue waves-effect"><i class="mdi-content-add i-24"></i></button>
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
    <script type="text/template" id="notificacionCollectionTemplate">
        <%=  view.getPaginationHtml(page) %>
        <div class="table-responsive">
            <table class="collection table table-bordered table-hover">
                <thead>
                <tr>
                    <th id="header_Pknotificacion">ID notificacion<% if (page.orderBy == 'Pknotificacion') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Fecha">Fecha<% if (page.orderBy == 'Fecha') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Hora">Hora<% if (page.orderBy == 'Hora') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_FkusuarioDestino">Usuario destino<% if (page.orderBy == 'FkusuarioDestino') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Fkposter">ID poster<% if (page.orderBy == 'Fkposter') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                    <th id="header_Visto">Visto<% if (page.orderBy == 'Visto') { %> <i class='fa fa-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                </tr>
                </thead>
                <tbody>
                <% items.each(function(item) { %>
                    <tr id="<%= _.escape(item.get('pknotificacion')) %>">
                        <td><%= _.escape(item.get('pknotificacion') || '') %></td>
                        <td><%= _.escape(item.get('fecha') || '') %></td>
                        <td><%= _.escape(item.get('hora') || '') %></td>
                        <td><%= _.escape(item.get('fkusuarioDestino') || '') %></td>
                        <td><%= _.escape(item.get('fkposter') || '') %></td>
                        <td><%= _.escape(item.get('visto') || '') %></td>
                    </tr>
                <% }); %>
                </tbody>
            </table>
        </div>
    </script>

    <!-- underscore template for the model -->
    <script type="text/template" id="notificacionModelTemplate">
        <form onsubmit="return false;">
            <fieldset>
                <span class="hidden" id="pknotificacion"><%= _.escape(item.get('pknotificacion') || '') %></span>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="text" class="form-control" id="fecha" placeholder="Fecha" value="<%= _.escape(item.get('fecha') || '') %>">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Hora</label>
                            <input type="text" class="form-control" id="hora" placeholder="Hora" value="<%= _.escape(item.get('hora') || '') %>">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Usuario Destino</label>
                            <select class="form-control" id="fkusuarioDestino"></select>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>ID Poster</label>
                            <select class="form-control" id="fkposter"></select>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-4 col-xs-4">
                        <div class="form-group text-center">
                            Visto
                            <label class="md-switch">
                                <input type="checkbox"  class="has-value" id="visto" <% if (_.escape(item.get('visto')) == 1) { %> checked <% } %>>
                                <i class="blue"></i>
                            </label>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- delete button is is a separate form to prevent enter key from triggering a delete -->
        <form id="deleteNotificacionButtonContainer" class="form-horizontal" onsubmit="return false;">
            <fieldset>
                <div class="control-group dropdown">
                    <button type="button" class="btn btn-fw btn-danger waves-effect" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-trash fa-fw"></i> Eliminar</button>
                    <ul class="dropdown-menu animated fadeIn">
                        <li><a href="#" id="confirmDeleteNotificacionButton"><i class="fa fa-check"></i></a></li>
                        <li><a href="#" id="cancelDeleteNotificacionButton"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
            </fieldset>
        </form>
    </script>

    <!-- modal edit dialog -->
    <div class="modal fade" id="notificacionDetailDialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">&times;</a>
                    <h3>
                        <i class="icon-edit"></i> Editar Notificacion
                        <span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
                    </h3>
                </div>
                <div class="modal-body">
                    <div id="modelAlert"></div>
                    <div id="notificacionModelContainer"></div>
                </div>
                <div class="modal-footer">
                    <button md-ink-ripple="" class="btn btn-fw btn-default waves-effect waves-effect" data-dismiss="modal"><i class="fa fa-ban fa-fw"></i> Cancelar</button>
                    <button md-ink-ripple="" id="saveNotificacionButton" class="btn btn-fw btn-success waves-effect waves-effect"><i class="fa fa-floppy-o fa-fw"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="collectionAlert"></div>

    <div id="notificacionCollectionContainer" class="collectionContainer">
    </div>


<?php
$this->display('_Footer.tpl.php');
?>