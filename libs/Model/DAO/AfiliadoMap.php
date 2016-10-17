<?php
/** @package    Petfinder::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * AfiliadoMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the AfiliadoDAO to the afiliado datastore.
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
class AfiliadoMap implements IDaoMap, IDaoMap2
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
			self::$FM["Pkafiliado"] = new FieldMap("Pkafiliado","afiliado","pkafiliado",true,FM_TYPE_INT,11,null,true);
			self::$FM["Nombre"] = new FieldMap("Nombre","afiliado","nombre",false,FM_TYPE_VARCHAR,50,null,false);
			self::$FM["Direccion"] = new FieldMap("Direccion","afiliado","direccion",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Latitud"] = new FieldMap("Latitud","afiliado","latitud",false,FM_TYPE_VARCHAR,30,null,false);
			self::$FM["Longitud"] = new FieldMap("Longitud","afiliado","longitud",false,FM_TYPE_VARCHAR,30,null,false);
			self::$FM["Telefono"] = new FieldMap("Telefono","afiliado","telefono",false,FM_TYPE_VARCHAR,10,null,false);
			self::$FM["Descripcion"] = new FieldMap("Descripcion","afiliado","descripcion",false,FM_TYPE_TEXT,null,null,false);
			self::$FM["Fkusuario"] = new FieldMap("Fkusuario","afiliado","fkusuario",false,FM_TYPE_INT,11,null,false);
			self::$FM["Plan"] = new FieldMap("Plan","afiliado","plan",false,FM_TYPE_INT,11,null,false);
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