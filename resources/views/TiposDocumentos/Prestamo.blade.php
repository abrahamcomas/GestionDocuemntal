                                    <br>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                            <h6>TÍTULO*</h6>
                                            <input type="text" class="form-control" wire:model="Titulo_T" value="{{ $Titulo_T }}">
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                            <h6>ACTA Nº*</h6>
                                            <input type="text" class="form-control" wire:model="Acta" value="{{ $Acta }}">
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                                <h6>Equipo 1</h6>
                                                    <input type="text" class="form-control" wire:model="Equipo1" value="{{ $Equipo1 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarEquipo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>
                                        @if($Equipo>2)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Equipo 2</h6>
                                                    <input type="text" class="form-control" wire:model="Equipo2" value="{{ $Equipo2 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarEquipo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarEquipo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Equipo>3)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Equipo 3</h6>
                                                    <input type="text" class="form-control" wire:model="Equipo3" value="{{ $Equipo3 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarEquipo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarEquipo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Equipo>4)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Equipo 4</h6>
                                                    <input type="text" class="form-control" wire:model="Equipo4" value="{{ $Equipo4 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarEquipo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarEquipo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Equipo>5)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Equipo 5</h6>
                                                    <input type="text" class="form-control" wire:model="Equipo5" value="{{ $Equipo5 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarEquipo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarEquipo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Equipo>6)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Equipo 6</h6>
                                                    <input type="text" class="form-control" wire:model="Equipo6" value="{{ $Equipo6 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarEquipo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarEquipo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Equipo>7)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Equipo 7</h6>
                                                    <input type="text" class="form-control" wire:model="Equipo7" value="{{ $Equipo7 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarEquipo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarEquipo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Equipo>8)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Equipo 8</h6>
                                                    <input type="text" class="form-control" wire:model="Equipo8" value="{{ $Equipo8 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarEquipo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarEquipo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                            </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                                <h6>Correo 1</h6>
                                                    <input type="email" class="form-control" wire:model="Correo1" value="{{ $Correo1 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarCorreo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>
                                        @if($Correo>2)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Correo 2</h6>
                                                    <input type="email" class="form-control" wire:model="Correo2" value="{{ $Correo2 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarCorreo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarCorreo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Correo>3)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Correo 3</h6>
                                                    <input type="email" class="form-control" wire:model="Correo3" value="{{ $Correo3 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarCorreo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarCorreo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Correo>4)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Correo 4</h6>
                                                    <input type="email" class="form-control" wire:model="Correo4" value="{{ $Correo4 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarCorreo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarCorreo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Correo>5)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Correo 5</h6>
                                                    <input type="email" class="form-control" wire:model="Correo5" value="{{ $Correo5 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarCorreo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarCorreo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Correo>6)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Correo 6</h6>
                                                    <input type="email" class="form-control" wire:model="Correo6" value="{{ $Correo6 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarCorreo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarCorreo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Correo>7)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Correo 7</h6>
                                                    <input type="email" class="form-control" wire:model="Correo7" value="{{ $Correo7 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarCorreo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarCorreo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        @if($Correo>8)
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                                                <h6>Correo 8</h6>
                                                    <input type="email" class="form-control" wire:model="Correo8" value="{{ $Correo8 }}">
                                                </div> 
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-danger active btn-info"  wire:click="RestarCorreo">-</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1">
                                                    <h6>.</h6>
                                                    <button class="btn btn-success active btn-info"  wire:click="AgregarCorreo">+</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>	
                                        @endif
                                        </div>
                                    </div>
                                    <br>
                                    <form method="POST" action="{{ route('ActaPrestamoController') }}">
                                        @csrf 
                                        <br>
                                        <input type="hidden" class="form-control" name="SelecID_Funcionario_T" value="{{ $SelecID_Funcionario_T }}">

                                        <input type="hidden" class="form-control" name="Materia" value="{{ $Materia }}">
                                        <input type="hidden" class="form-control" name="Titulo_T" value="{{ $Titulo_T }}">
                                        <input type="hidden" class="form-control" name="Acta" value="{{ $Acta }}">
                                    
                                        <input type="hidden" class="form-control" name="Equipo1" value="{{ $Equipo1 }}">
                                        <input type="hidden" class="form-control" name="Equipo2" value="{{ $Equipo2 }}">
                                        <input type="hidden" class="form-control" name="Equipo3" value="{{ $Equipo3 }}">
                                        <input type="hidden" class="form-control" name="Equipo4" value="{{ $Equipo4 }}">
                                        <input type="hidden" class="form-control" name="Equipo5" value="{{ $Equipo5 }}">
                                        <input type="hidden" class="form-control" name="Equipo6" value="{{ $Equipo6 }}">
                                        <input type="hidden" class="form-control" name="Equipo7" value="{{ $Equipo7 }}">
                                        <input type="hidden" class="form-control" name="Equipo8" value="{{ $Equipo8 }}">

                                        <input type="hidden" class="form-control" name="Correo1" value="{{ $Correo1 }}">
                                        <input type="hidden" class="form-control" name="Correo2" value="{{ $Correo2 }}">
                                        <input type="hidden" class="form-control" name="Correo3" value="{{ $Correo3 }}">
                                        <input type="hidden" class="form-control" name="Correo4" value="{{ $Correo4 }}">
                                        <input type="hidden" class="form-control" name="Correo5" value="{{ $Correo5 }}">
                                        <input type="hidden" class="form-control" name="Correo6" value="{{ $Correo6 }}">
                                        <input type="hidden" class="form-control" name="Correo7" value="{{ $Correo7 }}">
                                        <input type="hidden" class="form-control" name="Correo8" value="{{ $Correo8 }}">
                                        <center>
                                            <div class="btn-group" style=" width:80%;">
                                                <button type="submit" id="btnEnviar1" class="btn btn-success">CONTINUAR</button>
                                            </div>
                                        </center>
                                    </form> 
