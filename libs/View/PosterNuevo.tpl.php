<?php
$this->assign('title','FIND MY PET | Posters');
$this->assign('nav','publicar nuevo poster');
$this->display('_Header.tpl.php');
?>
<div class="row">
    <div class="col-xs-4">
        <h3><?php echo strtoupper($this->nav) ?></h3>
    </div>
</div>


<form action="web_service/poster/nuevo" method="post" enctype="multipart/form-data">
    <input type="hidden" name="pkusuario" value="1">
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label>Nombre de su mascota</label>
                <input class="form-control" type="text" name="nombre">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label>Genero</label>
                <select class="form-control" name="genero">
                    <option value="hembra">hembra</option>
                    <option value="macho">macho</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label>Tamaño</label>
                <select class="form-control" name="tamano">
                    <option value="pequeño">pequeño</option>
                    <option value="mediano">mediano</option>
                    <option value="grande">grande</option>
                </select>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label>Color</label>
                <input class="form-control" type="text" name="color">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label>Tipo de mascota</label>
                <select class="form-control" name="pktipo_mascota">
                    <?php foreach ($this->tipo_mascotas as $r){ ?>
                        <option value="<?php echo $r->pktipoMascota ?>"><?php echo $r->nombre ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label>Raza</label>
                <select class="form-control" name="pkraza">
                    <?php foreach ($this->razas as $r){ ?>
                        <option value="<?php echo $r->pkraza ?>"><?php echo $r->nombre ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label>Latitud</label>
                <input class="form-control" type="text" name="latitud">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label>Longitud</label>
                <input class="form-control" type="text" name="longitud">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label>Tipo de poster</label>
                <select class="form-control" name="pktipo_poster">
                    <?php foreach ($this->tipo_posters as $r){ ?>
                        <option value="<?php echo $r->pktipoPoster ?>"><?php echo $r->nombre ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <label>Recompensa</label>
                <input class="form-control" type="text" name="recompensa">
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <label>Moneda</label>
                <select class="form-control" name="tipo_moneda">
                    <option value="bolivianos">bolivianos</option>
                    <option value="dolares">dolares</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label>Descripcion</label>
                <textarea class="form-control" style="resize: vertical; max-height: 100px" name="descripcion"></textarea>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label>Imagen</label>
                <input type="file" name="imagen">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success waves-effect"> Guardar</button>
</form>



<?php
$this->display('_Footer.tpl.php');
?>