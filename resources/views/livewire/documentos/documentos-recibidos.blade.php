<div> 
    <br>  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            @include('messages')  
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div> 
@if($Detalles==0)   
    <div class="row">  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="card-header">
                         <h4><strong>Bandeja de entrada</strong></h4>
                    </div> 
                    <div class="card-body"> 
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <input class="form-control" type="text" placeholder="Buscar..." wire:model="search" title="Buscar por titulo,Tipo documento, Observación"/>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                        <select  class="form-control" wire:model="perPage">
                                            <option value="5" selected>Mostrar 5 por página</option>
                                            <option value="10">Mostrar 10 por página</option>
                                            <option value="15">Mostrar 15 por página</option>
                                            <option value="20">Mostrar 20 por página</option>
                                            <option value="25">Mostrar 25 por página</option>
                                            <option value="30">Mostrar 30 por página</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                        <center> 
                                            <button wire:click="clear" type="button" class="btn btn-danger active">X</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>   
                    <div class="table-responsive"> 
                        @if($posts->count()) 
                            <div class="card-body"> 
                                <div class="text-muted"> 
                                    <h4><strong>Solo los documentos firmados pueden ser enviados.</strong></h4>
                                </div>
                                <table table class="table table-hover">
                                    <thead>  
                                        <tr>  
                                            <th>Estado documento</th>
                                            <th>Creado por</th>
                                            <th>N° Folio</th>
                                            <th>Titulo documento</th>
                                            <th>Tipo documento</th>
                                            <th>Fecha Ingreso</th> 
                                            <th>Dias para termino</th>
                                            <th>Observacion</th>
                                            <th>Responder</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @foreach($posts as $post)
                                        <tr>
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            Detenido
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{$post->Nombres   }}  {{$post->Apellidos   }}
                                            </td>
                                            <td>
                                                {{$post->Folio   }}
                                            </td>
                                            <td>
                                                {{$post->Titulo_T  }}
                                            </td>
                                            <td>
                                                {{$post->Nombre_T   }}
                                            </td>
                                    @php
                                        $numeroDiaFC = date('d', strtotime($post->Fecha_T));
                                        $mesFC = date('F', strtotime($post->Fecha_T));
                                        $anioFC = date('Y', strtotime($post->Fecha_T));

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

                                        $date1=new DateTime(date("Y-m-d"));
                                        $date2=date_create($post->FechaUrgencia_T);
                                        $diff=date_diff($date1,$date2);
                                        $dias = $diff->format("%R%a");
                                        $Total = $dias*1;
                                    @endphp
                                    <td>
                                                {{$numeroDiaFC}}/{{$mesFC}}
                                            </td>
                                @if($Total>=10) 
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-success" 
                                                        role="progressbar"  style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> {{  $Total }} Dias</strong>
                                                    </div>
                                                </div>
                                            </td>
                                @elseif($Total<=9 & $Total>=1) 
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-info" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> {{  $Total }} Dias</strong>
                                                    </div>
                                                </div>
                                            </td>
                                @else 
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-danger" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> {{  $Total }} Dias atrasado</strong>
                                                    </div>
                                                </div>
                                            </td>
                                @endif
                                            <td>
                                                <textarea rows="3" style="width:100%;" disabled> {{$post->Observacion_T  }} </textarea>
                                            </td>
                                            <td> 
                                                <button class="btn btn-success" wire:click="Responder({{ $post->ID_IntDocFunc  }},{{ $post->ID_Documento_T }})">Responder</button>
                                            </td>   
                                        </tr>
                                @endforeach 
                                    </tbody>
                                </table>  
                            </div>
                        @else 
                            <div class="card-body">
                                <center><strong>No hay resultados para la búsqueda "{{ $search }}"</strong></center>
                            </div>
                        @endif   
                            <div class="card-footer table-responsive text-muted">
                                {{ $posts->links() }}
                            </div>	
                            <div class="card-footer text-muted">
                                GESTIÓN DOCUMENTAL
                            </div>
                 
                    </div>
                </div>
            </div>
        </div>
    </div> 
