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
<!--<!DOCTYPE html>-->
<meta charset="utf-8">
<title>GestionDocumental</title>
<head>
    <html lang="es">
    <meta name="description" content="SGD"> 
    <meta name="theme-color" content="#317EFB"/>
	<meta name="viewport" content="width=device-width"/>
   
	<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset ('ManuLateral/simple-sidebar.css ') }}" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<!--Para que funione el ajax-->


    <!--ERROR DE VULNERABILIDAD-->
	<!--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>-->
    
    <!--PDF JAVASCRIP-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>


    <!--PARA CONVERTIR DIV EN IMAGEN-->
    <script src="https://superal.github.io/canvas2image/canvas2image.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

    <!-- ejemplos 
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">-->
    
    <!--GRAFICOS-->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script> 
	
    <!--CKEDITOR-->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
    <!--<script src="{{ asset('ckeditor5/build/imageresize.js') }}"></script>-->



	<!--<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>-->

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


            $(document).ready(function(){
                $("#boton").click(function(event){
                    event.preventDefault();
                $("#boton").prop('disabled',true)
                
                return false;
                })
            })
            
           
	</script>
 
	<style type="text/css">
 
        @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";
	
    <?php   if(!empty(session('ColorPrincipal'))){  ?>
             
                .card-header, #h { 
                    height:auto;
                    background: linear-gradient(0deg, <?php echo session('ColorSecundario'); ?>, <?php echo session('ColorPrincipal'); ?>);
                    color: white !important;
                } 

    <?php 
            } 
            else { ?>

                .card-header, #h { 
                    height:auto;
                    background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(0, 0, 0) 100%), -webkit-linear-gradient(-45deg,  #2AADB8 0%,#2AADB8 100%);
                    color: white !important;
                }

    <?php   }   ?>

    <?php if(!empty(session('ColorSecundario'))){  ?>

                /*Colo letras menu opincipal*/
                  #sidebar {
                    min-width: 250px;
                    max-width: 250px;
                    background: linear-gradient(70deg, <?php echo session('ColorSecundario'); ?>, <?php echo session('ColorPrincipal'); ?>);
                    color: #FFFFFF;
                    transition: all 0.9s;
                    min-height: 100vh;
                }

    <?php 
            } 
            else { ?>

                /*Colo letras menu opincipal*/
                #sidebar {
                    min-width: 250px;
                    max-width: 250px;
                    background: linear-gradient(70deg, #000000, #09818F);
                    color: #FFFFFF;
                    transition: all 0.9s;
                    min-height: 100vh;
                }

    <?php   }   ?>


    <?php   if(!empty(session('BodyPrincipal'))){  ?>
                body {
                    font-family: 'Poppins', sans-serif;
                    background: linear-gradient(10deg, <?php echo session('BodyPrincipal'); ?>, <?php echo session('BodySecundario'); ?>);
                }

    <?php 
            } 
            else { ?>
                body {
                    font-family: 'Poppins', sans-serif;
                    background: linear-gradient(10deg, #8AB3D3, #FFFFFF);
                }

    <?php   }   ?>

    <?php   if(!empty(session('FocoNoSelecLetra'))){  ?>

                /*Foco sin seleccionar*/
                #sidebar ul li  a:hover {
                    color: <?php echo session('FocoNoSelecLetra'); ?>;
                    background: <?php echo session('FocoNoSelecFondo'); ?>;
                }
    <?php 
            } 
            else { ?>

                 /*Foco sin seleccionar*/
                #sidebar ul li  a:hover {
                    color: #56FF02;
                    background: #0E8B85;
                }
 
    <?php   }   ?>

    <?php   if(!empty(session('FocoSelecLetra'))){  ?> 
                /*Foco seleccionado*/
                #sidebar ul li.active>a,
                a[aria-expanded="true"] {
                    color:<?php echo session('FocoSelecLetra'); ?>;
                    background: <?php echo session('FocoSelecFondo'); ?>;
                }
    <?php 
            } 
            else { ?>

                /*Foco seleccionado*/
                #sidebar ul li.active>a,
                a[aria-expanded="true"] {
                    color: #FFFFFF;
                    background: #0E8B85;
                }

    <?php   }   ?>

    <?php   if(!empty(session('LetraLista'))){  ?> 

                /*Color letras*/
                .btn-link {
                    color: <?php echo session('LetraLista'); ?>;
                    font-weight: bold;
                }
    <?php 
            } 
            else { ?>

                 /*Color letras*/
                .btn-link {
                    color: #56FF02;
                    font-weight: bold;
                }

    <?php   }   ?>

    <?php   if(!empty(session('LetraPrincipal'))){  ?> 

                a,
                a:hover,
                a:focus {
                    color: <?php echo session('LetraPrincipal'); ?>;
                    text-decoration: none;
                    transition: all 0.9s;
                }
    <?php 
            } 
            else { ?>

                a,
                a:hover,
                a:focus {
                    color: #FFFFFF;
                    text-decoration: none;
                    transition: all 0.9s;
                }
	<?php	
            }   ?>
        

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
        color:#FFFFFF;
        font-size:20px;
        position:relative;
        top:-27px;
        left:-10px;
    }

    /* ---------------------------------------------------
        SIDEBAR STYLE
    ----------------------------------------------------- */

    .wrapper {
        display: flex;
        width: 100%;
        align-items: stretch;
    }


    #sidebar.active {
        margin-left: -250px;
    }

    /*Separacion menu*/
    #sidebar ul li a {
        padding: 12px;
        font-size: 1.1em;
        display: block;
    }

    a[data-toggle="collapse"] {
        position: relative;
    }

    #sidebar p:hover{
        color: #00CD19;
        background: #0E8B85;
    }

    .dropdown-toggle::after {
        display: block;
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
    }

    ul.CTAs {
        padding: 20px;
    }

    ul.CTAs a {
        text-align: center;
        font-size: 0.9em !important;
        display: block;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    #content {
        width: 100%;
        padding: 20px;
        min-height: 100vh;
        transition: all 0.3s;
    }
  

    /*Animacion Cargar*/
    h1 {
    text-align: center;
    margin: 2rem auto 2rem;
    font-weight: normal;
    }

    .circle {
    display: inline-block;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: whiteSmoke;
    box-shadow: 4px -40px 60px 5px rgb(26, 117, 206) inset;
    }

    .bounce2 {
    animation: bounce2 2s ease infinite;
    }
    @keyframes bounce2 {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-30px);}
        60% {transform: translateY(-15px);}
    }

    /*Menu agrandar*/
        article:hover{ 
        -webkit-transform: scale(1.1);
        transform: scale(1.1)
    }















     /*Fondo animado*/
		section{
			width: 40%;
			color: #fff;
			background: linear-gradient(45deg,red,blue,green,black);
			background-size: 400% 400%;
			position: relative;
			animation: cambiar 7s ease-in-out infinite;
            border-radius: 20px;
            opacity: 0.9;
		}

		@keyframes cambiar{
			0%{background-position: 0 50%;}
			50%{background-position: 100% 50%;}
			100%{background-position: 0 50%;}
		}

	</style> 

	<nav class="navbar navbar-expand-lg navbar-light bg-light" id="h">
		<div class="top-right link">	 
			@if(Auth::guard()->check())
				<a style="color: white;">
					<strong>
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-border-width" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 3.5A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-2zm0 5A.5.5 0 0 1 .5 8h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1zm0 4a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5z"/>
							</svg>
                        </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<u>{{ Auth::user()->Nombres}} 
						{{ Auth::user()->Apellidos }}</u>
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
					<center><strong>REGISTRO </strong></center>
                </a>
		    @endif

  		</ul>
	</nav>  
		@livewireStyles
