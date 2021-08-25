<div> 
<br>
@include('messages')  
@if($Detalles==0) 
    <div class="row">  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
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
                                    <input class="form-control" type="text" placeholder="Buscar..." wire:model="search" title="Buscar por título,Tipo documento, Observación"/>
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
                                            @if($post->Estado_T==1)
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
                                                    <form method="POST" action="{{ route('MostrarPDF') }}">   
                                                        @csrf             
                                                        <input type="hidden" name="ID_Documento_T" value="{{ $post->ID_Documento_T }}">
                                                        <div class="btn-group" style=" width:100%;">	
                                                            <button type="submit" class="btn btn-primary active" formtarget="_blank">PDF</button>
                                                        </div>
                                                    </form> 
                                                </td>
                                                <td> 
                                                    <button class="btn btn-success" wire:click="Detalles({{ $post->ID_Documento_T }})">DETALLES</button>
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
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <center><strong>No hay resultados para la búsqueda "{{ $search }}"</strong></center>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
                        </div>
                        <br>
                    @endif    
                    </div>
                </div> 
            </div>
        </div> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>                  
@else
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
                                <h5><strong>Lista destinatarios</strong></h5> 
                            </div>  
                            <div class="card-body">
                                <table id="Multas" class="table table-striped table-bordered" style="width:100%">
                                    <thead> 
                                        <tr>  
                                            <th>Funcionario</th>
                                            <th>Estado</th>
                                            <th>Recibido</th>
                                            <th>Observacion Enviada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($FuncionariosAsig as $post)
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
                                            @endphp

                                            <tr>
                                                <td>
                                                    <strong>{{$post->Nombres}} {{$post->Apellidos}}</strong>
                                                </td>
                                                @if($post->Estado==0)  
                                        
                                        <td>
                                            <div class="progress" style="height: 33px;">
                                                <div class="progress-bar bg-danger" 
                                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    <strong> NO RESPONDIDO </strong>
                                                </div>
                                            </div>
                                        </td>
                            @elseif($post->Estado==1)
                            
                                        <td> 
                                            <div class="progress" style="height: 33px;">
                                                <div class="progress-bar bg-primary" 
                                                    role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                    <strong> ENVIADO </strong>
                                                </div>
                                            </div>
                                        </td>
                            @elseif($post->Estado==2)
                            
                            <td> 
                                <div class="progress" style="height: 33px;">
                                    <div class="progress-bar bg-success" 
                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        <strong> FINALIZADO </strong>
                                    </div>
                                </div>
                            </td> 
                            @elseif($post->Estado==3)
                            
                            <td> 
                                <div class="progress" style="height: 33px;">
                                    <div class="progress-bar bg-danger" 
                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        <strong> RECHAZADO </strong>
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
                            @endif   
                                                <td>
                                                   <strong> {{$numeroDiaFR}} de {{$mesFR}} del {{$anioFR}}</strong>
                                                </td>
                                            @php
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
                                                <td>  <textarea rows="3" style="width:100%;" disabled>{{$post->Mensaje_Cre  }}</textarea> </td>  
                                            </tr>
                                        @endforeach 
                                    </tbody>
                                </table> 
                            </div>	
                            <div class="card-footer text-muted">
                                {{ $FuncionariosAsig->links() }} 
                            </div>	
                            <div class="btn-group" style=" width:100%;">	
                                <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
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
@endif 
