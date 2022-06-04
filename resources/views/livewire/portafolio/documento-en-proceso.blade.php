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
@if($Detalles==0)   
    <div class="row">   
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted" >
                        <br> 
                        <h1><center><strong>SOLICITUDES EN PROCESO</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <button class="btn btn-warning" onclick="location.reload()"><img src="{{URL::asset('Imagenes/Actualizar.png')}}" width="25" height="25"/></button>
                                <strong><div id="ver"></div></strong>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <input class="form-control" type="text" placeholder="Buscar..." wire:model="search" title="Buscar por título,Folio,Tipo documento, Observación"/>
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
                    <div class="card-body table-responsive">
                        <table table class="table table-hover">
                            <thead> 
                                <tr>  
                                    <th>ESTADO</th>
                                    <th>N° INTERNO</th> 
                                    <th>N° FOLIO</th>
                                    <th>TÍTULO</th>
                                    <th>TIPO</th>
                                    <th>FECHA INGRESO</th>
                                    <th>OBSERVACIÓN</th>
                                    <th>DETALLES</th>
                                </tr> 
                            </thead> 
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        EN PROCESO
                                                    </div>
                                                </div>
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
                                        @endphp
                                            <td>
                                                {{$numeroDiaFC}} de {{$mesFC}}
                                            </td> 
                                            <td> {{ $post->Observacion_T }}  </td>
                                            <td> 
                                                <button class="btn btn-success" wire:click="Detalles({{ $post->ID_Documento_T }})">DETALLES</button>
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted" >
                        <br> 
                        <h1><center><strong>ARCHIVOS</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <table table class="table table-hover">
                            <thead>  
                                <tr>  
                                    <th>NOMBRE ARCHIVO</th>
                                    <th>VER</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach($MostrarDocumentos as $post)
                                    <tr> 
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
                                @endforeach 
                            </tbody> 
                        </table> 
                    </div>
                </div>
            @if($Cambiar==0)
                <div class="card bg-light mb-3"> 
                    <div class="text-muted" >
                        <br> 
                        <h1><center><strong>ODP FIRMANTES</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body table-responsive">
                        <table table class="table table-hover">
                            <thead>  
                                <tr> 
                                    <th>ESTADO</th>
                                    <th>ODP</th>
                                    <th>OBSERVACIÓN ENVIADA</th>
                                    <th>OBSERVACIÓN RECIBIDA</th>
                                    <th>RECIBIDO</th>
                                    <th>VISTO</th>
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
                                            {{$post->Nombre_DepDir }}
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
                                    </tr>
                                @endforeach 
                            <tbody> 
                        </table> 
                    </div>
                    <div class="card-footer text-muted">
                        <div class="btn-group" style=" width:100%;">	
                            <button class="btn btn-warning active" wire:click="CambiarVB">MOSTRAR ODP V°B°</button>
                        </div> 
                    </div>	
                </div> 
            @else 
                <div class="card bg-light mb-3">
                    <div class="text-muted" >
                        <br> 
                        <h1><center><strong>ODP V°B°</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body table-responsive">
                        <table table class="table table-hover">
                            <thead>  
                                <tr>
                                    <th>ESTADO</th>
                                    <th>ODP</th>
                                    <th>OBSERVACIÓN ENVIADA</th>
                                    <th>OBSERVACIÓN RECIBIDA</th>
                                    <th>RECIBIDO</th>
                                    <th>VISTO</th>
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
                                            $numeroDiaV = date('d', strtotime($post->FechaVisto));
                                            $mesV = date('F', strtotime($post->FechaVisto));

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
                                    </tr>
                                @endforeach 
                            <tbody> 
                        </table> 
                    </div>
                    <div class="card-footer text-muted">
                        <div class="btn-group" style=" width:100%;">	
                            <button class="btn btn-warning active" wire:click="CambiarFirmantes">MOSTRAR ODP FIRMANTES</button>
                        </div> 
                    </div>
                </div>
            @endif
            <div class="card-footer text-muted">
                <div class="btn-group" style=" width:100%;">	
                    <button class="btn btn-danger active" wire:click="Volver">VOLVER</button>
                </div> 
            </div> 
@endif  
@endif  
 