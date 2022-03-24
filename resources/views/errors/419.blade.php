  <meta charset="utf-8">
<title>Control De Partes</title>
<head>
	<meta name="viewport" content="width=device-width"/>
	<!--Para que funione el ajax-->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> 
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" >
	<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script> 
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset ('css/bootstrap.min.css') }}" >
	<style type="text/css">

#h {  

height:auto;
background: #31A877;
background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.1) 10%,rgba(138,114,76,0) 40%),-moz-linear-gradient(top,  rgba(255, 255, 255,.25) 0%, rgba(0, 0, 0,.1) 100%), -moz-linear-gradient(-45deg,  #31A877 0%, #31A877 100%);
background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(76, 25, 88) 100%), -webkit-linear-gradient(-45deg,  #31A877 0%,#31A877 100%);
background: -o-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), -o-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(76, 25, 88) 100%), -o-linear-gradient(-45deg,  #31A877 0%,#31A877 100%);
background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), -ms-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(76, 25, 88) 100%), -ms-linear-gradient(-45deg,  #1B67AE 0%,#1B67AE 100%);
background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(255, 255, 255,.25) 0%,rgba(76, 25, 88) 100%), linear-gradient(135deg,  #31A877 0%,#31A877 100%);

}

	</style> 
	<nav class="navbar navbar-expand-lg navbar-light bg-light" id="h">
		<div class="top-right link">	 
			<a class="navbar-brand" href="#" style="color: white; font-size:16px;"><STRONG>GESTIÓN DOCUMENTAL</STRONG></a>		
		</div>		  
	</nav>
</head>  
<div class="container-fluid">  
	<body onLoad="redireccionar()">
		<br>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="col">
					<div class="card bg-light mb-3" >
						<div class="card-header">
						<center><h3>Sesión expirada</h3></center>
						</div>   
						<div class="card-body">
						<center>Volviendo a página principal...</center>  
						<center><a href="{{ route('Index') }}" style="color: black;"><strong>Volver</strong></a></center> 
						</div> 
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
		</div>
	</body>
</div> 
@if(Auth::guard('web')->check())
<script type="text/javascript">
	function redireccionar() {
    setTimeout("location.href='{{ route('CerrarSesion') }}'", 1000);
  }
</script>
@endif




