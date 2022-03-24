<div> 
    <br> 
@if($Ayuda==1)    
    <div class="container-fluid">  
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3">  
                        <div class="card-header"> 
                        <center>
                                <h5> 
                                    <strong>
                                        INFORMACIÓN
                                    </strong>
                                </h5>
                            </center> 
                        </div>
                        <div class="card-body">
                            <center><img src="{{URL::asset('Imagenes/ODP/ExternosVB.JPG')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
                        </div>
                        <div class="card-footer text-muted"> 
                            <div class="btn-group" style=" width:100%;">	
                                <button class="btn btn-danger active" wire:click="VolverAyuda">
                                    VOLVER
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                @include('messages')  
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
        </div>
    </div> 
@if($Detalles==0)     
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col"> 
                    <div class="card bg-light mb-3"> 
                        <div class="card-header">
                            <h4><strong>SOLICITUDES EXTERNAS V°B°</strong></h4>
                        </div> 
                        <div class="card-body"> 
                            <div class="row"> 
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" onmouseover="mostrar('Más información.');" onmouseout="ocultar()" width="25" height="25"/></button>
                                    <button class="btn btn-warning" onclick="location.reload()"><img src="{{URL::asset('Imagenes/Actualizar.png')}}" width="25" height="25"/></button>
                                    <strong><div id="ver"></div></strong>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <select  class="form-control" wire:model="Orden">
                                        <option value="1" selected>Asc. fecha</option>
                                        <option value="2">Desc. fecha</option>
                                    </select>
                                </div> 
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <input class="form-control" type="text" placeholder="Buscar..." wire:model="search" title="Buscar por titulo,Tipo documento, Observación"/>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
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
                        @if($posts->count()) 
                            <div class="card-body table-responsive">
                                <table table class="table table-hover">
                                    <thead>  
                                        <tr>
                                            <th>ENVIADO POR</th>
                                            <th>FUNCIONARIO</th>
                                            <th>N° INTERNO</th> 
                                            <th>N° FOLIO</th>
                                            <th>TÍTULO</th> 
                                            <th>DOCUMENTO</th>
                                            <th>INGRESO</th> 
                                            <th>DÍAS PARA TERMINO</th>
                                            <th>OBSERVACIÓN</th>
                                            <th>SOLICITUD</th>
                                            <th>RECHAZAR</th>
                                        </tr> 
                                    </thead>
                                    <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>
                                                {{$post->Nombre_DepDir}}
                                            </td>
                                            <td>
                                                {{$post->Nombres}} {{$post->Apellidos}}
                                            </td>
                                            <td>
                                                {{$post->NumeroInterno}}{{$post->Anio}}
                                            </td>
                                            <td>
                                                {{$post->Folio   }}
                                            </td>
                                            <td>
                                            <strong>{{$post->Titulo_T}}</strong>
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
                                                {{$numeroDiaFC}} de {{$mesFC}}
                                            </td>
                                    @if($Total>=10) 
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                                        role="progressbar"  style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> {{  $Total }} Días </strong>
                                                    </div>
                                                </div>
                                            </td> 
                                    @elseif($Total<=9 & $Total>=1) 
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> {{  $Total }} Días </strong>
                                                    </div>
                                                </div>
                                            </td>
                                    @else 
                                            <td>
                                                
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> {{  $Total }} Días atrasados</strong>
                                                    </div>
                                                </div>
                                            </td>
                                    @endif 
                                            <td>
                                                <textarea rows="3" style="width:100%;" disabled> {{$post->ObservacionE}} </textarea>
                                            </td>
                                            <td>  
                                                <button class="btn btn-success active" wire:click="Responder({{$post->ID_Aviso_T}},{{$post->ID_Documento_T}})">ADMINISTRAR</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger active" wire:click="ComfirmarRechazo({{$post->ID_Aviso_T}})">RECHAZAR</button>
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
                                GESTIÓN DOCUMENTAL <br>
                                SECRETARIA/O OFICINA DE PARTES {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                            </div>
                    </div>
                </div>
            </div>
        </div>
@elseif($Detalles==1) 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <h4><strong>RECHAZAR PORTAFOLIO</strong></h4>
                    </div> 
                    <div class="card-body">
                        <h5>Si considera que el portafolio de <strong> {{ $NombreEliminar }} </strong>fue recibido de manera incorrecta, puede rechazar dicho portafolio.</h5>
                        <br>
                        <strong>AGREGAR OBSERVACIÓN</strong>
                        <div class="form-label-group"> 
                            <textarea class=" form-control" wire:model="ObservacionRechazo"></textarea>
                        </div>
                        <br>	
                        <strong>Por favor, Confirme su contraseña de usuario.</strong>
                        <div class="form-label-group">
                            <input type="password" class="form-control" wire:model="ContraseniaRechazo"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                        </div>
                        <br>
                        <div class="btn-group" style=" width:100%;">	
                            <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                            <button class="btn btn-success active" wire:click="RechazarPortafolio">CONFIRMAR</button>
                        </div> 
                    </div> 
                    <div class="card-footer text-muted"> 
                    </div>
                    <div class="card-footer text-muted"> 
                        GESTIÓN DOCUMENTAL <br>
                        SECRETARIA/O OFICINA DE PARTES {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                    </div>
                </div>
                </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>
@elseif($Detalles==2) 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <h4><strong>ARCHIVOS</strong></h4>
                        </div> 
                        <div class="card-body table-responsive">
                            <table table class="table table-hover">
                                <thead>  
                                    <tr>  
                                        <th>SUBIDO POR</th>
                                        <th>NOMBRE ARCHIVO</th>
                                        <th>VER</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                @foreach($MostrarDocumentos as $post)
                                    @if($post->Privado==0)
                                        <tr> 
                                            <td>
                                                {{ $post->Nombres  }} {{ $post->Apellidos }} 
                                            </td>
                                            <td>
                                                <textarea rows="3" style="width:100%;" disabled>   {{ $post->NombreDocumento }} </textarea>
                                            </td>
                                            <td> 
                                                <form method="POST" action="{{ route('MostrarPDF') }}">   
                                                    @csrf             
                                                    <input type="hidden" name="ID_DestinoDocumento" value="{{ $post->ID_DestinoDocumento }}">
                                                    <div class="btn-group" style=" width:50%;">	
                                                        <button type="submit" class="btn btn-primary active" formtarget="_blank">PDF</button>
                                                    </div>
                                                </form> 
                                            </td>
                                        </tr>
                                    @else
                                        <tr> 
                                            <td colspan="3">
                                                <center><strong>NO DISPONIBLE</strong></center>
                                            </td>
                                        </tr>
                                    @endif  
                                @endforeach 
                                </tbody> 
                            </table>  
                        </div> 
                    </div>
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <h4><strong>V°B°</strong></h4>
                        </div> 
                        <div class="card-body table-responsive">
                            <table table class="table table-hover">
                                <thead>  
                                    <tr>
                                        <th>ESTADO</th>
                                        <th>NOMBRE</th>
                                        <th>OBSERVACIÓN ENVIADO</th>
                                        <th>FECHA RECIBIDO</th>  
                                        <th>VISTO</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                    @foreach($DestinoPortafolio as $post)
                                        <tr>
                                        @if($post->Estado==0)  
                                                <td>
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" 
                                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"> 
                                                            PENDIENTE
                                                        </div>
                                                    </div>
                                                </td>
                                        @elseif($post->Estado==1)
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            ACEPTADO     
                                                        </div>
                                                    </div>
                                                </td>
                                        @else
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" 
                                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            RECHAZADO
                                                        </div>
                                                    </div>
                                                </td>
                                        @endif
                                            <td>
                                                {{$post->Nombres}} {{$post->Apellidos}}
                                            </td> 
                                            <td>
                                                {{$post->Observacion}}
                                            </td> 
                                        @php
                                            $numeroDiaR = date('d', strtotime($post->FechaR));
                                            $mesR = date('F', strtotime($post->FechaR));

                                            if($mesR=='January'){
                                            $mesR= 'Enero';
                                            }
                                            elseif($mesR=='February'){   
                                            $mesR= 'Febrero';
                                            }
                                            elseif($mesR=='March'){  
                                            $mesR= 'Marzo';
                                            }
                                            elseif($mesR=='April'){
                                                $mesR= 'Abril';
                                            }
                                            elseif($mesR=='May'){
                                                $mesR= 'Mayo';
                                            }
                                            elseif($mesR=='June'){
                                                $mesR= 'Junio';
                                            }
                                            elseif($mesR=='July'){ 
                                                $mesR= 'Julio';
                                            }
                                            elseif($mesR=='August'){  
                                                $mesR= 'Agosto';
                                            }
                                            elseif($mesR=='September'){  
                                                $mesR= 'Septiembre';
                                            }
                                            elseif($mesR=='October'){  
                                                $mesR= 'Octubre';
                                            }
                                            elseif($mesR=='November'){  
                                                $mesR= 'Noviembre';
                                            }
                                            else{  
                                                $mesR= 'Diciembre';
                                            }
                                        @endphp
                                            <td>
                                                {{$numeroDiaR}} de {{$mesR}}
                                            </td> 
                                            @if($post->Visto==0)
                                                <td> 
                                                    <button class="btn btn-danger active" wire:click="AnularFirmantes({{ $post->IPFVB }})">ELIMINAR</button>
                                                </td>
                                            @else
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar bg-success" 
                                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            SI
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach 
                                <tbody> 
                            </table> 
                        </div>
                    </div>
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <h4><strong>ENVIAR</strong></h4>
                        </div>
                        <div class="card-body">
                            <table table class="table table-hover">
                                <label><strong>ENVIAR A:</strong></label>
                                <select wire:model="DestinoFuncionario" class="form-control" >
                                    <option value="" selected>---SELECCIONAR---</option>
                                    @foreach($FuncionariosAsig as $post)
                                    <option value="{{ $post->ID_Funcionario_T }}">{{ $post->Nombres }}{{ $post->Apellidos }}</option>
                                    @endforeach
                                </select>
                                <label><strong>AGREGAR OBSERVACIÓN (OPCIONAL)</strong></label>
                                <div class="form-label-group"> 
                                    <textarea class=" form-control" wire:model="ObservacionPortafolio"></textarea>
                                </div>		
                            </table> 
                        </div> 
                        <div class="card-footer text-muted">  
                            <div class="btn-group" style=" width:100%;">	
                                <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                <button class="btn btn-success active" wire:click="EnviarPortafolio">ENVIAR</button>
                            </div> 
                        </div>
                        <hr> 
                        <div class="card-body">
                            <h5>Si el portafolio ha sido enviado a los funcionarios requeridos, puede dar por confirmada su recepción.</h5>
                        </div>
                        <br>
                        @if (session()->has('messageFinalizar1'))
                            <div class="alert alert-danger">
                                {{ session('messageFinalizar1') }} 
                            </div>
                        @endif
                        <div class="card-footer text-muted">  
                            <div class="btn-group" style=" width:100%;">	
                                <button class="btn btn-success active" wire:click="ConfirmarFinalizarPortafolio">CONFIRMAR PORTAFOLIO</button>
                            </div> 
                        </div>
                        <div class="card-footer text-muted"> 
                        </div>
                        <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL <br>
                            SECRETARIA/O OFICINA DE PARTES {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                        </div>
                    </div>  
                </div>	
            </div>
        </div> 
@elseif($Detalles==3) 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <div class="col">
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <h4><strong>NO DISPONIBLE</strong></h4>
                        </div> 
                        <div class="card-body">
                            <h6>El portafolio fue enviado a un funcionario, por lo que la opción de rechazo no esta disponible.</h6>
                            <br>
                        </div> 
                        <center>
                        <div class="btn-group" style=" width:50%;">
                            <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        </div> 
                        </center>
                        <br>
                        <div class="card-footer text-muted"> 
                        </div>
                        <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL <br>
                            SECRETARIA/O OFICINA DE PARTES {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        </div>  
@elseif($Detalles==4)  
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <div class="col">
                    @if (session()->has('message4'))
                        <div class="alert alert-danger">
                            {{ session('message4') }} 
                        </div>
                    @endif
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <h4><strong>FINALIZAR PORTAFOLIO</strong></h4>
                        </div> 
                        <div class="card-body">
                            <h6>¿DESEA CONFIRMAR PORTAFOLIO?</h6>
                            <br>
                            <strong>RESPUESTA*</strong> 
                            <select wire:model="RespuestaFinal" class="form-control" >
                                    <option value="" selected>---SELECCIONAR---</option>
                                    <option value="1">ACEPTADO</option>
                                    <option value="2">RECHAZADO</option>
                            </select> 
                        <strong>AGREGAR OBSERVACIÓN (OPCIONAL)</strong>
                        <div class="form-label-group"> 
                            <textarea class=" form-control" wire:model="ObservacionFinalizado"></textarea>
                        </div>
                        </div> 
                        <br>
                        <div class="btn-group" style=" width:100%;">
                            <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                            <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="FinalizarPortafolio">CONFIRMAR</button>
                        </div>
                        <br>
                        <div class="card-footer text-muted"> 
                        </div>
                        <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL <br>
                            SECRETARIA/O OFICINA DE PARTES {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        </div> 
    @endif   
</div>
@endif



  
 

        
 
