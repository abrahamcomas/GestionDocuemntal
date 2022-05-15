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
                                <center><img src="{{URL::asset('Imagenes/Portafolio/Nuevo.JPG')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
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
        @if($Pagina==0) 
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col">
                        @if (session()->has('message'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                        @include('messages')  
                    </div>
                </div>  
            </div> 
            <div class="container-fluid">  
                <div class="row">  
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col"> 
                            <div class="card bg-light mb-3"> 
                                <div class="card-header">
                                    <h4><strong>CREAR ACTA DE ENTREGA</strong></h4>
                                </div>
                                <div class="card-body"> 
                                    <div class="container-fluid">  
                                        <div class="row">   
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                                <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" onmouseover="mostrar('Más información.');" onmouseout="ocultar()" width="25" height="25"/></button>
                                                <strong><div id="ver"></div></strong>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">
                                                <h6>CREAR ACTA DE ENTREGA A*</h6>
                                                <input class="form-control" type="text" placeholder="Buscar funcionario..." wire:model="search" title="Buscar por titulo,Tipo documento, Observación"/>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <strong>IMPORTANTE <br> El sistema ingresara de forma automática un código QR en cada archivo subido en la parte inferior derecha de dicho archivo.</strong>
                                            </div>
                                        </div>
                                        <div class="card-body table-responsive">
                                            @if($ListaFuncionarios->count())
                                                <table table class="table table-hover">
                                                    <thead>
                                                        <tr> 
                                                            <th>RUN</th>
                                                            <th>NOMBRE</th>
                                                            <th>APELLIDO</th>
                                                            <th>SELECCIONAR</th> 
                                                        </tr> 
                                                    </thead>  
                                                    <tbody>  
                                                        @foreach($ListaFuncionarios as $post)
                                                        <tr>
                                                            <td>{{ $post->Rut }}</td>
                                                            <td>{{ $post->Nombres }}</td>
                                                            <td>{{ $post->Apellidos }}</td>
                                                            <td>
                                                                <button class="btn btn-success active btn-info"  wire:click="SeleccionarFunc({{ $post->ID_Funcionario_T }})">SELECCIONAR</button>
                                                            </td>
                                                        </tr>
                                                        @endforeach   
                                                    </tbody>
                                                </table>
                                            @else 
                                                <center><strong>No hay resultados para la búsqueda "{{ $search }}"</strong></center>
                                            @endif
                                            <hr> 
                                        </div>
                                        <h2><strong>{{ $SelecNombres }} {{ $SelecApellidos }}</strong></h2>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                <h6>TÍTULO*</h6>
                                                <input type="text" class="form-control" wire:model="Titulo_T">
                                            </div> 
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                <h6>AGREGAR ARCHIVO/S* <strong>PDF</strong></h6>
                                                <input type="file" class="form-control" id="PDF" wire:model="PDF" accept="application/pdf">
                                                <div wire:loading wire:target="PDF"> 
                                                    <center> 
                                                        <h5><strong>Subiendo documentos, espere por favor...</strong></h5>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>  
                                        <br>
                                        <div class="btn-group" style=" width:100%;">
                                            <button class="btn btn-warning active" wire:click="Ingresar">INGRESAR</button>
                                        </div>
                                    </div> 
                                </div> 
                                <div class=" text-muted">
                                    <strong>(*)OBLIGATORIO</strong>
                                </div>
                                <div class="card-footer text-muted">
                                </div>
                                <div class="card-footer text-muted"> 
                                    GESTIÓN DOCUMENTAL <br>
                                </div>
                            </div>
                        </div>  
                    </div>		 
                </div> 
            </div>   
        @else 

            @if($Existe==1)
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
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                        @include('messages')  
                        <div class="col">     
                            <div class="card bg-light mb-3"> 
                                <div class="card-header"> 
                                    <h4><strong>CREAR IMAGEN DE FIRMA AUTOMÁTICA</strong></g4>
                                </div>
                                <div class="card-body">	 
                                    <div id="Imagen" class="specific" style="height:30vh;width:35vw;"> 
                                        <p><img class="izquierda" src="{{URL::asset('Imagenes/escudo.png')}}" width="260" height="260"/>
                                            <h2><strong>Firmado digitalmente por<br> {{$Nombres}} {{$Apellidos}} <br> {{$Rut}} <br>{{$Oficina}}  <br>{{$Cargo}}</strong></h2>
                                        </p>
                                    </div> 
                                    <form method="POST" action="{{ route('ImagenCreada5') }}"> 
                                        @csrf  
                                        <div style="display: none">   
                                            <input type="text" id="Firma" name="Firma">
                                            <input type="text" name="SelecID_Funcionario_T" value="{{$SelecID_Funcionario_T}}">
                                        </div> 
                                        @if($Creado==1)
                                            <div class="btn-group" style=" width:100%;">
                                                <button type="button" onclick="Capturar()" class="btn btn-warning" wire:click="Creada">
                                                    CREAR
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
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col">
                            <div class="card bg-light mb-3" > 
                                <div class="card-header"><h4><strong>ACTA DE ENTREGA INGRESADA.</strong></strong></h4></div>  
                                <br> 
                                    <form method="POST" action="{{ route('Envio11') }}"> 
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
                                    </div>
                                </div>
                            </div>	
                        </div>
                    </div>			
                </div>
            @endif  
        @endif   
    @endif          
</div> 
  