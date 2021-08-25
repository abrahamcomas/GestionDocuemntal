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
                            <h5><strong>Documentos de aviso</strong></h5>
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
                                        <th>Mensaje de Emisor</th>
                                        <th>Titulo</th>
                                        <th>Tipo</th>
                                        <th>Fecha Ingreso</th> 
                                        <th>Observación Documento</th>
                                        <th>Documento</th>
                                        <th>Participantes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $post)
                                        <tr>
                                        <td>
                                                {{$post->Nombres   }} {{$post->Apellidos    }}
                                            </td>
                                            <td>
                                                {{$post->Observacion   }}
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
                                                <form method="POST" action="{{ route('MostrarPDF') }}">   
                                                    @csrf             
                                                    <input type="hidden" name="ID_Documento_T" value="{{ $post->ID_Documento_T }}"> 
                                                    <div class="btn-group" style=" width:100%;">	 
                                                        <button type="submit" class="btn btn-primary active" wire:click="Visto({{ $post->ID_Documento_T }})" formtarget="_blank">PDF</button>
                                                    </div>
                                                </form> 
                                            </td>
                                            <td> 
                                                <button class="btn btn-success" wire:click="Opciones({{ $post->ID_Documento_T }})">Lista</button>
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
                                    <div class="table-responsive"> 
                                        <table table class="table table-hover">
                                            <thead> 
                                                <tr>  
                                                    <th>Estado</th>
                                                    <th>Nombre</th>
                                                    <th>Visto</th>
                                                    <th>Observación</th>
                                                 
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
                                                    <strong> EN ESPERA </strong>
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
                                                            {{$post->Nombres  }}      {{$post->Apellidos  }}
                                                        </td> 
                                                    @if($post->Visto==0)
                                                        <td>NO</td>  
                                                    @else 
                                                        <td>{{$post->Fecha_V  }}</td>
                                                    @endif
                                                        <td><textarea rows="3" style="width:100%;" disabled>{{$post->Mensaje_Cre  }}</textarea> </td>  

                                          
                                                        </tr>
                                                @endforeach 
                                            </tbody>
                                        </table>  
                                    </div>	
                                </div>	
                                <div class="card-footer text-muted">
                                    {{ $FuncionariosAsig->links() }}
                                </div>	
                                
                            @if (session()->has('messageEnviado'))
                                <div class="alert alert-danger">
                                    {{ session('messageEnviado') }}
                                </div> 
                            @endif
                                <div class="btn-group" style=" width:100%;">	
                                    <button class="btn btn-danger active" wire:click="VolverPrincipal">volver</button>
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
</div>



  


        
 
