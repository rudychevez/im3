<?php
class CompanyController extends BaseController
{
	protected $layout        = 'layout.default';
	private $validateCompany = array ( 'company_name' => 'required|max:30|min:3' );
	private $validateRates   = array (
			'rates_name'  => 'required|max:50',
			'price'       => 'required|max:9999|numeric',
			'description' => 'required|max:200',
	);
	
	public function company( $IdCompany = '', $IdRates = '' )
	{

		$data = array();
		$data ['company']   = Company::getCompany();
		if ($IdCompany != '') {
			$data ['rates']     = Company::find ( $IdCompany )->rates;
		}
		$data ['IdCompany'] = $IdCompany;
		
		if ( $IdRates != '' ) {
			$data ['rate'] = Rates::find ( $IdRates );
		}
	
		$this->layout->content  = View::make ( 'company.company', $data );
	}


	public function addCompany()
	{
	
		$data  = array();
		$input = Input::all();
		
		$validator = Validator::make ( $input, $this->validateCompany );
		
		if ( $validator->fails () ) {
			
			return Redirect::to ( 'company/' )->withErrors ( $validator )->WithInput ();
			
		} else {
			
			$input     = array_add( $input, 'id_branch', Auth::user()->id_branch );
			$company   = Company::create($input);
			$IdCompany = $company->id_company;
		
			return Redirect::to ( 'company/' . $IdCompany )->with ( 'message', 'Company added' );
		}
	
		$this->layout->content  = View::make ( 'company.company', $data );
	}

	public function addRates()
	{
	
		$data  = array();
		$input = Input::all();
		$IdCompany = Input::get ( 'id_company' );
		
		$validator = Validator::make ( $input, $this->validateRates );
	
		if ( $validator->fails () ) {
			
			return Redirect::to ( 'company/' . Input::get ( 'id_company' ) )->withErrors ( $validator )->WithInput ();
			
		} else {
			if ( Input::get ( 'id_rates' ) != '' ) {
				Rates::find (Input::get ( 'id_rates' ))->update ($input);
			} else  {
				$rates   = Rates::create($input);
				$IdRates = $rates->id_rates;
			}
	
			return Redirect::to ( 'company/' . $IdCompany )->with ( 'message', 'rates added' );
		}
	
		$this->layout->content  = View::make ( 'company.company', $data );
	}
}