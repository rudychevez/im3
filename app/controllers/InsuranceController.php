<?php

class InsuranceController extends BaseController
{
	private $validateInsurance = array (
		'id_company' => 'required|numeric',
		'id_rates'   => 'required|numeric',
		'policy_number' => 'required',
		'start_at'   => 'required|date_format:m/d/Y',
		'end_at'     => 'required|date_format:m/d/Y|after:now',
	);
	private $validateVechicle = array (
			'make'  => array ( 'required' ),
			'model' => array ( 'required' ),
			'VIN'   => array ( 'required' ),
			'year'  => array ( 'required' )
	);
	private $validateVehiclePhoto = array(
			'image_name' => 'mimes:jpeg|size:2024'
	);
	
	protected $layout           = 'layout.default';
	
	public function nearExpire($beforeDays = 3)
	{
		if ($beforeDays <= 30 && $beforeDays > 3) {
			$before = date('Y-m-d', strtotime('now ' . $beforeDays . ' days'));
		} else {
			$before = date('Y-m-d', strtotime('now + 3 days'));
		}
		
		$today = date('Y-m-d');
		$data = array();
		$data['beforeDays'] = $beforeDays;
		$data['data'] = Insurance::join('vehicle', 'insurance.id_vehicle', '=', 'vehicle.id_vehicle')
			->join('client', 'vehicle.id_client', '=', 'client.id_client')
			->select(
					'client.client_name',
					'client.last_name',
					'client.id_client',
					'vehicle.id_vehicle',
					'vehicle.make',
					'vehicle.model',
					'vehicle.year',
					'vehicle.VIN',
					'insurance.end_at')
			->whereBetween('insurance.end_at', array($today, $before))
			->get();
		
		return View::make('insurance.near_expire', $data);
	}
	
	public function insurance ($IdClient, $IdInsurance = '')
	{
		$data               = array();
		$data ['company']   = Company::getCompany();
		$data ['IdClient']  = $IdClient;
		$data ['IdInsurance']  = $IdInsurance;
		$data ['clientName'] = Client::getClientName ($IdClient);
		
		$data ['vehicle']   = array();
		
		if ($IdInsurance) {
			$data ['vehicle'] = Insurance::find ($IdInsurance)->vehicle;
		}
		
		$data ['insurance'] = array (
			'id_insurance'  => '',
			'id_rates'      => '',
			'id_company'    => '',
			'company_name'  => '',
			'rates_name'    => '',
			'policy_number' => '',
			'start_at'      => '',
			'end_at'        => ''
		);
		
		if ($IdInsurance != '') {
			$insurance = Insurance::find ($IdInsurance);
			$data ['insurance'] = array (
				'id_insurance'  => $insurance->id_insurance,
				'id_rates'      => $insurance->id_rates,
				'id_company'    => $insurance->id_company,
				'company_name'  => $insurance->company_name,
				'rates_name'    => $insurance->rates_name,
				'policy_number' => $insurance->policy_number,
				'start_at'      => $insurance->start_at,
				'end_at'        => $insurance->end_at
			);
		}
		
		$data ['rates']     = array();
		
		if (Input::old ('id_company') != '' || $data ['insurance']['id_company'] != '') {
			$IdCompany = $data ['insurance']['id_company'] != '' ? $data ['insurance']['id_company'] : Input::old ('id_company');
			$data ['rates'] = Rates::getRatesForSelect ($IdCompany);
		}
		
		$this->layout->layoutDefaultScriptTag = array ( 'vehicle', 'jquery-ui-1.10.4.min' );
		$this->layout->layoutDefaultLinkTag = array ( 'start/jquery-ui-1.10.4.min' );
		$this->layout->content = View::make ( 'insurance.insurance', $data );
	}
	
	public function addInsurance ($IdClient)
	{
		$input = Input::all();
		
		if (Input::all () != NULL) {
		
			$validator = Validator::make ( $input, $this->validateInsurance );
				
			if ($validator->fails ()) {
				
				return Redirect::to ( 'insurance/' . $IdClient )->withErrors ( $validator )->WithInput ();
				
			} else {
				$input     = array_add($input, 'id_client', $IdClient);
				$insurance = Insurance::create ( $input );
				return Redirect::to ( 'insurance/' . $IdClient . '/' . $insurance->id_insurance )->with ( 'message', 'insurance added' );
			}
		} else {
			$this->layout->content = View::make ( 'client.client' );
		}
	}
	
