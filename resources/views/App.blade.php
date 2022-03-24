@php
    $FechaCitacion=date("Y-m-d");
    $numeroDiaFC = date('d', strtotime($FechaCitacion));
    $diaFC = date('l', strtotime($FechaCitacion));
    $mesFC = date('F', strtotime($FechaCitacion));
    $anioFC = date('Y', strtotime($FechaCitacion));
     
    if($mesFC=='January'){
      $mesFC= 'Enero';
      }
    elseif($mesFC=='February'){   
      $mesFC= 'Febrero';
      }
    elseif($mesFC=='March'){  
      $mesFC= 'Marzo';
      }
    elseif($mesFC=='April'){
         $mesFC= 'Abril';
      }
    elseif($mesFC=='May'){
         $mesFC= 'Mayo';
      }
    elseif($mesFC=='June'){
         $mesFC= 'Junio';
      }
    elseif($mesFC=='July'){ 
         $mesFC= 'Julio';
      }
    elseif($mesFC=='August'){  
         $mesFC= 'Agosto';
      }
    elseif($mesFC=='September'){  
         $mesFC= 'Septiembre';
      }
    elseif($mesFC=='October'){  
         $mesFC= 'Octubre'; 
      }
    elseif($mesFC=='November'){  
         $mesFC= 'Noviembre';
      }
    else{  
         $mesFC= 'Diciembre';
      }

    if($diaFC=='Monday'){
      $diaFC= 'Lunes';
      }
    elseif($diaFC=='Tuesday'){   
      $diaFC= 'Martes';
      }
    elseif($diaFC=='Wednesday'){  
      $diaFC= 'Miércoles';
      }
    elseif($diaFC=='Thursday'){
         $diaFC= 'Jueves';
      }
    elseif($diaFC=='Friday'){
         $diaFC= 'Viernes';
      }
    elseif($diaFC=='Saturday'){
         $diaFC= 'Sábado'; 
      }
    else{ 
         $diaFC= 'Domingo';  
      }
  @endphp 

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
    <!--PDF JAVASCRIP-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>

    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    

    <!--PARA CONVERTIR DIV EN IMAGEN-->
    <script src="https://superal.github.io/canvas2image/canvas2image.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

    <!-- ejemplos 
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">-->

	
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

            function mueveReloj(){
                momentoActual = new Date()
                hora = momentoActual.getHours()
                minuto = momentoActual.getMinutes()
                segundo = momentoActual.getSeconds()

                horaImprimible = hora + " : " + minuto + " : " + segundo
            
                document.getElementById("Hora").innerHTML =horaImprimible;
            
                setTimeout("mueveReloj()",1000)
            
            }

            function ocultar() {
                document.getElementById('ver').style.opacity= 0;
            }
            
            function mostrar(mensaje){
                document.getElementById('ver').innerHTML = '<p>' + mensaje + '</p>';
                document.getElementById('ver').style.opacity= 1;
            }
           
	</script>
    
	<style type="text/css">
 
	

        .card-header, #h,.btn-primary { 
            height:auto;
	        background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(0, 0, 0) 100%), -webkit-linear-gradient(-45deg,  #2AADB8 0%,#2AADB8 100%);
			color: white !important;
		
		}

		.btn-warning{
			color: #FFFFFF !important;
		}
        
        /* CODIGO VISUALIZADOR PDF*/
            #canvas_container {
            overflow: auto;
            background: #333; 
            text-align: center; 
            border: solid 3px;
            overflow-y: scroll;
            overflow-y: scroll;
        }

        #Hora{
            width:100%;
            text-align:center; 
            margin-top:10%;
            color:#000000;
            font-size:20px;
            position:relative;
            top:-27px;
            left:-10px;
        }

	</style> 

	<nav class="navbar navbar-expand-lg navbar-light bg-light" id="h">
		<div class="top-right link">	 
			@if(Auth::guard()->check())
				<a style="color: white;">
					<strong>
						<button class="btn btn-info active" id="menu-toggle" style="background: #2AADB8;">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-border-width" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							  		<path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-2zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5z"/>
							</svg>
						</button>
						{{ Auth::user()->Nombres}} 
						{{ Auth::user()->Apellidos }}
					</strong>
				</a>  
			@else
				<a class="navbar-brand" href="#" style="color: #FFFFFF; font-size:16px;"><STRONG>GESTIÓN DOCUMENTAL</STRONG></a>		
			@endif
		</div>
			 
	  	<ul class="navbar-nav ml-auto mt-2 mt-lg-0"> 
		    @if(Auth::guard()->check())
                <a class="dropdown-item active" href="#" data-toggle="modal" data-target="#logoutModal"  style="color: #FFFFFF; background: #2AADB8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
				</a>
		    @else	
				<a href="{{ route('Registrarse') }}" style="color: white;">
					<center><strong>REGISTRARSE </strong></center>
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
                    @if(Auth::user()->Root==1)
                        <div class="dropdown">
                            <a href="" class="list-group-item list-group-item-action dropdown-toggle" id="dropdownMenuButton" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong>ROOT&nbsp;</strong></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 90%">
                                <form method="POST" action="{{ route('AgregarJefes') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        AGREGAR JEFES
                                    </button>  
                                </form>
                                <form method="POST" action="{{ route('AgregarFirma') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        AGREGAR FIRMA
                                    </button>   
                                </form> 
                                <form method="POST" action="{{ route('AgregarPlantillas') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        AGREGAR PLANTILLAS
                                    </button>  
                                </form>
                                <form method="POST" action="{{ route('HabilitarFirmaMasiva') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                      FIRMA MASIVA
                                    </button>   
                                </form>
                                <form method="POST" action="{{ route('AgregarDocumentos') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        AGREGAR DOCUMENTOS
                                    </button>   
                                </form> 
                                <form method="POST" action="{{ route('AgregarDirDEP') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        AGREGAR DIREC. DEPT.
                                    </button>  
                                </form>
                                <form method="POST" action="{{ route('Mensaje') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        MENSAJE PÚBLICO
                                    </button>  
                                </form>
                            </div>
                        </div>
                    @endif
                    @if(Auth::user()->Jefe==1)
                        <div class="dropdown">
                            <a href="" class="list-group-item list-group-item-action dropdown-toggle" id="dropdownMenuButton" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ENCARGADO/A ODP&nbsp;</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                                <form method="POST" action="{{ route('AdministrarSecretaria') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        SECRETARIA 
                                    </button> 
                                </form>
                                <form method="POST" action="{{ route('PortafolioDirecto') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        <strong>PORTAFOLIOS DIRECTOS</strong>
                                    </button> 
                                </form>
                                <form method="POST" action="{{ route('Subrogante') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        SUBROGANTE
                                    </button>
                                </form>
                            </div> 
                        </div> 
                    @endif
                    @if(Auth::user()->Secretaria==1)
                        <div class="dropdown">
                            <a href="" class="list-group-item list-group-item-action dropdown-toggle" id="dropdownMenuButton" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong>OFICINA DE PARTES&nbsp;</strong></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                                <form method="POST" action="{{ route('CrearDocumentoODP') }}"> 
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        NUEVA SOLIC.
                                    </button> 
                                </form>
                                <form method="POST" action="{{ route('EnvioOficinaPartesODP') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        SOLIC. DETENIDAS
                                    </button>  
                                </form>
                                <hr>
                                <form method="POST" action="{{ route('Distribuccion') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        <strong>SOLIC. INTERNAS</strong>
                                    </button> 
                                </form>
                                <hr>
                                <form method="POST" action="{{ route('ODPExternos') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        SOLIC. EXTERNAS
                                    </button>  
                                </form>
                                <form method="POST" action="{{ route('ODPExternosVB') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        SOLIC. EXTERNAS V°B°
                                    </button>  
                                </form>
                            </div>
                        </div> 
                    @endif

                    @if(Auth::user()->FirmaMasiva==1)
                    <div class="dropdown">
                            <a href="" class="list-group-item list-group-item-action dropdown-toggle" id="dropdownMenuButton" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #FF0C00;"><strong>FIRMA MASIVA&nbsp;</strong></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                                <form method="POST" action="{{ route('DocumentoExt') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        <a style="color: #FF0C00;"><strong>FIRMA MASIVA ARCHIVOS EXT.</strong></a>
                                    </button>
                                </form>
                            </div> 
                        </div>  
                    @endif
                        <div class="dropdown">
                            <a href="" class="list-group-item list-group-item-action dropdown-toggle" id="dropdownMenuButton" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SOLICITUDES&nbsp;</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                            @if(Auth::user()->Secretaria!=1)
                                <form method="POST" action="{{ route('CrearDocumento') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        NUEVA 
                                    </button> 
                                </form>
                            @endif
                                <form method="POST" action="{{ route('EnvioOficinaPartes') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        DETENIDAS
                                    </button>  
                                </form>
                         
                                <form method="POST" action="{{ route('DocumentoEnProcesoOP') }}">
                                    @csrf 
                                    <button type="submit" class="btn list-group-item-action">
                                        EN PROCESO
                                    </button> 
                                </form>
                                <form method="POST" action="{{ route('PortafoliosRecibidos') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        RECIBIDAS
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('PortafoliosRecibidosVB') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        V°B°
                                    </button>
                                </form>
                                <hr>
                                <center><strong>HISTORIAL</strong></center>
                                <hr>
                                <form method="POST" action="{{ route('PortafoliosFinalizados') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        FINALIZADAS
                                    </button>
                                </form> 
                                <form method="POST" action="{{ route('PortafoliosFinalizadosFir') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        FIRMADAS
                                    </button>
                                </form> 
                                <form method="POST" action="{{ route('PortafoliosFinalizadosVB') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        V°B°
                                    </button>
                                </form>
                            </div>
                        </div>
                    <!--<div class="dropdown">
			  			<a href="" class="list-group-item list-group-item-action dropdown-toggle" id="dropdownMenuButton" 
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PLANTILLAS&nbsp;</a>
				  		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 90%">
                            <form method="POST" action="{{ route('DescargarPlantillasU') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action">
                                    DESCARGAR
                                </button>  
                            </form> 
						</div> 
				  	</div>-->
                    <div class="dropdown">
                        <a href="" class="list-group-item list-group-item-action dropdown-toggle" id="dropdownMenuButton" 
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OPCIONES&nbsp;</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                            @if(Auth::user()->Secretaria==1)
                                <form method="POST" action="{{ route('AutorizarRegistro') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                        <strong>ADMINISTRAR REGISTROS</strong>
                                    </button>   
                                </form>
                                <form method="POST" action="{{ route('ListaFuncionarios') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action">
                                       <strong>LISTA FUNCIONARIOS</strong> 
                                    </button> 
                                </form>
                            @endif
                            <form method="POST" action="{{ route('CambiarCorreo') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action">
                                EMAIL 
                                </button> 
                            </form>
                            <form method="POST" action="{{ route('CambiarContrasenia') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action">
                                CONTRASEÑA 
                                </button> 
                            </form>
                            <form method="POST" action="{{ route('Sessiones') }}">
								@csrf
								<button type="submit" class="btn">
									<a>DISP. VINCULADOS</a>
								</button>
							</form>
                        </div> 
                    </div>
                    @php
                        $Mensaje =  DB::table('Mensaje')
                                    ->where('Estado', '=',1)
                                    ->first();
                        if(!empty($Mensaje)){

                            $Mensaje = $Mensaje->Mensaje;
                            
                        }
                    @endphp 
                    <marquee><h5><strong>{{ $Mensaje }}</strong></h5></marquee> 
				</div>
				<br><br>
				<div>
					<center><img src="{{URL::asset('Imagenes/escudo.png')}}" width="90" height="90"/></center>
					<hr>
					<center>
					  	© {{ date("Y") }} DEP. DE INFORMÁTICA<br>
						MUNICIPALIDAD DE CURICÓ<br>
                        <hr>
                        <strong>VERSIÓN BETA 0.5.230322</strong><br>
                        <hr>
                        @if(Auth::user()->Subrogante==1)
                            <a class="navbar-brand" href="#" style="color: red; font-size:15px;"><strong>IMPORTANTE<br>SUBROGANTE HABILITADO</strong></a>
                        @endif
                        <body onload="mueveReloj()">
                        <center><h7>{{ $diaFC }} {{ $numeroDiaFC }} de {{ $mesFC }} {{ $anioFC }}</h7><br></center>
                        <strong><div id="Hora"></div></strong>
					</center>
				</div>
			</div> 
            @endif	

		<div id="page-content-wrapper"> 
			@yield("content")
			@livewireScripts
			@yield('scripts')
			@yield("foot")
		</div>
	</div>
</body>
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title" id="exampleModalLabel">¿Cerrar Sesión?</h5>
		        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">X</span>
		        </button>
      		</div>
      		<div class="modal-body"><center><img src="{{URL::asset('Imagenes/escudo.png')}}" width="120" height="120"/></center></div>
                <center>
                    © {{ date("Y") }} DEP. DE INFORMÁTICA<br>
                    MUNICIPALIDAD DE CURICÓ<br>
                    <hr>
                    <strong>VERSIÓN BETA 0.5.230322</strong><br>
                    <hr>
				</center>
			<br>
			<div class="btn-group">
				<button class="btn btn-danger active" type="button" data-dismiss="modal">Cancelar</button>
        		<a class="btn btn-primary active" href="{{ route('CerrarSesion') }}">Aceptar</a>
      		</div>
    	</div>
 	</div>
</div> 
