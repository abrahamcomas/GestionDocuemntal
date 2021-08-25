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

  <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="table-responsive">
                        <div class="card-header">
                            <h5><strong>Gestión Documental</strong></h5>
                        </div> 
                        <div class="card-body"> 
                            <div class="row">  
                                <div class="col-sm-6">
                                    <div class="card bg-light mb-3" >  
                                    <div class="card-footer text-muted">
                                         
                                         </div>  
                                        <div class="card-body">
                                            <h5 class="card-title">Nuevo Documento</h5>
                                            <p class="card-text">  Ingrese un nuevo documento para su posterior difusión.</p>
                                            <a href="{{ route('CrearDocumento') }}" class="btn btn-primary">INGRESAR</a>
                                        </div>
                                        <div class="card-footer text-muted">
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card bg-light mb-3" >  
                                    <div class="card-footer text-muted">
                                         
                                         </div>  
                                        <div class="card-body">
                                            <h5 class="card-title">Documentos en proceso</h5>
                                            <p class="card-text">Revise el estado de sus documentos.</p>
                                            <a href="{{ route('Distribuccion') }}" class="btn btn-primary">VER</a>
                                        </div>
                                        <div class="card-footer text-muted">
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="card-body"> 
                            <div class="row">  
                                <div class="col-sm-6">
                                    <div class="card bg-light mb-3" > 
                                        <div class="card-footer text-muted">
                                         
                                         </div>   
                                        <div class="card-body">
                                            <h5 class="card-title">Bandeja de entrada</h5>
                                            <p class="card-text"> Analice los documentos recibidos para que continúen su flujo.</p>
                                            <a href="{{ route('DocumentosDeEntrada') }}" class="btn btn-primary">REVISAR</a>
                                        </div>
                                        <div class="card-footer text-muted">
                                
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card bg-light mb-3" >
                                        <div class="card-footer text-muted">
                                         
                                         </div>  
                                        <div class="card-body">
                                            <h5 class="card-title">Documentos de aviso</h5>
                                            <p class="card-text">Documentos de solo aviso, para que se mantenga informado.</p>
                                            <a href="{{ route('DocumentosAvisos') }}" class="btn btn-primary">VER</a>
                                        </div>
                                        <div class="card-footer text-muted">
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                
                                <div class="card-footer text-muted"> 
                                <center><h7>{{ $diaFC }} {{ $numeroDiaFC }} de {{ $mesFC }} {{ $anioFC }}</h7><br></center>
                                                    <center>{{ $hoy = date("g:i a")  }}</center>
                                </div>
                           
                  
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>




</div>
  