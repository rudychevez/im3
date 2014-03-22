<?php
class ClientController extends BaseController
{
	protected $layout           = 'layout.default';
	private $validateClientInfo = array (
			'client_name'    => 'required|max:35',
			'last_name'      => 'required|max:35',
			'telephone'      => 'required|max:10',
			'address'        => 'required|max:100',
			'telephone'      => 'required|max:10',
			'city'           => 'required|max:30',
			'state'          => 'required|max:2',
			'zip_code'       => 'required|max:30',
			'driver_license' => 'required|max:15'
	);
	
	public function searchClient()
	{
		$name = Input::get ( 'n' );
		if ($name != '') {
			$query = 'SELECT c.`id_client` AS `IdClient`, UPPER(c.`client_name`) AS `client_name`, UPPER(c.`last_name`) AS `lastName`, c.`telephone` AS `telephone` ';
			
			if (is_numeric ( $name )) {
				$clients = DB::select ( $query . 'FROM client c WHERE c.`telephone` = ? ORDER BY c.`client_name` LIMIT 10', array ( $name ) );
			} else {
				$clients = DB::select ( $query . 'FROM client c WHERE c.`client_name` LIKE ? ORDER BY c.`client_name` LIMIT 10', array ( '%' . $name . '%' ) );
				if ($clients == NULL) {
					// $clients = DB::select($query . ', MATCH (c.`name`) AGAINST (?) AS `match` '
					// . 'FROM client c WHERE MATCH (c.`name`) AGAINST (?) HAVING `match` > 5.2 ORDER BY c.`name` LIMIT 10', array($name, $name));
					// var_dump($clients);
				}
			}
			
			$this->layout->content = View::make ( 'client.search', array ( 'clients' => $clients ) );
		}
	}
	
	
	public function perfilClient($IdClient)
	{
		$data = array ();
		if (is_numeric ( $IdClient )) {
			$data ['client']  = Client::find ( $IdClient );
			$data ['vehicle'] = Client::find ( $IdClient )->vehicle;
			$data ['insurance'] = Insurance::select (
					'company.company_name',
					'rates.rates_name',
					'insurance.id_insurance',
					'insurance.policy_number',
					'insurance.start_at',
					'insurance.end_at'
				)->join ('rates', 'rates.id_rates', '=', 'insurance.id_rates')
				->join ('company', 'company.id_company', '=', 'insurance.id_company')
				->where ('insurance.id_client', '=', $IdClient)
				->get ();
			
			if ($data != NULL) {
				$this->layout->content = View::make ( 'client.client', array ( 'data' => $data ) );
			} else {
				echo 'cliente no existe';
			}
		}
	}
	
	
	public function addClient()
	{
		$input = Input::all();
		
		if (Input::all () != NULL) {
		
			$validator = Validator::make ( $input, $this->validateClientInfo );
			
			if ($validator->fails ()) {
				return Redirect::to ( 'client/add' )->withErrors ( $validator )->WithInput ();
			} else {
				$client   = Client::create($input);
				$IdClient = $client->id_client;
				
				return Redirect::to ( 'client/perfil/' . $IdClient )->with ( 'message', 'Client added' );
			}
		} else {
			$this->layout->content = View::make ( 'client.client' );
		}
	}
	
	
	public function editClient()
	{
		$input = Input::except ( '_token' );
		$IdClient = Input::get ( 'id_client' );
		
		if ($input != NULL) {
			
			$validator = Validator::make ( $input, $this->validateClientInfo );
			
			if ($validator->fails ()) {
				return Redirect::to ( 'client/perfil/' . $IdClient )->withErrors ( $validator )->WithInput ();
			} else {
				$client = Client::where ( 'id_client', $IdClient )->update ( $input );
				
				return Redirect::to ( 'client/perfil/' . $IdClient )->with ( 'message', 'Done' );
			}
		} else {
			$this->layout->content = View::make ( 'client.client' );
		}
	}
}
?>