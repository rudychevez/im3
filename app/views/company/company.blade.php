<?php 

if ( isset( $rate ) ) {
	$ratesName = $rate->rates_name;
	$price       = $rate->price;
	$description = $rate->description;
} else {
	$ratesName = $price = $description = '';
}

?>
@extends('layout.default')


@section('sidebar')
<h1>Company</h1>
@stop

@section('content')


<div class="row">
	<div class="col-md-3">
		{{ Form::open ( array('url' => 'company/addCompany', 'method' => 'post')) }}
			{{ Form::label ( 'company_name', 'Company' ) }}
			{{ Form::text ( 'company_name', '', array ( 'size' => '20', 'class' => 'form-control' ) ) }}
			{{ $errors->first ( 'company_name' ) }}
			
			{{ Form::submit ( 'Add', array ( 'class' => 'form-control' ) ) }}
		{{ Form::close () }}
		<br />
		<ul class="list-group">
			@foreach ( $company as $c )
				<?php $activeClass = ( $IdCompany == $c->id_company ) ? ' active' : ''; ?>
  				<li class="list-group-item{{ $activeClass }}">{{ link_to ( 'company/' . $c->id_company, $c->company_name) }}</li>
  			@endforeach
		</ul>
		
	</div>
	<div class="col-md-9">
	
		@if ( $IdCompany != '' )
		
			{{ Form::open ( array('url' => 'company/addRates', 'method' => 'post')) }}
			
			@if ( isset ( $rate->id_rates ) )
				{{ Form::hidden ( 'id_rates', $rate->id_rates ) }}
			@endif
			
			{{ Form::hidden ( 'id_company', $IdCompany ) }}
			<table>
				<tr>
					<td>{{ Form::label ( 'rates_name', 'Name' ) }}</td>
					<td>{{ Form::text ( 'rates_name', $ratesName, array ( 'size' => '18' ) ) }}
					{{ $errors->first ( 'rates_name' ) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label ( 'price', 'Price' ) }}</td>
					<td>{{ Form::text ( 'price', $price, array ( 'size' => '18' ) ) }}
					{{ $errors->first ( 'price' ) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label ( 'description', 'Description' ) }}</td>
					<td>{{ Form::textarea ( 'description', $description, array ( 'rows' => '5' ) ) }}
					{{ $errors->first ( 'description' ) }}</td>
				</tr>
				<tr>
					<td colspan="2">{{ Form::submit ( 'Save') }}</td>
				</tr>
			</table>
			{{ Form::close () }}
			
		@endif
		
		@if ( isset ( $rates ) )
		
			<table class="table">
				<tr>
					<th>Name</th>
					<th>Price</th>
					<th>Description</th>
				</tr>
				
			@foreach ( $rates as $r )
			
				<tr>
					<td>{{ link_to( 'company/' . $IdCompany . '/' . $r->id_rates, $r->rates_name ) }}</td>
					<td>{{ $r->price }}</td>
					<td>{{ $r->description }}</td>
				</tr>
				
			@endforeach
			
			</table>
		
		@endif
		
	</div>
</div>

@stop