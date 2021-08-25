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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="table-responsive">
                        <div class="card-header">
                            <h5><strong>Bandeja de entrada</strong></h5>
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
                    @if($posts->count()) 
                        <div class="card-body">
                            <h8><strong>Solo los documentos firmados pueden ser finalizados o enviados.</strong></h8>
                            <div class="table-responsive"> 
                            <table table class="table table-hover">
                                <thead> 
                                    <tr>  
                                        <th>Firma</th>
                                        <th>Titulo</th>
                                        <th>Tipo</th>
                                        <th>Fecha Ingreso</th> 
                                        <th>Observacion</th>
                                        <th>Documento</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $post)
                                        <tr>
                                        @if(empty($post->Firmado))
                                            <td>
                                                <div class="btn-group" style=" width:100%;">	
                                                    <button class="btn btn-danger active" wire:click="FirmarDocumento({{ $post->ID_Documento_T }})">FIRMAR</button>
                                                </div>
                                            </td>
                                    @else
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-success" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> FIRMADO </strong>
                                                    </div>
                                                </div>
                                            </td>
                                    @endif
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

                                @if($Total>=10) 
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-success" 
                                                        role="progressbar"  style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> {{  $Total }} Dias faltantes </strong>
                                                    </div>
                                                </div>
                                                <center>{{$numeroDiaFC}} de {{$mesFC}} del {{$anioFC}}</center>
                                            </td>
                                @elseif($Total<=9 & $Total>=1) 
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-info" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> {{  $Total }} Dias faltantes </strong>
                                                    </div>
                                                </div>
                                                <center>{{$numeroDiaFC}} de {{$mesFC}} del {{$anioFC}}</center>
                                            </td>
                                @else 
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-danger" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong> {{  $Total }} Dias </strong>
                                                    </div>
                                                </div>
                                                <center>{{$numeroDiaFC}} de {{$mesFC}} del {{$anioFC}}</center>
                                            </td>
                                @endif
                                            <td>
                                                <textarea rows="3" style="width:100%;" disabled> {{$post->Observacion_T  }} </textarea>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('MostrarPDF') }}">   
                                                    @csrf             
                                                    <input type="hidden" name="ID_Documento_T" value="{{ $post->ID_Documento_T }}"> 
                                                    <div class="btn-group" style=" width:100%;">	 
                                                        <button type="submit" class="btn btn-primary active" wire:click="Visto({{ $post->ID_Documento_T }})" formtarget="_blank">PDF</button>
                                                    </div>
                                                </form> 
                                            </td>
                                            <td> 
                                                <button class="btn btn-success" wire:click="Opciones({{ $post->ID_Documento_T }})">OPCIONES</button>
                                            </td>   
                                        </tr>
                                @endforeach 
                                </tbody>
                            </table>  
                        </div>
                        <div class="card-footer text-muted">
                            {{ $posts->links() }}
                        </div>	
                        <div class="card-footer text-muted">
                            GESTIÓN DOCUMENTAL
                        </div>
                    @else 
                        <div class="card">
                            <div class="card-body">
                                <center><strong>No hay resultados para la búsqueda "{{ $search }}"</strong></center>
                            </div>
                        </div>
                        <br>
                    @endif    
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div> 
@elseif($Detalles==1)   
    <div  id="MostrarFor" style="display:none">
        <div class="col">
            <div class="card bg-light mb-3" >
                <div class="card-body">
                    <center> 
                        <img src="{{URL::asset('Imagenes/12.gif')}}" width="220" height="220"/>
                        <h5><strong>Firmando documentos, espere por favor...</strong></h5>
                    </center>
                </div>
                <div class="card-footer text-muted">
                    GESTIÓN DOCUMENTAL
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="IngresoFirma"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
            <div class="col">
                <div class="card bg-light mb-3" >
                    <div class="card-header">
                        <center><h5>¿DESEA FIRMAR DOCUMENTO?</h5></center> 
                    </div>   
                    <div class="card-body">
                        <form method="POST" action="{{ route('Firmar2') }}">
                            @csrf    
                            <input type="hidden" name="ID_Documento_T" value="{{ $ID_Documento_T }}">	
                            <br>
                            @foreach($TipoFirma as $post) 
                                @if($post->TipoFirma==1)
                                    <h6>Firma atendida</h6>
                                    <div class="form-label-group">
                                        <input type="text" class="form-control" name="OTP"  placeholder="Ingrese OTP" autocomplete="off">
                                    </div>
                                    <hr>
                                @else
                                    <h6>Firma desatendida</h6>
                                @endif
                            @endforeach
                            <div class="form-label-group">
                                <input type="password" class="form-control" name="Contrasenia"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                            </div>
                            <br>
                            <center>
                                <button type="submit" id="btnEnviar1" class="btn btn-success active btn-info">Aceptar</button>
                            </center>
                        </form> 
                    </div> 
                    <div class="btn-group">
                        <button class="btn btn-danger btn-lg active" id="CancelarConfirmarIngreso"  wire:click="VolverPrincipal">Cancelar</button>
                    </div>
                    <br>
                    <div class="card-footer text-muted">
                        GESTIÓN DOCUMENTAL
                    </div>
                </div>
            </div>
        <div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
    </div>
