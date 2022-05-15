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
                            <center><img src="{{URL::asset('Imagenes/Portafolio/EnProceso.JPG')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
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
                        <div class="text-muted">
                            <br> 
                            <h1><center><strong>SOLICITUDES CREADAS</strong></center></h1>
                            <hr>
                        </div> 
                        <div class="card-body"> 
                            <div class="row"> 
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" onmouseover="mostrar('Más información.');" onmouseout="ocultar()" width="25" height="25"/></button>
                                    <button class="btn btn-warning" onclick="location.reload()"><img src="{{URL::asset('Imagenes/Actualizar.png')}}" width="25" height="25"/></button>
                                    <strong><div id="ver"></div></strong>
                                </div> 
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <input class="form-control" type="text" placeholder="Buscar..." wire:model="search" title="Buscar por titulo,Tipo documento"/>
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
                                        <th>FUNCIONARIO</th>
                                        <th>N° INTERNO</th>
                                        <th>N° FOLIO</th>
                                        <th>TÍTULO DOCUMENTO</th>
                                        <th>TIPO DOCUMENTO</th>
                                        <th>FECHA INGRESO</th>
                                        <th>DÍAS PARA TÉRMINO</th>
                                        <th>ADMINISTRAR</th>
                                        <th>ELIMINAR</th>
                                    </tr>
                                </thead>   
                                <tbody> 
                                    @foreach($posts as $post) 
                                            <tr>
                                        @if($post->Estado_T==11)
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            DETENIDO
                                                        </div>
                                                    </div>
                                                </td>
                                        @elseif($post->Estado_T==22)
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        ESPERANDO
                                                        </div>
                                                    </div>
                                                </td>
                                        @elseif($post->Estado_T==33)
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            RECHAZADO
                                                        </div>
                                                    </div>
                                                </td>
                                        @endif

                                                <td>
                                                    {{$post->Nombres }} {{$post->Apellidos }}
                                                </td>

                                                <td>
                                                    {{$post->NumeroInterno }}{{$post->Anio }}
                                                </td>
                                                <td>
                                                    {{$post->Folio}}
                                                </td>
                                                <td>
                                                    <strong>{{$post->Titulo_T}}</strong>
                                                </td>
                                                <td> 
                                                    {{$post->Nombre_T}}
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
                                        @if($post->Estado_T==33)
                                                <td>
                                                        <strong>Rechazado por {{ $NombreEncargado }} {{ $ApellidoEncargado }} </strong>
                                                </td> 
                                        @else
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
                                        @endif  
                                        @if($post->Estado_T==33)
                                                <td>
                                                    <button class="btn btn-danger active"  id="MostrarMensaje" wire:click="MensajeRechazo({{ $post->ID_Documento_T }})">VER MOTIVO</button>
                                                </td>
                                        @elseif($post->Estado_T!=33) 
                                                <td>
                                                    <button class="btn btn-success active" wire:click="EnviarDocumento({{ $post->ID_Documento_T }},{{ $post->ID_Funcionario_T }})">ADMINISTRAR</button>
                                                </td>
                                        @endif 
                                                <td> 
                                                    <button class="btn btn-danger active" wire:click="EliminarPortafolio({{$post->ID_Documento_T }})">ELIMINAR</button>
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
    @elseif($Detalles==2)  
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3">
                        <div class="text-muted">
                            <br> 
                            <h1><center><strong>SOLICITAR FIRMAS</strong></center></h1>
                            <hr>
                        </div>
                        <div class="card-body table-responsive">  
                            <table table class="table table-hover">
                                <thead> 
                                    <tr>  
                                        <th>ARCHIVOS</th>
                                        <th>VER</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    @foreach($MostrarDocumentos as $post) 
                                        <tr> 
                                            <td>
                                                <strong>{{ $post->NombreDocumento }}</strong>
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
                                    @endforeach
                                </tbody>    
                            </table>
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
                                                <form method="POST" action="{{ route('SolicitarFirma') }}">
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
                                                    <button class="btn btn-success active" wire:click="EnviarCorreo({{ $post->ID_LinkFirma }})">ENVIAR</button>
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
                                                <strong>NO DISPONIBLE</strong>
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
                        <div class="text-muted">
                            <br> 
                            <h1><center><strong>ELIMINAR</strong></center></h1>
                            <hr>
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
    @endif 
</div>
@endif 