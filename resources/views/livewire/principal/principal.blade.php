<div>
<br>
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
        <div class="card bg-light mb-3"> 
        @if(Auth::user()->Secretaria==0 AND (Auth::user()->Jefe==1 OR Auth::user()->Jefe==0))
            <div class="card-header">
                <h2><strong>SOLICITUDES</strong></h2>
            </div> 
            <div class="card-body"> 
                <div class="row">  
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">                      
                        <div class="card bg-light mb-3"> 
                            <br> 
                            <center><h5>INGRESAR</h5><h3><strong>*</strong></h3></center>      
                            <form method="POST" action="{{ route('CrearDocumento') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        NUEVO 
                                    </button> 
                                </div> 
                            </form>
                        </div> 
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">     
                        <div class="card bg-light mb-3" > 
                            <br> 
                            <center><h5>DETENIDAS</h5><h3><strong>{{ $PortafoliosDetenidos }}</strong></h3></center>      
                            <form method="POST" action="{{ route('EnvioOficinaPartes') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        DETENIDOS
                                    </button>  
                                </div>
                            </form>
                        </div>
                    </div>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">                      
                        <div class="card bg-light mb-3"> 
                            <br>
                                <center><h5>EN PROCESO</h5><h3><strong>{{ $PortafoliosEnProceso }}</strong></h3></center>      
                            <form method="POST" action="{{ route('DocumentoEnProcesoOP') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        EN PROCESO
                                    </button>  
                                </div>
                            </form>
                        </div>       
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">     
                        <div class="card bg-light mb-3" >
                            <br>
                            <center><h5>FINALIZADAS</h5><h3><strong>{{ $PortafoliosFinalizados }}</strong></h3></center>      
                            <form method="POST" action="{{ route('PortafoliosFinalizados') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        FINALIZADOS
                                    </button>  
                                </div>
                            </form> 
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">                      
                        <div class="card bg-light mb-3"> 
                            <br>
                            <center><h5>RECIBIDAS<h5><h3><strong>{{ $PortafoliosRecibidos }} </strong></h3></center>    
                            <form method="POST" action="{{ route('PortafoliosRecibidos') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        RECIBIDOS
                                    </button>  
                                </div>
                            </form>
                        </div>         
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">     
                        <div class="card bg-light mb-3" >
                            <br>
                            <center><h5>V°B°</h5><h3><strong>{{ $PortafolioRecibidosVB }} </strong></h3></center>      
                            <form method="POST" action="{{ route('PortafoliosRecibidosVB') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        V°B°
                                    </button>   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(Auth::user()->Secretaria==1)
            <div class="card-header">
                <h2><strong>SECRETARIA</strong></h2>
            </div> 
            <div class="card-body"> 
                <div class="row">  
                    <div class="col-sm-3">                      
                        <div class="card bg-light mb-3">  
                            <br>
                            <center><h5>INGRESAR</h5><h3><strong>*</strong></h3></center>            
                            <form method="POST" action="{{ route('CrearDocumentoODP') }}"> 
                                @csrf
                                <div class="btn-group" style=" width:100%;">
                                    <button type="submit" class="btn btn-primary">
                                        NUEVA 
                                    </button> 
                                </div> 
                            </form> 
                        </div>       
                    </div>
                    <div class="col-sm-3">                      
                        <div class="card bg-light mb-3">  
                            <br>
                            <center><h5>EXTERNOS RECIBIDOS</h5><h3><strong>{{ $PortafolioExterno }}</strong></h3></center>      
                            <form method="POST" action="{{ route('ODPExternos') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        EXTERNOS
                                    </button>  
                                </div> 
                            </form>
                        </div>       
                    </div>
                    <div class="col-sm-3">     
                        <div class="card bg-light mb-3" > 
                            <br>
                            <center><h5>INTERNOS RECIBIDOS</h5><h3><strong>{{ $PortafolioInterno }}</strong></h3></center>      
                            <form method="POST" action="{{ route('Distribuccion') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        INTERNOS
                                    </button>  
                                </div>
                            </form>
                        </div> 
                    </div>
                    <div class="col-sm-3">                      
                        <div class="card bg-light mb-3"> 
                            <br>
                            <center><h5>EXTERNOS V°B°</h5><h3><strong>{{ $PortafolioExternosVB }}</strong></h3></center>      
                            <form method="POST" action="{{ route('ODPExternosVB') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        EXTERNOS V°B°
                                    </button>  
                                </div> 
                            </form>
                        </div>       
                    </div>
                </div>
            </div>
        @endif
        @if(Auth::user()->Jefe==1)
            <div class="card-header">
                <h2><strong>JEFE</strong></h2> 
            </div> 
            <div class="card-body"> 
                <div class="row"> 
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-6">                      
                        <div class="card bg-light mb-3"> 
                            <br>
                            <center><h5>DIRECTOS</h5><h3><strong>{{ $PortafolioDirecto }}</strong></h3></center>      
                            <form method="POST" action="{{ route('PortafolioDirecto') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary">
                                        DIRECTOS
                                    </button>  
                                </div> 
                            </form>
                        </div>       
                    </div>
                    <div class="col-sm-3"></div> 
                </div>
            </div>
            @endif


            <div class="card-footer text-muted"> 
                <center><h7>{{ $diaFC }} {{ $numeroDiaFC }} de {{ $mesFC }} {{ $anioFC }}</h7><br></center>
            </div> 
        </div>