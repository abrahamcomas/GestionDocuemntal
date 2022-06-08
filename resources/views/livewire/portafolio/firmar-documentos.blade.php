<div> 
    <br>     
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
                        <h1><center><strong>SOLICITUDES DETENIDAS</strong></center></h1>
                        <hr>
                    </div> 
                    <div class="card-body"> 
                        <div class="row">  
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                               <!-- <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" onmouseover="mostrar('Más información.');" onmouseout="ocultar()" width="25" height="25"/></button>-->
                                <button class="btn btn-warning" onclick="location.reload()"><img src="{{URL::asset('Imagenes/Actualizar.png')}}" width="25" height="25"/></button>
                                <strong><div id="ver"></div></strong>
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
                            <div class="alert alert-danger content2" style="display:none;"> {{$MensajeRechazo}}</div>
                            <table table class="table table-hover table-sm"> 
                                <thead> 
                                    <tr>
                                        <th>ESTADO</th>
                                        <th>N° INTERNO</th>
                                        <th>N° FOLIO</th>
                                        <th>TÍTULO</th>
                                        <th>TIPO</th>
                                        <th>INGRESO</th>
                                        <th>OBSERVACIÓN</th>
                                        <th>DÍAS PARA TÉRMINO</th>
                                        <th>ENVIAR</th>
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
                                    @elseif($post->ODP==1) 
                                        <td> 
                                            <div class="progress" style="height: 33px;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    ODP
                                                </div>
                                            </div>
                                        </td>
                                    @elseif($post->Estado_T==11)<!--ESPERANDO-->
                                        <td> 
                                            <div class="progress" style="height: 33px;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    ESPERANDO
                                                </div>
                                            </div>
                                        </td>
                                    @elseif($post->Estado_T==22)<!--ESPERANDO-->
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
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    RECHAZADO
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                        <td>
                                            {{$post->NumeroInterno }}-{{$post->Anio }}
                                        </td>
                                        <td>
                                            {{$post->Folio}}
                                        </td>
                                        <td>
                                           <strong> {{$post->Titulo_T}}</strong>
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
                                        <td>
                                            <textarea class="form-control" disabled>{{$post->Observacion_T}}</textarea>
                                        </td>

                            @if($post->Estado_T!=33)
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
                                            <button class="btn btn-danger active" wire:click="MensajeRechazo({{ $post->ID_Documento_T }})">&nbsp;&nbsp;&nbsp;&nbsp;VER MOTIVO&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                        </td>
                            @endif
                                @if($post->Estado_T==0)<!--DETENDIDO-->
                                        <td>
                                            <button class="btn btn-success active" wire:click="EnviarDocumento({{ $post->ID_Documento_T }})">CONTINUAR</button>
                                        </td>
                                        <td> 
                                            <button class="btn btn-danger active" wire:click="EliminarPortafolio({{$post->ID_Documento_T }})">ELIMINAR</button>
                                        </td>
                                @elseif($post->ODP==1 AND $post->Estado_T==11)<!--CREADO POR OPD-->
                                        <td>
                                            <button class="btn btn-success active" wire:click="ConfirmarEnvioOPD({{ $post->ID_Documento_T }})">FIRMAR</button>
                                        </td>
                                        <td>  
                                            <strong>ESPERANDO FIRMAS</strong>
                                        </td>
                                @elseif($post->Estado_T==22)<!--CREADO POR OPD-->
                                        <td>
                                            <button class="btn btn-danger active" wire:click="ConfirmarEnvioOPD({{ $post->ID_Documento_T }})">FIRMAR</button>
                                        </td>
                                        <td>  
                                            <strong>ESPERANDO FIRMAS</strong>
                                        </td>
                                @elseif($post->Estado_T==33)<!--RECHAZADO--> 
                                        <td>
                                            <button class="btn btn-success active" wire:click="EnviarDocumento({{ $post->ID_Documento_T }})">CONTINUAR</button>
                                        </td>
                                    @if($post->ODP==1) 
                                        <td> 
                                            <strong>SOLO ODP</strong>
                                        </td>
                                    @else
                                        <td> 
                                            <button class="btn btn-warning active" wire:click="EliminarPortafolio({{$post->ID_Documento_T }})">ELIMINAR</button>
                                        </td>
                                    @endif 
                                @elseif($post->Estado_T==11)<!--ESPERANDO JEFE-->
                                        <td colspan="2"> 
                                            <strong> Esperando a {{ $NombreEncargado2 }} {{ $ApellidoEncargado2 }}</strong>
                                        </td>
                               
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
                            SGD
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
                        <h1><center><strong>ADMINISTRAR ARCHIVOS</strong></center></h1>
                        <hr>
                    </div> 
                    <div class="card-body">
                        <div class="text-muted"> 
                            <h5>Antes de enviar una solicitud, debe existir al menos uno o más archivos.</h5>
                        </div> 
                        <div class="table-responsive"> 
                            <table table class="table table-hover table-sm table-bordered"> 
                                <thead> 
                                    <tr>  
                                        <th>NOMBRE</th>
                                        <th>FIRMA NO REQUERIDA</th>
                                        <th>FIRMAR</th>
                                        <th>ELIMINAR</th>
                                        <th>VER</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                        @foreach($MostrarDocumentos as $post) 
                                            <tr> 
                                                   <td>
                                                        <div style="width:200px;">
                                                            <strong>{{ $post->NombreDocumento }}</strong>
                                                        </div>
                                                    </td>   
                                            @if($post->Firmado==0)    
                                                    <td>    
                                                        <button class="btn btn-warning active" wire:click="ConfirmarFirma({{ $post->ID_DestinoDocumento  }})">OMITIR FIRMA</button>
                                                    </td>
                                                    <td>    
                                                        <form method="POST" action="{{ route('FirmaDetenidoIndividual') }}">
                                                            @csrf      
                                                            <input type="hidden" name="ID_DestinoDocumento" value="{{ $post->ID_DestinoDocumento  }}">	
                                                            <div class="btn-group" style=" width:50%;">	
                                                                <button type="submit" id="btnEnviar1" class="btn btn-success active">FIRMAR</button>
                                                            </div> 
                                                        </form>
                                                    </td> 
                                                    @if($post->ID_FSube==Auth::user()->ID_Funcionario_T)
                                                        <td>
                                                            <div class="btn-group" style=" width:50%;">	
                                                                <button class="btn btn-danger active" wire:click="ConfirmarEliminar({{ $post->ID_DestinoDocumento  }})">ELIMINAR</button>
                                                            </div>
                                                        </td>
                                                    @endif 
                                            @elseif($post->Firmado==4)     
                                                    <td colspan="3">
                                                       <center> <strong>FIRMA NO REQUERIDA</strong></center>
                                                    </td>
                                            @else       
                                                    <td colspan="2">
                                                        @php 
                                                            $FechaFirma = $post->FechaFirma;
                                                            $MostrarFecha = date("d-m-Y", strtotime($FechaFirma));
                                                        @endphp
                                                        <strong>FIRMADO EL {{$MostrarFecha   }}</strong>
                                                    </td>
                                            @endif
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
                        </div>
                    @if($cuantos>=2)
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <form method="POST" action="{{ route('FirmaDetenidoMasiva') }}">
                                    @csrf      
                                    <input type="hidden" name="ID_Documento_T" value="{{ $ID_Documento_T  }}">	
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" id="btnEnviar1" class="btn btn-success active">FIRMAR TODOS</button>
                                    </div>
                                </form>
                            </div> 
                        </div>
                    @endif	
                        <br> 
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <h6>AGREGAR ARCHIVO/S* <strong>PDF</strong></h6>
                                    <input type="file" class="form-control" wire:model="PDF" multiple accept="application/pdf">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
                            </div>
                            </div>  
                        </div>
                        <div wire:loading wire:target="PDF"> 
                            <center> 
                                <h5><strong>Subiendo documentos, espere por favor...</strong></h5>
                            </center>
                        </div>
                        <center>
                        <div class="btn-group" style=" width:80%;">	
                            <button class="btn btn-danger active" id="CancelarConfirmarIngreso"  wire:click="VolverPrincipal">VOLVER</button>
                            <button class="btn btn-primary active" wire:click="Ingresar" id="boton">INGRESAR</button>
                        </div>
                        </center>
                        <center>
                            <div wire:loading wire:target="Ingresar">
                                <div class="circle bounce2"><h1 style="color: #FFFFFF;"><strong>SGD</strong></h1></div>
                                <h5><strong>Verificando documentos, espere por favor...</strong></h5>                         
                            </div>  
                        </center> 
                        <div class="card-footer text-muted"> 
                        </div>
                        <div class="card-footer text-muted"> 
                           SGD
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div> 
@elseif($Detalles==3) <!--ELIMINAR VB-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3"> 
                    <div class="text-muted">
                        <h1><center><strong>ELIMINAR</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <p>Una solicitud puede ser eliminada si considera que fue ingresada incorrectamente.</p>
                        <strong>Por favor, Confirme su contraseña de usuario.</strong>
                        <div class="form-label-group">
                            <input type="password" class="form-control" wire:model="ContraseniaPortafolio"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                        </div>
                    </div> 
                    <center>
                    <div class="btn-group" style=" width:80%;">
                        <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        <button type="button" class="btn btn-warning active" data-dismiss="modal" wire:click="EliminarPortafolioConf">ELIMINAR</button>
                    </div> 
                    </center>
                    <br>
                    <div class="card-footer text-muted"> 
                       SGD
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>  
@elseif($Detalles==4)<!--ENVIAR SOLICITUD--> 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3" > 
                    <table table class="table table-hover table-sm"> 
                        <div class="text-muted">
                            <h1><center><strong>ENVIAR SOLICITUD</strong></center></h1>
                            <hr>
                        </div>
                        <div class="card-body"> 
                            <div class="row">  
                            @if(Auth::user()->Jefe!=1)
                                <div class="col-sm-6">
                                    <div class="card bg-light mb-3" >
                                        <div class="card-footer text-muted">
                                            <h4>SOLICITAR FIRMA ENCARGADO ODP</h4>
                                        </div>  
                                        <div class="card-body">
                                            Antes de enviar el portafolio a la ODP correspondiente, considere si es necesario solicitar la firma de su jefe/a directo.<br>
                                            <hr>
                                            Si la solicitud fue rechazada, asegúrese de corregir el motivo de tal rechazo antes de volver a enviar.
                                        </div>
                                        <div class="card-footer text-muted">
                                            <div class="btn-group" style=" width:100%;"> 
                                                <button class="btn btn-warning active"  wire:click="SolicitarFirma">SOLICITAR FIRMAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="card bg-light mb-3" >
                                        <div class="card-footer text-muted">
                                            <h4>ADMINISTRAR ARCHIVOS</h4>
                                        </div>  
                                        <div class="card-body">
                                            Puede eliminar o agregar nuevos archivos a su solicitud..
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <div class="card-footer text-muted">
                                            <div class="btn-group" style=" width:100%;">
                                                <button class="btn btn-warning active"  wire:click="SubirArchivos">ADMINISTRAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            @else
                                <div class="col-sm-3"></div> 
                                <div class="col-sm-6">
                                    <div class="card bg-light mb-3" >
                                        <div class="card-footer text-muted">
                                            <h4>¿Faltaron archivos?</h4>
                                        </div>  
                                        <div class="card-body">
                                            Si faltaron archivos puede subirlos y firmarlos antes de enviar el portafolio.
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <div class="card-footer text-muted">
                                            <div class="btn-group" style=" width:100%;">
                                                <button class="btn btn-warning active"  wire:click="SubirArchivos">INGRESAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-3"></div> 
                            @endif
                            </div>
                        </div> 
                    </table> 
                    <div class="card-footer text-muted"> 
                        <table table class="table table-hover table-sm"> 
                            <center><h1><strong>Enviar solicitud ODP {{ $NombreOficinaParte->Nombre_DepDir }}.</strong></h1></center>
                            <div class="text-muted">
                                <h5></h5>
                            </div>
                        </table> 
                            <center>
                            <div class="btn-group" style=" width:80%;">	
                                <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                <button class="btn btn-success active" wire:click="ConfirmarEnvio">ENVIAR</button>
                            </div> 
                            </center>
                    </div>
                    <div class="card-footer text-muted">
                            SGD
                    </div>	
                </div>	
            </div>			
        </div>
    </div>
