<?php

$years = array_combine ( range ( date ( 'Y' ), 1947 ), range ( date ( 'Y' ), 1947 ) );

?>

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

<div class="row">
	<h5>Company: <span class="label label-default"><?php echo $insurance['company_name']?></span>,
	Tarifa: <span class="label label-default"><?php echo $insurance['rates_name']?></span>,
	Policy: <span class="label label-default"><?php echo $insurance['policy_number']?></span>,
	Comienza: <span class="label label-default"><?php echo $insurance['start_at']?></span>,
	Termina: <span class="label label-default"><?php echo $insurance['end_at']?></span></h5>
	<br />
	
</div>

@if ( Session::get ( 'message' ) != '' )
	<div class="alert alert-success">{{ Session::get ( 'message' ) }}</div>
@endif

<div class="row">
	<div class="col-md-5">
		{{ Form::open ( array('url' => action('InsuranceController@addVehicle', array ($IdClient, $IdInsurance)), 'method' => 'post')) }}
		{{ Form::hidden ( 'id_vehicle', $IdVehicle) }}
		<table>
			<tr>
				<td>{{ Form::label ( 'name', 'A&ntilde;o' ) }}</td>
				<td>{{ Form::select ( 'year', $years, $vehicle['year'], array( 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'year' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'make', 'Marca' ) }}</td>
				<td>{{ Form::select ( 'make', $make, $vehicle['make'], array( 'onchange' => 'getVehicleModel()', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'make' ) }}</td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'model', 'Modelo' ) }}</td>
				<td><div id="vehicle_model">{{ Form::select ( 'model', $model, $vehicle['model'], array( 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'model' ) }}</div></td>
			</tr>
			<tr>
				<td>{{ Form::label ( 'VIN', 'VIN' ) }}</td>
				<td>{{ Form::text ( 'VIN', $vehicle['VIN'], array ( 'size' => '18', 'class' => 'form-control' ) ) }}
				{{ $errors->first ( 'VIN' ) }}</td>
			</tr>
			<tr>
				<td colspan="2" align="center">{{ Form::submit ( 'Save', array ( 'class' => 'btn btn-default navbar-btn' ) ) }}</td>
			</tr>
		</table>
		{{ Form::close () }}
	</div>
	<div class="col-md-7">
		<?php if ($IdVehicle != '') :?>
		<div class="panel panel-default">
			<div class="panel-heading">Add Photos (.jpg)</div>
			<div class="panel-body">
			<?php
			echo Form::open (
				array (
					'url' => action('InsuranceController@addVehiclePhoto', array ($IdClient, $IdInsurance, $IdVehicle)),
					'method' => 'post',
					'enctype' => 'multipart/form-data',
					'class' => 'form-inline'
				)
			);?>
			<?php echo Form::file ('image_name');?>
			<?php echo Form::submit ('Save', array ('class' => 'btn btn-default'));?>
			<?php echo Form::close ();?>
			</div>
		</div>
		<?php endif;?>
	</div>
</div>
@stop