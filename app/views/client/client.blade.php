<?php

$state_list = array (
		''   => '',
		'AL' => 'Alabama',
		'AK' => 'Alaska',
		'AZ' => 'Arizona',
		'AR' => 'Arkansas',
		'CA' => 'California',
		'CO' => 'Colorado',
		'CT' => 'Connecticut',
		'DE' => 'Delaware',
		'DC' => 'District Of Columbia',
		'FL' => 'Florida',
		'GA' => 'Georgia',
		'HI' => 'Hawaii',
		'ID' => 'Idaho',
		'IL' => 'Illinois',
		'IN' => 'Indiana',
		'IA' => 'Iowa',
		'KS' => 'Kansas',
		'KY' => 'Kentucky',
		'LA' => 'Louisiana',
		'ME' => 'Maine',
		'MD' => 'Maryland',
		'MA' => 'Massachusetts',
		'MI' => 'Michigan',
		'MN' => 'Minnesota',
		'MS' => 'Mississippi',
		'MO' => 'Missouri',
		'MT' => 'Montana',
		'NE' => 'Nebraska',
		'NV' => 'Nevada',
		'NH' => 'New Hampshire',
		'NJ' => 'New Jersey',
		'NM' => 'New Mexico',
		'NY' => 'New York',
		'NC' => 'North Carolina',
		'ND' => 'North Dakota',
		'OH' => 'Ohio',
		'OK' => 'Oklahoma',
		'OR' => 'Oregon',
		'PA' => 'Pennsylvania',
		'RI' => 'Rhode Island',
		'SC' => 'South Carolina',
		'SD' => 'South Dakota',
		'TN' => 'Tennessee',
		'TX' => 'Texas',
		'UT' => 'Utah',
		'VT' => 'Vermont',
		'VA' => 'Virginia',
		'WA' => 'Washington',
		'WV' => 'West Virginia',
		'WI' => 'Wisconsin',
		'WY' => 'Wyoming' 
);


if (isset( $data )) {
	$clientName = $data['client']->client_name;
	$lastName   = $data['client']->last_name;
	$address    = $data['client']->address;
	$city       = $data['client']->city;
	$state      = $data['client']->state;
	$zipCode    = $data['client']->zip_code;
	$telephone  = $data['client']->telephone;
	$url        = 'client/edit';
	$IdClient   = $data['client']->id_client;
	$driverLicense = $data['client']->driver_license;

} else {
	$clientName = Input::old ( 'client_name' );
	$lastName   = Input::old ( 'last_name' );
	$address    = Input::old ( 'address' );
	$city       = Input::old ( 'city' );
	$state      = Input::old ( 'state' );
	$zipCode    = Input::old ( 'zip_code' );
	$telephone  = Input::old ( 'telephone' );
	$url        = 'client/add';
	$IdClient   = '';
	$driverLicense = Input::old ( 'driver_license' );
}



?>


@extends('layout.default')


@section('sidebar')

<h1>add</h1>

@stop

@section('content')

@if ( Session::get( 'message' ) != '' )
<div class="alert-success">{{ Session::get( 'message' ) }}</div>
@endif


{{ Form::open ( array('url' => $url, 'method' => 'post')) }}

{{ Form::hidden ( 'id_client', $IdClient ) }}


<div class="row">

	<div class="col-md-5">

		<table>
			<tr>
				<td>{{ Form::label ( 'client_name', 'Name' ) }}</td>
				<td>{{ Form::text ( 'client_name', $clientName, array ( 'size' => '18', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'client_name' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'last_name', 'Last Name' ) }}</td>
				<td>{{ Form::text ( 'last_name', $lastName, array ( 'size' => '18', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'last_name' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'address', 'Address' ) }}</td>
				<td>{{ Form::text ( 'address', $address, array ( 'size' => '30', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'address' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'city', 'City' ) }}</td>
				<td>{{ Form::text ( 'city', $city, array ( 'size' => '15', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'city' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'state', 'State' ) }}</td>
				<td>{{ Form::select ( 'state', $state_list, $state, array ( 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'state' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'zip_code', 'Zip Code' ) }}</td>
				<td>{{ Form::text ( 'zip_code', $zipCode, array ( 'size' => '5', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'zip_code' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'telephone', 'Telephone' ) }}</td>
				<td>{{ Form::text ( 'telephone', $telephone, array ( 'size' => '10', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'telephone' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'driver_license', 'Driver License' ) }}</td>
				<td>{{ Form::text ( 'driver_license', $driverLicense, array ( 'size' => '15', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'driver_license' ) }}

				@if ($IdClient != '' )
					<a href="{{ action( 'DriverLicenseController@driverLicense', $IdClient ) }}">Add/Edit Foto</a>
				@endif
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">{{ Form::submit ( 'Save', array('class' => 'btn btn-default navbar-btn') ) }}</td>
			</tr>
		</table>

	</div>
	<div class="col-md-7">
		@if ( $IdClient != '' )
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo link_to_action('InsuranceController@insurance', 'Add Insurance', $IdClient);?></div>
			<table class="table">
				<tr>
					<th>Company</th>
					<th>Rates</th>
					<th>Policy Number</th>
					<th>Start At</th>
					<th>End At</th>
				</tr>
				<?php foreach ($data['insurance'] as $i) : ?>
				<tr>
					<td><?php echo link_to_action('InsuranceController@insurance', $i->company_name, array ($IdClient, $i->id_insurance));?></td>
					<td>{{ $i->rates_name }}</td>
					<td>{{ $i->policy_number }}</td>
					<td>{{ $i->start_at }}</td>
					<td>{{ $i->end_at }}</td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">Vehicles</div>
			<table class="table">
				<tr>
					<th>Marca</th>
					<th>Modelo</th>
					<th>VIN</th>
					<th>a&ntilde;o</th>
				</tr>
				<?php foreach ($data['vehicle'] as $vehicle) : ?>
				<tr>
					<td><?php echo link_to_action('InsuranceController@vehicle', $vehicle->make, array ($IdClient, $vehicle->id_insurance, $vehicle->id_vehicle));?></td>
					<td>{{ $vehicle->model }}</td>
					<td>{{ $vehicle->VIN }}</td>
					<td>{{ $vehicle->year }}</td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
		@endif
	</div>


</div>
{{ Form::close () }}

@stop
