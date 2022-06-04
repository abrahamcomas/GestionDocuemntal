<div> 
    <br>    
    <div  id="MostrarFor" style="display:none">
        <div class="col">
            <div class="card bg-light mb-3" >
                <div class="card-body">
                    <center> 
                        <img src="{{URL::asset('Imagenes/12.gif')}}" width="220" height="220"/>
                        <h5><strong>Firmando, espere por favor...</strong></h5>
                    </center>
                </div>
                <div class="card-footer text-muted">
                    GESTIÓN DOCUMENTAL
                </div>
            </div> 
        </div>  
    </div> 
    <div id="IngresoFirma" class="row">                                          
        @if($Pagina==0)
            <div class="container-fluid">  
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
                <div class="row">  
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col"> 
                            <div class="card bg-light mb-3"> 
                                <div class="text-muted" >
                                    <br> 
                                    <h1><center><strong>CREAR ACTA</strong></center></h1>
                                    <hr> 
                                </div> 
                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <h6>FUNCIONARIO*</h6>
                                        <input class="form-control" type="text" placeholder="Buscar funcionario..." wire:model="search" title="Buscar por titulo,Tipo documento, Observación"/>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
                                </div>
                                <div class="row">   
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-1"></div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-10">
                                        <div class="card-body table-responsive">
                                            @if($ListaFuncionarios->count())
                                                <table table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr> 
                                                            <th>RUT</th>
                                                            <th>FUNCIONARIO</th>
                                                            <th>SELECCIONAR</th> 
                                                        </tr> 
                                                    </thead>  
                                                    <tbody>  
                                                        @foreach($ListaFuncionarios as $post)
                                                        <tr>
                                                            <td>{{ $post->Rut }}</td>
                                                            <td>{{ $post->Nombres }} {{ $post->Apellidos }}</td>
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
                                        </div>
                                        <div class="text-muted" >
                                            <h1><center><strong>{{ $SelecNombres }} {{ $SelecApellidos }}</strong></center></h1>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <h6>TIPO*</h6>
                                        <div class="form-label-group">   
                                            <select name="Materia" wire:model="Materia" class="form-control">
                                                <option value="0" selected>--SELECCIONAR--</option>
                                                <option value="1" selected>ENTREGA</option>
                                                <option value="2" selected>Otro</option>
                                            </select> 
                                        </div>		
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
                                </div>
                            @if($Materia==1)
                                @include('TiposDocumentos/Prestamo')
                            @elseif($Materia==2)
                                <div class="card-body"> 
                                    <div class="container-fluid">
                                        <hr>
                                        <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <h6>TÍTULO*</h6>
                                            <input type="text" class="form-control" wire:model="SoloTitulo" value="{{ $SoloTitulo }}">
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
                            @endif
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
    </div>       
</div> 
  