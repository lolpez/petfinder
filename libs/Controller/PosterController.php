<?php
/** @package    PETFINDER::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Poster.php");
require_once("Model/Mascota.php");
require_once("Model/Imagen.php");

/**
 * PosterController is the controller class for the Poster object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package PETFINDER::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class PosterController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 *
	 * @inheritdocs
	 */
	protected function Init()
	{
		parent::Init();

		// TODO: add controller-wide bootstrap code
		
		// TODO: if authentiation is required for this entire controller, for example:
		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	/**
	 * Displays a list view of Poster objects
	 */
	public function ListView()
	{
		$this->Render();
	}

    public function Listar()
    {
        echo json_encode($this->Phreezer->Query('PosterReporter')->ToObjectArray(true, $this->SimpleObjectParams()));
    }

    public function Nuevo(){
        $this->Assign('tipo_mascotas',$this->Phreezer->Query('TipoMascota')->ToObjectArray(true, $this->SimpleObjectParams()));
        $this->Assign('razas',$this->Phreezer->Query('Raza')->ToObjectArray(true, $this->SimpleObjectParams()));
        $this->Assign('tipo_posters',$this->Phreezer->Query('TipoPoster')->ToObjectArray(true, $this->SimpleObjectParams()));
        $this->Render('PosterNuevo');
    }

    public function Ver(){
        $criteria = new PosterCriteria();
        $criteria->Pkposter_Equals = $this->GetRouter()->GetUrlParam('pkposter');
        $this->Assign('poster',$this->Phreezer->GetByCriteria('PosterReporter',$criteria)->ToObject());
        $this->Render('PosterVer');
    }

    public function Guardar(){
		//echo json_encode($_POST);
		//Insertar la mascota
	    $mascota = new Mascota($this->Phreezer);
        $mascota->Nombre = $_POST['nombre'];
        $mascota->Genero = $_POST['genero'];
        $mascota->Tamano = $_POST['tamano'];
        $mascota->Color = $_POST['color'];
        $mascota->FktipoMascota = $_POST['pktipo_mascota'];
        $mascota->Fkraza = $_POST['pkraza'];
        $mascota->Validate();
        if (count($mascota->GetValidationErrors()) > 0)
        {
            echo 0;
        }
        else
        {
            $mascota->Save();
        }

        //Insertar poster
        $poster = new Poster($this->Phreezer);
        date_default_timezone_set("America/La_Paz");
        $poster->Fkusuario = $_POST['pkusuario'];
        $poster->Fkmascota = $mascota->Pkmascota;
        $poster->FktipoPoster = $_POST['pktipo_poster'];
        $poster->Latitud = $_POST['latitud'];
        $poster->Longitud = $_POST['longitud'];
        $poster->Recompensa = $_POST['recompensa'];
        $poster->TipoMoneda = $_POST['tipo_moneda'];
        $poster->Descripcion = $_POST['descripcion'];
        $poster->Fecha = date("d/m/Y");
        $poster->Hora = date("h:i:s");
        $poster->Validate();

        if (count($poster->GetValidationErrors()) > 0)
        {
            //Rollback
            $mascota->Delete();
            echo 0;
        }
        else
        {
            $poster->Save();
            //Insertar imagen
			$imagen = new Imagen($this->Phreezer);
			$imagen->Fkposter = $poster->Pkposter;
			if (isset($_FILES["imagen"])){
				if ($_FILES["imagen"]['size'] > 0) {
					$extencion = pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
					$imagen->Ruta = "resources/images/pets/".$imagen->Fkposter.".".$extencion;
					move_uploaded_file($_FILES['imagen']['tmp_name'],  $imagen->Ruta);
				}else{
					$imagen->Ruta = '';
				}
			}else{
                $imagen->Ruta = '';
            }
			$imagen->Validate();
			if (count($imagen->GetValidationErrors()) > 0)
			{
                //Rollback
                $poster->Delete();
                $mascota->Delete();
				echo 0;
			}
			else
			{
				$imagen->Save();
				echo $poster->Pkposter;
			}
        }
    }

	/**
	 * API Method queries for Poster records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new PosterCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Pkposter,Fkusuario,Fkmascota,FktipoPoster,Latitud,Longitud,Recompensa,TipoMoneda,Descripcion,Fecha,Hora,Mascota_nombre,Mascota_genero,Mascota_tamano,Mascota_color,Mascota_estado,TipoMascota_nombre,Raza_nombre,Usuario_nombre'
				, '%'.$filter.'%')
			);

			// TODO: this is generic query filtering based only on criteria properties
			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					// this is a convenience so that the _Equals suffix is not needed
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

			// if a sort order was specified then specify in the criteria
 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				// if page is specified, use this instead (at the expense of one extra count query)
				$pagesize = $this->GetDefaultPageSize();

				$posters = $this->Phreezer->Query('PosterReporter',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $posters->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $posters->TotalResults;
				$output->totalPages = $posters->TotalPages;
				$output->pageSize = $posters->PageSize;
				$output->currentPage = $posters->CurrentPage;
			}
			else
			{
				// return all results
				$posters = $this->Phreezer->Query('PosterReporter',$criteria);
				$output->rows = $posters->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method retrieves a single Poster record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('pkposter');
			$poster = $this->Phreezer->Get('Poster',$pk);
			$this->RenderJSON($poster, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Poster record and render response as JSON
	 */
	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$poster = new Poster($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $poster->Pkposter = $this->SafeGetVal($json, 'pkposter');
            date_default_timezone_set("America/La_Paz");
			$poster->Fkusuario = $this->SafeGetVal($json, 'fkusuario');
			$poster->Fkmascota = $this->SafeGetVal($json, 'fkmascota');
			$poster->FktipoPoster = $this->SafeGetVal($json, 'fktipoPoster');
			$poster->Latitud = $this->SafeGetVal($json, 'latitud');
			$poster->Longitud = $this->SafeGetVal($json, 'longitud');
			$poster->Recompensa = $this->SafeGetVal($json, 'recompensa');
			$poster->TipoMoneda = $this->SafeGetVal($json, 'tipoMoneda');
			$poster->Descripcion = $this->SafeGetVal($json, 'descripcion');
			$poster->Fecha = date("d/m/Y");
			$poster->Hora = date("h:i:s");

			$poster->Validate();
			$errors = $poster->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$poster->Save();
				$this->RenderJSON($poster, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Poster record and render response as JSON
	 */
	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('pkposter');
			$poster = $this->Phreezer->Get('Poster',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $poster->Pkposter = $this->SafeGetVal($json, 'pkposter', $poster->Pkposter);
            date_default_timezone_set("America/La_Paz");
			$poster->Fkusuario = $this->SafeGetVal($json, 'fkusuario', $poster->Fkusuario);
			$poster->Fkmascota = $this->SafeGetVal($json, 'fkmascota', $poster->Fkmascota);
			$poster->FktipoPoster = $this->SafeGetVal($json, 'fktipoPoster', $poster->FktipoPoster);
			$poster->Latitud = $this->SafeGetVal($json, 'latitud', $poster->Latitud);
			$poster->Longitud = $this->SafeGetVal($json, 'longitud', $poster->Longitud);
			$poster->Recompensa = $this->SafeGetVal($json, 'recompensa', $poster->Recompensa);
			$poster->TipoMoneda = $this->SafeGetVal($json, 'tipoMoneda', $poster->TipoMoneda);
			$poster->Descripcion = $this->SafeGetVal($json, 'descripcion', $poster->Descripcion);
            $poster->Fecha = date("d/m/Y");
            $poster->Hora = date("h:i:s");

			$poster->Validate();
			$errors = $poster->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$poster->Save();
				$this->RenderJSON($poster, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Poster record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('pkposter');
			$poster = $this->Phreezer->Get('Poster',$pk);

			$poster->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>
