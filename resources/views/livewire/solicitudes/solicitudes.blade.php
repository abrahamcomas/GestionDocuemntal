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
                            <center><img src="{{URL::asset('Imagenes/Portafolio/Detenidos.JPG')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
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
                        <div class="text-muted" >
                                <br> 
                                <h1><center><strong>ACTA</strong></center></h1>
                                <hr>
                            </div>
                        <div class="card-body"> 
                            <div class="row">  
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" onmouseover="mostrar('Más información.');" onmouseout="ocultar()" width="25" height="25"/></button>
                                    <button class="btn btn-warning" onclick="location.reload()"><img src="{{URL::asset('Imagenes/Actualizar.png')}}" width="25" height="25"/></button>
                                    <strong><div id="ver"></div></strong>
                                </div> 
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <select  class="form-control" wire:model="Lista">
                                        <option value="0" selected>Detenidos, Esperando</option>
                                        <option value="1">Finalizados</option>
                                    </select>
                                </div> 
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <input class="form-control" type="text" placeholder="Buscar título..." wire:model="search" title="Buscar por titulo,Tipo documento, Observación"/>
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
                            <div class="alert alert-danger content2" style="display:none;"> {{$MensajeRechazo}}</div>
                            <table table class="table table-hover"> 
                                <thead> 
                                    <tr>
                                        <th>ESTADO</th>
                                        <th>TÍTULO DOCUMENTO</th>
                                        <th>FECHA</th>
                                        <th>PDF</th>
                                        <th>SOLICITUD</th>
                                        <th>ELIMINAR</th>
                                    </tr>
                                </thead>   
                                <tbody> 
                                    @foreach($posts as $post) 
                                            <tr>
                                        @if($post->Estado_T==0)
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            DETENIDO
                                                        </div>
                                                    </div>
                                                </td>
                                        @elseif($post->Estado_T==1)
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        ESPERANDO
                                                        </div>
                                                    </div> 
                                                </td>
                                        @else
                                                <td>  
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            FINALIZADOS
                                                        </div>
                                                    </div>
                                                </td>
                                        @endif
                                                <td> 
                                                    <strong>{{$post->Titulo_T}}</strong>
                                                </td>

                                                @php 
                                                    
                                                    $newDate = date("d/m/Y", strtotime($post->Fecha_T));

                                                @endphp
                                                <td>  
                                                    <strong>{{$newDate}}</strong>
                                                </td>
                                        @if($post->Estado_T==0)
                                                <td colspan="2">       
                                                    <form method="POST" action="{{ route('Firma11') }}">
                                                        @csrf      
                                                        <input type="hidden" name="ID_Documento_T" value="{{ $post->ID_Documento_T}}">	
                                                        <div class="btn-group" style=" width:50%;">	
                                                            <button type="submit" id="btnEnviar1" class="btn btn-warning active">FIRMAR</button>
                                                        </div>
                                                    </form>
                                                </td> 
                                                <td> 
                                                    <button class="btn btn-danger active" wire:click="EliminarPortafolio({{$post->ID_Documento_T }})">ELIMINAR</button>
                                                </td>
                                        @elseif($post->Estado_T==1)
                                                <td>
                                                    <form method="POST" action="{{ route('MostrarPDF11') }}">   
                                                        @csrf             
                                                        <input type="hidden" name="ID_Documento_T" value="{{ $post->ID_Documento_T }}">
                                                        <input type="hidden" name="ID_Funcionario_T" value="{{ $post->ID_Funcionario_T }}">
                                                        <div class="btn-group" style=" width:50%;">	
                                                            <button type="submit" class="btn btn-success active">PDF</button>
                                                        </div>
                                                    </form> 
                                                </td>  
                                                <td>
                                                    <button class="btn btn-warning active" wire:click="EnviarDocumento({{ $post->ID_Documento_T }},{{ $post->ID_Funcionario_T }})">ENVIAR</button>
                                                </td>
                                                <td> 
                                                    <button class="btn btn-danger active" wire:click="EliminarPortafolio({{$post->ID_Documento_T }})">ELIMINAR</button>
                                                </td>
                                        @else

                                            @if($post->Solicitud==0) 
                                                <td>
                                                    <form method="POST" action="{{ route('MostrarPDF11') }}">   
                                                        @csrf             
                                                        <input type="hidden" name="ID_Documento_T" value="{{ $post->ID_Documento_T }}">
                                                        <input type="hidden" name="ID_Funcionario_T" value="{{ $post->ID_Funcionario_T }}">
                                                        <div class="btn-group" style=" width:50%;">	
                                                            <button type="submit" class="btn btn-success active">PDF</button>
                                                        </div>
                                                    </form> 
                                                </td>
                                                <td> 
                                                    <button class="btn btn-warning active" wire:click="CrearSolicitud({{ $post->ID_Documento_T }},{{ $post->ID_Funcionario_T }})">CREAR</button>
                                                </td>
                                                <td> 
                                                    <button class="btn btn-warning active">X</button> 
                                                </td>
                                            @else
                                                <td>
                                                    <form method="POST" action="{{ route('MostrarPDF11') }}">   
                                                        @csrf             
                                                        <input type="hidden" name="ID_Documento_T" value="{{ $post->ID_Documento_T }}">
                                                        <input type="hidden" name="ID_Funcionario_T" value="{{ $post->ID_Funcionario_T }}">
                                                        <div class="btn-group" style=" width:50%;">	
                                                            <button type="submit" class="btn btn-success active">PDF</button>
                                                        </div>
                                                    </form> 
                                                </td>
                                                <td> 
                                                    <button class="btn btn-primary active">CREADA</button>
                                                </td>
                                                <td> 
                                                    <button class="btn btn-warning active">X</button> 
                                                </td>
                                            @endif 
                                        @endif 
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
    @elseif($Detalles==2)  
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <h4><strong>SOLICITAR FIRMAS</strong></h4>
                        </div> 
                        <div class="card-body table-responsive">
                        @if($LinkFirma->count())
                            <table table class="table table-hover">
                                <thead> 
                                    <tr>  
                                        <th>FUNCIONARIO</th>
                                        <th>URL DIRECTO DISPONIBLE</th>
                                        <th>EMAIL</th>
                                        <th>ENVIAR</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    @foreach($LinkFirma as $post) 
                                        <tr>    
                                            <td> 
                                                <strong>{{ $post->Nombres_L }} {{ $post->Apellidos_L }}</strong>
                                            </td>
                                        @if($post->Estado==0) 
                                            <td>  
                                            <!--<form method="POST" action="{{ route('SolicitarFirma11') }}">-->
                                                <form method="POST" action="{{ route('SolicitarFirmaFuncionario11') }}">
                                                    @csrf      
                                                    <input type="hidden" name="ID_Documento_T" value="{{ $ID_Documento_T }}">	
                                                    <input type="hidden" name="ID_LinkFirma" value="{{ $post->ID_LinkFirma }}">	
                                                    <button type="submit" id="btnEnviar1" class="btn btn-info active">SOLICITAR FIRMAR</button>
                                                </form>
                                            </td>
                                            <td> 
                                                <strong>{{ $post->direccionEmail }}</strong>
                                            </td>  
                                            <td>
                                                <strong>NO DISPONIBLE</strong>
                                            </td>
                                        @elseif($post->Estado==1)
                                            <td>
                                                <textarea id="textarea1" class="form-control response" readonly="" rows="3">{{$post->Contenido}}</textarea>
                                            </td>
                                            @if($post->Email==0)
                                                <td>
                                                    <strong>{{ $post->direccionEmail }}</strong>
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning active" wire:click="EnviarCorreo({{ $post->ID_LinkFirma }})">ENVIAR</button>
                                                    <br>
                                                    <div wire:loading wire:target="EnviarCorreo">
                                                        <strong>Enviando...</strong></h5>
                                                    </div>
                                                </td>
                                            @else 
                                                <td>  
                                                    <strong>{{ $post->direccionEmail }}</strong> 
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning active" wire:click="EnviarCorreo({{ $post->ID_LinkFirma }})">VOLVER A ENVIAR</button>
                                                    <br>
                                                    <div wire:loading wire:target="EnviarCorreo">
                                                        <strong>Enviando...</strong></h5>
                                                    </div>
                                                </td>
                                            @endif
                                        @elseif($post->Estado==2)
                                                <td> 
                                                    <button type="button" class="btn btn-success active">ACEPTADO</button>
                                                </td>
                                                <td>  
                                                    <strong>{{ $post->direccionEmail }}</strong> 
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning active" wire:click="EnviarCorreo({{ $post->ID_LinkFirma }})">ENVIAR COPIA PDF</button>
                                                    <br>
                                                    <div wire:loading wire:target="EnviarCorreo">
                                                        <strong>Enviando...</strong></h5>
                                                    </div>
                                                </td>
                                        @elseif($post->Estado==3)
                                            <td>
                                                <button type="button" class="btn btn-danger active">RECHAZADO</button>
                                            </td> 
                                        @endif
                                        </tr>
                                    @endforeach
                                </tbody> 
                            </table> 
                        @endif
                        </div>
                        <div class="btn-group" style=" width:100%;">
                            <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        </div> 
                        <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL
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
                            <h4><strong>ELIMINAR</strong></h4>
                        </div> 
                        <div class="card-body">
                            <strong>Una solicitud puede ser eliminada del sistema si considera que fue ingresada incorrectamente.</strong>
                            <br><br>
                            <strong>Por favor, Confirme su contraseña de usuario.</strong>
                            <div class="form-label-group">
                                <input type="password" class="form-control" wire:model="ContraseniaPortafolio"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                            </div>
                        </div> 
                        <div class="btn-group" style=" width:100%;">
                            <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                            <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="EliminarPortafolioConf">CONFIRMAR</button>
                        </div> 
                        <br>
                        <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL
                        </div>
                    </div>  
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        </div>
    </div>





    @elseif($Detalles==4)



