<?php
	$this->assign('title','petfinder | TipoPosters');
	$this->assign('nav','tipoposters');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/tipoposters.js").wait(function(){
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
	<i class="icon-th-list"></i> TipoPosters
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="tipoPosterCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_PktipoPoster">Pktipo Poster<% if (page.orderBy == 'PktipoPoster') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Nombre">Nombre<% if (page.orderBy == 'Nombre') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Descripcion">Descripcion<% if (page.orderBy == 'Descripcion') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Precio">Precio<% if (page.orderBy == 'Precio') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_TipoMoneda">Tipo Moneda<% if (page.orderBy == 'TipoMoneda') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('pktipoPoster')) %>">
				<td><%= _.escape(item.get('pktipoPoster') || '') %></td>
				<td><%= _.escape(item.get('nombre') || '') %></td>
				<td><%= _.escape(item.get('descripcion') || '') %></td>
				<td><%= _.escape(item.get('precio') || '') %></td>
				<td><%= _.escape(item.get('tipoMoneda') || '') %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="tipoPosterModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="pktipoPosterInputContainer" class="control-group">
					<label class="control-label" for="pktipoPoster">Pktipo Poster</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="pktipoPoster"><%= _.escape(item.get('pktipoPoster') || '') %></span>
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
				<div id="descripcionInputContainer" class="control-group">
					<label class="control-label" for="descripcion">Descripcion</label>
					<div class="controls inline-inputs">
						<textarea class="input-xlarge" id="descripcion" rows="3"><%= _.escape(item.get('descripcion') || '') %></textarea>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="precioInputContainer" class="control-group">
					<label class="control-label" for="precio">Precio</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="precio" placeholder="Precio" value="<%= _.escape(item.get('precio') || '') %>">
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
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteTipoPosterButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteTipoPosterButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete TipoPoster</button>
						<span id="confirmDeleteTipoPosterContainer" class="hide">
							<button id="cancelDeleteTipoPosterButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteTipoPosterButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="tipoPosterDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit TipoPoster
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="tipoPosterModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveTipoPosterButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="tipoPosterCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newTipoPosterButton" class="btn btn-primary">Add TipoPoster</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
