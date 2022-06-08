<div> 
    <br>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>
@if($Detalles==0)  
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col"> 
                <div class="card bg-light mb-3"> 
                    <div class="text-muted">
                        <h1><center>SOLICITUDES INTERNAS <strong> {{ $OPDSelectNombre}}</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body"> 
                        <div class="row">   
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <!--<button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" onmouseover="mostrar('Más información.');" onmouseout="ocultar()" width="25" height="25"/></button>-->
                                <button class="btn btn-warning" onclick="location.reload()"><img src="{{URL::asset('Imagenes/Actualizar.png')}}" width="25" height="25"/></button>
                                <strong><div id="ver"></div></strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <select  class="form-control" wire:model="Orden">
                                    <option value="1" selected>Asc. fecha ingreso</option>
                                    <option value="2">Desc. fecha ingreso</option>
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
                            <table table class="table table-hover table-sm"> 
                                <thead>  
                                    <tr>  
                                        <th>ESTADO</th>
                                        <th>EMISOR</th>
                                        <th>N° INTERNO</th>
                                        <th>N° FOLIO</th>
                                        <th>TÍTULO</th>
                                        <th>DOCUMENTO</th>
                                        <th>INGRESO</th>
                                        <th>DÍAS PARA TERMINO</th>
                                        <th>OBSERVACIÓN</th>
                                        <th>ADMINISTRAR</th> 
                                        <th>ELIMINAR</th>
                                    </tr>
                                </thead>  
                                <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                        @if($post->Estado_T==1)
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            Detenido
                                                    </div>
                                                </div>
                                            </td>
                                        @elseif($post->Estado_T==2)
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            Enviado
                                                    </div>
                                                </div>
                                            </td>
                                        @else 
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        Revision
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                            <td>
                                                {{$post->Nombres}} {{$post->Apellidos}}
                                            </td>
                                            <td>
                                                {{$post->NumeroInterno}}{{$post->Anio}}
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
                                                <textarea rows="3" style="width:100%;" disabled> {{$post->Observacion_T }} </textarea>
                                            </td>
                                            <td>
                                                <button class="btn btn-success active" wire:click="EnviarDocumento({{ $post->ID_Documento_T }})">ADMINISTRAR</button>
                                            </td>
                                        @if($post->Estado_T==1)
                                            <td>
                                                <button class="btn btn-danger" wire:click="ConfirmarCancelarPortafolio({{ $post->ID_Documento_T }})">ELIMINAR</button>
                                            </td>
                                        @elseif($post->Estado_T==2)
                                            <td>
                                                <button class="btn btn-danger">NO DISP.</button>
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
@elseif($Detalles==1) 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>ELIMINAR SOLICITUD</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <h6>Si considera que la solicitud ingresada por<strong> {{ $NombreEliminar }} {{ $ApellidoEliminar }} </strong>fue ingresado de manera incorrecta, puede eliminar dicha solicitud.</h6>
                        <br>
                        <strong>Por favor, Confirme su contraseña de usuario.</strong>
                        <div class="form-label-group">
                            <input type="password" class="form-control" wire:model="Contrasenia"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                        </div>
                    </div> 
                    <center>
                    <div class="btn-group" style=" width:80%;">
                        <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="CancelarPortafolio">ELIMINAR</button>
                    </div> 
                    </center>
                    <br>
                    <div class="card-footer text-muted"> 
                    </div>
                    <div class="card-footer text-muted"> 
                        SGD
                    </div>
                </div>
            </div> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>
