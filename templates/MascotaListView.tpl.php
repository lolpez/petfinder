<?php
	$this->assign('title','PETFINDER | Mascotas');
	$this->assign('nav','mascotas');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/mascotas.js").wait(function(){
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
	<i class="icon-th-list"></i> Mascotas
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="mascotaCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Pkmascota">Pkmascota<% if (page.orderBy == 'Pkmascota') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Nombre">Nombre<% if (page.orderBy == 'Nombre') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Nombre">Genero<% if (page.orderBy == 'Genero') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Tamano">Tamano<% if (page.orderBy == 'Tamano') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Color">Color<% if (page.orderBy == 'Color') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_FktipoMascota">Fktipo Mascota<% if (page.orderBy == 'FktipoMascota') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Fkraza">Fkraza<% if (page.orderBy == 'Fkraza') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Estado">Estado<% if (page.orderBy == 'Estado') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
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

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="mascotaModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="pkmascotaInputContainer" class="control-group">
					<label class="control-label" for="pkmascota">Pkmascota</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="pkmascota"><%= _.escape(item.get('pkmascota') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="nombreInputContainer" class="control-group">
					<label class="control-label" for="nombre">Nombre</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="nombre" placeholder="Nombre" value="<%= _.escape(item.get('nombre') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
                <div id="nombreInputContainer" class="control-group">
                    <label class="control-label" for="genero">Genero</label>
                    <div class="controls inline-inputs">
                        <select class="input-xlarge" id="genero">
                            <option value="macho">macho</option>
                            <option value="hembra">hembra</option>
                            <option value="indeterminado">indeterminado</option>
                        </select>
                        <span class="help-inline"></span>
                    </div>
                </div>
				<div id="tamanoInputContainer" class="control-group">
					<label class="control-label" for="tamano">Tamano</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="tamano" placeholder="Tamano" value="<%= _.escape(item.get('tamano') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="colorInputContainer" class="control-group">
					<label class="control-label" for="color">Color</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="color" placeholder="Color" value="<%= _.escape(item.get('color') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="fktipoMascotaInputContainer" class="control-group">
					<label class="control-label" for="fktipoMascota">Tipo Mascota</label>
					<div class="controls inline-inputs">
                        <select class="form-control" id="fktipoMascota"></select>
                        <span class="help-inline"></span>
					</div>
				</div>
				<div id="fkrazaInputContainer" class="control-group">
					<label class="control-label" for="fkraza">Raza</label>
					<div class="controls inline-inputs">
                        <select class="form-control" id="fkraza"></select>
                        <span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteMascotaButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteMascotaButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Mascota</button>
						<span id="confirmDeleteMascotaContainer" class="hide">
							<button id="cancelDeleteMascotaButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteMascotaButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="mascotaDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Mascota
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="mascotaModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveMascotaButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="mascotaCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newMascotaButton" class="btn btn-primary">Add Mascota</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
