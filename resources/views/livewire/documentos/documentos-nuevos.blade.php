<div> 
  	<br>
    @if($Pagina==0)
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                @include('messages')  
                <div class="col">   
                    <div class="card bg-light mb-3">
                        <div class="card-header"> <h5><strong>Nuevo Documento</strong></h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <h6>Título*</h6>
                                    <div class="form-label-group"> 
                                        <input type="text" class="form-control" wire:model="Titulo_T">
                                    </div>		 
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <h6>Tipo*</h6>
                                    <div class="form-label-group"> 
                                        <select wire:model="Tipo_T" class="form-control" >
                                            <option value="0" selected>---SELECCIONAR---</option>
                                            @foreach($TipoDocumento as $post)
                                                <option value="{{ $post->ID_TipoDocumento_T  }}">{{ $post->Nombre_T }}</option>
                                            @endforeach
                                        </select>
                                    </div> 	
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <h6>Fecha Urgencia*</h6>
                                    <div class="form-label-group"> 
                                        <input type="date" class="form-control" wire:model="Fecha_T">
                                    </div>		
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h6>Observación</h6>
                                    <div class="form-label-group"> 
                                    <textarea class=" form-control" wire:model="Materia_T"></textarea>
                                    </div>		
                                </div>
                            </div> 
                            <br>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <h6>Elegir archivo*</h6>
                                        <div class="form-label-group"> 
                                            <input type="file" class="form-control" wire:model="PDF">
                                        </div> 
                                    </div>
                                    <div class="card-footer text-muted">
                                        <div class="btn-group" style=" width:100%;">
                                            <button class="btn btn-primary active" wire:click="Ingresar">INGRESAR</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>	
                            </div> 
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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <div class="col">
                    <div class="card bg-light mb-3" > 
                    <div class="card-header"><h5><strong>Ingresar Documento</strong></h5></div>  
                        <div class="card-body">
                            <div class="form-group">
                               <h6>Documento ingresado correctamente</h6>
                            </div>
                        </div>
                            <form method="POST" action="{{ route('Distribuccion') }}">
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
                            GESTIÓN DOCUMENTAL
                        </div>
                    </div>
                </div>	
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>				
        </div>
    @endif
</div> 
  