@elseif($Detalles==2)<!--ENVIAR SOLICITUD--> 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>ARCHIVOS</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body table-responsive">
                        <table table class="table table-sm table-bordered">
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
                                                {{ $post->NombreDocumento }}
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
                    <div class="text-muted">
                        <h1><center><strong>COMENTARIO POR ARCHIVO</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body table-responsive">
                        <table table class="table table-sm table-bordered">
                            <thead>  
                                <tr>  
                                    <th>NOMBRE ARCHIVO</th>
                                    <th>COMENTARIO DE ENCARGADO/A ODP</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach($MostrarDocumentosComentarios as $post)
                                        <tr>  
                                            <td>
                                                {{ $post->NombreDocumento  }}
                                            </td>
                                            <td>
                                                {{ $post->ObservacionFirma }}
                                            </td>
                                        </tr>
                                @endforeach 
                            </tbody> 
                        </table> 
                    </div> 
                </div>
            @if($Cambiar==0)
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>ODP FIRMANTES</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body table-responsive">
                        <table table class="table table-sm table-bordered"> 
                            <thead>  
                                <tr> 
                                    <th>ESTADO</th>
                                    <th>ODP</th>
                                    <th>OBSERVACIÓN ENVIADA</th>
                                    <th>OBSERVACIÓN RECIBIDA</th>
                                    <th>RECIBIDO</th>
                                    <th>VISTO</th>
                                    <th>ELIMINAR</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach($DestinoFirmantes as $post)
                                    <tr>
                                        @if($post->Estado==0)
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        PENDIENTE
                                                    </div>
                                                </div>
                                            </td>
                                        @elseif($post->Estado==1)
                                            <td> 
                                               <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        CONFIRMADO
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
                                                {{$post->Nombre_DepDir}}
                                            </td> 
                                            <td>
                                                {{$post->Mensaje_E}}
                                            </td>  
                                            <td>
                                                {{$post->Mensaje_R}}
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
                                                <button class="btn btn-danger active">NO</button>
                                            </td>
                                        @else 
                                            <td> 
                                                {{$post->Fecha_V}}
                                            </td>
                                        @endif
                                        @if($post->Fecha_V==NULL)
                                            <td> 
                                                <button class="btn btn-danger" wire:click="AnularFirmante({{$post->ID_IntDocFunc}},{{$post->ID_OP_R}})">ELIMINAR</button>
                                            </td>
                                        @else
                                            <td> 
                                                {{$post->Fecha_V}}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach 
                            <tbody> 
                        </table> 
                        <hr>
                        <center>
                            <div class="btn-group" style=" width:80%;">	
                                <button class="btn btn-warning active" wire:click="CambiarVB">CAMBIAR</button>
                            </div> 
                        </center>
                    </div>
                </div> 
            @elseif($Cambiar==1)
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>ODP V°B°</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body table-responsive">
                        <table table class="table table-sm table-bordered"> 
                            <thead>  
                                <tr>
                                    <th>ESTADO</th>
                                    <th>ODP</th>
                                    <th>OBSERVACIÓN ENVIADA</th>
                                    <th>OBSERVACIÓN RECIBIDA</th>
                                    <th>RECIBIDO</th>
                                    <th>VISTO</th>
                                    <th>ELIMINAR</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach($VistoBueno as $post)
                                    <tr>
                                        @if($post->Estado==0)
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        PENDIENTE
                                                    </div>
                                                </div>
                                            </td>
                                        @elseif($post->Estado==1)
                                            <td> 
                                               <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        CONFIRMADO
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
                                            {{$post->Nombre_DepDir}}
                                        </td> 
                                        <td>
                                            {{$post->ObservacionE}}
                                        </td> 
                                        <td>
                                            {{$post->ObservacionR}}
                                        </td> 
                                        @php
                                            $numeroDiaV = date('d', strtotime($post->Fecha));
                                            $mesV = date('F', strtotime($post->Fecha));

                                            if($mesV=='January'){
                                            $mesV= 'Enero';
                                            }
                                            elseif($mesV=='February'){   
                                            $mesV= 'Febrero';
                                            }
                                            elseif($mesV=='March'){  
                                            $mesV= 'Marzo';
                                            }
                                            elseif($mesV=='April'){
                                                $mesV= 'Abril';
                                            }
                                            elseif($mesV=='May'){
                                                $mesV= 'Mayo';
                                            }
                                            elseif($mesV=='June'){
                                                $mesV= 'Junio';
                                            }
                                            elseif($mesV=='July'){ 
                                                $mesV= 'Julio';
                                            }
                                            elseif($mesV=='August'){  
                                                $mesV= 'Agosto';
                                            }
                                            elseif($mesV=='September'){  
                                                $mesV= 'Septiembre';
                                            }
                                            elseif($mesV=='October'){  
                                                $mesV= 'Octubre';
                                            }
                                            elseif($mesV=='November'){  
                                                $mesV= 'Noviembre';
                                            }
                                            else{  
                                                $mesV= 'Diciembre';
                                            }
                                        @endphp 
                                        <td>
                                            {{$numeroDiaV}} de {{$mesV}}
                                        </td> 
                                        @if($post->Visto==0)
                                            <td> 
                                                <button class="btn btn-danger active">NO</button>
                                            </td>
                                        @else
                                            <td> 
                                                {{$post->FechaVisto}}
                                            </td> 
                                        @endif
                                        @if($post->FechaVisto==NULL)
                                            <td> 
                                                <button class="btn btn-danger" wire:click="AnularAviso({{ $post->ID_Aviso_T }})">ELIMINAR</button>
                                            </td>
                                        @else
                                            <td> 
                                                {{$post->FechaVisto}}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach 
                            <tbody> 
                        </table> 
                        <hr>
                        <center>
                            <div class="btn-group" style=" width:80%;">	
                                <button class="btn btn-warning active" wire:click="CambiarEnviado">CAMBIAR</button>
                            </div> 
                        </center>
                    </div>
                </div>
            @else 
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>ODP ENVIADO</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body table-responsive">
                        <table table class="table table-sm table-bordered"> 
                            <thead>  
                                <tr>
                                    <th>ESTADO</th>
                                    <th>ODP</th>
                                    <th>OBSERVACIÓN ENVIADA</th>
                                    <th>RECIBIDO</th>
                                    <th>VISTO</th>
                                    <th>ELIMINAR</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach($Recibidos as $post)
                                    <tr>
                                        @if($post->R_Estado==0)
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        PENDIENTE
                                                    </div>
                                                </div>
                                            </td>
                                        @elseif($post->R_Estado==1)
                                            <td> 
                                               <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        CONFIRMADO
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
                                            {{$post->Nombre_DepDir}}
                                        </td> 
                                        <td>
                                            {{$post->R_ObservacionE}}
                                        </td>
                                        @php
                                            $numeroDiaV = date('d', strtotime($post->R_Fecha));
                                            $mesV = date('F', strtotime($post->R_Fecha));

                                            if($mesV=='January'){
                                            $mesV= 'Enero';
                                            }
                                            elseif($mesV=='February'){   
                                            $mesV= 'Febrero';
                                            }
                                            elseif($mesV=='March'){  
                                            $mesV= 'Marzo';
                                            }
                                            elseif($mesV=='April'){
                                                $mesV= 'Abril';
                                            }
                                            elseif($mesV=='May'){
                                                $mesV= 'Mayo';
                                            }
                                            elseif($mesV=='June'){
                                                $mesV= 'Junio';
                                            }
                                            elseif($mesV=='July'){ 
                                                $mesV= 'Julio';
                                            }
                                            elseif($mesV=='August'){  
                                                $mesV= 'Agosto';
                                            }
                                            elseif($mesV=='September'){  
                                                $mesV= 'Septiembre';
                                            }
                                            elseif($mesV=='October'){  
                                                $mesV= 'Octubre';
                                            }
                                            elseif($mesV=='November'){  
                                                $mesV= 'Noviembre';
                                            }
                                            else{  
                                                $mesV= 'Diciembre';
                                            }
                                        @endphp 
                                        <td>
                                            {{$numeroDiaV}} de {{$mesV}}
                                        </td> 
                                        @if($post->R_Visto==0)
                                            <td> 
                                                <button class="btn btn-danger active">NO</button>
                                            </td>
                                        @else
                                            <td> 
                                                {{$post->R_FechaVisto}}
                                            </td> 
                                        @endif
                                        @if($post->R_FechaVisto==NULL)
                                            <td> 
                                                <button class="btn btn-danger" wire:click="AnularEnvio({{ $post->ID_Ricibidos }})">ELIMINAR</button>
                                            </td>
                                        @else
                                            <td> 
                                                {{$post->R_FechaVisto}}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach 
                            <tbody> 
                        </table> 
                        <hr>
                        <center>
                            <div class="btn-group" style=" width:80%;">	
                                <button class="btn btn-warning active" wire:click="CambiarFirmantes">CAMBIAR</button>
                            </div> 
                        </center>
                    </div>
                </div>
            @endif
                @if (session()->has('message3'))
                    <div class="alert alert-danger">
                        {{ session('message3') }} 
                    </div>
                @endif
                @if (session()->has('message4'))
                    <div class="alert alert-success">
                        {{ session('message4') }} 
                    </div>
                @endif
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>ENVIAR</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <table table class="table table-hover table-sm"> 
                            <label><strong>TIPO DE ENVIO</strong></label>
                            <select wire:model="TipoEnvio" class="form-control" >
                                <option value="" selected>---SELECCIONAR---</option>
                                <option value="1">SOLICITAR FIRMA</option>
                                <option value="2">SOLICITAR V°B°</option> 
                                <option value="3">SOLO ENVIAR</option>
                            </select>
                            <label><strong>SELECCIONAR OFICINA DE PARTES</strong></label>
                            <input class="form-control" type="text" placeholder="{{$NombreOficinaParte}}" wire:model="BuscarOficinaPartes"/>
                            @if($BuscarOficinaPartes!="")
                                <table table class="table table-hover table-sm"> 
                                    @foreach($OficinaPartes as $post)
                                        <tr>
                                            <td>
                                                {{$post->Nombre_DepDir}}
                                            </td>
                                            <td>
                                                <button class="btn btn-success active" wire:click="OficinaPartesSeleccionada({{ $post->ID_DepDir }})">SELECCIONAR</button>
                                            </td>
                                        </tr>
                                    @endforeach  
                                </table>    
                            @endif	
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
                    @if (session()->has('FinalizarPortafolio'))
                        <div class="alert alert-danger">
                            {{ session('FinalizarPortafolio') }} 
                        </div>
                    @endif  
                    <div class="card-body">
                        <h5>Si la solicitud ha sido confirmada por todas las ODP seleccionadas, puede finalizadar dicha solicitud.</h5>
                    </div>
                    <center>
                    <div class="card-footer text-muted">  
                        <div class="btn-group" style=" width:80%;">	 
                            <button class="btn btn-success active" wire:click="ConfirmarFinalizarPortafolio">FINALIZAR SOLICITUD</button>
                        </div> 
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
@elseif($Detalles==3) <!--ELIMINAR VB-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h2><center><strong>ELIMINAR V°B°</strong></center></h2>
                        <hr>
                    </div>
                    <div class="card-body">
                        <h6>Si considera que la solicitud enviada a<strong> {{ $Nombre_DepDir }} </strong>fue enviado por error, puede eliminar dicho V°B°.</h6>
                        <br>
                        <strong>Por favor, Confirme su contraseña de usuario.</strong>
                        <div class="form-label-group">
                            <input type="password" class="form-control" wire:model="ContraseniaVB"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                        </div>
                    </div> 
                    <center>
                    <div class="btn-group" style=" width:80%;">
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        <button type="button" class="btn btn-DANGER active" data-dismiss="modal" wire:click="CancelarVB">CONFIRMAR</button>
                    </div>
                    </center> 
                    <br>
                    <div class="card-footer text-muted"> 
                    </div>
                    <div class="card-footer text-muted"> 
                        SGD
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>  
@elseif($Detalles==4) <!--ELIMINAR VB-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h2><center><strong>ELIMINAR FIRMANTE</strong></center></h2>
                        <hr>
                    </div>
                    <div class="card-body">
                        <h6>Si considera que la solicitud enviada a<strong> {{ $NombreAnularFirmante }} </strong>fue enviado por error, puede eliminar dicho firmante.</h6>
                        <br>
                        <strong>Por favor, Confirme su contraseña de usuario.</strong>
                        <div class="form-label-group">
                            <input type="password" class="form-control" wire:model="ContraseniaFirmante"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                        </div>
                    </div> 
                    <center>
                    <div class="btn-group" style=" width:80%;">
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        <button type="button" class="btn btn-DANGER active" data-dismiss="modal" wire:click="CancelarFirmante">CONFIRMAR</button>
                    </div> 
                    </center>
                    <br>
                    <div class="card-footer text-muted"> 
                    </div>
                    <div class="card-footer text-muted"> 
                       SGD
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>
@elseif($Detalles==5)  
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
                        <div class="text-muted">
                            <h1><center><strong>¿FINALIZAR SOLICITUD?</strong></center></h1>
                            <hr>
                        </div>
                        <div class="card-body">
                            <h5>¿Desea finalizar solicitud?</h5>
                            <br>
                        </div> 
                        <center>
                        <div class="btn-group" style=" width:80%;">
                            <button type="button" class="btn btn-danger active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                            <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="FinalizarPortafolio">CONFIRMAR</button>
                        </div> 
                        </center>
                        <br>
                        <div class="card-footer text-muted"> 
                        </div>
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
                        <h1><center><strong>ELIMINAR ENVIO</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <h6>Si considera que la solicitud enviada a<strong> {{ $NombreAnularFirmante }} </strong>fue enviado por error, puede eliminar dicho firmante.</h6>
                        <br>
                        <strong>Por favor, Confirme su contraseña de usuario.</strong>
                        <div class="form-label-group">
                            <input type="password" class="form-control" wire:model="ContraseniaFirmanteEnvio"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                        </div>
                    </div> 
                    <center>
                    <div class="btn-group" style=" width:80%;">
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="VolverPrincipal">VOLVER</button>
                        <button type="button" class="btn btn-DANGER active" data-dismiss="modal" wire:click="CancelarEnvio">CONFIRMAR</button>
                    </div> 
                    </center>
                    <br>
                    <div class="card-footer text-muted"> 
                    </div>
                    <div class="card-footer text-muted"> 
                        SGD
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div> 
@endif 
</div>