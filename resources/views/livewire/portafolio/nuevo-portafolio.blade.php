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
                            <center><img src="{{URL::asset('Imagenes/Portafolio/Nuevo.png')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
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
                        <div class="card-header"> 
                            <h4><strong>IMAGEN DE FIRMA AUTOMÁTICA</strong></g4>
                        </div>
                        <div class="card-body">	 
                            <div id="Imagen" class="specific" style="height:30vh;width:35vw;"> 
                                <p><img class="izquierda" src="{{URL::asset('Imagenes/escudo.png')}}" width="260" height="260"/>
                                    <h2><strong>Firmado digitalmente por<br> {{$Nombres}} {{$Apellidos}} <br> {{$Rut}} <br>{{$Oficina}}  <br>{{$Cargo}}</strong></h2>
                                </p>
                            </div>
                            <form method="POST" action="{{ route('ImagenCreada2') }}"> 
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
                            GESTIÓN DOCUMENTAL <br>
                            SECRETARIA/O OFICINA DE PARTES {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                        </div>
                    </div>
                </div> 
            </div>  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>		 
        </div>     
    @else                                     
        @if($Pagina==0) 
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col">   
                        @include('messages')  
                        <div class="card bg-light mb-3"> 
                            <div class="text-muted" >
                                <br> 
                                <h1><center><strong>NUEVA SOLICITUD</strong></center></h1>
                                <hr>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                        <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" onmouseover="mostrar('Más información.');" onmouseout="ocultar()" width="25" height="25"/></button>
                                        <strong><div id="ver"></div></strong>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <strong>IMPORTANTE <br> El sistema ingresara de forma automática un código QR en cada archivo subido en la parte inferior derecha de dicho archivo.</strong>
                                    </div>      
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <h6>PLANTILLAS (OPCIONAL)</h6>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                                <div class="form-label-group">  
                                                    <select wire:model="ID_Plantilla" class="form-control" >
                                                        <option value="0" selected>---SELECCIONAR---</option>
                                                        @foreach($plantillas as $post)
                                                            <option value="{{ $post->id_plantillas}}">
                                                                {{ $post->nombre_plantilla }}
                                                            </option>
                                                        @endforeach 
                                                    </select>  
                                                </div> 	 
                                            </div>
                                        @if($ID_Plantilla!=0)
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                                <form method="POST" action="{{ route('DescargarPlantillas') }}" enctype="multipart/form-data">
                                                    @csrf  
                                                    <input type="hidden" name="id_plantillas" value="{{ $ID_Plantilla  }}">
                                                    <button type="submit" class="btn btn-info active" style="background: #31A877;">DESCARGAR</button>
                                                </form> 
                                            </div>  
                                        @endif    
                                        </div>
                                    </div>   
                                </div> 
                                <hr>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <h6>TÍTULO*</h6>
                                        <div class="form-label-group"> 
                                            <input type="text" class="form-control" wire:model="Titulo_T">
                                        </div>		 
                                    </div> 
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <h6>TIPO*</h6>
                                        <div class="form-label-group">  
                                            <select wire:model="Tipo_T" class="form-control" >
                                                <option value="0" selected>---SELECCIONAR---</option>
                                                @foreach($TipoDocumento as $post)
                                                    <option value="{{ $post->ID_TipoDocumento_T  }}">{{ $post->Nombre_T }}</option>
                                                @endforeach
                                            </select> 
                                        </div> 	 
                                    </div> 
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <h6>NÚMERO FOLIO (OPCIONAL)</h6>
                                        <div class="form-label-group"> 
                                            <div class="form-label-group"> 
                                                <input type="text" class="form-control" wire:model="Folio">
                                            </div>		
                                        </div> 	 
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <h6>DÍAS PARA FINALIZAR*</h6>
                                        <div class="form-label-group"> 
                                            <input type="number" class="form-control" wire:model="Fecha_T">
                                        </div>		
                                    </div>
                                </div> 
                                <br> 
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <h6>OBSERVACIÓN A {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }}  (OPCIONAL)</h6>
                                        <div class="form-label-group"> 
                                        <textarea class=" form-control" wire:model="Materia_T"></textarea>
                                        </div>		
                                    </div>
                                </div>
                                <br> 
                                @if(Auth::user()->Jefe==1)
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                   <h6><strong>PORTAFOLIO PRIVADO</strong></h6>
                                    <h8>Cuando un portafolio es privado las ODP emisora y receptora no podrá visualizar los archivos PDF.</h8>
                                        <div class="form-label-group">  
                                            <select wire:model="Privado" class="form-control">
                                                <option value="0" selected>NO</option>
                                                <option value="1">SI, ES PRIVADO</option>
                                            </select> 
                                        </div>		
                                    </div>	
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"></div>	
                                </div>	 
                                @endif 
                                @if(Auth::user()->Acta==1)
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                   <h6><strong>NO INGRESAR CODIGO QR</strong></h6>
                                    <h8>Los archivos subidos contienen firmas electrónicas, y se deben mantener.</h8>
                                        <div class="form-label-group">   
                                            <select wire:model="Acta" class="form-control">
                                                <option value="0" selected>INGRESAR QR</option>
                                                <option value="1">SI, MANTENER FIRMAS</option>
                                            </select> 
                                        </div>		
                                    </div>	
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"></div>	
                                </div>	 
                                @endif
                                <br> 
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <!--<strong>Si su archivo es Word debe convertirlo a PDF, debido a que el sistema acepta solo archivos en dicho formato.</strong>-->
                                            <!--<div class="text-muted">
                                                <strong>Importante, los archivos subidos a gestión documental no deben tener firmas digitales avanzadas, debido a que el sistema anulara estas firmas.</strong>
                                            </div>-->
                                            <hr>
                                            <h6>AGREGAR ARCHIVO/S* <strong>PDF</strong></h6>
                                            <div class="form-label-group"> 
                                                <input type="file" class="form-control" id="PDF" wire:model="PDF" multiple accept="application/pdf">
                                                <h6><strong>(MÁXIMO 10 PDF)</strong></h6>
                                            </div> 
                                            <div wire:loading wire:target="PDF">
                                                <center> 
                                                    <h5><strong>Subiendo documentos, espere por favor...</strong></h5>
                                                </center>
                                            </div> 
                                        </div>
                                        <div class="btn-group" style=" width:100%;">
                                            <button class="btn btn-primary" wire:click="Ingresar">CONTINUAR</button>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>	
                                </div>  
                            </div> 
                            <div class=" text-muted">
                                <strong>(*)OBLIGATORIO</strong>
                            </div>
                            <div class="card-footer text-muted">
                            </div>
                            <div class="card-footer text-muted"> 
                                GESTIÓN DOCUMENTAL <br>
                                SECRETARIA/O OFICINA DE PARTES {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                            </div>
                        </div>
                    </div> 
                </div>		
            </div> 
            @else
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col">
                        <div class="card bg-light mb-3">
                                <div class="text-muted">
                                    <br> 
                                    <h1><center><strong>NÚMERO DE IDENTIFICACIÓN INTERNA<strong> {{ $NumeroIngresado }} </strong></center></h1>
                                    <hr>
                                </div> 
                                <div class="card-body">
                                    <div class="form-group">
                                        <h5>NUEVA SOLICITUD INGRESADA.</h5>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('EnvioOficinaPartes') }}">
                                    @csrf 
                                    <center>
                                    <div class="btn-group" style=" width:50%;">
                                        <button type="submit" class="btn btn-primary active">
                                            CONTINUAR
                                        </button> 
                                    </div></center> 
                                </form>  
                                <br> 
                                <div class="card-footer text-muted">
                                </div>
                                <div class="card-footer text-muted">
                                    GESTIÓN DOCUMENTAL <br>
                                    SECRETARIA/O OFICINA DE PARTES {{  $DatosOficinaPartes->Nombres }}  {{  $DatosOficinaPartes->Apellidos }} 
                                </div>
                            </div>
                        </div>	
                    </div>
                </div>			
            </div>
        @endif
    @endif               
</div> 
@endif  