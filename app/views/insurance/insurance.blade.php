@extends('layout.default')

@section('sidebar')
<h3><?php echo link_to_action('ClientController@perfilClient', $clientName, $IdClient);?></h3>
@stop

@section('content')

 <script type="text/javascript">
$(function() {
$( "#start_at, #end_at" ).datepicker();
});
</script>

@if ( Session::get ( 'message' ) != '' )
	<div class="alert alert-success">{{ Session::get ( 'message' ) }}</div>
@endif

<div class="row">
	<div class="col-md-5">
		{{ Form::open ( array('url' => 'insurance/' . $IdClient, 'method' => 'post')) }}
		<table>
			<tr>
				<td>{{ Form::label ( 'id_company', 'Company' ) }}</td>
				<td>{{ Form::select ( 'id_company', $company, $insurance['id_company'], array( 'onchange' => 'getInsuranceRates()', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'id_company' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'id_rates', 'Tarifa' ) }}</td>
				<td><div id="insurance_company">{{ Form::select ( 'id_rates', $rates, $insurance['id_rates'], array( 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'id_rates' ) }}</div></td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'policy_number', 'Policy Number' ) }}</td>
				<td>{{ Form::text ( 'policy_number', $insurance['policy_number'], array ( 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'policy_number' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'start_at', 'Comienza' ) }}</td>
				<td>{{ Form::text ( 'start_at', $insurance['start_at'], array ( 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'start_at' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'end_at', 'Termina' ) }}</td>
				<td>{{ Form::text ( 'end_at', $insurance['end_at'], array ( 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'end_at' ) }}</td>
			</tr>
			<tr>
				<td colspan="2" align="center">{{ Form::submit ( 'Save', array ( 'class' => 'btn btn-default navbar-btn' ) ) }}</td>
			</tr>
		</table>
		{{ Form::close () }}
	</div>
	<div class="col-md-7">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo link_to_action('InsuranceController@vehicle', 'Add Vehicle', array ($IdClient, $IdInsurance));?></div>
			<table class="table">
				<tr>
					<th>Marca</th>
					<th>Modelo</th>
					<th>VIN</th>
					<th>a&ntilde;o</th>
				</tr>
				<?php foreach ($vehicle as $v) : ?>
				<tr>
					<td><?php echo link_to_action('InsuranceController@vehicle', $v->make, array ($IdClient, $v->id_insurance, $v->id_vehicle));?></td>
					<td>{{ $v->model }}</td>
					<td>{{ $v->VIN }}</td>
					<td>{{ $v->year }}</td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
	</div>
</div>
@stop