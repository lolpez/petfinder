<?php
	$this->assign('title','PETFINDER | Home');
	$this->assign('nav','home');

	$this->display('_Header.tpl.php');
?>

	<div class="container">

		<!-- Main hero unit for a primary marketing message or call to action -->
		<div class="hero-unit">
			<h1>Find My Pet Web <i class="icon-thumbs-up"></i></h1>
			<p>Esta es una pagina solo para los administradores. Por favor vayase</p>
			<a class="btn btn-primary btn-large" href="post.php">Ejemplo de nueva publicacion</a></p>
		</div>

	</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>