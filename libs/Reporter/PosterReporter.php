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
    public $Mascota_nombre;
    public $Mascota_genero;
    public $Mascota_tamano;
    public $Mascota_color;
    public $Mascota_estado;
    public $TipoMascota_nombre;
    public $Raza_nombre;
    public $Usuario_nombre;
    public $Usuario_id_facebook;

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
			,`mascota`.`nombre` as Mascota_nombre
			,`mascota`.`genero` as Mascota_genero
			,`mascota`.`tamano` as Mascota_tamano
			,`mascota`.`color` as Mascota_color
			,`mascota`.`estado` as Mascota_estado
			,`tipo_mascota`.`nombre` as TipoMascota_nombre
			,`raza`.`nombre` as Raza_nombre
			,`usuario`.`nombre` as Usuario_nombre
			,`usuario`.`id_facebook` as Usuario_id_facebook

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
        inner join `mascota` on `poster`.`fkmascota`=`mascota`.`pkmascota`
        inner join `raza` on `mascota`.`fkraza`=`raza`.`pkraza`
        inner join `tipo_mascota` on `mascota`.`fktipo_mascota`=`tipo_mascota`.`pktipo_mascota`
        inner join `usuario` on `poster`.`fkusuario`=`usuario`.`pkusuario`
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
		$sql = "select count(1) as counter
                from `poster`
                inner join `imagen` on `poster`.`pkposter`=`imagen`.`fkposter`
                inner join `mascota` on `poster`.`fkmascota`=`mascota`.`pkmascota`
                inner join `raza` on `mascota`.`fkraza`=`raza`.`pkraza`
                inner join `tipo_mascota` on `mascota`.`fktipo_mascota`=`tipo_mascota`.`pktipo_mascota`
                inner join `usuario` on `poster`.`fkusuario`=`usuario`.`pkusuario`
              ";
		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
    }
}

?>