@elseif($Detalles==2)
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3" > 
                    <div class="card">
                        <div class="table-responsive">
                            <div class="card-header">
                                <h5><strong>Respuesta Documentos</strong></h5>
                            </div>  
                            <div class="card-body">
                                <label><strong>Seleccionar Respuesta</strong></label>
                                <td> 
                                    <select id="test" class="form-control" wire:model="Opciones">
                                        <option value="0" selected>---Seleccionar---</option>
                                        <option value="1" >ACEPTAR Y FINALIZAR</option>
                                        <option value="2" >ACEPTAR Y ENVIAR</option>
                                        <option value="4" >ACEPTAR</option>
                                        <option value="3" >RECHAZAR</option>
                                    </select>
                                </td> 
                            </div> 
                            @if($RespuestaOpciones==0)
                                <div class="card-body"> 
                                    <div class="btn-group" style=" width:100%;">	
                                        <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                    </div> 
                                </div> 
                            @elseif($RespuestaOpciones==1)
                                <div class="card-body">
                      
                                    <div class="form-group">
                                        <center> <h5><strong>Elegir archivo</strong></h5></center>
                                        <div class="form-label-group"> 
                                            <input type="file" class="form-control" wire:model="PDF">
                                        </div> 
                                    </div>
                                @if (session()->has('messageFinalizado'))
                                    <div class="alert alert-danger">
                                        {{ session('messageFinalizado') }}
                                    </div>
                                @endif
                                    <div class="btn-group" style=" width:100%;">	
                                        <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                        <button class="btn btn-success active" wire:click="FinalizarDocumento">FINALIZAR</button>
                                    </div> 
                                </div> 
                            @elseif($RespuestaOpciones==2)
                                <div class="card-body"> 
                                    <div class="form-group">
                                        <center> <h5><strong>Elegir archivo</strong></h5></center>
                                        <div class="form-label-group"> 
                                            <input type="file" class="form-control" wire:model="PDF">
                                        </div> 
                                    </div> 
                                </div>
                            @elseif($RespuestaOpciones==3)
                                <div class="card-body">
                                    <hr>
                                    <div class="btn-group" style=" width:100%;">	
                                        <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                        <button class="btn btn-warning active" wire:click="RechazarDocumento">RECHAZAR</button>
                                    </div> 
                                </div> 
                            @elseif($RespuestaOpciones==4)
                                <div class="card-body">
                                    <hr>
                                    <div class="btn-group" style=" width:100%;">	
                                        <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                        <button class="btn btn-success active" wire:click="SoloAceptar">ACEPTAR</button>
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>		
    </div> 
    @if($RespuestaOpciones==2)

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <div class="col">
                    <div class="card bg-light mb-3" > 
                        <div class="card">
                            <div class="table-responsive">
                                <div class="card-header">
                                    <h5><strong>Enviar Documentos</strong></h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive"> 
                                        <table table class="table table-hover">
                                            <thead> 
                                                <tr>  
                                                    <th>Estado</th>
                                                    <th>Nombre</th>
                                                    <th>Visto</th>
                                                    <th>Observación</th>
                                                    <th>Envio</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($FuncionariosAsig as $post)
                                                <tr>
                                                    @if($post->Estado==0)
                                                        <td> 
                                                            <div class="progress" style="height: 33px;">
                                                                <div class="progress-bar bg-danger" 
                                                                    role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                    <strong> DETENIDO </strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @elseif($post->Estado==4)
                                                        <td> 
                                                            <div class="progress" style="height: 33px;">
                                                                <div class="progress-bar bg-success" 
                                                                    role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                    <strong> ACEPTADO </strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td> 
                                                            <div class="progress" style="height: 33px;">
                                                                <div class="progress-bar bg-success" 
                                                                    role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                    <strong> Enviado </strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                                                        <td> 
                                                            {{$post->Nombres  }}      {{$post->Apellidos  }}
                                                        </td> 
                                                    @if($post->Visto==0)
                                                        <td>NO</td>  
                                                    @else 
                                                        <td>{{$post->Fecha_V  }}</td>
                                                    @endif
                                                        <td><textarea rows="3" style="width:100%;" disabled>{{$post->Mensaje_Cre  }}</textarea> </td>  

                                            @if($post->Estado==0)  
                                                @if($post->Visto==0)

                                                    @if($post->Asignador==Auth::user()->ID_Funcionario_T)
                                                        <td>
                                                            <button type="button" class="btn btn-danger active" data-toggle="modal" data-target="#exampleModalCenter"  wire:click="AsignarIDAnular({{$post->ID_IntDocFunc }})">
                                                                ENVIADO
                                                            </button>
                                                        </td>
                                                    @else
                                                        <td> 
                                                            <div class="progress" style="height: 33px;">
                                                                <div class="progress-bar bg-danger" 
                                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                    <strong> EN ESPERA </strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                                                @else
                                                        <td>
                                                            <div class="progress" style="height: 33px;">
                                                                <div class="progress-bar bg-danger" 
                                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                    <strong> EN ESPERA </strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                @endif
                                            @else
                                            
                                                        <td> 
                                                            <div class="progress" style="height: 33px;">
                                                                <div class="progress-bar bg-success" 
                                                                    role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                    <strong> ENVIADO </strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                            @endif     
                                                        </tr>
                                                @endforeach 
                                            </tbody>
                                        </table>  
                                    </div>	
                                </div>	
                                <div class="card-footer text-muted">
                                    {{ $FuncionariosAsig->links() }}
                                </div>	
                                <div class="card-body">
                                    <tbody> 
                                        <td> 
                                        <h5><strong>Enviar</strong></h5>
                                            <div class="form-label-group"> 
                                                <select  wire:model="Destinatarios" class="form-control" >
                                                        <option value="0" selected>---Buscar---</option>
                                                    @foreach($Funcionarios as $post)
                                                        <option value="{{ $post->ID_Funcionario_T   }}">{{ $post->Nombres }} {{ $post->Apellidos }}</option>
                                                    @endforeach
                                                </select>
                                            </div> 	
                                        </td>
                                        <hr> 
                                        <td>
                                            <h5><strong>Comentario</strong></h5>
                                            <div class="form-label-group"> 
                                                <textarea cols="20" rows="3" style="width:100%;" wire:model="ObservacionEAbajo">  </textarea>
                                            </div> 	
                                        </td>  
                                    </tbody>               
                                </div>   
                            @if (session()->has('messageEnviado'))
                                <div class="alert alert-danger">
                                    {{ session('messageEnviado') }}
                                </div> 
                            @endif
                                <div class="btn-group" style=" width:100%;">	
                                    <button class="btn btn-danger active" wire:click="VolverPrincipal">volver</button>
                                    <button class="btn btn-success active" wire:click="EnviarDocumento">ENVIAR</button>
                                </div> 
                                <div class="card-footer text-muted">
                                    GESTION DOCUMENTAL
                                </div>
                            </div>  
                        </div>
                    </div>	
                </div>	 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>			
        </div> 

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">GESTION DOCUMENTAL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Desea anular envio a <strong>{{ $NombresAnular}} {{ $ApellidosAnular}}</strong>?
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" style=" width:100%;">	
                            <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="AnularEnvio">CONFIRMAR</button>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    @endif  
@endif   
</div>



  


        
 
