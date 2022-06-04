<div> 
@if($MostrarPagina==1)   
    <br>                                                             
        @if($Pagina==0) 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div> 
            </div> 
        </div> 
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col">   
                        @include('messages')  
                        <div class="card bg-light mb-3">
                            <div class="text-muted" >
                                <br>  
                                <h1><center><strong>CAMBIAR DE LUGAR DE TRABAJO A FUNCIONARIOS</strong></center></h1>
                                <hr> 
                            </div>
                            <div class="card-body"> 
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <h6>SELECCIONAR FUNCIONARIO*</h6>
                                        <div class="form-label-group"> 
                                            <select wire:model="DestinoFuncionario" class="form-control" >
                                                <option value="0" selected>---SELECCIONAR---</option>
                                                @foreach($ListaFuncionariosOP as $post)
                                                    <option value="{{ $post->ID_Funcionario_T   }}">{{ $post->Nombres }} {{ $post->Apellidos }}</option>
                                                @endforeach
                                            </select> 
                                        </div> 	
                                    </div> 	
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div> 
                                </div> 
                                <hr>
                                <div class="form-group"> 
                            <h6>Buscar departamento o dirección*</h6>
                            <input class="form-control" type="text" placeholder="{{$NombreOficinaParte}}" wire:model="BuscarOficinaPartes"/>
                            @if($BuscarOficinaPartes!="")
                                <table table class="table table-hover">
                                    <tbody> 
                                        @foreach($OficinaPartes as $post)
                                            <tr>
                                                <td style="color: #000000;">
                                                    {{$post->Nombre_DepDir}} 
                                                </td>
                                                <td>
                                                    <button class="btn btn-success" wire:click="OficinaPartesSeleccionada({{ $post->ID_DepDir }})">SELECCIONAR</button>
                                                </td>
                                            </tr>
                                        @endforeach  
                                    </tbody> 
                                </table>     
                            @endif	
                            <br>
                            <center>
                            <div class="btn-group" style=" width:80%;">
                                <button class="btn btn-primary" wire:click="Ingresar">CAMBIAR</button>
                            </div>
                            </center>
                        </div>  
                            </div> 
                            <div class=" text-muted">
                                <strong>(*)OBLIGATORIO</strong>
                            </div>
                            <div class="card-footer text-muted"> 
                                SGD
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
                                <form method="POST" action="{{ route('EnvioOficinaPartesODP') }}">
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
                                   SGD
                                </div>
                            </div>
                        </div>	 
                    </div>
                </div>			
            </div>
        @endif        
@else
<div class="container-fluid">  
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <div class="text-muted" >
                            <br> 
                            <h1><center><strong>CAMBIAR DE LUGAR DE TRABAJO A FUNCIONARIOS</strong></center></h1>
                            <hr>
                        </div>
                        <div class="row">  
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                <div class="text-muted" >
                                    <h4><center><strong>Opción no disponible para el funcionario/a actual.</strong></center></h4>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                        </div>      	
                        <div class="card-footer text-muted"> 
                            SGD
                        </div>
                    </div> 
                </div>
            </div> 
        </div>
    </div>  
@endif     
</div> 