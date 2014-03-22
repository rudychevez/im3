@extends('layout.default')



@section('sidebar')
<h1>Usuarios</h1>
@stop

@section('content')

<table class="table">
  <tr>
    <th>Name</th>
    <th>Last Name</th>
    <th>Telephone</th>
  </tr>
  @foreach($clients as $client)
  <tr>
    <td><a href="{{action('ClientController@perfilClient', $client->IdClient)}}">{{$client->client_name}}</a></td>
    <td>{{$client->lastName}}</td>
    <td>{{$client->telephone}}</td>
  </tr>
  @endforeach
</table>
@stop