@elseif($Detalles==5) <!--ELIMINAR VB-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3"> 
                    <div class="text-muted"> 
                        <h1><center><strong>FIRMA NO REQUERIDA</strong></center></h1>
                        <hr>
                    </div> 
                    <div class="card-body">
                        <strong>¿Desea omitir firma?</strong>
                        <br><br>
                        <p>Si el archivo fue firmado en el módulo 
                            <strong>“FIRMA MASIVA”</strong> 
                            y no se debe firmar nuevamente o considera que el archivo simplemente no debe ir firmado puede omitir el ingreso de dicha firma.</p>
                        <strong>Por favor, Confirme su contraseña de usuario.</strong>
                        <div class="form-label-group">
                            <input type="password" class="form-control" wire:model="ContraseniaFirmado"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                        </div>
                    </div> 
                    <center>
                    <div class="btn-group" style=" width:80%;">
                        <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="Firmado">CONFIRMAR</button>
                    </div> 
                    </center>
                    <br>
                    <div class="card-footer text-muted">
                        SGD
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div> 
@elseif($Detalles==10)
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>ARCHIVOS FIRMADOS</strong></center></h1>
                        <hr>
                    </div> 
                    <div class="card-body">
                        <strong>Si los archivos subidos a gestión documental ya se encuentra con una firma digital avanzada y considera que no es necesario firmar nuevamente dichos archivos, puede omitir ese paso.</strong>
                        <br><br>
                        <strong>Por favor, Confirme su contraseña de usuario.</strong>
                        <div class="form-label-group">
                            <input type="password" class="form-control" wire:model="ContraseniaFirmadoTodos"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                        </div>
                    </div> 
                    <center>
                    <div class="btn-group" style=" width:80%;">
                        <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="FirmadoTodos">CONFIRMAR</button>
                    </div> 
                    </center>
                    <br>
                    <div class="card-footer text-muted">
                        SGD
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>  
@elseif($Detalles==6) <!--ELIMINAR VB-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>ELIMINAR ARCHIVO</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <strong>¿Desea eliminar archivo?</strong>
                        <br><br>
                        <strong>Por favor, Confirme su contraseña de usuario.</strong>
                        <div class="form-label-group">
                            <input type="password" class="form-control" wire:model="ContraseniaDocumento"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                        </div>
                    </div> 
                    <center>
                    <div class="btn-group" style=" width:80%;">
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="VolverArchivos">VOLVER</button>
                        <button type="button" class="btn btn-DANGER active" data-dismiss="modal" wire:click="EliminarArchivo">CONFIRMAR</button>
                    </div> 
                    </center>
                    <br>
                    <div class="card-footer text-muted">
                        SGD 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div> 
