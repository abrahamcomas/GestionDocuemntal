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
                    <div class="card-header">
                        <h5><strong>Documentos En Proceso</strong></h5>
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
                        <h8><strong>Solo los documentos firmados pueden ser enviados.</strong></h8>
                        <div class="table-responsive"> 
                            <table table class="table table-hover">
                                <thead> 
                                    <tr>  
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Observación</th>
                                        <th>Documento</th>
                                        <th>Enviar</th>
                                    </tr>
                                </thead>
                                <tbody>
                            @foreach($posts as $post)
                                        <tr>
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
                                                        <strong> {{  $Total }} Dias atrasado</strong>
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
                                                        <button type="submit" class="btn btn-primary active" formtarget="_blank">PDF</button>
                                                    </div>
                                                </form> 
                                            </td>

                                            @if($post->Firmado==NULL)
                                            <td>
                                                <button class="btn btn-danger active" wire:click="FirmarDocumento({{ $post->ID_Documento_T }})">FIRMAR</button>
                                            </td>
                                    @else
                                            <td> 
                                                <button class="btn btn-success" wire:click="Derivar({{ $post->ID_Documento_T }})">ENVIAR</button>
                                            </td>  
                                    @endif
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
              <!--</div>-->
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
                        <h5><strong>Firmando documento, espere por favor...</strong></h5>
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
                        <h5><strong>Firmar Documento</strong></h5>
                    </div>   
                    <div class="card-body">
                        <form method="POST" action="{{ route('Firmar') }}">
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
                                    <button type="submit" id="btnEnviar1" class="btn btn-success active btn-info">ACEPTAR</button>
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
                            <h5><strong>Administrar Avisos</strong></h5> 
                        </div>  
                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table table class="table table-hover">
                                    <thead> 
                                        <tr>  
                                            <th>Funcionario</th>           
                                            <th>Visto</th>
                                            <th>Observacion Enviada</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($FuncionariosAvisos as $post)
                                            <tr>
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
                                                    <textarea rows="3" style="width:100%;" disabled> {{$post->Observacion}} </textarea>
                                                </td>

                                            @if($post->Visto==0)
                                                <td>
                                                    <button type="button" class="btn btn-danger active" data-toggle="modal" data-target="#exampleModalCenter2"  wire:click="AnularAviso({{$post->ID_Aviso_T}})">
                                                        CANCELAR
                                                    </button>
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
                                <div class="card-footer text-muted">
                                    {{ $FuncionariosAvisos->links() }}
                                </div>	
                            </div>
                        </div>
                        <div class="card-body">
                            <tbody>
                                <td>
                                    <h5><strong>Enviar</strong></h5>
                                    <div class="form-label-group"> 
                                        <select  wire:model="DestinatariosVistos" class="form-control" >
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
                                        <textarea cols="20" rows="3" style="width:100%;" wire:model="ObservacionVisto">  </textarea>
                                    </div> 	
                                </td>  
                            </tbody>               
                        </div>  
                        <div class="btn-group" style=" width:100%;">	
                            <button class="btn btn-danger active" wire:click="VolverAvisos">VOLVER</button>
                            <button class="btn btn-success active" wire:click="Avisar">AVISAR</button>
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
@else
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
                        <div class="table-responsive">
                            <div class="card-header"> 
                                <h5><strong>Enviar Documentos</strong></h5> 
                            </div>  
                            <div class="card-body">
                                <div class="table-responsive"> 
                                    <table table class="table table-hover">
                                        <p align="right">         
                                            <button class="btn btn-success active" wire:click="AdministrarAvisos">ADMINISTRAR AVISOS</button> 
                                        </p>
                                        <thead> 
                                            <tr>  
                                                <th>Funcionario</th>
                                                <th>Estado</th>
                                                <th>Recibido</th>
                                                <th>Visto</th>
                                                <th>Observacion Enviada</th>
                                
                                                <th>Envio</th>
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

                                                $date1R=new DateTime(date("Y-m-d"));
                                                $date2R=date_create($post->FechaR);
                                                $diffR=date_diff($date2R,$date1R);
                                                $diasR = $diffR->format("%R%a");
                                                $TotalR = $diasR*1;
                                                
                                            @endphp

                                            <tr>
                                                <td>
                                                    <strong>  {{$post->Nombres  }}      {{$post->Apellidos  }}</strong>
                                                </td>
                                            @if($post->Estado==0)
                                                <td> 
                                                    <div class="progress" style="height: 33px;">
                                                        <div class="progress-bar bg-info" 
                                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            <strong>  {{$TotalR }}  DIAS DETENIDO </strong>
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
                                                            <strong> ENVIADO </strong>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                                <td>
                                                   <strong> {{$numeroDiaFR}} de {{$mesFR}} del {{$anioFR}}</strong>
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
                                                    {{$numeroDiaFV}} de {{$mesFV}} del {{$anioFV}}
                                                </td>
                                            @endif
                                                <td>
                                                    <textarea rows="3" style="width:100%;" disabled> {{$post->Mensaje_Cre   }} </textarea>
                                                </td>
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
                                            <textarea cols="20" rows="3" style="width:100%;" wire:model="ObservacionR">  </textarea>
                                        </div> 	
                                    </td>  
                                </tbody>               
                            </div>  
                            <div class="btn-group" style=" width:100%;">	
                                <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                <button class="btn btn-success active" wire:click="AsignarDerivacion">ENVIAR</button>
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
                    <h5>¿Desea anular envio a <strong>{{ $NombresAnular}} {{ $ApellidosAnular}}</strong>?</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" style=" width:100%;">	
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="AnularEnvio">CONFIRMAR</button>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">GESTION DOCUMENTAL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>¿Desea anular aviso a <strong>{{ $NombresAviso}} {{ $ApellidosAviso}}</strong>?</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" style=" width:100%;">	
                        <button type="button" class="btn btn-success active" data-dismiss="modal" wire:click="ConfirmarAnularAviso">CONFIRMAR</button>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>