@elseif($Detalles==2)<!--Archivo Adicional-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            @include('messages')  
            <div class="col">   
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <h4><strong>Solicitar archivo adicional</strong></h4></div>
                    <br>
                    <div class="text-muted"> 
                        <h5><strong>A continuación agregue una observación sobre el documento adicional requerido.</strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h6>Observación</h6>
                                <div class="form-label-group"> 
                                <textarea class=" form-control" wire:model="Mensaje_R"></textarea>
                                </div>		
                            </div>
                        </div>   
                        <br>
                    </div> 
                    <div class="card-footer text-muted"> 
                        <div class="btn-group" style=" width:100%;">
                            <button class="btn btn-danger active" id="CancelarConfirmarIngreso"  wire:click="VolverPrincipal">VOLVER</button>	
                            <button class="btn btn-primary active" wire:click="SolicitudArchivo">CONFIRMAR</button>
                        </div> 
                    </div> 
                    <div class="card-footer text-muted">
                        GESTIÓN DOCUMENTAL
                    </div>
                </div>
            </div> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>				
    </div>        
@elseif($Detalles==3)<!--FIRMAR DOCUMENTOS-->
    <div  id="MostrarFor" style="display:none">
        <div class="col">
            <div class="card bg-light mb-3" >
                <div class="card-body">
                    <center> 
                        <img src="{{URL::asset('Imagenes/12.gif')}}" width="220" height="220"/>
                        <h5><strong>Firmando archivos, espere por favor...</strong></h5>
                    </center>
                </div>
                <div class="card-footer text-muted">
                    GESTIÓN DOCUMENTAL
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="IngresoFirma"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <div class="col">
                <div class="card bg-light mb-3" >
                    <div class="card-header">  
                        <center><h4>FIRMAR ARCHIVO</h4></center> 
                    </div>   
                    <div class="card-body">
                        <form method="POST" action="{{ route('Firmar2') }}"> 
                            @csrf    
                            <input type="hidden" name="ID_DestinoDocumento" value="{{ $ID_DestinoDocumento }}">	
                            <br>
                            @foreach($TipoFirma as $post) 
                                @if($post->TipoFirma==1)
                                    <h5>Firma atendida</h5>
                                    <div class="form-label-group">
                                        <input type="text" class="form-control" name="OTP"  placeholder="Ingrese OTP" autocomplete="off">
                                    </div>
                                    <hr>
                                @else
                                   <strong>Firma desatendida</strong>
                                    <div class="text-muted">
                                    <h6><strong>Para firmar el archivo ingrese a continuación la clave de usuario que utiliza al ingresar al sistema de gestión documental.</strong></h6>
                                    </div>
                                @endif
                            @endforeach
                            <div class="form-label-group">
                                <input type="password" class="form-control" name="Contrasenia"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                            </div>
                            <br>
                            <div class="card-footer text-muted">
                                <div class="btn-group" style=" width:100%;">	
                    
                                    <button type="submit" id="btnEnviar1" class="btn btn-success active btn-info">Aceptar</button>
                                </div> 
                            </div>
                        </form> 
                        <div class="card-footer text-muted">
                                <div class="btn-group" style=" width:100%;">	
                                    <button class="btn btn-danger active" id="CancelarConfirmarIngreso"  wire:click="VolverPrincipal">Cancelar</button>
                                
                                </div> 
                            </div>
                    </div> 
                    <div class="card-footer text-muted">
                        GESTIÓN DOCUMENTAL 
                    </div>
                </div>
            </div>
        <div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
    </div>
