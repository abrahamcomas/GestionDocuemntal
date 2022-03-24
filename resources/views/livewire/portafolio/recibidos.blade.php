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
                            <center><img src="{{URL::asset('Imagenes/Portafolio/Recibidos.JPG')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
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
@if($Existe==0) 
        <style>
                #Imagen {
                    font-size: 18px;
                    width: 700px;
                    height: 150px;
                }
                img.izquierda { 
                    float: left;
                }
                img.derecha {
                    float: right; 
                }
                p {
                font: oblique bold 120% cursive;
                }  
            </style>
        <script type="text/javascript">
            function Capturar(){
                html2canvas(document.querySelector('.specific'), {
                    onrendered: function(canvas) {
                        document.getElementById("Firma").value = canvas.toDataURL();
                    }
                }); 
            }
        </script>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                @include('messages')  
                <div class="col">     
                    <div class="card bg-light mb-3">
                        <div class="card-header"> <h4><strong>IMAGEN DE FIRMA AUTOMÁTICA</strong></g4></div>
                        <div class="card-body">	 
                            <div id="Imagen" class="specific"> 
                                <p><img class="izquierda" src="{{URL::asset('Imagenes/escudo.png')}}" width="120" height="120"/><strong>Firmado digitalmente por<br> {{$Nombres}} {{$Apellidos}} <br> {{$Rut}} <br>{{$Oficina}} <br>{{$Cargo}}</strong></p>
                            </div>
                            <br><br><br>  
                            <form method="POST" action="{{ route('ImagenCreada3') }}"> 
                                @csrf  
                                <div style="display: none">   
                                    <input type="text" id="Firma" name="Firma">
                                </div>  
                                @if($Creado==1)
                                    <div class="btn-group" style=" width:100%;">
                                        <button type="button" onclick="Capturar()" class="btn btn-warning" wire:click="Creada">
                                            ACEPTAR
                                        </button> 
                                    </div> 
                                @else
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" class="btn btn-success">CONTINUAR</button>
                                    </div>
                                @endif
                            </form>
                        </div> 
                        <div class="card-footer text-muted">
                            GESTIÓN DOCUMENTAL 
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>		 
        </div>    