</head> 
<body>
@if(Auth::guard('web')->check()) 
    <div class="d-flex" id="wrapper"> 
        <nav id="sidebar">
            <ul class="list-unstyled"> 
                <br>
                <div class="sidebar-heading"><strong><a href="{{ route('Principal') }}" style="color: #ffffff;"><center><h4>MENÚ</h4></center></a></strong></div>
                @if(Auth::user()->Root==1 || Auth::user()->Root==2)
                    <hr style="height:3px;background-color: #56FF02;">
                    <li>
                        <a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>ADMINISTRADOR</strong></a>
                        <ul class="collapse list-unstyled" id="homeSubmenu1">
                            <hr style="background-color: #FFFFFF;">
                            <form method="POST" action="{{ route('AgregarJefes') }}">
                                @csrf 
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    AGREGAR JEFES
                                </button>  
                            </form>
                            <form method="POST" action="{{ route('AgregarSecretaria') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    AGREGAR SECRETARIA
                                </button>    
                            </form> 
                            <form method="POST" action="{{ route('AgregarFirma') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    AGREGAR IMAGEN FIRMA
                                </button>   
                            </form>  
                            <form method="POST" action="{{ route('HabilitarFirmaMasiva') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                FIRMA MASIVA
                                </button>   
                            </form>
                            <form method="POST" action="{{ route('DesactivarUsuario') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    ESTADO USUARIOS
                                </button>   
                            </form>
                        @if(Auth::user()->Root==2)
                            <form method="POST" action="{{ route('Acta') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    ACTA DE ENTREGA
                                </button>   
                            </form> 
                            <form method="POST" action="{{ route('AgregarPlantillas') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    AGREGAR PLANTILLAS
                                </button>  
                            </form>
                            <form method="POST" action="{{ route('AgregarDocumentos') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    AGREGAR DOCUMENTOS
                                </button>    
                            </form>
                            <form method="POST" action="{{ route('AgregarDirDEP') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    AGREGAR DIREC. DEPT.
                                </button>  
                            </form>
                            <form method="POST" action="{{ route('Mensaje') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    MENSAJE PÚBLICO
                                </button>  
                            </form>
                        @endif
                        </ul>
                    </li>
                @endif 
                @if(Auth::user()->Jefe==1)
                        <hr style="height:3px;background-color: #56FF02;">
                        <form method="POST" action="{{ route('PortafolioDirecto') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                <strong>SOLICITUDES INTERNAS</strong>
                            </button> 
                        </form>
                    @endif
                @if(Auth::user()->Acta==1)
                    <hr style="height:3px;background-color: #56FF02;">
                    <li>
                        <a href="#homeSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>ACTA DE ENTREGA</strong></a>
                        <ul class="collapse list-unstyled" id="homeSubmenu2">
                            <hr style="background-color: #FFFFFF;">
                            <form method="POST" action="{{ route('CrearSolicitud') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    CREAR 
                                </button> 
                            </form> 
                        
                            <form method="POST" action="{{ route('Solicitudes') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    ACTA DE ENTREGAS 
                                </button> 
                            </form>
                            <hr style="background-color: #FFFFFF;">
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->Secretaria==1)
                    <hr style="height:3px;background-color: #56FF02;">
                    <li>
                        <a href="#homeSubmenuOPD0" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>ODP</strong></a>
                        <ul class="collapse list-unstyled" id="homeSubmenuOPD0">
                            <hr style="background-color: #FFFFFF;">
                            <form method="POST" action="{{ route('Distribuccion') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    <strong>OPD INTERNA</strong>
                                </button> 
                            </form>
                            <hr style="background-color: #FFFFFF;">
                            <li>
                                <a href="#homeSubmenuOPD1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>CREAR</strong></a>
                                <ul class="collapse list-unstyled" id="homeSubmenuOPD1">
                                    <hr style="background-color: #FFFFFF;">
                                    <form method="POST" action="{{ route('CrearDocumentoODP') }}"> 
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                        SOLIC. A FUNCIONARIO
                                        </button> 
                                    </form>
                                    <form method="POST" action="{{ route('EnvioOficinaPartesODP') }}">
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                            SOLICITAR FIRMAS
                                        </button>  
                                    </form>
                                    <hr style="background-color: #FFFFFF;">
                                </ul>
                            </li>
                            <li>
                                <a href="#homeSubmenuOPD3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>ODP EXTERNA</strong></a>
                                <ul class="collapse list-unstyled" id="homeSubmenuOPD3">
                                    <hr style="background-color: #FFFFFF;">
                                    <form method="POST" action="{{ route('ODPExternos') }}">
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                            SOLIC. EXTERNAS
                                        </button>  
                                    </form>
                                    <form method="POST" action="{{ route('ODPExternosVB') }}">
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                            SOLIC. EXTERNAS V°B°
                                        </button>  
                                    </form>
                                    <form method="POST" action="{{ route('RecibidosODP') }}">
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                        SOLIC. RECIBIDAS
                                        </button> 
                                    </form>
                                    <hr style="background-color: #FFFFFF;">
                                </ul>
                            </li>
                            <li>
                                <a href="#homeSubmenuOPD5" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>ADMINISTRAR ODP</strong></a>
                                <ul class="collapse list-unstyled" id="homeSubmenuOPD5">
                                    <hr style="background-color: #FFFFFF;">
                                    <form method="POST" action="{{ route('CambiarLugarODP') }}">
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                            CAMBIAR FUNCIONARIOS
                                        </button>  
                                    </form>
                                    <form method="POST" action="{{ route('ADODP') }}">
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                            AGREGAR FUNCIONARIO ODP 
                                        </button>  
                                    </form>
                                    <!--Desabilitado por cumplir la misma funcion que ListaFuncionarios
                                    <form method="POST" action="{{ route('AutorizarRegistro') }}">
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                            NUEVOS REGISTROS
                                        </button>   
                                    </form>-->
                                    <form method="POST" action="{{ route('ListaFuncionarios') }}">
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                        LISTA FUNCIONARIOS
                                        </button> 
                                    </form>
                                    <form method="POST" action="{{ route('HistorialODP') }}">
                                        @csrf
                                        <button type="submit" class="btn list-group-item-action btn-link">
                                            HISTORIAL ODP
                                        </button> 
                                    </form>
                                    <hr style="background-color: #FFFFFF;">
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
                <hr style="height:3px;background-color: #56FF02;">
                <li>
                    <a href="#homeSubmenu6" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>SOLICITUDES</strong></a>
                    <ul class="collapse list-unstyled" id="homeSubmenu6">
                        <hr style="background-color: #FFFFFF;">
                        @if(Auth::user()->Secretaria!=1)
                            <!--<form method="POST" action="{{ route('ListaPlantillas') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    CREAR DOCUMENTO 
                                </button> 
                            </form>-->  
                        @endif
                        <form method="POST" action="{{ route('CrearDocumento') }}">
                                @csrf
                                <button type="submit" class="btn list-group-item-action btn-link">
                                    NUEVA 
                                </button> 
                        </form>
                        <form method="POST" action="{{ route('EnvioOficinaPartes') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                DETENIDAS
                            </button>  
                        </form>
                        <form method="POST" action="{{ route('PortafoliosRecibidos') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                RECIBIDAS
                            </button>
                        </form>
                        <form method="POST" action="{{ route('PortafoliosRecibidosVB') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                V°B°
                            </button>
                        </form> 
                        <form method="POST" action="{{ route('Compartidas') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                COMPARTIDAS
                            </button>
                        </form>
                        <hr style="background-color: #FFFFFF;">
                        <li>
                            <a href="#homeSubmenuS1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>HISTORIAL</strong></a>
                            <ul class="collapse list-unstyled" id="homeSubmenuS1">
                                <hr style="background-color: #FFFFFF;">
                                    <!--<form method="POST" action="{{ route('DocumentoEnProcesoOP') }}">
                                    @csrf 
                                    <button type="submit" class="btn list-group-item-action">
                                        EN PROCESO
                                    </button> 
                                </form>-->
                                <form method="POST" action="{{ route('PortafoliosFinalizados') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action btn-link">
                                        SOLIC. CREADAS
                                    </button>
                                </form> 
                                <form method="POST" action="{{ route('PortafoliosFinalizadosFir') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action btn-link">
                                        FIRMADAS
                                    </button>
                                </form> 
                                <form method="POST" action="{{ route('PortafoliosFinalizadosVB') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action btn-link">
                                        V°B°
                                    </button>
                                </form>
                                <hr style="background-color: #FFFFFF;">
                            </ul>
                        </li>
                    </ul>
                </li>
                <hr style="height:3px;background-color: #56FF02;">
                <li>
                    <a href="#homeSubmenu7" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>OPCIONES</strong></a>
                    <ul class="collapse list-unstyled" id="homeSubmenu7">
                    <hr style="background-color: #FFFFFF;">

                    @if(Auth::user()->Jefe==1)
                        <hr style="height:3px;background-color: #56FF02;">
                        <li>
                            <a href="#homeSubmenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><strong>ENCARGADO/A ODP</strong></a>
                            <ul class="collapse list-unstyled" id="homeSubmenu3">
                                <hr style="background-color: #FFFFFF;">
                                <form method="POST" action="{{ route('AdministrarSecretaria') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action btn-link">
                                        CAMBIAR SECRETARIA ODP
                                    </button> 
                                </form>
                                <form method="POST" action="{{ route('Subrogante') }}">
                                    @csrf
                                    <button type="submit" class="btn list-group-item-action btn-link">
                                        SUBROGANTE
                                    </button>
                                </form>
                            </ul>
                            <hr style="height:3px;background-color: #56FF02;">
                        </li>
                        <li>
                        <form method="POST" action="{{ route('PortafolioDirecto') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                <strong>SOLICITUDES INTERNAS</strong>
                            </button> 
                        </form>
                    @endif
                        <form method="POST" action="{{ route('CambiarLugar') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                LUGAR DE TRABAJO
                            </button>  
                        </form>
                        <form method="POST" action="{{ route('CambiarCorreo') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                            EMAIL 
                            </button>  
                        </form>
                   
                        <form method="POST" action="{{ route('CambiarContrasenia') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                            CONTRASEÑA 
                            </button> 
                        </form>
                        <form method="POST" action="{{ route('Personalizar') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                PERSONALIZAR
                            </button> 
                        </form>
                        <form method="POST" action="{{ route('Sessiones') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                DISP. VINCULADOS
                            </button>
                        </form>
                    </ul>
                </li>
                <hr style="height:3px;background-color: #56FF02;">
                @if(Auth::user()->FirmaMasiva==1)
                    <li>
                        <form method="POST" action="{{ route('DocumentoExt') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                <h5><strong>FIRMA MASIVA</strong></h5>
                            </button> 
                        </form> 
                         <!--<form method="POST" action="{{ route('DocumentoExt2') }}">
                            @csrf
                            <button type="submit" class="btn list-group-item-action btn-link">
                                FIRMA MASIVA 2.0
                            </button>
                        </form>-->
                    </li>
                @endif
            </ul>
            <hr style="height:3px;background-color: #56FF02;">
            <ul class="list-unstyled CTAs">
                <li>
                    <div class="sidebar-heading"><a href="{{ route('Graficos') }}" style="color: #FFFFFF;"><center><h4>GRÁFICOS</h4></center></a></div>
                </li>
            </ul>
            <hr style="background-color: #FFFFFF;">
            <ul class="list-unstyled">
                <center>
                    @if(Auth::user()->Subrogante==1)
                        <a class="navbar-brand" href="#" style="color: red; font-size:13px;"><strong>IMPORTANTE<br>SUBROGANTE HABILITADO</strong></a>
                    @endif
                    <body onload="mueveReloj()">
                    <center><h7>{{ $diaFC }} {{ $numeroDiaFC }} de {{ $mesFC }} {{ $anioFC }}</h7><br></center>
                    <strong><div id="Hora"></div></strong>
                    <p><strong>ODP <?php echo session('LugarDeTrabajo'); ?></strong></p>
                </center>
            </ul>
            <hr style="background-color: #FFFFFF;">
            <ul class="list-unstyled">
                <li>
                    @php
                        $Mensaje =  DB::table('Mensaje')
                                    ->where('Estado', '=',1) 
                                    ->first();
                        if(!empty($Mensaje)){

                            $Mensaje = $Mensaje->Mensaje;
                            
                        }
                    @endphp 
                    <marquee><h5><strong>{{ $Mensaje }}</strong></h5></marquee> 
                </li>
            </ul>
            <center><section><h1 style="color: #FFFFFF;"><strong>SGD</strong></h1></section></center>
            <center><strong><p>INFORMÁTICA {{ date("Y") }}</p></strong></center>
        </nav>
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
    $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
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
            <br><br>
            <center>          
                <div class="circle bounce2"><h1 style="color: #FFFFFF;"><strong>SGD</strong></h1></div>
                <hr>
                <h5><strong>Sistema Gestión Documental (SGD)</strong></h5>                                 
            </center> 
			<div class="btn-group">
				<button class="btn btn-danger active" type="button" data-dismiss="modal">NO</button>
        		<a class="btn btn-primary active" href="{{ route('CerrarSesion') }}">SI</a>
      		</div>
    	</div>
 	</div>
</div> 
