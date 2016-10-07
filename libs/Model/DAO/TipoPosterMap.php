<?php
/** @package    Petfinder::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * TipoPosterMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the TipoPosterDAO to the tipo_poster datastore.
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
class TipoPosterMap implements IDaoMap, IDaoMap2
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
			self::$FM["PktipoPoster"] = new FieldMap("PktipoPoster","tipo_poster","pktipo_poster",true,FM_TYPE_INT,11,null,true);
			self::$FM["Nombre"] = new FieldMap("Nombre","tipo_poster","nombre",false,FM_TYPE_VARCHAR,30,null,false);
			self::$FM["Descripcion"] = new FieldMap("Descripcion","tipo_poster","descripcion",false,FM_TYPE_TEXT,null,null,false);
			self::$FM["Precio"] = new FieldMap("Precio","tipo_poster","precio",false,FM_TYPE_FLOAT,null,null,false);
			self::$FM["TipoMoneda"] = new FieldMap("TipoMoneda","tipo_poster","tipo_moneda",false,FM_TYPE_VARCHAR,30,null,false);
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