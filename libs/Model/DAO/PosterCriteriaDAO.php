<?php
/** @package    Petfinder::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/Criteria.php");

/**
 * PosterCriteria allows custom querying for the Poster object.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * Add any custom business logic to the ModelCriteria class which is extended from this class.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @inheritdocs
 * @package Petfinder::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class PosterCriteriaDAO extends Criteria
{

	public $Pkposter_Equals;
	public $Pkposter_NotEquals;
	public $Pkposter_IsLike;
	public $Pkposter_IsNotLike;
	public $Pkposter_BeginsWith;
	public $Pkposter_EndsWith;
	public $Pkposter_GreaterThan;
	public $Pkposter_GreaterThanOrEqual;
	public $Pkposter_LessThan;
	public $Pkposter_LessThanOrEqual;
	public $Pkposter_In;
	public $Pkposter_IsNotEmpty;
	public $Pkposter_IsEmpty;
	public $Pkposter_BitwiseOr;
	public $Pkposter_BitwiseAnd;
	public $Fkusuario_Equals;
	public $Fkusuario_NotEquals;
	public $Fkusuario_IsLike;
	public $Fkusuario_IsNotLike;
	public $Fkusuario_BeginsWith;
	public $Fkusuario_EndsWith;
	public $Fkusuario_GreaterThan;
	public $Fkusuario_GreaterThanOrEqual;
	public $Fkusuario_LessThan;
	public $Fkusuario_LessThanOrEqual;
	public $Fkusuario_In;
	public $Fkusuario_IsNotEmpty;
	public $Fkusuario_IsEmpty;
	public $Fkusuario_BitwiseOr;
	public $Fkusuario_BitwiseAnd;
	public $Fkmascota_Equals;
	public $Fkmascota_NotEquals;
	public $Fkmascota_IsLike;
	public $Fkmascota_IsNotLike;
	public $Fkmascota_BeginsWith;
	public $Fkmascota_EndsWith;
	public $Fkmascota_GreaterThan;
	public $Fkmascota_GreaterThanOrEqual;
	public $Fkmascota_LessThan;
	public $Fkmascota_LessThanOrEqual;
	public $Fkmascota_In;
	public $Fkmascota_IsNotEmpty;
	public $Fkmascota_IsEmpty;
	public $Fkmascota_BitwiseOr;
	public $Fkmascota_BitwiseAnd;
	public $FktipoPoster_Equals;
	public $FktipoPoster_NotEquals;
	public $FktipoPoster_IsLike;
	public $FktipoPoster_IsNotLike;
	public $FktipoPoster_BeginsWith;
	public $FktipoPoster_EndsWith;
	public $FktipoPoster_GreaterThan;
	public $FktipoPoster_GreaterThanOrEqual;
	public $FktipoPoster_LessThan;
	public $FktipoPoster_LessThanOrEqual;
	public $FktipoPoster_In;
	public $FktipoPoster_IsNotEmpty;
	public $FktipoPoster_IsEmpty;
	public $FktipoPoster_BitwiseOr;
	public $FktipoPoster_BitwiseAnd;
	public $Latitud_Equals;
	public $Latitud_NotEquals;
	public $Latitud_IsLike;
	public $Latitud_IsNotLike;
	public $Latitud_BeginsWith;
	public $Latitud_EndsWith;
	public $Latitud_GreaterThan;
	public $Latitud_GreaterThanOrEqual;
	public $Latitud_LessThan;
	public $Latitud_LessThanOrEqual;
	public $Latitud_In;
	public $Latitud_IsNotEmpty;
	public $Latitud_IsEmpty;
	public $Latitud_BitwiseOr;
	public $Latitud_BitwiseAnd;
	public $Longitud_Equals;
	public $Longitud_NotEquals;
	public $Longitud_IsLike;
	public $Longitud_IsNotLike;
	public $Longitud_BeginsWith;
	public $Longitud_EndsWith;
	public $Longitud_GreaterThan;
	public $Longitud_GreaterThanOrEqual;
	public $Longitud_LessThan;
	public $Longitud_LessThanOrEqual;
	public $Longitud_In;
	public $Longitud_IsNotEmpty;
	public $Longitud_IsEmpty;
	public $Longitud_BitwiseOr;
	public $Longitud_BitwiseAnd;
	public $Recompensa_Equals;
	public $Recompensa_NotEquals;
	public $Recompensa_IsLike;
	public $Recompensa_IsNotLike;
	public $Recompensa_BeginsWith;
	public $Recompensa_EndsWith;
	public $Recompensa_GreaterThan;
	public $Recompensa_GreaterThanOrEqual;
	public $Recompensa_LessThan;
	public $Recompensa_LessThanOrEqual;
	public $Recompensa_In;
	public $Recompensa_IsNotEmpty;
	public $Recompensa_IsEmpty;
	public $Recompensa_BitwiseOr;
	public $Recompensa_BitwiseAnd;
	public $TipoMoneda_Equals;
	public $TipoMoneda_NotEquals;
	public $TipoMoneda_IsLike;
	public $TipoMoneda_IsNotLike;
	public $TipoMoneda_BeginsWith;
	public $TipoMoneda_EndsWith;
	public $TipoMoneda_GreaterThan;
	public $TipoMoneda_GreaterThanOrEqual;
	public $TipoMoneda_LessThan;
	public $TipoMoneda_LessThanOrEqual;
	public $TipoMoneda_In;
	public $TipoMoneda_IsNotEmpty;
	public $TipoMoneda_IsEmpty;
	public $TipoMoneda_BitwiseOr;
	public $TipoMoneda_BitwiseAnd;
	public $Descripcion_Equals;
	public $Descripcion_NotEquals;
	public $Descripcion_IsLike;
	public $Descripcion_IsNotLike;
	public $Descripcion_BeginsWith;
	public $Descripcion_EndsWith;
	public $Descripcion_GreaterThan;
	public $Descripcion_GreaterThanOrEqual;
	public $Descripcion_LessThan;
	public $Descripcion_LessThanOrEqual;
	public $Descripcion_In;
	public $Descripcion_IsNotEmpty;
	public $Descripcion_IsEmpty;
	public $Descripcion_BitwiseOr;
	public $Descripcion_BitwiseAnd;
	public $Fecha_Equals;
	public $Fecha_NotEquals;
	public $Fecha_IsLike;
	public $Fecha_IsNotLike;
	public $Fecha_BeginsWith;
	public $Fecha_EndsWith;
	public $Fecha_GreaterThan;
	public $Fecha_GreaterThanOrEqual;
	public $Fecha_LessThan;
	public $Fecha_LessThanOrEqual;
	public $Fecha_In;
	public $Fecha_IsNotEmpty;
	public $Fecha_IsEmpty;
	public $Fecha_BitwiseOr;
	public $Fecha_BitwiseAnd;
	public $Hora_Equals;
	public $Hora_NotEquals;
	public $Hora_IsLike;
	public $Hora_IsNotLike;
	public $Hora_BeginsWith;
	public $Hora_EndsWith;
	public $Hora_GreaterThan;
	public $Hora_GreaterThanOrEqual;
	public $Hora_LessThan;
	public $Hora_LessThanOrEqual;
	public $Hora_In;
	public $Hora_IsNotEmpty;
	public $Hora_IsEmpty;
	public $Hora_BitwiseOr;
	public $Hora_BitwiseAnd;

}

?>