<?php
	$this->assign('title','petfinder | Posters');
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
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Pkposter">Pkposter<% if (page.orderBy == 'Pkposter') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Fkusuario">Fkusuario<% if (page.orderBy == 'Fkusuario') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Fkmascota">Fkmascota<% if (page.orderBy == 'Fkmascota') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FktipoPoster">Fktipo Poster<% if (page.orderBy == 'FktipoPoster') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Latitud">Latitud<% if (page.orderBy == 'Latitud') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Longitud">Longitud<% if (page.orderBy == 'Longitud') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Recompensa">Recompensa<% if (page.orderBy == 'Recompensa') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_TipoMoneda">Tipo Moneda<% if (page.orderBy == 'TipoMoneda') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Descripcion">Descripcion<% if (page.orderBy == 'Descripcion') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Fecha">Fecha<% if (page.orderBy == 'Fecha') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Hora">Hora<% if (page.orderBy == 'Hora') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Estado">Estado<% if (page.orderBy == 'Estado') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
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
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('longitud') || '') %></td>
				<td><%= _.escape(item.get('recompensa') || '') %></td>
				<td><%= _.escape(item.get('tipoMoneda') || '') %></td>
				<td><%= _.escape(item.get('descripcion') || '') %></td>
				<td><%= _.escape(item.get('fecha') || '') %></td>
				<td><%= _.escape(item.get('hora') || '') %></td>
				<td><%= _.escape(item.get('estado') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
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
						<input type="text" class="input-xlarge" id="fkusuario" placeholder="Fkusuario" value="<%= _.escape(item.get('fkusuario') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkmascotaInputContainer" class="control-group">
					<label class="control-label" for="fkmascota">Fkmascota</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkmascota" placeholder="Fkmascota" value="<%= _.escape(item.get('fkmascota') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fktipoPosterInputContainer" class="control-group">
					<label class="control-label" for="fktipoPoster">Fktipo Poster</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fktipoPoster" placeholder="Fktipo Poster" value="<%= _.escape(item.get('fktipoPoster') || '') %>">
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
				<div id="fechaInputContainer" class="control-group">
					<label class="control-label" for="fecha">Fecha</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fecha" placeholder="Fecha" value="<%= _.escape(item.get('fecha') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="horaInputContainer" class="control-group">
					<label class="control-label" for="hora">Hora</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="hora" placeholder="Hora" value="<%= _.escape(item.get('hora') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="estadoInputContainer" class="control-group">
					<label class="control-label" for="estado">Estado</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="estado" placeholder="Estado" value="<%= _.escape(item.get('estado') || '') %>">
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