@elseif($Detalles==7) <!--Solicitar firma-->    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>SOLICITAR FIRMA ENCARGADO ODP</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <h4>¿Desea enviar solicitud a  <strong>{{ $NombreEncargado}} {{ $ApellidoEncargado}}?</strong></h4>
                        <br><br>
                    </div> 
                    <center>
                    <div class="btn-group" style=" width:80%;">
                        <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="EnvioDirectoJefatura">ENVIAR</button>
                    </div>
                    </center> 
                    <br> 
                    <div class="card-footer text-muted">
                        SGD
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div> 
@elseif($Detalles==9) 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>LISTA DE ARCHIVOS</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <div class="text-muted"> 
                            <h5>Solicitud creada por OPD.</h5>
                        </div> 
                        <div class="table-responsive"> 
                        <table table class="table table-hover table-sm"> 
                                <thead> 
                                    <tr>  
                                        <th>NOMBRE</th>
                                        <th>FIRMAR</th>
                                        <th>VER</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                        @foreach($MostrarDocumentos as $post) 
                                            <tr> 
                                                   <td>
                                                        <div style="width:200px;">
                                                            <strong>{{ $post->NombreDocumento }}</strong>
                                                        </div>
                                                    </td>   
                                            @if($post->Firmado==0)
                                                    <td>    
                                                        <form method="POST" action="{{ route('FirmaDetenidoIndividual') }}">
                                                            @csrf      
                                                            <input type="hidden" name="ID_DestinoDocumento" value="{{ $post->ID_DestinoDocumento  }}">	
                                                            <div class="btn-group" style=" width:50%;">	
                                                                <button type="submit" id="btnEnviar1" class="btn btn-success active">FIRMAR</button>
                                                            </div>
                                                        </form>
                                                    </td>  
                                            @else       
                                                    <td> 
                                                        @php 
                                                            $FechaFirma = $post->FechaFirma;
                                                            $MostrarFecha = date("d-m-Y", strtotime($FechaFirma));
                                                        @endphp
                                                        <strong>FIRMADO EL {{$MostrarFecha   }}</strong>
                                                    </td>
                                            @endif
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
                        </div>
                    @if($cuantos>=2)
                        <form method="POST" action="{{ route('FirmaDetenidoMasiva') }}">
                            @csrf      
                            <input type="hidden" name="ID_Documento_T" value="{{ $ID_Documento_T  }}">	
                            <div class="btn-group" style=" width:100%;">	
                                <button type="submit" id="btnEnviar1" class="btn btn-info active">FIRMA MASIVA</button>
                            </div>
                        </form>
                    @endif
                        <br>
                        <center>
                        <div class="btn-group" style=" width:80%;">	
                            <button class="btn btn-danger active" id="CancelarConfirmarIngreso"  wire:click="VolverPrincipal">VOLVER</button>
                        </div>
                        </center>
                        <div class="card-footer text-muted"> 
                        </div>
                        <div class="card-footer text-muted"> 
                            SGD
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif 
</div>