	public function vehicle ($IdClient, $IdInsurance, $IdVehicle = '')
	{

		$data                = array();
		$data ['IdClient']    = $IdClient;
		$data ['IdVehicle']    = $IdVehicle;
		$data ['IdInsurance']    = $IdInsurance;
		$data ['clientName'] = Client::getClientName ($IdClient);
		$data ['make'] = VehicleMake::getMake ();
		$data ['model'] = array();
		$data ['insurancedVehicle'] = Insurance::find ($IdInsurance)->vehicle;
		$data ['vehicle'] = array ('year' => '', 'make' => '', 'model' => '', 'VIN' => '');

		if ($IdVehicle != '') {
			$vehicle = Vehicle::find ($IdVehicle);
			$data ['vehicle'] = array (
				'year' => $vehicle->year,
				'make' => $vehicle->make,
				'model' => $vehicle->model,
				'VIN' => $vehicle->VIN
			);
		}
		
		foreach (Insurance::find($IdInsurance)->select ('company.company_name', 'rates.rates_name', 'insurance.policy_number', 'insurance.start_at', 'insurance.end_at')
			->join('rates', 'rates.id_rates', '=', 'insurance.id_rates')
			->join('company', 'company.id_company', '=', 'insurance.id_company')
			->where ('id_insurance', '=', $IdInsurance)
			->get() as $i) {
			$data ['insurance'] = array(
				'company_name'  => $i->company_name,
				'rates_name'    => $i->rates_name,
				'policy_number' => $i->policy_number,
				'start_at'      => $i->start_at,
				'end_at'        => $i->end_at
			);
		}
		
		if (Input::old ( 'make' ) != '' || $data ['vehicle']['make'] != '') {
			
			$vehicleMake = Input::old ('make') != '' ? Input::old ( 'make' ) : $data ['vehicle']['make'];
			
			$data['model'] = VehicleModel::where ( 'make', '=', $vehicleMake )->orderBy( 'model', 'ASC' )->lists ('model', 'model');
		}
		
		$this->layout->layoutDefaultScriptTag = array ( 'vehicle' );
		$this->layout->content  = View::make ( 'insurance.vehicle', $data );
	}
	
	public function addVehicle ($IdClient, $IdInsurance, $IdVehicle = '')
	{
		$input = Input::all();
		$IdVehicle = Input::get ( 'id_vehicle' );
		
		if (Input::all () != null) {
		
			$validator = Validator::make ( $input, $this->validateVechicle );
				
			if ($validator->fails ()) {
				
				return Redirect::to (action ('InsuranceController@vehicle', array ($IdClient, $IdInsurance, $IdVehicle)))->withErrors ( $validator )->WithInput ();
				
			} else {
				
				if ( Input::get ( 'id_vehicle' ) != '' ) {
					Vehicle::find ( Input::get ( 'id_vehicle' ) )->update ($input);
					return Redirect::to (action ('InsuranceController@insurance', array ($IdClient, $IdInsurance)))->with ('message', 'car updated');
				} else {
				
					$input     = array_add ($input, 'id_client', $IdClient);
					$input     = array_add ($input, 'id_insurance', $IdInsurance);
					$vehicle   = Vehicle::create ( $input );
					$IdVehicle = $vehicle->id_vehicle;
					return Redirect::to (action ('InsuranceController@insurance', array ($IdClient, $IdInsurance)))->with ( 'message', 'car added' );
				}
			}
		} else {
			$this->layout->content = View::make ( 'client.client' );
		}
	}
	
	public function addVehiclePhoto ($IdClient, $IdInsurance, $IdVehicle)
	{
		$input = Input::all ();
		
		$validator = Validator::make ($input, $this->validateVehiclePhoto);
		
		if ($validator->fails ()) {
			return Redirect::to (action ('InsuranceController@vehicle', array ($IdClient, $IdInsurance, $IdVehicle)))->withErrors ( $validator )->WithInput ();
		} else {
			$fileName = str_random(12);
			$input['image_name'] = $fileName . '.jpg';
			$input = array_add($input, 'id_table', $IdVehicle);
			$input = array_add($input, 'table_name', 'vehicle');
		}
	}
}