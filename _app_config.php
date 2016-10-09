<?php
/**
 * @package PETFINDER
 *
 * APPLICATION-WIDE CONFIGURATION SETTINGS
 *
 * This file contains application-wide configuration settings.  The settings
 * here will be the same regardless of the machine on which the app is running.
 *
 * This configuration should be added to version control.
 *
 * No settings should be added to this file that would need to be changed
 * on a per-machine basic (ie local, staging or production).  Any
 * machine-specific settings should be added to _machine_config.php
 */

/**
 * APPLICATION ROOT DIRECTORY
 * If the application doesn't detect this correctly then it can be set explicitly
 */
if (!GlobalConfig::$APP_ROOT) GlobalConfig::$APP_ROOT = realpath("./");

/**
 * check is needed to ensure asp_tags is not enabled
 */
if (ini_get('asp_tags')) 
	die('<h3>Server Configuration Problem: asp_tags is enabled, but is not compatible with Savant.</h3>'
	. '<p>You can disable asp_tags in .htaccess, php.ini or generate your app with another template engine such as Smarty.</p>');

/**
 * INCLUDE PATH
 * Adjust the include path as necessary so PHP can locate required libraries
 */
set_include_path(
		GlobalConfig::$APP_ROOT . '/libs/' . PATH_SEPARATOR .
		'phar://' . GlobalConfig::$APP_ROOT . '/libs/phreeze-3.3.8.phar' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/../libs/phreeze' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/vendor/phreeze/phreeze/libs/' . PATH_SEPARATOR .
		get_include_path()
);

/**
 * COMPOSER AUTOLOADER
 * Uncomment if Composer is being used to manage dependencies
 */
// $loader = require 'vendor/autoload.php';
// $loader->setUseIncludePath(true);

/**
 * SESSION CLASSES
 * Any classes that will be stored in the session can be added here
 * and will be pre-loaded on every page
 */
require_once "App/ExampleUser.php";

/**
 * RENDER ENGINE
 * You can use any template system that implements
 * IRenderEngine for the view layer.  Phreeze provides pre-built
 * implementations for Smarty, Savant and plain PHP.
 */
require_once 'verysimple/Phreeze/SavantRenderEngine.php';
GlobalConfig::$TEMPLATE_ENGINE = 'SavantRenderEngine';
GlobalConfig::$TEMPLATE_PATH = GlobalConfig::$APP_ROOT . '/templates/';

/**
 * ROUTE MAP
 * The route map connects URLs to Controller+Method and additionally maps the
 * wildcards to a named parameter so that they are accessible inside the
 * Controller without having to parse the URL for parameters such as IDs
 */
