<?php
class VehicleController extends BaseController
{
	protected $layout         = 'layout.default';
	private $validateVechicle = array (
			'make'  => array ( 'required' ),
			'model' => array ( 'required' ),
			'VIN'   => array ( 'required' ),
			'year'  => array ( 'required' )
	);
	private $validateInsurance = array (
			'id_company' => 'required|numeric',
			'id_rates'   => 'required|numeric',
			'policy_number' => 'required',
			'start_at'   => 'required|date_format:m/d/Y',
			'end_at'     => 'required|date_format:m/d/Y|after:now',
		);
	
	public function vehicle($IdClient)
	{

		$data                = array();
		$data['IdClient']    = $IdClient;
		$data['vehicleMake'] = VehicleMake::all();
		
		if (Input::old ( 'make' ) != '') {
			
			$vehicleMake = Input::old ( 'make' );
			
			$data['vehicleModel'] = VehicleModel::where ( 'make', '=', $vehicleMake )->orderBy( 'model', 'ASC' )->get();
		}
		
		$this->layout->layoutDefaultScriptTag = array ( 'vehicle' );
		$this->layout->content  = View::make ( 'client.vehicle', $data );
	}
	
	public function addVehicle ($IdClient)
	{
		$input = Input::all();
		$IdVehicle = Input::get ( 'id_vehicle' );
		$redirectTo = ( $IdVehicle != '' ) ? 'vehicle/' . $IdClient . '/' . $IdVehicle : 'vehicle/' . $IdClient;
		
		if (Input::all () != NULL) {
		
			$validator = Validator::make ( $input, $this->validateVechicle );
				
			if ($validator->fails ()) {
				
				return Redirect::to ( $redirectTo )->withErrors ( $validator )->WithInput ();
				
			} else {
				
				if ( Input::get ( 'id_vehicle' ) != '' ) {
					Vehicle::find ( Input::get ( 'id_vehicle' ) )->update ($input);
					return Redirect::to ( $redirectTo )->with ( 'message', 'car updated' );
				} else {
				
					$input     = array_add ($input, 'id_client', $IdClient);
					$vehicle   = Vehicle::create ( $input );
					$IdVehicle = $vehicle->id_vehicle;
					return Redirect::to ( 'vehicle/' . $IdClient . '/' . $IdVehicle )->with ( 'message', 'car added' );
				}
			}
		} else {
			$this->layout->content = View::make ( 'client.client' );
		}
	}
	
	public function insurance ( $IdClient, $IdVehicle )
	{
		$data                      = array();
		$data ['vehicle']          = Vehicle::find( $IdVehicle );
		$data ['IdVehicle']        = $IdVehicle;
		$data ['vehicleMake']      = VehicleMake::all();
		$data ['vehicleModel']     = VehicleModel::where ( 'make', '=', $data['vehicle']->make )->orderBy( 'model', 'ASC' )->get();
		$data ['insuranceCompany'] = Company::getCompany();
		$data ['IdClient']         = $IdClient;
		$data ['currentInsurance'] = array (
				'id_insurance' => '',
				'id_rates' => '',
				'id_company' => '',
				'company_name' => '',
				'rates_name'   => '',
				'start_at'     => '',
				'end_at'       => '' 
		);
		
		foreach (Insurance::join('company', 'insurance.id_company', '=', 'company.id_company')
		    ->join('rates', 'insurance.id_rates', '=', 'rates.id_rates')
		    ->select('insurance.id_insurance', 'insurance.id_company', 'insurance.start_at', 'insurance.end_at', 'company.company_name', 'rates.rates_name', 'rates.id_rates')
		    ->where('insurance.id_vehicle', '=', $IdVehicle)
		    ->where('end_at', '>', date('Y-m-d'))
		    ->get()
		 as $c_i) {
			$data ['currentInsurance']['id_insurance'] = $c_i->id_insurance;
			$data ['currentInsurance']['id_company']   = $c_i->id_company;
			$data ['currentInsurance']['id_rates']     = $c_i->id_rates;
			$data ['currentInsurance']['company_name'] = $c_i->company_name;
			$data ['currentInsurance']['rates_name']   = $c_i->rates_name;
			$data ['currentInsurance']['start_at']     = $c_i->start_at;
			$data ['currentInsurance']['end_at']       = $c_i->end_at;
		}
		
		if ( Input::old ( 'id_company' ) != '' || $data ['currentInsurance']['id_company'] != '') {
			
			$IdCompany = Input::old( 'id_company' ) != '' ? Input::old( 'id_company' ) : $data ['currentInsurance']['id_company'];
			
			$data ['companyRates'] = Company::find( $IdCompany )->rates;
		}
		
		$this->layout->layoutDefaultScriptTag = array ( 'vehicle', 'jquery-ui-1.10.4.min' );
		$this->layout->layoutDefaultLinkTag = array ( 'start/jquery-ui-1.10.4.min' );
		$this->layout->content = View::make ( 'client.vehicle', $data );
	}
	
	public function addInsurance ( $IdClient, $IdVehicle )
	{
		$input = Input::all();
		$input = array_add($input, 'id_vehicle', $IdVehicle);
		
		if (Input::all () != NULL) {
		
			$validator = Validator::make ( $input, $this->validateInsurance );
				
			if ($validator->fails ()) {
				
				return Redirect::to ( 'vehicle/' . $IdClient . '/' . $IdVehicle )->withErrors ( $validator )->WithInput ();
				
			} else {
				
				Insurance::create ( $input );
				return Redirect::to ( 'vehicle/' . $IdClient . '/' . $IdVehicle )->with ( 'message', 'insurance added' );
			}
		} else {
			$this->layout->content = View::make ( 'client.client' );
		}
	}
}