<?php
/** @package    Petfinder::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Afiliado object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Petfinder::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class AfiliadoReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `afiliado` table
	public $CustomFieldExample;

	public $Pkafiliado;
	public $Nombre;
	public $Direccion;
	public $Latitud;
	public $Longitud;
	public $Telefono;
	public $Descripcion;
	public $Fkusuario;
	public $Plan;

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
			'custom value here...' as CustomFieldExample
			,`afiliado`.`pkafiliado` as Pkafiliado
			,`afiliado`.`nombre` as Nombre
			,`afiliado`.`direccion` as Direccion
			,`afiliado`.`latitud` as Latitud
			,`afiliado`.`longitud` as Longitud
			,`afiliado`.`telefono` as Telefono
			,`afiliado`.`descripcion` as Descripcion
			,`afiliado`.`fkusuario` as Fkusuario
			,`afiliado`.`plan` as Plan
		from `afiliado`";

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
		$sql = "select count(1) as counter from `afiliado`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>