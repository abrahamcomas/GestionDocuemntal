<meta charset="utf-8">
<title>GestionDocumental</title>
<head>
	<meta name="viewport" content="width=device-width"/>
	<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet">


	<link href="{{ asset ('ManuLateral/simple-sidebar.css ') }}" rel="stylesheet">
	

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<!--Para que funione el ajax-->
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	


    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
	
	<script type="text/javascript">
		function checkRut(rut)  
		    {
			    var valor = rut.value.replace('.','');
			    valor = valor.replace('-','');
			    cuerpo = valor.slice(0,-1);
			    dv = valor.slice(-1).toUpperCase(); 
			    rut.value = cuerpo + '-'+ dv
			    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
			    suma = 0;
			    multiplo = 2;
			    for(i=1;i<=cuerpo.length;i++) {
			        index = multiplo * valor.charAt(cuerpo.length - i);
			        suma = suma + index;
			        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
			    }
			    dvEsperado = 11 - (suma % 11);
			    dv = (dv == 'K')?10:dv;
			    dv = (dv == 0)?11:dv;
			    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
			    rut.setCustomValidity('');
		    }
			
	</script>
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

		.card-header { 
			color: white !important;
			background-color: #31A877 !important;
		}

		.btn-primary{
			background: #31A877 !important;
		}

		.btn-warning{
			color: #FFFFFF !important;
		}
	</style> 

	<nav class="navbar navbar-expand-lg navbar-light bg-light" id="h">
		<div class="top-right link">	 
			@if(Auth::guard()->check())
				<a style="color: white;">
					<strong>
						<button class="btn btn-info active" id="menu-toggle" style="background: #31A877;">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-border-width" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							  		<path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-2zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5z"/>
							</svg>
						</button>
						{{ Auth::user()->Nombres}} 
						{{ Auth::user()->Apellidos }}
					</strong>
				</a> 
			@else
				<a class="navbar-brand" href="#" style="color: white; font-size:16px;"><STRONG>Gestion Documental</STRONG></a>		
			@endif
		</div>
			 
	  	<ul class="navbar-nav ml-auto mt-2 mt-lg-0"> 
		    @if(Auth::guard()->check())
				<a class="dropdown-item active" href="{{ route('CerrarSesion') }}" style="color: #FFFFFF; background: #31A877;">
	      			CERRAR
				</a>
		    @else	
				<a href="{{ route('Registrarse') }}" style="color: white;">
					<center><strong>Registrarse</strong></center>
                </a>
		    @endif

  		</ul>
	</nav>  
		@livewireStyles  
</head>
<body>
@if(Auth::guard('web')->check())
  		<div class="d-flex" id="wrapper"> 
			<div class="bg-light border-right" id="sidebar-wrapper">
      			<div class="sidebar-heading"><strong><center><a href="{{ route('Principal') }}" style="color: #000000;">MENÚ</a></center></strong></div>
				<div class="list-group list-group-flush">
				<div class="dropdown">
			  		<a href="" class="list-group-item list-group-item-action dropdown-toggle" id="dropdownMenuButton" 
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DOCUMENTOS&nbsp;</a>
				  	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 90%">
				    	<form method="POST" action="{{ route('CrearDocumento') }}">
							@csrf
							<button type="submit" class="btn list-group-item list-group-item-action">
								Nuevo Documento
							</button>
						</form>
						<form method="POST" action="{{ route('Distribuccion') }}">
							@csrf
							<button type="submit" class="btn list-group-item list-group-item-action">
								Documento En Proceso
							</button> 
						</form>
						<form method="POST" action="{{ route('DocumentosDeEntrada') }}">
							@csrf
							<button type="submit" class="btn list-group-item list-group-item-action">
								Bandeja De Entrada
							</button>
						</form>
						<form method="POST" action="{{ route('DocumentosFinalizados') }}">
							@csrf
							<button type="submit" class="btn list-group-item list-group-item-action">
								Documentos Finalizados
							</button>
						</form>
						<form method="POST" action="{{ route('DocumentosAvisos') }}">
							@csrf
							<button type="submit" class="btn list-group-item list-group-item-action">
								Documentos Avisos
							</button>
						</form>
				  	</div>
				</div>
				
				
				
				<!--<form method="POST" action="{{ route('DocumentoExt') }}">
					@csrf
					<button type="submit" class="btn list-group-item list-group-item-action">
							FIRMAR DOCUMENTO EXT.
					</button>
				</form>
			
					
					

					

				
				

					
					<div class="dropdown">
			  			<a href="" class="list-group-item list-group-item-action dropdown-toggle" id="dropdownMenuButton" 
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DISP. VINCULADOS&nbsp;</a>
				  		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 90%">
							<form method="POST" action="">
								@csrf
								<button type="submit" class="btn">
									<a>DISP. VINCULADOS</a>
								</button>
							</form>
						
						</div>
				  	</div>-->
				</div>
				<br><br>
				<div>
					<center><img src="{{URL::asset('Imagenes/escudo.png')}}" width="90" height="90"/></center>
					<hr>
					<center>
					  	© {{ date("Y") }} Dep. de informática V0.1<br>
						Municipalidad de Curicó
					</center>
				</div>
			</div> 

				
	@endif
		
				<div id="page-content-wrapper"> 
				@yield("content")
			      @livewireScripts
			 	@yield('scripts')
				@yield("foot")
				<footer> 
					<br>
				  	<center>
				  		<p>
				  			<a style="color: #31A877;">
				  				<strong>
				  					© {{ date("Y") }} Versión 0.1<br>
                                      ILUSTRE MUNICIPALIDAD DE CURICÓ
								</strong> 
							</a>
						</p>
					</center>
				</footer>
  			
				</div>
		</div>
</body>
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>