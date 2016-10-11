<?php
	$this->assign('title','PETFINDER | Posters');
	$this->assign('nav','posters');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/posters.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>

<div class="container">

<h1>
	<i class="icon-th-list"></i> Posters
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="posterCollectionTemplate">
        <%=  view.getPaginationHtml(page) %>
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Blog</a></li>
                <li><a href="#tab2" data-toggle="tab">Tabla</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <ul class="thumbnails">
                        <% items.each(function(item) { %>
                            <li class="span3">
                                <div class="thumbnail">
								<% if (_.escape(item.get('imagen')) != '') { %>
									<a href="<%= _.escape(item.get('imagen') || '') %>" class="thumbnail" target="_blank">
                                        <img src="<%= _.escape(item.get('imagen') || '') %>" width="100px" style="border-radius: 5px">
                                    </a>
								<% }else{ %>
									(Sin imagen)
								<% } %>                                    
                                    <div class="caption">
                                        <h3><%= _.escape(item.get('fkmascota') || '') %></h3>
                                        <p><%= _.escape(item.get('descripcion') || '') %></p>
                                    </div>
                                </div>
                            </li>
                        <% }); %>
                    </ul>
                </div>
                <div class="tab-pane" id="tab2">
                    <table class="collection table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th id="header_Pkposter">Pkposter<% if (page.orderBy == 'Pkposter') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_Fkusuario">Fkusuario<% if (page.orderBy == 'Fkusuario') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_Fkmascota">Fkmascota<% if (page.orderBy == 'Fkmascota') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_FktipoPoster">Fktipo Poster<% if (page.orderBy == 'FktipoPoster') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_Latitud">Latitud<% if (page.orderBy == 'Latitud') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_Longitud">Longitud<% if (page.orderBy == 'Longitud') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_Recompensa">Recompensa<% if (page.orderBy == 'Recompensa') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_TipoMoneda">Tipo Moneda<% if (page.orderBy == 'TipoMoneda') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_Descripcion">Descripcion<% if (page.orderBy == 'Descripcion') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_Fecha">Fecha<% if (page.orderBy == 'Fecha') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_Hora">Hora<% if (page.orderBy == 'Hora') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                            <th id="header_Imagen">Imagen<% if (page.orderBy == 'Imagen') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
                        </tr>
                        </thead>
                        <tbody>
                        <% items.each(function(item) { %>
                            <tr id="<%= _.escape(item.get('pkposter')) %>">
                                <td><%= _.escape(item.get('pkposter') || '') %></td>
                                <td><%= _.escape(item.get('fkusuario') || '') %></td>
                                <td><%= _.escape(item.get('fkmascota') || '') %></td>
                                <td><%= _.escape(item.get('fktipoPoster') || '') %></td>
                                <td><%= _.escape(item.get('latitud') || '') %></td>
                                <td><%= _.escape(item.get('longitud') || '') %></td>
                                <td><%= _.escape(item.get('recompensa') || '') %></td>
                                <td><%= _.escape(item.get('tipoMoneda') || '') %></td>
                                <td><%= _.escape(item.get('descripcion') || '') %></td>
                                <td><%= _.escape(item.get('fecha') || '') %></td>
                                <td><%= _.escape(item.get('hora') || '') %></td>
                                <td>
									<% if (_.escape(item.get('imagen')) != '') { %>
										<img src="<%= _.escape(item.get('imagen') || '') %>" width="100px" style="border-radius: 5px">
									<% }else{ %>
										(Sin imagen)
									<% } %>
								</td>
                            </tr>
                        <% }); %>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="posterModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="pkposterInputContainer" class="control-group">
					<label class="control-label" for="pkposter">Pkposter</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="pkposter"><%= _.escape(item.get('pkposter') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkusuarioInputContainer" class="control-group">
					<label class="control-label" for="fkusuario">Fkusuario</label>
					<div class="controls inline-inputs">
                        <select class="form-control" id="fkusuario"></select>
                        <span class="help-inline"></span>
					</div>
				</div>
				<div id="fkmascotaInputContainer" class="control-group">
					<label class="control-label" for="fkmascota">Fkmascota</label>
					<div class="controls inline-inputs">
                        <select class="form-control" id="fkmascota"></select>
                        <span class="help-inline"></span>
					</div>
				</div>
				<div id="fktipoPosterInputContainer" class="control-group">
					<label class="control-label" for="fktipoPoster">Fktipo Poster</label>
					<div class="controls inline-inputs">
                        <select class="form-control" id="fktipoPoster"></select>
                        <span class="help-inline"></span>
					</div>
				</div>
				<div id="latitudInputContainer" class="control-group">
					<label class="control-label" for="latitud">Latitud</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="latitud" placeholder="Latitud" value="<%= _.escape(item.get('latitud') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="longitudInputContainer" class="control-group">
					<label class="control-label" for="longitud">Longitud</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="longitud" placeholder="Longitud" value="<%= _.escape(item.get('longitud') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="recompensaInputContainer" class="control-group">
					<label class="control-label" for="recompensa">Recompensa</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="recompensa" placeholder="Recompensa" value="<%= _.escape(item.get('recompensa') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="tipoMonedaInputContainer" class="control-group">
					<label class="control-label" for="tipoMoneda">Tipo Moneda</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="tipoMoneda" placeholder="Tipo Moneda" value="<%= _.escape(item.get('tipoMoneda') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="descripcionInputContainer" class="control-group">
					<label class="control-label" for="descripcion">Descripcion</label>
					<div class="controls inline-inputs">
						<textarea class="input-xlarge" id="descripcion" rows="3"><%= _.escape(item.get('descripcion') || '') %></textarea>
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deletePosterButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deletePosterButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Poster</button>
						<span id="confirmDeletePosterContainer" class="hide">
							<button id="cancelDeletePosterButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeletePosterButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="posterDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Poster
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="posterModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="savePosterButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="posterCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newPosterButton" class="btn btn-primary">Add Poster</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
