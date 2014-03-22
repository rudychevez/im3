@extends('layout.default')



@section('sidebar')
<h1>Driver License</h1>
@stop

@section('content')

{{ Session::get( 'message' ) }}


{{ Form::open ( array('url' => 'client/add-photo-driver-license/' . $IdClient, 'method' => 'post', 'enctype' => 'multipart/form-data' ) ) }}

<table cellpadding="0" cellspacing="0" align="center" width="400" border="0">
  <tr>
    <td>Select a file</td>
    <td>{{ Form::file('driver_license') }}</td>
    <td>{{ Form::submit ( 'Save') }}</td>
  </tr>
  @foreach ( $driver_license as $data )
  <tr>
    <td align="center"><a href="http://{{ $_SERVER['SERVER_NAME'] }}/driver_license/{{ $data->file_name }}"><img alt="Delete" src="http://{{ $_SERVER['SERVER_NAME'] }}/img/delete.png" height="15" width="15">{{ $data->id_driver_license }}</a></td>
    <td align="center" colspan="2"><a href="http://{{ $_SERVER['SERVER_NAME'] }}/driver_license/{{ $data->file_name }}" target="driver_license">{{ $data->file_name }}</a></td>
  </tr>
  @endforeach
</table>

{{ Form::close () }}

<br />

<iframe src="" style="border: 1px solid #CCDDEE; width:600px; height:400px; background: #FFFFFF;" name="driver_license"></iframe>


@stop