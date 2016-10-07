<?php
/** @package    Petfinder::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * NotificacionMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the NotificacionDAO to the notificacion datastore.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * You can override the default fetching strategies for KeyMaps in _config.php.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package Petfinder::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class NotificacionMap implements IDaoMap, IDaoMap2
{

	private static $KM;
	private static $FM;
	
	/**
	 * {@inheritdoc}
	 */
	public static function AddMap($property,FieldMap $map)
	{
		self::GetFieldMaps();
		self::$FM[$property] = $map;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function SetFetchingStrategy($property,$loadType)
	{
		self::GetKeyMaps();
		self::$KM[$property]->LoadType = $loadType;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetFieldMaps()
	{
		if (self::$FM == null)
		{
			self::$FM = Array();
			self::$FM["Pknotificacion"] = new FieldMap("Pknotificacion","notificacion","pknotificacion",true,FM_TYPE_INT,11,null,true);
			self::$FM["Fecha"] = new FieldMap("Fecha","notificacion","fecha",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["Hora"] = new FieldMap("Hora","notificacion","hora",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["Fkusuario"] = new FieldMap("Fkusuario","notificacion","fkusuario",false,FM_TYPE_INT,11,null,false);
			self::$FM["Visto"] = new FieldMap("Visto","notificacion","visto",false,FM_TYPE_INT,11,null,false);
		}
		return self::$FM;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
		}
		return self::$KM;
	}

}

?>