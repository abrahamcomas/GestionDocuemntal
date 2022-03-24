<div> 
<br>
@include('messages')  
@if($Detalles==0)  
    <div class="row">  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="table-responsive">
                        <div class="card-header">
                            <h5><strong>Documentos Finalizados año {{ $AnioSelect}}  </strong></h5>
                        </div> 
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-label-group">
                                        <select class="form-control" wire:model="AnioSelect"> 
                                            @foreach ($Anio as $row)
                                                <option value="{{ $row->Anio }}">Año {{ $row->Anio }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
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
                        <div class="card-body">
                            <table id="Multas" class="table table-striped table-bordered" style="width:100%">
                                <thead> 
                                    <tr>  
                                        <th>Estado</th>
                                        <th>Titulo</th>
                                        <th>N° Folio</th>
                                        <th>Tipo</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Observacion</th> 
                                        <th>Documento</th>
                                        <th>DETALLES</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                            @if($post->Estado_T==3)
                                                <td>
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar bg-success" 
                                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            <strong> Finalizado </strong>
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar bg-danger" 
                                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            <strong> Rechazado </strong>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                                <td>
                                                    {{$post->Titulo_T  }}
                                                </td>
                                                <td>
                                                    {{$post->Folio}}
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
                                            @endphp
                                                <td>
                                                    {{$numeroDiaFC}} de {{$mesFC}} del {{$anioFC}}
                                                </td> 
                                                <td>
                                                    <textarea rows="3" style="width:100%;" disabled> {{$post->Observacion_T  }} </textarea>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success active" wire:click="DocumentosSubidosTotal({{ $post->ID_Documento_T }})">LISTA DE DOCUMENTOS</button> 
                                                </td>
                                                <td> 
                                                    <button class="btn btn-success" wire:click="Detalles({{ $post->ID_Documento_T }})">DETALLES</button>
                                                </td>
                                        </tr>
                                    @endforeach 
                                </tbody>    
                            </table> 
                        </div>
                        <div class="card-footer table-responsive text-muted">
                            {{ $posts->links() }}
                        </div>	
                        <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL
                        </div>
                    @else 
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <center><strong>No hay resultados para la búsqueda "{{ $search }}"</strong></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    @endif    
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
                    <div class="card-header">
                        <h5><strong>Lista de documentos</strong></h5>
                    </div> 
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table table class="table table-hover">
                                <thead> 
                                    <tr>  
                                        <th>Funcionario</th>
                                        <th>Nombre documento</th>
                                        <th>Ver</th>
                                    </tr>
                                </thead>  
                                <tbody>
                                    @foreach($DocumentosSubidosTotal as $post) 
                                        <tr> 
                                            <td>
                                                {{ $post->Nombres}} {{ $post->Apellidos}}
                                            </td>
                                            <td>
                                                <textarea rows="3" style="width:100%;" disabled>   {{ $post->NombreDocumento }} </textarea>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('MostrarPDF') }}">   
                                                    @csrf             
                                                    <input type="hidden" name="ID_DestinoDocumento" value="{{ $post->ID_DestinoDocumento }}">
                                                    <center> 
                                                    <div class="btn-group" style=" width:50%;">	
                                                        <button type="submit" class="btn btn-primary active" formtarget="_blank">PDF</button>
                                                    </div>
                                                    </center> 
                                                </form>  
                                            </td>
                                        </tr>
                                    @endforeach 
                                </tbody> 
                            </table> 
                            <div class="card-footer table-responsive text-muted">
                                {{ $DocumentosSubidosTotal->links() }}
                            </div>	
                        </div>
                    </div> 
                    <div class="card-footer text-muted"> 
                        <div class="btn-group" style=" width:100%;">	
                            <button class="btn btn-danger active" id="CancelarConfirmarIngreso"  wire:click="VolverListaDocumentos">VOLVER</button>
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
@elseif($Detalles==2) 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3" > 
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
                    <div class="card">
                        <div class="card-header"> 
                            <h5><strong>Vistos buenos</strong></h5> 
                        </div>  
                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table table class="table table-hover">
                                    <thead> 
                                        <tr>  
                                            <th>Observacion enviada</th>
                                            <th>Funcionario</th>           
                                            <th>Visto</th>
                                            <th>Observacion recibida</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($FuncionariosAvisos as $post)
                                            <tr>
                                                <td>
                                                    <textarea rows="3" style="width:100%;" disabled> {{$post->ObservacionE}} </textarea>
                                                </td>
                                                <td>
                                                    <strong>  {{$post->Nombres  }}      {{$post->Apellidos  }}</strong>
                                                </td>
                                            @if($post->Visto==0)
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar bg-danger" 
                                                            role="progressbar"  style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            <strong> NO </strong>
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                @php
                                                    $numeroDiaFV = date('d', strtotime($post->Fecha ));
                                                    $mesFV = date('F', strtotime($post->Fecha ));
                                                    $anioFV = date('Y', strtotime($post->Fecha ));

                                                    if($mesFV=='January'){
                                                    $mesFV= 'Enero';
                                                    }
                                                    elseif($mesFV=='February'){   
                                                    $mesFV= 'Febrero';
                                                    }
                                                    elseif($mesFV=='March'){  
                                                    $mesFV= 'Marzo';
                                                    }
                                                    elseif($mesFV=='April'){
                                                        $mesFV= 'Abril';
                                                    }
                                                    elseif($mesFV=='May'){
                                                        $mesFV= 'Mayo';
                                                    }
                                                    elseif($mesFV=='June'){
                                                        $mesFV= 'Junio';
                                                    }
                                                    elseif($mesFV=='July'){ 
                                                        $mesFV= 'Julio';
                                                    }
                                                    elseif($mesFV=='August'){  
                                                        $mesFV= 'Agosto';
                                                    }
                                                    elseif($mesFV=='September'){  
                                                        $mesFV= 'Septiembre';
                                                    }
                                                    elseif($mesFV=='October'){  
                                                        $mesFV= 'Octubre';
                                                    }
                                                    elseif($mesFV=='November'){  
                                                        $mesFV= 'Noviembre';
                                                    }
                                                    else{  
                                                        $mesFV= 'Diciembre';
                                                    }
                                        
                                                @endphp
                                                <td>
                                                    {{$numeroDiaFV}} de {{$mesFV}} del {{$anioFV}}
                                                </td>
                                            @endif
                                            <td>
                                                    <textarea rows="3" style="width:100%;" disabled> {{$post->ObservacionR}} </textarea>
                                                </td>

                                            @if($post->Visto==0)
                                                <td>
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar bg-success" 
                                                            role="progressbar"  style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            <strong> NO VISTO </strong>
                                                        </div>
                                                    </div>
                                                </td> 
                                            @else
                                                <td>
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar bg-success" 
                                                            role="progressbar"  style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            <strong> CONFIRMADO </strong>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                            </tr>
                                        @endforeach 
                                    </tbody>
                                </table> 
                                <div class="card-footer table-responsive text-muted">
                                    {{ $FuncionariosAvisos->links() }}
                                </div>	
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="btn-group" style=" width:100%;">	
                                <button class="btn btn-danger active" wire:click="VolverAvisos">VOLVER</button>
                            </div> 
                        </div> 
                        <div class="card-footer text-muted">
                            GESTION DOCUMENTAL
                        </div>
                    </div>  
                </div>	
            </div>	 	
        </div>	
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>
@elseif($Detalles==3)
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <div class="col">
                <div class="card bg-light mb-3" > 
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
                    <div class="card">
                        <div class="table-responsive">
                            <div class="card-header"> 
                                <h5><strong>Detalles Solicitud</strong></h5> 
                            </div>  
                            <div class="card-body">
                                <div class="table-responsive"> 
                                    <table table class="table table-hover">
                                        <button class="btn btn-success active" wire:click="AdministrarVistosBuenos" style="float: right;">VISTOS BUENOS</button> 
                                        <thead> 
                                            <tr>  
                                                <th>Emisor</th>
                                                <th>Observación</th>
                                                <th>Receptor</th>
                                                <th>Recibido</th>
                                                <th>Visto</th>
                                                <th>Estado</th>
                                            </tr> 
                                        </thead>
                                        <tbody> 
                                    @foreach($FuncionariosAsig as $post)
                                        <tr>
                                            <td>
                                                 <strong>{{$post->NombreEmis}} {{$post->ApellidoEmis}}</strong>
                                            </td>
                                            <td>
                                                <textarea rows="3" style="width:100%;" disabled> {{$post->Mensaje_E}} </textarea>
                                            </td>
                                            <td>
                                                <strong>{{$post->NombreRecp}} {{$post->ApellidoRecp}}</strong>
                                            </td>
                                        @php
                                            $numeroDiaFR = date('d', strtotime($post->FechaR));
                                            $mesFR = date('F', strtotime($post->FechaR));
                                            $anioFR = date('Y', strtotime($post->FechaR));

                                            if($mesFR=='January'){
                                            $mesFR= 'Enero';
                                            }
                                            elseif($mesFR=='February'){   
                                            $mesFR= 'Febrero';
                                            }
                                            elseif($mesFR=='March'){  
                                            $mesFR= 'Marzo';
                                            }
                                            elseif($mesFR=='April'){
                                                $mesFR= 'Abril';
                                            }
                                            elseif($mesFR=='May'){
                                                $mesFR= 'Mayo';
                                            }
                                            elseif($mesFR=='June'){
                                                $mesFR= 'Junio';
                                            }
                                            elseif($mesFR=='July'){ 
                                                $mesFR= 'Julio';
                                            }
                                            elseif($mesFR=='August'){  
                                                $mesFR= 'Agosto';
                                            }
                                            elseif($mesFR=='September'){  
                                                $mesFR= 'Septiembre';
                                            }
                                            elseif($mesFR=='October'){  
                                                $mesFR= 'Octubre';
                                            }
                                            elseif($mesFR=='November'){  
                                                $mesFR= 'Noviembre';
                                            }
                                            else{  
                                                $mesFR= 'Diciembre';
                                            }

                                            $date1R=new DateTime(date("Y-m-d"));
                                            $date2R=date_create($post->FechaR);
                                            $diffR=date_diff($date2R,$date1R);
                                            $diasR = $diffR->format("%R%a");
                                            $TotalR = $diasR*1;  
                            
                                            $numeroDiaFV = date('d', strtotime($post->Fecha_V));
                                            $mesFV = date('F', strtotime($post->Fecha_V));
                                            $anioFV = date('Y', strtotime($post->Fecha_V));

                                            if($mesFV=='January'){
                                            $mesFV= 'Enero';
                                            }
                                            elseif($mesFV=='February'){   
                                            $mesFV= 'Febrero';
                                            }
                                            elseif($mesFV=='March'){  
                                            $mesFV= 'Marzo';
                                            }
                                            elseif($mesFV=='April'){
                                                $mesFV= 'Abril';
                                            }
                                            elseif($mesFV=='May'){
                                                $mesFV= 'Mayo';
                                            }
                                            elseif($mesFV=='June'){
                                                $mesFV= 'Junio';
                                            }
                                            elseif($mesFV=='July'){ 
                                                $mesFV= 'Julio';
                                            }
                                            elseif($mesFV=='August'){  
                                                $mesFV= 'Agosto';
                                            }
                                            elseif($mesFV=='September'){  
                                                $mesFV= 'Septiembre';
                                            }
                                            elseif($mesFV=='October'){  
                                                $mesFV= 'Octubre';
                                            }
                                            elseif($mesFV=='November'){  
                                                $mesFV= 'Noviembre';
                                            }
                                            else{  
                                                $mesFV= 'Diciembre';
                                            }
                                     
                                        @endphp
                                            <td>
                                                {{$numeroDiaFV}}/{{$mesFV}}/{{$anioFV}}
                                            </td>
                                            <td>
                                                <strong> {{$numeroDiaFR}}/{{$mesFR}}/{{$anioFR}}</strong>
                                            </td>
                                        @if($post->Estado==1)
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-success" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong>ACEPTADO</strong>
                                                    </div>
                                                </div>
                                            </td>
                                        @elseif($post->Estado==2)
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-success" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong>ACEPTADO Y ENVIADO</strong>
                                                    </div>
                                                </div>
                                            </td>
                                        @elseif($post->Estado==3)
                                            <td> 
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-danger" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong>RECHAZADO</strong>
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
                            <div class="card-footer table-responsive text-muted">
                                {{ $FuncionariosAsig->links() }}
                            </div>
                            <div class="card-footer text-muted"> 
                                <div class="btn-group" style=" width:100%;">	
                                    <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                </div> 
                            </div>
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
