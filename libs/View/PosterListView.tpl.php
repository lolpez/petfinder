<?php
$this->assign('title','FIND MY PET | Posters');
$this->assign('nav','posters');
$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
    $LAB.script("libs/View/scripts/posters.js").wait(function(){
        $(document).ready(function(){
            page.init();
        });
        // hack for IE9 which may respond inconsistently with document.ready
        setTimeout(function(){
            if (!page.isInitialized) page.init();
        },1000);
    });
</script>

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
<a href="poster/nuevo" class="md-btn md-fab md-fab-bottom-right pos-fix blue waves-effect"><i class="mdi-content-add i-24"></i></a>
<!-- underscore template for the collection -->
<script type="text/template" id="posterCollectionTemplate">
    <%=  view.getPaginationHtml(page) %>
	<div class="p">            
		<% var i=0; %>
		<% items.each(function(item) { %>
			<% if (i == 0){ %> <div class="row"> <% } %>
				<div class="col-sm-4">
					<div class="panel panel-card">
						<div class="item text-center">
							<% if (_.escape(item.get('imagen')) != '') { %>
								<img src="<%= _.escape(item.get('imagen') || '') %>" class="w-full r-t" style="height: 200px; max-height: 200px; max-width:200px" >
							<% }else{ %>
								<span class="fa-stack fa-lg">
									<i class="fa fa-camera fa-stack-1x"></i>
									<i class="fa fa-ban fa-stack-2x text-danger"></i>
								</span>
							<% } %>
						</div>
						<a href="poster/ver/<%= _.escape(item.get('pkposter') || '') %>" md-ink-ripple="" class="md-btn md-fab md-raised green m-r md-fab-offset pull-right waves-effect"><i class="fa fa-fw fa-info"></i></a>
						<div class="p">
							<h3><%= _.escape(item.get('mascota_nombre') || '') %></h3>
							<h4><%= _.escape(item.get('tipoMascota_nombre')+ ' ' + item.get('mascota_tamano')+ ' ' +item.get('raza_nombre') || '') %></h4>
							<h5>Dueño: <%= _.escape(item.get('usuario_nombre') || '') %></h5>
							<h5>Genero: <%= _.escape(item.get('mascota_genero') || '') %></h5>
							<h5>Color: <%= _.escape(item.get('mascota_color') || '') %></h5>
							<p class="text-sm text-muted">
								Descripcion: <%= jQuery.trim(_.escape(item.get('descripcion') || '')).substring(0, 20).split(" ").slice(0, -1).join(" ") + "..." %>
							</p>
							<div class="text-muted-dk">Publicado el <%= _.escape(item.get('fecha')+ ' ' +item.get('hora') || '') %></div>
						</div>
					</div>
				</div>
			<% if (i == 2){ i=0; %> </div> <% }else{ i++; } %>
		<% }); %>
		<% if (i != 0){ %> </div> <% } %>           
	</div>    
</script>

<div id="collectionAlert"></div>

<div id="posterCollectionContainer" class="collectionContainer">
</div>


<?php
$this->display('_Footer.tpl.php');
?>