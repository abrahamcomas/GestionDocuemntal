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
    <style type="text/css">
        .card .card__corner {
        position: absolute;
        top: 0;
        right: 0;
        width: 2em;
        height: 2em;
        background-color: #e6e7e8;
        }

        .card .card__corner .card__corner-triangle {
        position: absolute;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 2em 2em 0;
        border-color: transparent #f1f2f2 transparent transparent;
        }
    </style>
        <div class="card bg-light mb-3">
            <div class="text-muted">
                <br> 
                <h1><center><strong>SOLICITUDES</strong></center></h1>
                <hr>
            </div> 
            <div class="card-body"> 
                <div class="row">  
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">                      
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>
                            <div style="background: linear-gradient(10deg, #272C2E, #24A44B);">
                                <br> 
                                <div style="color: #FFFFFF"><center><h5>INGRESAR</h5><h3><strong>*</strong></h3></center></div> 
                                <form method="POST" action="{{ route('CrearDocumento') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div> 
                                </form>
                            </div> 
                        </article>  
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">     
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>      
                            <div style="background: linear-gradient(10deg, #272C2E, #2452A4);">
                                <br> 
                                <div style="color: #FFFFFF"><center><h5>DETENIDAS</h5><h3><strong>{{ $PortafoliosDetenidos }}</strong></h3></center></div>       
                                <form method="POST" action="{{ route('EnvioOficinaPartes') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div> 
                                </form>
                            </div>
                        </article>  
                    </div>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">                      
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>      
                            <div style="background: linear-gradient(10deg, #272C2E, #7524A4);"> 
                                <br>
                                <div style="color: #FFFFFF"><center><h5>EN PROCESO</h5><h3><strong>{{ $PortafoliosEnProceso }}</strong></h3></center></div>       
                                <form method="POST" action="{{ route('DocumentoEnProcesoOP') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div> 
                                </form>
                            </div>   
                        </article>      
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">     
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>      
                            <div style="background: linear-gradient(10deg, #272C2E, #A4243F);">
                                <br>
                                <div style="color: #FFFFFF"><center><h5>FINALIZADAS</h5><h3><strong>{{ $PortafoliosFinalizados }}</strong></h3></center></div>       
                                <form method="POST" action="{{ route('PortafoliosFinalizados') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div> 
                                </form> 
                            </div>
                        </article>  
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">                      
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>      
                            <div style="background: linear-gradient(10deg, #272C2E, #A4A224);">
                                <br>
                                <div style="color: #FFFFFF"><center><h5>RECIBIDAS<h5><h3><strong>{{ $PortafoliosRecibidos }} </strong></h3></center></div>     
                                <form method="POST" action="{{ route('PortafoliosRecibidos') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div> 
                                </form>
                            </div>  
                        </article>         
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">    
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>
                            <div style="background: linear-gradient(10deg, #272C2E, #A46D24);">
                                <br>
                                <div style="color: #FFFFFF"><center><h5>V°B°</h5><h3><strong>{{ $PortafolioRecibidosVB }} </strong></h3></center></div>       
                                <form method="POST" action="{{ route('PortafoliosRecibidosVB') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div> 
                                </form>
                            </div>
                        </article>  
                    </div>
                </div>
            </div>
        @if(Auth::user()->Secretaria==1)
            <div class="text-muted">
                <br> 
                <h1><center><strong>SECRETARIA</strong></center></h1>
                <hr>
            </div>
            <div class="card-body"> 
                <div class="row">  
                    <div class="col-sm-3">  
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>                    
                            <div style="background: linear-gradient(10deg, #272C2E, #11D8DB);">
                                <br>
                                <div style="color: #FFFFFF"><center><h5>INGRESAR</h5><h3><strong>*</strong></h3></center></div>          
                                <form method="POST" action="{{ route('CrearDocumentoODP') }}"> 
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div> 
                                </form> 
                            </div> 
                        </article>          
                    </div>
                    <div class="col-sm-3"> 
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>                     
                            <div style="background: linear-gradient(10deg, #272C2E, #2CC20D);">  
                                <br>
                                <div style="color: #FFFFFF"><center><h5>EXTERNOS RECIBIDOS</h5><h3><strong>{{ $PortafolioExterno }}</strong></h3></center></div>       
                                <form method="POST" action="{{ route('ODPExternos') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div>  
                                </form>
                            </div>  
                        </article>         
                    </div> 
                    <div class="col-sm-3"> 
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>    
                            <div style="background: linear-gradient(10deg, #272C2E, #2BB47E);">
                                <br>
                                <div style="color: #FFFFFF"><center><h5>INTERNOS RECIBIDOS</h5><h3><strong>{{ $PortafolioInterno }}</strong></h3></center></div>       
                                <form method="POST" action="{{ route('Distribuccion') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF">INGRESAR</strong>
                                        </button> 
                                    </div> 
                                </form>
                            </div> 
                        </article>    
                    </div>
                    <div class="col-sm-3">  
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div> 
                            <div style="background: linear-gradient(10deg, #272C2E, #B50A96);">
                                <br>
                                <div style="color: #FFFFFF"><center><h5>EXTERNOS V°B°</h5><h3><strong>{{ $PortafolioExternosVB }}</strong></h3></center></div>       
                                <form method="POST" action="{{ route('ODPExternosVB') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div> 
                                </form>
                            </div>
                        </article>           
                    </div>
                </div>
            </div>
        @endif
        @if(Auth::user()->Jefe==1)
            <div class="text-muted">
                <br> 
                <h1><center><strong>JEFE</strong></center></h1>
                <hr>
            </div>
            <div class="card-body"> 
                <div class="row"> 
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-6">                      
                        <article class="card">
                            <div class="card__corner">
                                <div class="card__corner-triangle"></div>
                            </div>
                            <div style="background: linear-gradient(10deg, #272C2E, #07AEB1);">
                                <br>
                                <div style="color: #FFFFFF"><center><h5>DIRECTOS</h5><h3><strong>{{ $PortafolioDirecto }}</strong></h3></center></div>      
                                <form method="POST" action="{{ route('PortafolioDirecto') }}">
                                    @csrf
                                    <hr style="background-color: #FFFFFF">
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn">
                                        <strong style="color: #FFFFFF"> INGRESAR </strong>
                                        </button> 
                                    </div>  
                                </form>
                            </div>    
                        </article>    
                    </div>
                    <div class="col-sm-3"></div> 
                </div>
            </div>
            @endif
            <div class="card-footer text-muted"> 
                <center><h7>{{ $diaFC }} {{ $numeroDiaFC }} de {{ $mesFC }} {{ $anioFC }}</h7><br></center>
            </div> 
        </div>













