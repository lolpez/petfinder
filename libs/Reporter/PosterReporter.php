<?php
/** @package    Petfinder::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Poster object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Petfinder::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class PosterReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `poster` table
	public $Imagen;

	public $Pkposter;
	public $Fkusuario;
	public $Fkmascota;
	public $FktipoPoster;
	public $Latitud;
	public $Longitud;
	public $Recompensa;
	public $TipoMoneda;
	public $Descripcion;
	public $Fecha;
	public $Hora;
	public $Estado;

	/*
	* GetCustomQuery returns a fully formed SQL statement.  The result columns
	* must match with the properties of this reporter object.
	*
	* @see Reporter::GetCustomQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomQuery($criteria)
	{
		$sql = "select
			`imagen`.`ruta` as Imagen
			,`poster`.`pkposter` as Pkposter
			,`poster`.`fkusuario` as Fkusuario
			,`poster`.`fkmascota` as Fkmascota
			,`poster`.`fktipo_poster` as FktipoPoster
			,`poster`.`latitud` as Latitud
			,`poster`.`longitud` as Longitud
			,`poster`.`recompensa` as Recompensa
			,`poster`.`tipo_moneda` as TipoMoneda
			,`poster`.`descripcion` as Descripcion
			,`poster`.`fecha` as Fecha
			,`poster`.`hora` as Hora
		from `poster`
        inner join `imagen` on `poster`.`pkposter`=`imagen`.`fkposter`
        ";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();
		$sql .= $criteria->GetOrder();

		return $sql;
	}
	
	/*
	* GetCustomCountQuery returns a fully formed SQL statement that will count
	* the results.  This query must return the correct number of results that
	* GetCustomQuery would, given the same criteria
	*
	* @see Reporter::GetCustomCountQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomCountQuery($criteria)
	{
		$sql = "select count(1) as counter from `poster`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>