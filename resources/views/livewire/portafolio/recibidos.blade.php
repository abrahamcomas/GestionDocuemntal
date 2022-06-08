<div> 
<br>      
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
                font: oblique bold 120%;
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
                        <div class="text-muted">
                            <h1><center><strong>IMAGEN DE FIRMA AUTOMÁTICA</strong></center></h1>
                            <hr>
                        </div> 
                        <div class="card-body">	 
                            <div id="Imagen" class="specific"> 
                                <p><img class="izquierda" src="{{URL::asset('Imagenes/escudo.png')}}" width="120" height="120"/><strong>Firmado digitalmente por<br> {{$Nombres}} {{$Apellidos}} <br> {{$Rut}} <br>{{$Oficina}} <br>{{$Cargo}}</strong></p>
                            </div>
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
                            <div class="text-muted">
                                <h1><center><strong>SOLICITUDES RECIBIDAS</strong></center></h1>
                                <hr>
                            </div> 
                            <div class="card-body">  
                                <div class="row">  
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <!--<button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" onmouseover="mostrar('Más información.');" onmouseout="ocultar()" width="25" height="25"/></button>-->
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
                                SGD
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
                            <div class="text-muted">
                                <h1><center><strong>ARCHIVOS</strong></center></h1>
                                <hr>
                            </div> 
                            <div class="card-body table-responsive">
                                <table table class="table table-hover">
                                    <thead>  
                                        <tr>  
                                            <th>SUBIDO POR</th>
                                            <th>NOMBRE ARCHIVO</th>
                                            <th>VER</th> 
                                            <th>FIRMA NO REQUERIDA</th>
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
                                                        <button class="btn btn-warning active" wire:click="ConfirmarFirma({{ $post->ID_DestinoDocumento  }})">OMITIR FIRMA</button>
                                                    </td>
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
                                                            @elseif($post->Firmado==4)   
                                                            <td colspan="2">
                                                                @php 
                                                                    $FechaFirma = $post->FechaFirma;
                                                                    $MostrarFecha = date("d-m-Y", strtotime($FechaFirma));
                                                                @endphp
                                                                <strong>FIRMA NO REQUERIDA {{$MostrarFecha}}</strong>
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
                    <div class="text-muted">
                        <h1><center><strong>AGREGAR ARCHIVOS</strong></center></h1>
                        <hr>
                    </div> 
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table table class="table table-hover">
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
                                        @foreach($MostrarDocumentosSubidos as $post) 
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
                                                        <form method="POST" action="{{ route('FirmaSubidoRecibido') }}">
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
                                                                <button class="btn btn-danger active" wire:click="EliminarArchivo({{ $post->ID_DestinoDocumento  }})">ELIMINAR</button>
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
                        <div wire:loading wire:target="PDF"> 
                            <center> 
                                <h5><strong>Subiendo documentos, espere por favor...</strong></h5>
                            </center>
                        </div>
                        <center>
                        <div class="btn-group" style=" width:80%;">
                            <button class="btn btn-primary active" wire:click="Ingresar" id="boton">INGRESAR</button>
                        </div> 
                        </center>
                        <br>
                        <center>
                            <div wire:loading wire:target="Ingresar">
                                <div class="circle bounce2"><h1 style="color: #FFFFFF;"><strong>SGD</strong></h1></div>
                                <h5><strong>Verificando documentos, espere por favor...</strong></h5>                         
                            </div>  
                        </center> 
                    </div>
                </div>
            </div>
        </div>
    </div> 
            @if($Cambiar==0)
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>FIRMANTES</strong></center></h1>
                        <hr>
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
                                                {{ $post->Nombres }} {{ $post->Apellidos }}
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
                                                <div class="progress" style="height: 33px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        NO
                                                    </div>
                                                </div>
                                            </td>
                                        @else 
                                        @php
                                                $numeroDiaVV = date('d', strtotime($post->FechaR ));
                                                $mesVV = date('F', strtotime($post->FechaR ));

                                                if($mesVV=='January'){
                                                $mesVV= 'Enero';
                                                }
                                                elseif($mesVV=='February'){   
                                                $mesVV= 'Febrero';
                                                }
                                                elseif($mesVV=='March'){  
                                                $mesVV= 'Marzo';
                                                }
                                                elseif($mesVV=='April'){
                                                    $mesVV= 'Abril';
                                                }
                                                elseif($mesVV=='May'){
                                                    $mesVV= 'Mayo';
                                                }
                                                elseif($mesVV=='June'){
                                                    $mesVV= 'Junio';
                                                }
                                                elseif($mesVV=='July'){ 
                                                    $mesVV= 'Julio';
                                                }
                                                elseif($mesVV=='August'){  
                                                    $mesVV= 'Agosto';
                                                }
                                                elseif($mesVV=='September'){  
                                                    $mesVV= 'Septiembre';
                                                }
                                                elseif($mesVV=='October'){  
                                                    $mesVV= 'Octubre';
                                                }
                                                elseif($mesVV=='November'){  
                                                    $mesVV= 'Noviembre';
                                                }
                                                else{  
                                                    $mesVV= 'Diciembre';
                                                }
                                            @endphp
                                                <td>
                                                    {{$numeroDiaVV}} de {{$mesVV}}
                                                </td> 
                                        @endif
                                    </tr>
                                @endforeach 
                            <tbody> 
                        </table> 
                    </div>
                    <div class="card-footer text-muted"> 
                        <div class="btn-group" style=" width:100%;">
                            <button class="btn btn-warning active" wire:click="CambiarVB">MOSTRAR V°B°</button>
                        </div> 
                    </div>
                </div>
            @else 
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>V°B°</strong></center></h1>
                        <hr>
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
                    <div class="card-footer text-muted"> 
                        <div class="btn-group" style=" width:100%;">
                            <button class="btn btn-warning active" wire:click="CambiarFirmantes">MOSTRAR FIRMANTES</button>
                        </div> 
                    </div>
                </div> 
            @endif
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col">
                        @if (session()->has('message2'))
                            <div class="alert alert-danger">
                                {{ session('message2') }}
                            </div>
                        @endif
                        <div class="card bg-light mb-3">
                            <div class="text-muted">
                                <h1><center><strong>RECHAZAR</strong></center></h1>
                                <hr>
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
                               SGD
                            </div>
                        </div>	
                    </div>	
                </div>			
            </div>
     

@elseif($Detalles==5)
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
    @endif 
@endif 
</div>