<?php
	$this->assign('title','PETFINDER | Notificaciones');
	$this->assign('nav','notificaciones');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/notificaciones.js").wait(function(){
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
	<i class="icon-th-list"></i> Notificaciones
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="notificacionCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Pknotificacion">Pknotificacion<% if (page.orderBy == 'Pknotificacion') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Fecha">Fecha<% if (page.orderBy == 'Fecha') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Hora">Hora<% if (page.orderBy == 'Hora') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FkusuarioDestino">Fkusuario Destino<% if (page.orderBy == 'FkusuarioDestino') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Fkposter">Fkposter<% if (page.orderBy == 'Fkposter') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Visto">Visto<% if (page.orderBy == 'Visto') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
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
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('visto') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="notificacionModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="pknotificacionInputContainer" class="control-group">
					<label class="control-label" for="pknotificacion">Pknotificacion</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="pknotificacion"><%= _.escape(item.get('pknotificacion') || '') %></span>
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
				<div id="fkusuarioDestinoInputContainer" class="control-group">
					<label class="control-label" for="fkusuarioDestino">Fkusuario Destino</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkusuarioDestino" placeholder="Fkusuario Destino" value="<%= _.escape(item.get('fkusuarioDestino') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fkposterInputContainer" class="control-group">
					<label class="control-label" for="fkposter">Fkposter</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="fkposter" placeholder="Fkposter" value="<%= _.escape(item.get('fkposter') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="vistoInputContainer" class="control-group">
					<label class="control-label" for="visto">Visto</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="visto" placeholder="Visto" value="<%= _.escape(item.get('visto') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteNotificacionButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteNotificacionButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Notificacion</button>
						<span id="confirmDeleteNotificacionContainer" class="hide">
							<button id="cancelDeleteNotificacionButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteNotificacionButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="notificacionDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Notificacion
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="notificacionModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveNotificacionButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="notificacionCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newNotificacionButton" class="btn btn-primary">Add Notificacion</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
