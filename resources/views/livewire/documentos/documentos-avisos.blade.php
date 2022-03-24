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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="table-responsive"> 
                        <div class="card-header">
                            <h5><strong>Documentos nuevos</strong></h5>
                        </div> 
                        <button class="btn btn-success active" wire:click="Historial" style="float: right;">HISTORIAL</button> 
                        <br><br>
                    @if($postsSV->count()) 
                        <div class="card-body">
                            <table table class="table table-hover">
                                <thead> 
                                    <tr>  
                                        <th>Funcionario</th>
                                        <th>Mensaje</th>
                                        <th>N° Folio</th>
                                        <th>Titulo</th>
                                        <th>Tipo</th>
                                        <th>Fecha Ingreso</th> 
                                        <th>Observación Documento</th>
                                    
                                        <th>Documentos</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($postsSV as $post)
                                    <tr>
                                        <td>
                                            {{$post->Nombres}} {{$post->Apellidos}}
                                        </td>
                                        <td>
                                            {{$post->ObservacionE}}
                                        </td>
                                        <td>
                                            {{$post->Folio}}
                                        </td>
                                        <td>
                                            {{$post->Titulo_T}}
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
                                            <div class="progress" style="height: 33px;">
                                                <div class="progress-bar bg-success" 
                                                    role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    <strong><center>{{$numeroDiaFC}} de {{$mesFC}} del {{$anioFC}}</center> </strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <textarea rows="3" style="width:100%;" disabled> {{$post->Observacion_T  }} </textarea>
                                        </td>

                                        <td>
                                            <button class="btn btn-success active" wire:click="DocumentosSubidosTotal({{ $post->ID_Aviso_T }})">DOCUMENTOS</button> 
                                        </td>
                                        <td> 
                                            <button class="btn btn-success active" wire:click="Responder({{ $post->ID_Aviso_T }})">CONFIRMAR</button>
                                        </td>   
                                    </tr>
                                @endforeach 
                                </tbody>
                            </table>  
                            </div>	
                            <div class="card-footer table-responsive text-muted">
                                {{ $postsSV->links() }}
                            </div>	
                            <div class="card-footer text-muted">
                                GESTIÓN DOCUMENTAL
                            </div>
                        </div>
                    @else 
                        <div class="card">
                            <div class="card-body">
                                <center><strong>No hay nuevos documentos</strong></center>
                            </div>
                        </div>
                    @endif    
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
    </div>
@elseif($Historial==0) 
    <div class="row">  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="table-responsive">
                        <div class="card-header">
                            <h5><strong>Historial</strong></h5>
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
                            <div class="table-responsive"> 
                            <table table class="table table-hover">
                                <thead> 
                                    <tr>  
                                        <th>Funcionario</th>
                                        <th>Mensaje</th>
                                        <th>N° Folio</th>
                                        <th>Titulo</th>
                                        <th>Tipo</th>
                                        <th>Fecha Ingreso</th> 
                                        <th>Observación Documento</th>
                                        <th>Respuesta</th>
                                        <th>Documentos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $post)
                                        <tr>
                                        <td>
                                                {{$post->Nombres   }} {{$post->Apellidos    }}
                                            </td>
                                            <td>
                                                {{$post->ObservacionE    }}
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

    
                                    @endphp
                                            <td>
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar bg-success" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        <strong>      <center>{{$numeroDiaFC}} de {{$mesFC}} del {{$anioFC}}</center> </strong>
                                                    </div>
                                                </div>
                                           
                                            </td>
                               
                                            <td>
                                                <textarea rows="3" style="width:100%;" disabled> {{$post->Observacion_T  }} </textarea>
                                            </td>
                                            <td>
                                            <textarea rows="3" style="width:100%;" disabled> {{$post->ObservacionR  }} </textarea>
                                        </td>
                                            <td>
                                                <button class="btn btn-success active" wire:click="DocumentosSubidosTotal2({{ $post->ID_Documento_T }})">DOCUMENTOS</button> 
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
                                    <div class="btn-group" style=" width:100%;">	
                                        <button class="btn btn-danger active" wire:click="VolverPrincipal2">VOLVER</button>
                                     </div> 
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
    </div>
@elseif($Detalles=="DocumentosSubidosTotal") 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
    </div>
@elseif($Detalles=="DocumentosSubidosTotal2") 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                                                    <div class="btn-group" style=" width:50%;">	
                                                        <button type="submit" class="btn btn-primary active" formtarget="_blank">PDF</button>
                                                    </div>
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
                            <button class="btn btn-danger active" id="CancelarConfirmarIngreso"  wire:click="VolverListaDocumentos2">VOLVER</button>
                        </div> 
                    </div>
                    <div class="card-footer text-muted"> 
                        GESTIÓN DOCUMENTAL
                    </div>
                </div>
            </div>   
        </div>
    </div>
@elseif($Detalles=="ResponderSolicitud") 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                        <h5><strong>Agregar comentario (Opcional)<oPCIONAL</strong></h5>
                    </div> 
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table table class="table table-hover">
       
                                <tbody> 
              
                                        <tr> 
                                    
                                            <td>
                                                <textarea rows="3" style="width:100%;" wire:model="Comentario">    </textarea>
                                            </td>
                                     
                                        </tr>
                             
                                </tbody> 
                            </table> 

                        </div>
                    </div> 
                    <div class="card-footer text-muted"> 
                        <div class="btn-group" style=" width:100%;">	
                            <button class="btn btn-danger active"  wire:click="VolverListaDocumentos">VOLVER</button>
                            <button class="btn btn-success active" wire:click="IngresarComentario">INGRESAR</button>
                        </div> 
                    </div>
                    <div class="card-footer text-muted"> 
                        GESTIÓN DOCUMENTAL
                    </div>
                </div>
            </div>   
        </div>
    </div>
@endif


  


        
 
