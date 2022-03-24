<div>
<br>  
    <div class="container-fluid">   
        <div class="row" id="IngresoFirma"> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                @include('messages')  
                <div class="col"> 
                    <div class="card bg-light mb-3"> 
                        <div class="card-header"> <h5><strong>GENERADOR DE PLANTILLAS</strong></h5></div>
                            <div class="card-body">
                                @if($Subido==0)    
                                <div class="form-group"> 
                                    <h6>Subir PDF* <strong>(Solo archivos en formato PDF  son permitidos)</strong></h6> 
                                    <div class="form-label-group">  
                                        <input type="file" class="form-control" wire:model="PDF" accept="application/pdf"/>
                                    </div> 
                                </div>    
                                <br>  
                            </div> 
                            <div class="card-footer text-muted">
                                    <div class="btn-group" style=" width:100%;">
                                        <button class="btn btn-warning active" wire:click="SubirArchivo">SUBIR</button>
                                    </div> 
                                @else 
                                    <br>   
                                    <form method="POST" action="{{ route('IngresoPlantilla') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                        @csrf    
                                        <input type="hidden" name="Ruta" value= "{{ $Ruta }}">   
                                        <div class="btn-group" style=" width:100%;">
                                            <button type="submit" id="btnEnviar1" class="btn btn-success active">CONTINUAR</button>
                                        </div>
                                    </form> 
                                @endif
                            </div> 
                            <div wire:loading wire:target="SubirArchivo">
                                <center> 
                                    <h6><strong>Ingresando PDF, espere por favor...</strong></h6>
                                </center>
                            </div>
                            <div class="card-footer text-muted">
                                GESTIÓN DOCUMENTAL
                            </div>   
                        </div>     
                    </div>
                </div> 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
        </div>
</div>
