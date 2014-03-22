<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>I M</title>

<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/jquery.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME'];?>/js/bootstrap.min.js"></script>
<?php

if (isset ( $layoutDefaultScriptTag ) ) {
	foreach ( $layoutDefaultScriptTag as $headScriptTag ) {
		echo '<script type="text/javascript" src="http://' . $_SERVER['SERVER_NAME'] . '/js/' . $headScriptTag . '.js"></script>' . PHP_EOL;
	}
}

?>
<link type="text/css" rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/css/bootstrap-theme.min.css" />
<link type="text/css" rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/css/bootstrap.min.css" />
<?php

if (isset ( $layoutDefaultLinkTag ) ) {
	foreach ( $layoutDefaultLinkTag as $headStyleTag ) {
		echo '<link type="text/css" rel="stylesheet" href="http://' . $_SERVER['SERVER_NAME'] . '/css/' . $headStyleTag . '.css" />' . PHP_EOL;
	}
}

?>

@if ( isset ( $headTags ) )
	{{ $headTags }}
@endif

</head>
<body bgcolor="#EAEEEA">

<table align="center" style="width: 900px; border: 1px solid #9A9A9A; background-color: #FFFFFF" cellspacing="0" cellpadding="0">
	<tr>
		<td height="140" style="background-image:url('http://<?php echo $_SERVER['SERVER_NAME'];?>/img/blue_header.jpg');">
	<?php //if ($_SESSION['IdUser'] != '') : ?>
		<table style="border: 1px solid #000000; width: 900px;">
			<tr>
				<td rowspan="2" height="140" width="220"><img src="http://<?php echo $_SERVER['SERVER_NAME'];?>/img/im.gif" height="140" width="220" /></td>
				<td align="center" height="110" style="font: 32px bold ;">{{ Session::get('branch') }}</td>
			</tr>
			<tr>
				<td valign="bottom">

					<!-- <div class="row">
						<div class="col-md-9">
							{{ Form::open ( array('url' => 'client/search/', 'method' => 'get')) }}
							<div class="input-group input-group-sm">
  								<span class="input-group-addon">{{ link_to( 'client/add', 'Crear' ) }}</span>
  								{{ Form::text ( 'n', '', array ( 'style' => 'width: 353px', 'class' => 'form-control', 'placeholder' => 'Search' ) ) }}
  								{{ Form::submit ( 'Buscar', array ( 'style' => 'display: none' ) ) }}  								
							</div>
							{{ Form::close () }}
						</div>
						<div class="col-md-3">
							{{ link_to ( 'logout', 'Log Out') }}
						</div>
					</div> -->

    			</td>
			</tr>
		</table>
		</td>
	</tr>
@if ( Auth::check() )
	<tr>
		<td height="40">
			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">{{ Session::get('branch') }}</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li>{{ link_to ( 'company', 'Company') }}</li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">{{ Auth::user()->user_name }}</a></li>
									<li class="divider"></li>
									<li><?php echo link_to('insurance-near-expire', 'Cerca de expirar');?></li>
								</ul>
					        </li>
							<li>{{ link_to ( 'company', 'Company') }}</li>
							<li>{{ link_to( 'client/add', 'Crear' ) }}</li>
						</ul>
						{{ Form::open ( array('url' => 'client/search/', 'method' => 'get', 'class' => 'navbar-form navbar-left', 'role' => 'search' )) }}
						
						<div class="form-group">
							{{ Form::text ( 'n', '', array ( 'style' => 'width: 203px', 'class' => 'form-control', 'placeholder' => 'Search' ) ) }}
							
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
						{{ Form::close () }}
						<ul class="nav navbar-nav navbar-right">
							<li>{{ link_to ( 'logout', 'Log Out') }}</li>
						</ul>
					</div>
				</div>
			</nav>
		</td>
	</tr>
@endif
	<tr>
		<td height="40">
@section('sidebar')

@show</td>
	</tr>
	<tr>
		<td><div class="container">
@yield('content')
		</div></td>
	</tr>
	<tr>
		<td height="30">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" height="30">&copy; Beta</td>
	</tr>
</table>
</body>
</html>