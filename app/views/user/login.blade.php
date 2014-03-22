@extends ( 'layout.default' )



@section ( 'sidebar' )

<h2>
  Log In
</h2>

@stop



@section ( 'content' )

@if ( Session::has ( 'error' ) )
	<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif


@if ( Cookie::get ( 's' ) == '' )
	<div class="alert alert-info">Este equipo necesita ser registrado por un administrador</div>
@endif




{{ Form::open ( array ( 'url' => 'login' ) ) }}


@if (  $s != '' )
	{{ Form::hidden ( 's', $s ); }}
@endif

<table >
  <tr>
    <td>{{ Form::label('user', 'User'); }}</td>
    <td>{{ Form::text('user'); }}</td>
  </tr>
  <tr>
    <td>{{ Form::label('password', 'Password'); }}</td>
    <td>{{ Form::password('password'); }}</td>
  </tr>
  <tr>
    <td colspan="2">{{ Form::submit('Go!'); }}</td>
  </tr>
</table>

{{ Form::close() }}


@stop