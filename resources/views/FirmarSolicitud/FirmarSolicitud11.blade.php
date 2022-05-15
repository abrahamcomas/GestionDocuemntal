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
	<style type="text/css">
 
        .card-header, #h, .btn-success,.btn-primary { 
            height:auto;
	        background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(0, 0, 0) 100%), -webkit-linear-gradient(-45deg,  #2AADB8 0%,#2AADB8 100%);
			color: white !important;
		
		}
	</style> 

    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="h">
		<div class="top-right link">	 
			<a class="navbar-brand" href="#" style="color: white; font-size:16px;"><STRONG>GESTIÓN DOCUMENTAL</STRONG></a>		
		</div>
	</nav>  
</head>
<body>
    <div id="MostrarFor" style="display:none">
        <div class="col">
            <div class="card bg-light mb-3" >
                <div class="card-body">
                    <center> 
                        <img src="{{URL::asset('Imagenes/12.gif')}}" width="220" height="220"/>
                        <h5><strong>Firmando archivo/s, espere por favor...</strong></h5>
                    </center>
                </div>
                <div class="card-footer text-muted">
                    GESTIÓN DOCUMENTAL
                </div>
            </div> 
        </div>  
    </div> 
    <div id="IngresoFirma" class="container-fluid">  
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <br>
                <div class="col">
                    @include('messages')  
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <h4><strong>FIRMAR SOLICITUD {{ $Titulo_T }} </center></strong></h4>
                        </div>
                        <div class="table-responsive"> 
                            <div class="card-body"> 
                                <h4><strong>{{ $Nombres }} {{ $Apellidos }} </strong></h4>
                                <table table class="table table-hover"> 
                                    <thead> 
                                        <tr>
                                            <th>PDF</th>
                                            <th>VER</th> 
                                        </tr>
                                    </thead>  
                                    <tbody> 
                                    @foreach($Archivos as $post) 
                                        <tr>
                                            <td>
                                                {{$post->NombreDocumento  }} 
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('MostrarPDF11') }}">   
                                                    @csrf             
                                                    <input type="hidden" name="ID_DestinoDocumento" value="{{ $post->ID_DestinoDocumento }}">
                                                    <div class="btn-group" style=" width:50%;">	
                                                        <button type="submit" class="btn btn-primary active" formtarget="_blank">PDF</button>
                                                    </div>
                                                </form> 
                                            </td>
                                        </tr>
                                    @endforeach    
                                    </tbody>  
                                </table>   
                            </div> 
                            <div class="card-footer text-muted">
                                <form id="F_prestamo" name="F_prestamo" method="POST" action="{{ route('FirmandoSolicitud11') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="ID_LinkFirma" value= "{{ $ID_LinkFirma }}">
                                    <input type="hidden" name="ID_Funcionario_T" value= "{{ $ID_Funcionario_T }}">
                                    <input type="hidden" name="mousePosX" value="{{ $mousePosX }}">
                                    <input type="hidden" name="mousePosY" value="{{ $mousePosY }}">
                                    <input type="hidden" name="Pagina" value="{{ $Pagina }}">
                                    <input type="hidden" name="Ancho" value="{{ $Ancho }}"> 
                                    <input type="hidden" name="Alto" value="{{ $Alto }}">
                                    <strong>Por favor, Confirme su contraseña de usuario para firmar archivos.</strong>
                                    <div class="form-label-group">
                                        <input type="password" class="form-control" name="Contrasenia"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    <div class="btn-group" style=" width:100%;">
                                        <button type="submit" id="btnEnviar1" class="btn btn-success  btn-submit active">FIRMAR</button>
                                    </div>
                                </div>
                            </form> 
                        </div>
                        <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        </div> 
    </div>
    <div>		
        <div>
            <center><img src="{{URL::asset('Imagenes/escudo.png')}}" width="90" height="90"/></center>
            <center>
                © {{ date("Y") }} Dep. de informática V0.1<br>
                Municipalidad de Curicó<br>
                VERSIÓN BETA 0.5.230322 
            </center>
        </div>
    </div> 
    <div id="page-content-wrapper"> 
        @yield("content")
        @livewireScripts
        @yield('scripts')
        @yield("foot")
    </div>
</body>
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    $(document).ready(function(){               
        $(document).on('click', '#btnEnviar1', function(){ 
            $("#IngresoFirma").hide();       
            $("#errors").hide();  
            $("#MostrarFor").show(); 
        }); 
    }); 
</script>