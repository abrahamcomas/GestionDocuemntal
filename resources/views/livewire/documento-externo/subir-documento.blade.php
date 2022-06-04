<div>
    <?php
        $tablet_browser = 0;
        $mobile_browser = 0;
        $body_class = 'desktop';
        
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
            $body_class = "tablet";
        }
        
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
            $body_class = "mobile";
        }
        
        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
            $body_class = "mobile";
        }
        
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');
        
        if (in_array($mobile_ua,$mobile_agents)) {
            $mobile_browser++;
        }
        
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
            $tablet_browser++;
            }
        }
    ?> 
    <br>
    @if(($tablet_browser > 0) OR ($mobile_browser > 0))
        <div class="col">
            <div class="card bg-light mb-3" >
                <div class="card-header"> <h4><strong>NO DISPONIBLE</strong></h4></div>
                <div class="card-body">
                    <center>
                        <h5 style="color: #FF0C00;"><strong> 
                            Modulo no soportado desde navegador móvil, solo disponible para navegadores de escritorio.
                        </strong></h5>
                    </center>
                </div>
                <div class="card-footer text-muted">
                    SGD
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
                            <div class="card-header"> 
                                <h4><strong>IMAGEN DE FIRMA AUTOMÁTICA</strong></h4>
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
                                SGD
                            </div>
                        </div>
                    </div> 
                </div> 
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>		 
            </div>   
        @else     
        <div class="container-fluid">   
            <div class="row" id="IngresoFirma"> 
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                    @include('messages')  
                    <div class="col"> 
                        <div class="card bg-light mb-3">
                                <div class="text-muted" >
                                    <br> 
                                    <h1><center><strong>FIRMAR ARCHIVO EXTERNO</strong></center></h1>
                                    <hr>
                                </div>
                                <div class="card-body"> 
                                    <h5><strong>Importante</strong></h5>
                                    <div class="text-muted"> 
                                        <h5>El archivo firmado en este módulo no se almacena en el Sistema Gestión Documental.</h5>
                                    </div>     
                                    @if($Subido==0)    
                                    <div class="form-group"> 
                                        <h6>Subir PDF* <strong>(Solo archivos en formato PDF  son permitidos.)</strong></h6> 
                                        <div class="form-label-group">  
                                            <input type="file" class="form-control" id="PDF" wire:model="PDF" multiple accept="application/pdf"/>
                                            <h6><strong>(MÁXIMO 10 PDF)</strong></h6>
                                        </div> 
                                    </div>  
                                @if($Numero>1)
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <h6>TIPO DE IMAGEN DE FIRMA*</h6>
                                            <div class="form-label-group">  
                                                <select wire:model="RutaImagenFirma" class="form-control" >
                                                    <option value="0" selected>---SELECCIONAR---</option>
                                                    @foreach($ImagenFirma as $post)
                                                        <option value="{{ $post->Ruta }}">{{ $post->NombreImagen }}</option>
                                                    @endforeach
                                                </select> 
                                            </div> 	 
                                        </div> 
                                    </div> 
                                @endif
                                <br>   
                                </div> 
                                <div class="card-footer text-muted">
                                        <div class="btn-group" style=" width:100%;">
                                            <button class="btn btn-warning active" wire:click="SubirArchivo">SUBIR</button>
                                        </div>
                                    @else 
                                        <br>
                                        <form method="POST" action="{{ route('FirmarExterno') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                            @csrf    
                                            <input type="hidden" name="Ruta" value= "{{ $Ruta }}"> 
                                            <input type="hidden" name="RutaImagenFirma" value= "{{ $RutaImagenFirma }}">
                                            <div class="btn-group" style=" width:100%;">
                                                <button type="submit" id="btnEnviar1" class="btn btn-success active">CONTINUAR</button>
                                            </div>
                                        </form> 
                                    @endif 
                                </div> 
                                <div wire:loading wire:target="PDF">
                                    <center> 
                                        <h4><strong>Subiendo PDF, espere por favor...</strong></h4>
                                    </center>
                                </div>
                                <div wire:loading wire:target="SubirArchivo">
                                    <center> 
                                        <h4><strong>Ingresando PDF, espere por favor...</strong></h4>
                                    </center>
                                </div>
                                <div class="card-footer text-muted">
                                    SGD
                                </div>   
                            </div>     
                        </div>
                    </div> 
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
            </div>
        @endif 
    @endif 
</div>
 