<?php
/** @package    petfinder::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Mascota.php");

/**
 * MascotaController is the controller class for the Mascota object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package petfinder::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class MascotaController extends AppBaseController
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
	 * Displays a list view of Mascota objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Mascota records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new MascotaCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Pkmascota,Nombre,Tamano,Color,Fkraza,FktipoMascota,Estado'
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

				$mascotas = $this->Phreezer->Query('Mascota',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $mascotas->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $mascotas->TotalResults;
				$output->totalPages = $mascotas->TotalPages;
				$output->pageSize = $mascotas->PageSize;
				$output->currentPage = $mascotas->CurrentPage;
			}
			else
			{
				// return all results
				$mascotas = $this->Phreezer->Query('Mascota',$criteria);
				$output->rows = $mascotas->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single Mascota record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('pkmascota');
			$mascota = $this->Phreezer->Get('Mascota',$pk);
			$this->RenderJSON($mascota, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Mascota record and render response as JSON
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

			$mascota = new Mascota($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $mascota->Pkmascota = $this->SafeGetVal($json, 'pkmascota');

			$mascota->Nombre = $this->SafeGetVal($json, 'nombre');
			$mascota->Tamano = $this->SafeGetVal($json, 'tamano');
			$mascota->Color = $this->SafeGetVal($json, 'color');
			$mascota->Fkraza = $this->SafeGetVal($json, 'fkraza');
			$mascota->FktipoMascota = $this->SafeGetVal($json, 'fktipoMascota');
			$mascota->Estado = $this->SafeGetVal($json, 'estado');

			$mascota->Validate();
			$errors = $mascota->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$mascota->Save();
				$this->RenderJSON($mascota, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Mascota record and render response as JSON
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

			$pk = $this->GetRouter()->GetUrlParam('pkmascota');
			$mascota = $this->Phreezer->Get('Mascota',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $mascota->Pkmascota = $this->SafeGetVal($json, 'pkmascota', $mascota->Pkmascota);

			$mascota->Nombre = $this->SafeGetVal($json, 'nombre', $mascota->Nombre);
			$mascota->Tamano = $this->SafeGetVal($json, 'tamano', $mascota->Tamano);
			$mascota->Color = $this->SafeGetVal($json, 'color', $mascota->Color);
			$mascota->Fkraza = $this->SafeGetVal($json, 'fkraza', $mascota->Fkraza);
			$mascota->FktipoMascota = $this->SafeGetVal($json, 'fktipoMascota', $mascota->FktipoMascota);
			$mascota->Estado = $this->SafeGetVal($json, 'estado', $mascota->Estado);

			$mascota->Validate();
			$errors = $mascota->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$mascota->Save();
				$this->RenderJSON($mascota, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Mascota record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('pkmascota');
			$mascota = $this->Phreezer->Get('Mascota',$pk);

			$mascota->Delete();

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
