<?php
$this->assign('title','FIND MY PET | Publicacion');
$this->assign('nav','Publicacion');
$this->display('_Header.tpl.php');
?>
<div class="row">
    <div class="col-xs-4">
        <h3>Publicacion</h3>
    </div>
</div>

<div class="row row-sm">
    <div class="col-sm-4">
        <div class="panel panel-card">
            <div class="r-t pos-rlt waves-effect" md-ink-ripple="" style="background:url(<?php echo $this->poster->Imagen ?>) center center; background-size:cover; display: block">
                <div class="p-lg bg-white-overlay text-center r-t">
                    <a href="">
                        <img src="<?php echo $this->poster->Imagen ?>" style="width: 50%">
                    </a>
                    <div class="m-b m-t-sm h2">
                        <span class=""><?php echo $this->poster->Mascota_nombre ?></span>
                    </div>
                </div>
            </div>
            <div class="list-group no-radius no-border">
                <a class="list-group-item">
                    <span class="pull-right badge"><?php echo $this->poster->Usuario_nombre ?></span>Dueño
                </a>
                <a class="list-group-item">
                    <span class="pull-right badge"><?php echo $this->poster->TipoMascota_nombre ?></span>Tipo de mascota
                </a>
                <a class="list-group-item">
                    <span class="pull-right badge"><?php echo $this->poster->Raza_nombre ?></span>Raza
                </a>
                <a class="list-group-item">
                    <span class="pull-right badge"><?php echo $this->poster->Mascota_tamano ?></span>Tamaño
                </a>
            </div>
            <div class="p">
                <p>Descripcion</p>
                <p><?php echo $this->poster->Descripcion ?></p>
                <div class="m-v">
                    <a class="btn btn-icon btn-default waves-effect"><i class="fa fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="panel panel-card">
            <textarea class="form-control no-border" rows="3" placeholder="Comunícate con su dueño!..." style="resize: vertical; max-height: 200px"></textarea>
            <div class="lt p">
                <button class="btn btn-info pull-right btn-sm p-h font-bold waves-effect">Enviar</button>
                <ul class="nav nav-pills nav-sm">

                </ul>
            </div>
        </div>
        <div class="panel panel-card clearfix">
            <ul class="nav nav-md nav-tabs nav-lines b-info">
                <li class="active">
                    <a href="" data-toggle="tab" data-target="#tab_1" aria-expanded="true">Mapa</a>
                </li>
                <li class="">
                    <a href="" data-toggle="tab" data-target="#tab_2" aria-expanded="false">Imagenes</a>
                </li>
            </ul>
            <div class="tab-content p m-b-md b-t b-t-2x">
                <div role="tabpanel" class="tab-pane animated fadeIn active" id="tab_1">
                    sup
                </div>
                <div role="tabpanel" class="tab-pane animated fadeIn" id="tab_2">
                    bitches
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->display('_Footer.tpl.php');
?>