GlobalConfig::$ROUTE_MAP = array(

    //Web Service Personalizado
    'POST:web_service/poster' => array('route' => 'Poster.NuevoPost'),

	// default controller when no route specified
	'GET:' => array('route' => 'Default.Home'),
		
	// example authentication routes
	'GET:loginform' => array('route' => 'SecureExample.LoginForm'),
	'POST:login' => array('route' => 'SecureExample.Login'),
	'GET:secureuser' => array('route' => 'SecureExample.UserPage'),
	'GET:secureadmin' => array('route' => 'SecureExample.AdminPage'),
	'GET:logout' => array('route' => 'SecureExample.Logout'),
		
	// Imagen
	'GET:imagenes' => array('route' => 'Imagen.ListView'),
	'GET:imagen/(:num)' => array('route' => 'Imagen.SingleView', 'params' => array('pkimagen' => 1)),
	'GET:api/imagenes' => array('route' => 'Imagen.Query'),
	'POST:api/imagen' => array('route' => 'Imagen.Create'),
	'GET:api/imagen/(:num)' => array('route' => 'Imagen.Read', 'params' => array('pkimagen' => 2)),
	'PUT:api/imagen/(:num)' => array('route' => 'Imagen.Update', 'params' => array('pkimagen' => 2)),
	'DELETE:api/imagen/(:num)' => array('route' => 'Imagen.Delete', 'params' => array('pkimagen' => 2)),
		
	// Mascota
	'GET:mascotas' => array('route' => 'Mascota.ListView'),
	'GET:mascota/(:num)' => array('route' => 'Mascota.SingleView', 'params' => array('pkmascota' => 1)),
	'GET:api/mascotas' => array('route' => 'Mascota.Query'),
	'POST:api/mascota' => array('route' => 'Mascota.Create'),
	'GET:api/mascota/(:num)' => array('route' => 'Mascota.Read', 'params' => array('pkmascota' => 2)),
	'PUT:api/mascota/(:num)' => array('route' => 'Mascota.Update', 'params' => array('pkmascota' => 2)),
	'DELETE:api/mascota/(:num)' => array('route' => 'Mascota.Delete', 'params' => array('pkmascota' => 2)),
		
	// Notificacion
	'GET:notificaciones' => array('route' => 'Notificacion.ListView'),
	'GET:notificacion/(:num)' => array('route' => 'Notificacion.SingleView', 'params' => array('pknotificacion' => 1)),
	'GET:api/notificaciones' => array('route' => 'Notificacion.Query'),
	'POST:api/notificacion' => array('route' => 'Notificacion.Create'),
	'GET:api/notificacion/(:num)' => array('route' => 'Notificacion.Read', 'params' => array('pknotificacion' => 2)),
	'PUT:api/notificacion/(:num)' => array('route' => 'Notificacion.Update', 'params' => array('pknotificacion' => 2)),
	'DELETE:api/notificacion/(:num)' => array('route' => 'Notificacion.Delete', 'params' => array('pknotificacion' => 2)),
		
	// Poster
	'GET:posters' => array('route' => 'Poster.ListView'),
	'GET:poster/(:num)' => array('route' => 'Poster.SingleView', 'params' => array('pkposter' => 1)),
	'GET:api/posters' => array('route' => 'Poster.Query'),
	'POST:api/poster' => array('route' => 'Poster.Create'),
	'GET:api/poster/(:num)' => array('route' => 'Poster.Read', 'params' => array('pkposter' => 2)),
	'PUT:api/poster/(:num)' => array('route' => 'Poster.Update', 'params' => array('pkposter' => 2)),
	'DELETE:api/poster/(:num)' => array('route' => 'Poster.Delete', 'params' => array('pkposter' => 2)),
		
	// Raza
	'GET:razas' => array('route' => 'Raza.ListView'),
	'GET:raza/(:num)' => array('route' => 'Raza.SingleView', 'params' => array('pkraza' => 1)),
	'GET:api/razas' => array('route' => 'Raza.Query'),
	'POST:api/raza' => array('route' => 'Raza.Create'),
	'GET:api/raza/(:num)' => array('route' => 'Raza.Read', 'params' => array('pkraza' => 2)),
	'PUT:api/raza/(:num)' => array('route' => 'Raza.Update', 'params' => array('pkraza' => 2)),
	'DELETE:api/raza/(:num)' => array('route' => 'Raza.Delete', 'params' => array('pkraza' => 2)),
		
	// TipoMascota
	'GET:tipomascotas' => array('route' => 'TipoMascota.ListView'),
	'GET:tipomascota/(:num)' => array('route' => 'TipoMascota.SingleView', 'params' => array('pktipoMascota' => 1)),
	'GET:api/tipomascotas' => array('route' => 'TipoMascota.Query'),
	'POST:api/tipomascota' => array('route' => 'TipoMascota.Create'),
	'GET:api/tipomascota/(:num)' => array('route' => 'TipoMascota.Read', 'params' => array('pktipoMascota' => 2)),
	'PUT:api/tipomascota/(:num)' => array('route' => 'TipoMascota.Update', 'params' => array('pktipoMascota' => 2)),
	'DELETE:api/tipomascota/(:num)' => array('route' => 'TipoMascota.Delete', 'params' => array('pktipoMascota' => 2)),
		
	// TipoPoster
	'GET:tipoposters' => array('route' => 'TipoPoster.ListView'),
	'GET:tipoposter/(:num)' => array('route' => 'TipoPoster.SingleView', 'params' => array('pktipoPoster' => 1)),
	'GET:api/tipoposters' => array('route' => 'TipoPoster.Query'),
	'POST:api/tipoposter' => array('route' => 'TipoPoster.Create'),
	'GET:api/tipoposter/(:num)' => array('route' => 'TipoPoster.Read', 'params' => array('pktipoPoster' => 2)),
	'PUT:api/tipoposter/(:num)' => array('route' => 'TipoPoster.Update', 'params' => array('pktipoPoster' => 2)),
	'DELETE:api/tipoposter/(:num)' => array('route' => 'TipoPoster.Delete', 'params' => array('pktipoPoster' => 2)),
		
	// Usuario
	'GET:usuarios' => array('route' => 'Usuario.ListView'),
	'GET:usuario/(:num)' => array('route' => 'Usuario.SingleView', 'params' => array('pkusuario' => 1)),
	'GET:api/usuarios' => array('route' => 'Usuario.Query'),
	'POST:api/usuario' => array('route' => 'Usuario.Create'),
	'GET:api/usuario/(:num)' => array('route' => 'Usuario.Read', 'params' => array('pkusuario' => 2)),
	'PUT:api/usuario/(:num)' => array('route' => 'Usuario.Update', 'params' => array('pkusuario' => 2)),
	'DELETE:api/usuario/(:num)' => array('route' => 'Usuario.Delete', 'params' => array('pkusuario' => 2)),

	// catch any broken API urls
	'GET:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'PUT:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'POST:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'DELETE:api/(:any)' => array('route' => 'Default.ErrorApi404')
);

/**
 * FETCHING STRATEGY
 * You may uncomment any of the lines below to specify always eager fetching.
 * Alternatively, you can copy/paste to a specific page for one-time eager fetching
 * If you paste into a controller method, replace $G_PHREEZER with $this->Phreezer
 */
?>