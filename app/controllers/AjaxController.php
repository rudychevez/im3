<?php
class AjaxController extends BaseController {
	
	public function getVehicleModel($vehicleMake)
	{
		$vehicleModel = VehicleModel::where ( 'make', '=', $vehicleMake )->orderBy ( 'model', 'ASC' )->get ();
		
		$model = array ();
		foreach ( $vehicleModel as $data ) {
			$model [$data->model] = $data->model;
		}
		
		echo Form::select ( 'model', $model, '', array( 'class' => 'form-control' ) );
	}
	
	public function getInsuranceRates($IdCompany)
	{
		$rates = Rates::getRatesForSelect ($IdCompany);
		echo Form::select ( 'id_rates', $rates, '', array( 'class' => 'form-control' ) );
	}
}