@else                    
        @if($Detalles==0)  
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col">
                        @if (session()->has('message1'))
                            <div class="alert alert-success">
                                {{ session('message1') }}
                            </div>
                        @endif
                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                <h4><strong>SOLICITUDES RECIBIDAS</strong></h4>
                            </div> 
                            <div class="card-body">  
                                <div class="row">  
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" onmouseover="mostrar('Más información.');" onmouseout="ocultar()" width="25" height="25"/></button>
                                        <button class="btn btn-warning" onclick="location.reload()"><img src="{{URL::asset('Imagenes/Actualizar.png')}}" width="25" height="25"/></button>
                                        <strong><div id="ver"></div></strong>
                                    </div>
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
                            <div class="card-body table-responsive">
                                <table table class="table table-hover">
                                    <thead> 
                                        <tr>  
                                            <th>ENVIADO POR</th>
                                            <th>FUNCIONARIO</th>
                                            <th>N° INTERNO</th>
                                            <th>FOLIO</th>
                                            <th>TÍTULO</th>
                                            <th>INGRESO</th>
                                            <th>DÍAS PARA TERMINO</th>
                                            <th>OBSERVACIÓN</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    </thead>  
                                    <tbody> 
                            @foreach($posts as $post)
                                        <tr>
                                            <td>
                                                {{$post->Nombre_DepDir }}
                                            </td>
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
                                                {{$post->Titulo_T}}
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
                                                <textarea rows="3" style="width:100%;" disabled> {{$post->Observacion}} </textarea>
                                            </td>
                                            <td>
                                                <button class="btn btn-success" wire:click="EnviarDocumento({{ $post->ID_Documento_T }},{{ $post->IPF_ID }} )">OPCIONES</button>
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
                                GESTIÓN DOCUMENTAL<br>
                                SECRETARIA/O ODP {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
        @elseif($Detalles==4)<!--ENVIAR SOLICITUD-->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col">
                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                <h4><strong>ARCHIVOS</strong></h4>
                            </div>  
                            <div class="card-body table-responsive">
                                <table table class="table table-hover">
                                    <thead>  
                                        <tr>  
                                            <th>SUBIDO POR</th>
                                            <th>NOMBRE ARCHIVO</th>
                                            <th>VER</th> 
                                            <th>FIRMAR</th>
                                        </tr>
                                    </thead> 
                                    <tbody>  
                                        @foreach($MostrarDocumentos as $post)
                                            <tr> 
                                                <td>
                                                    {{ $Nombres=$post->Nombres  }} {{ $Apellidos=$post->Apellidos }}
                                                </td> 
                                                <td>
                                                    <textarea rows="3" style="width:100%;" disabled>{{ $post->NombreDocumento }}</textarea>
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
                                                @if($post->Firmado==0)    
                                                            <td>      
                                                                <form method="POST" action="{{ route('FirmaIndRec') }}">
                                                                    @csrf      
                                                                    <input type="hidden" name="ID_DestinoDocumento" value="{{ $post->ID_DestinoDocumento  }}">	
                                                                    <input type="hidden" name="IPF_ID" value="{{ $IPF_ID }}">
                                                                    <div class="btn-group" style=" width:50%;">	
                                                                        <button type="submit" id="btnEnviar1" class="btn btn-danger active">FIRMAR</button>
                                                                    </div>
                                                                </form> 
                                                            </td>  
                                                    @else        
                                                            <td colspan="2">
                                                                @php 
                                                                    $FechaFirma = $post->FechaFirma;
                                                                    $MostrarFecha = date("d-m-Y", strtotime($FechaFirma));
                                                                @endphp
                                                                <strong>FIRMADO EL {{$MostrarFecha}}</strong>
                                                            </td>
                                                    @endif
                                            </tr>
                                        @endforeach    
                                    </tbody> 
                                </table> 
                            </div>    
                            @if($cuantos>=2)
                                <form method="POST" action="{{ route('FirmaMasivaRec') }}">
                                    @csrf      
                                    <input type="hidden" name="ID_Documento_T" value="{{ $ID_Documento_T  }}">	
                                    <div class="btn-group" style=" width:100%;">	
                                        <button type="submit" id="btnEnviar1" class="btn btn-info active">FIRMA MASIVA</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col">
                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                <h4><strong>V°B°</strong></h4>
                            </div> 
                            <div class="card-body table-responsive">
                                <table table class="table table-hover">
                                    <thead>  
                                        <tr>
                                            <th>ESTADO</th>
                                            <th>FUNCIONARIO</th>
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
                                                                ACEPTADO
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
                                                    {{ $post->Nombres }} {{ $post->Apellidos }}
                                                </td>
                                                @php
                                                    $numeroDiaV = date('d', strtotime($post->FechaR ));
                                                    $mesV = date('F', strtotime($post->FechaR ));

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
                                                        <div class="progress" style="height: 33px;">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                NO
                                                            </div>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td> 
                                                        <div class="progress" style="height: 33px;">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                SI
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach 
                                    <tbody> 
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col">
                        @if (session()->has('message2'))
                            <div class="alert alert-danger">
                                {{ session('message2') }}
                            </div>
                        @endif
                        <div class="card bg-light mb-3">
                            <div class="card-header"> 
                                <h4><strong>RECHAZAR</strong></h4> 
                            </div> 
                            <div class="card-body"> 
                                <label><strong>AGREGAR OBSERVACIÓN (OPCIONAL)</strong></label>
                                <div class="form-label-group"> 
                                    <textarea class=" form-control" wire:model="ObservacionPortafolio"></textarea>
                                </div>
                            </div>
                            <div class="card-footer text-muted"> 
                                <div class="btn-group" style=" width:100%;">	
                                    <button class="btn btn-danger active" wire:click="VolverPrincipal">VOLVER</button>
                                    <button class="btn btn-warning active" wire:click="RespuestaPortafolio">RECHAZAR</button>
                                </div> 
                            </div>
                            <div class="card-footer text-muted">
                                GESTION DOCUMENTAL <br>
                                SECRETARIA OFICINA DE PARTES {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                            </div>
                        </div>	
                    </div>	
                </div>			
            </div>
        @endif
@endif 
</div>
@endif