<div> 
<br>                                  
    @if($Pagina==0) 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">   
                    @include('messages')  
                    <div class="card bg-light mb-3"> 
                        <div class="text-muted" >
                            <br> 
                            <h1><center><strong>SOLICITUD  "{{ $TituloSolicitud}}"</strong></center></h1>
                            <hr>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <h6>NÚMERO FOLIO (OPCIONAL)</h6>
                                    <div class="form-label-group"> 
                                        <div class="form-label-group"> 
                                            <input type="text" class="form-control" wire:model="Folio">
                                        </div>		
                                    </div> 	 
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <h6>DÍAS PARA FINALIZAR*</h6>
                                    <div class="form-label-group"> 
                                        <input type="number" class="form-control" wire:model="Fecha_T">
                                    </div>		
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <h6>OBSERVACIÓN (OPCIONAL)</h6>
                                    <div class="form-label-group"> 
                                    <textarea class=" form-control" wire:model="Materia_T"></textarea>
                                    </div>		
                                </div>
                            </div>
                            <br>
                            <div class="btn-group" style=" width:100%;">
                            <button type="button" class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                            <button class="btn btn-success" wire:click="Ingresar">INGRESAR</button>
                        </div> 
                        </div> 
                        <div class=" text-muted">
                            <strong>(*)OBLIGATORIO</strong>
                        </div>
                        <div class="card-footer text-muted">
                        </div>
                        <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL <br>
                        </div>
                    </div>
                </div> 
            </div>		
        </div> 
        @else
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3">
                            <div class="text-muted">
                                <br> 
                                <h1><center><strong>NÚMERO DE IDENTIFICACIÓN INTERNA<strong> {{ $NumeroIngresado }} </strong></center></h1>
                                <hr>
                            </div> 
                            <div class="card-body">
                                <div class="form-group">
                                    <h5>NUEVA SOLICITUD INGRESADA.</h5>
                                </div> 
                            </div>   
                            <form method="POST" action="{{ route('PortafoliosFinalizados') }}">
                                @csrf
                                <center> 
                                    <div class="btn-group" style=" width:50%;">
                                        <button type="submit" class="btn btn-primary active">
                                            CONTINUAR
                                        </button> 
                                    </div>
                                </center> 
                            </form> 
                            <br> 
                            <div class="card-footer text-muted">
                            </div>
                            <div class="card-footer text-muted">
                                GESTIÓN DOCUMENTAL <br>
                            </div>
                        </div>
                    </div>	
                </div>
            </div>			
        </div>
    @endif             




    
@endif 
 
@endif 







