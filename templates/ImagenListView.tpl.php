<?php
	$this->assign('title','petfinder | Imagenes');
	$this->assign('nav','imagenes');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/imagenes.js").wait(function(){
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
	<i class="icon-th-list"></i> Imagenes
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="imagenCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Pkimagen">Pkimagen<% if (page.orderBy == 'Pkimagen') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Ruta">Ruta<% if (page.orderBy == 'Ruta') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Fkmascota">Fkmascota<% if (page.orderBy == 'Fkmascota') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('pkimagen')) %>">
				<td><%= _.escape(item.get('pkimagen') || '') %></td>
				<td><%= _.escape(item.get('ruta') || '') %></td>
				<td><%= _.escape(item.get('fkmascota') || '') %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="imagenModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="pkimagenInputContainer" class="control-group">
					<label class="control-label" for="pkimagen">Pkimagen</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="pkimagen"><%= _.escape(item.get('pkimagen') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="rutaInputContainer" class="control-group">
					<label class="control-label" for="ruta">Ruta</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="ruta" placeholder="Ruta" value="<%= _.escape(item.get('ruta') || '') %>">
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
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteImagenButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteImagenButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Imagen</button>
						<span id="confirmDeleteImagenContainer" class="hide">
							<button id="cancelDeleteImagenButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteImagenButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="imagenDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Imagen
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="imagenModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveImagenButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="imagenCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newImagenButton" class="btn btn-primary">Add Imagen</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
