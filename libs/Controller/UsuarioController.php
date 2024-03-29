<?php
/** @package    PETFINDER::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Usuario.php");

/**
 * UsuarioController is the controller class for the Usuario object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package PETFINDER::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class UsuarioController extends AppBaseController
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
	 * Displays a list view of Usuario objects
	 */
	public function ListView()
	{
		$this->Render();
	}

    public function Nuevo(){
        $this->Render('UsuarioNuevo');
    }

    public function Guardar(){
        //Insertar poster
        $usuario = new Usuario($this->Phreezer);
        $usuario->Nombre = $_POST['nombre'];
        $usuario->GcmId = $_POST['gcm_id'];
        $usuario->Email = $_POST['email'];
        $usuario->Nrotelefono = $_POST['nro_telefono'];
        $usuario->IdFacebook = $_POST['id_facebook'];
        $usuario->Validate();
		$errors = $usuario->GetValidationErrors();
		require_once 'Model/UsuarioCriteria.php';
		//Verificar que el codigo facebook sea unico
		$criteria = new UsuarioCriteria();
		$criteria->IdFacebook_Equals = $usuario->IdFacebook;
		$resultado = $this->Phreezer->Query('Usuario',$criteria)->ToObjectArray(true, $this->SimpleObjectParams());

		if (count($resultado) == 1){
			//El usuario ya existe
			echo $resultado[0]->pkusuario;
		}else{
			//Registrar nuevo
			if (count($errors) > 0)
			{
				echo 0;
			}
			else
			{
				$usuario->Save();
				echo $usuario->Pkusuario;
			}
		} 
    }

	/**
	 * API Method queries for Usuario records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new UsuarioCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Pkusuario,Nombre,GcmId,Email,Nrotelefono,IdFacebook'
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

				$usuarios = $this->Phreezer->Query('Usuario',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $usuarios->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $usuarios->TotalResults;
				$output->totalPages = $usuarios->TotalPages;
				$output->pageSize = $usuarios->PageSize;
				$output->currentPage = $usuarios->CurrentPage;
			}
			else
			{
				// return all results
				$usuarios = $this->Phreezer->Query('Usuario',$criteria);
				$output->rows = $usuarios->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single Usuario record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('pkusuario');
			$usuario = $this->Phreezer->Get('Usuario',$pk);
			$this->RenderJSON($usuario, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Usuario record and render response as JSON
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

			$usuario = new Usuario($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $usuario->Pkusuario = $this->SafeGetVal($json, 'pkusuario');

			$usuario->Nombre = $this->SafeGetVal($json, 'nombre');
			$usuario->GcmId = $this->SafeGetVal($json, 'gcmId');
			$usuario->Email = $this->SafeGetVal($json, 'email');
			$usuario->Nrotelefono = $this->SafeGetVal($json, 'nrotelefono');
			$usuario->IdFacebook = $this->SafeGetVal($json, 'idFacebook');
			$usuario->Validate();
			$errors = $usuario->GetValidationErrors();

            require_once 'Model/UsuarioCriteria.php';
            //Verificar que el codigo facebook sea unico
            $criteria = new UsuarioCriteria();
            $criteria->IdFacebook_Equals = $usuario->IdFacebook;
			$resultado = $this->Phreezer->Query('Usuario',$criteria)->ToObjectArray(true, $this->SimpleObjectParams());
			
			
			if (count($resultado) == 1){
				//El usuario ya existe
				$this->RenderErrorJSON('El ID de facebook '.$resultado[0]->idFacebook.' ya existe',$errors);
			}else{
				//Registrar nuevo
				if (count($errors) > 0)
				{
					$this->RenderErrorJSON('Please check the form for errors',$errors);
				}
				else
				{
					$usuario->Save();
					$this->RenderJSON($usuario, $this->JSONPCallback(), true, $this->SimpleObjectParams());
				}
			}       
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Usuario record and render response as JSON
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

			$pk = $this->GetRouter()->GetUrlParam('pkusuario');
			$usuario = $this->Phreezer->Get('Usuario',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $usuario->Pkusuario = $this->SafeGetVal($json, 'pkusuario', $usuario->Pkusuario);

			$usuario->Nombre = $this->SafeGetVal($json, 'nombre', $usuario->Nombre);
			$usuario->GcmId = $this->SafeGetVal($json, 'gcmId', $usuario->GcmId);
			$usuario->Email = $this->SafeGetVal($json, 'email', $usuario->Email);
			$usuario->Nrotelefono = $this->SafeGetVal($json, 'nrotelefono', $usuario->Nrotelefono);
			$usuario->IdFacebook = $this->SafeGetVal($json, 'idFacebook', $usuario->IdFacebook);

			$usuario->Validate();
			$errors = $usuario->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$usuario->Save();
				$this->RenderJSON($usuario, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Usuario record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('pkusuario');
			$usuario = $this->Phreezer->Get('Usuario',$pk);

			$usuario->Delete();

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
