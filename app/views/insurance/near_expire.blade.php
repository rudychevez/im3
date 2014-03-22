@extends('layout.default')

<?php

$selectDaysBefore = array(3 => '3 days', 7 => '1 Week', 14 => '2 Weeks', 30 => '1 Month')

?>

@section('sidebar')
<h1>Usuarios</h1>
@stop

@section('content')

<?php echo Form::select('before_days', $selectDaysBefore, $beforeDays, array('onchange' => 'chgLocation( this.value )'))?>

<script type="text/javascript">
<!--
function chgLocation (v) {
	window.location = '/insurance-near-expire/' + v;
}
//-->
</script>

<table class="table">
    <tr>
        <th>Name</th>
        <th>Last Name</th>
        <th>Make</th>
        <th>Model</th>
        <th>Year</th>
        <th>VIN</th>
        <th>Fecha</th>
    </tr>
  @foreach($data as $d)
    <tr>
        <td>{{ link_to('vehicle/' . $d->id_client . '/' . $d->id_vehicle, $d->client_name) }}</td>
        <td>{{ link_to('vehicle/' . $d->id_client . '/' . $d->id_vehicle, $d->last_name) }}</td>
        <td>{{ $d->make }}</td>
        <td>{{ $d->model }}</td>
        <td>{{ $d->year }}</td>
        <td>{{ $d->VIN }}</td>
        <td>{{ $d->end_at }}</td>
    </tr>
  @endforeach
</table>
@stop