@elseif($Detalles==4) 
    <div> 
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('message2'))
            <div class="alert alert-danger">
                {{ session('message2') }}
            </div>
        @endif
    </div>  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <div class="col">
                <div class="card bg-light mb-3">
                    @if (session()->has('message'))
                        <div class="alert alert-success"> 
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session()->has('message2'))
                        <div class="alert alert-danger">
                            {{ session('message2') }}
                        </div> 
                    @endif
                    <div class="table-responsive"> 
                        <div class="card-header">
                            <h4><strong>1° LISTA DE ARCHIVOS</strong></h4>
                        </div> 
                        <br>
                        <div class="text-muted"> 
                            <h5><strong>En este paso puede revisar los archivos subidos por el solicitante, puede solicitar archivos adicionales si lo estima necesario, 
                                si está de acuerdo con los archivos agregados debe firmar cada uno de ellos para poder continuar con el paso 2.</strong></h5>
                        </div> 
                        <hr>
                        <div class="card-body">
                            <table table class="table table-hover">
                                <thead>  
                                    <tr>  
                                        <th>Subido por</th>
                                        <th>Nombre archivo</th>
                                        <!--<th>Ver</th>-->
                                        <th>Firmar</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($MostrarDocumentos as $post)
                                        <tr> 
                                                <td>
                                                    {{ $Nombres=$post->Nombres  }} {{ $Apellidos=$post->Apellidos }}
                                                </td>
                                                <td>
                                                    <textarea rows="3" style="width:100%;" disabled>   {{ $post->NombreDocumento }} </textarea>
                                                </td>
                                                <!--<td> 
                                                    <form method="POST" action="{{ route('MostrarPDF') }}">   
                                                        @csrf             
                                                        <input type="hidden" name="ID_DestinoDocumento" value="{{ $post->ID_DestinoDocumento }}">
                                                        <div class="btn-group" style=" width:50%;">	
                                                            <button type="submit" class="btn btn-primary active" formtarget="_blank">PDF</button>
                                                        </div>
                                                    </form> 
                                                </td>-->
                                        @if($post->Firmado==0 & $post->ID_FSube!=Auth::user()->ID_Funcionario_T)
                                                <!--<td colspan="2"> 
                                                    <div class="btn-group" style=" width:50%;">	
                                                        <button class="btn btn-warning active" wire:click="FirmarDocumento({{ $post->ID_DestinoDocumento  }})">FIRMAR</button>
                                                    </div>
                                                </td>--> 
  
                                                <td colspan="2"> 
                                                    <form method="POST" action="{{ route('FirmarDocumentoInterno2') }}">
                                                            @csrf      
                                                            <input type="hidden" name="ID_DestinoDocumento" value="{{ $post->ID_DestinoDocumento  }}">	
                                                                <div class="btn-group" style=" width:50%;">	
                                                                    <button type="submit" id="btnEnviar1" class="btn btn-warning active">FIRMAR</button>
                                                                </div>
                                                        </form> 
                                                </td> 
                                        @elseif($post->Firmado==0  &  $post->ID_FSube==Auth::user()->ID_Funcionario_T)
                                                <td>
                                                    <div class="btn-group" style=" width:50%;">	
                                                        <button class="btn btn-warning active" wire:click="FirmarDocumento({{ $post->ID_DestinoDocumento  }})">FIRMAR</button>
                                                    </div>
                                                </td> 
                                                <td>
                                                    <div class="btn-group" style=" width:50%;">	
                                                        <button class="btn btn-danger active" wire:click="EliminarDocumento({{ $post->ID_DestinoDocumento  }})">Eliminar</button>
                                                    </div>
                                                </td>
                                        @elseif($post->Firmado==1)    
                                        <td> 
                                                    <form method="POST" action="{{ route('MostrarPDF') }}">   
                                                        @csrf             
                                                        <input type="hidden" name="ID_DestinoDocumento" value="{{ $post->ID_DestinoDocumento }}">
                                                        <div class="btn-group" style=" width:50%;">	
                                                            <button type="submit" class="btn btn-primary active" formtarget="_blank">PDF</button>
                                                        </div>
                                                    </form> 
                                                </td> 
                                                <td>
                                                    @php 
                                                        $FechaFirma = $post->FechaFirma;
                                                        $MostrarFecha = date("d-m-Y", strtotime($FechaFirma));
                                                    @endphp
                                                    <strong>FIRMADO EL {{$MostrarFecha   }}</strong>
                                                </td>
                                        @endif
                                        </tr>
                                    @endforeach 
                                </tbody> 
                            </table> 
                        </div> 
                        <div class="card-footer table-responsive text-muted">
                            {{ $MostrarDocumentos->links() }}
                        </div>
                        <div class="card-footer text-muted">  
                            <div class="btn-group" style=" width:100%;">
                                <button class="btn btn-warning active" wire:click="Solicitar">SOLICITAR ARCHIVO ADICIONAL</button>
                            </div> 
                        </div>
                    </div> 
              
                    <div class="table-responsive"> 
                        <div class="card-header">
                            <h4><strong>2° AGREGAR ARCHIVO/S</strong></h4>
                        </div> 
                        <br>
                        <div class="text-muted"> 
                            <h5><strong>Si considera necesario puede finalizar esta solicitud agregando archivos adicionales, estos archivos también deben ser firmados. En caso contrario puede omitir este paso y continuar con el paso 3.</strong></h5>
                        </div> 	
                        <hr>
                        <div class="card-body">
                            <div class="form-group">
                                <h5>Agregar archivo/s*</h5>
                                <div class="form-label-group"> 
                                    <input type="file" class="form-control" wire:model="PDF" multiple>
                                </div>  
                            </div>
                            <div wire:loading wire:target="PDF">
                                <center> 
                                    <h5><strong>Subiendo documento/s, espere por favor...</strong></h5>
                                </center>
                            </div> 
                        </div> 
                        <div class="card-footer text-muted"> 
                        </div>
                        <div class="card-footer text-muted">
                            <div class="btn-group" style=" width:100%;">
                                <button class="btn btn-warning active" wire:click="Ingresar">AGREGAR ARCHIVO</button>
                            </div>  
                        </div>
                    </div>  
             
                        <div class="table-responsive">
                            <div class="card-header">
                                <h4><strong>3° RESPUESTA</strong></h4>
                            </div>   
                            <br>
                            <div class="text-muted"> 
                                <h5><strong>Antes de finalizar esta solicitud debe firmar los archivos subidos por el emisor, en caso de rechazar dicha solicitud, la firma de estos archivos no es necesaria.</strong></h5>
                            </div> 
                            <hr>
                            <div class="card-body">
                                <label><strong>Seleccionar Respuesta</strong></label>
                                <td> 
                                    <select id="test" class="form-control" wire:model="Opciones">
                                        <option value="0" selected>---Seleccionar---</option>
                                        <option value="1" >ACEPTAR</option>
                                        <option value="3" >RECHAZAR</option>
                                    </select>
                                </td> 
                            </div>  
                            
                            @if($RespuestaOpciones==0)
                            <div class="card-footer text-muted">  
                                    <div class="btn-group" style=" width:100%;">	
                                        <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                    </div> 
                                </div> 
                            @elseif($RespuestaOpciones==1)
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <h6>Agregar observación (Opcional)</h6>
                                            <div class="form-label-group"> 
                                                <textarea class=" form-control" wire:model="ObservacionAceptado"></textarea>
                                            </div>		
                                        </div> 
                                    </div> 
                                    @if (session()->has('messageFinalizado'))
                                        <div class="alert alert-danger">
                                            {{ session('messageFinalizado') }}
                                        </div>
                                    @endif
    
                                </div> 
                                <div class="card-footer text-muted">  
                                    <div class="btn-group" style=" width:100%;">	
                                        <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                        <button class="btn btn-success active" wire:click="AceptarDocumento">ACEPTAR</button>
                                    </div> 
                                </div>
                            @elseif($RespuestaOpciones==3)
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <h6>Agregar observación</h6>
                                            <div class="form-label-group"> 
                                                <textarea class=" form-control" wire:model="ObservacionAceptado"></textarea>
                                            </div>		
                                        </div>  
                                    </div>  
                                </div> 
                                <div class="card-footer text-muted">  
                                    <div class="btn-group" style=" width:100%;">	
                                        <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                        <button class="btn btn-warning active" wire:click="RechazarDocumento">RECHAZAR</button>
                                     </div> 
                                </div> 
                            @endif
                            <div class="card-footer text-muted">
                                GESTION DOCUMENTAL
                            </div>
                        </div>  
                    </div>
                </div>	
            </div>	
        </div>	
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>		
    </div> 
@endif   
</div>



  
 

        
 
