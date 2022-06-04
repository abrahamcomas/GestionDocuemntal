@extends('App')
@section('content')
@php
                        
    $mesFC = date('F', strtotime(date("F")));
    $Anio = date("Y");

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
@endphp
<div class="container-fluid">                                 
    @if(Auth::user()->Contrato==0)
        <div class="card bg-light mb-3">
            <div class="text-muted" >
                <br> 
                <center><strong><h1>POR FAVOR ACTUALIZAR TIPO DE CONTRATO</h1></strong></center> 
                <hr>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('Actualizar') }}"> 
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">    
                            <select name="Contrato" class="form-control" required>
                                <option value="" selected>--Seleccionar Contrato--</option>
                                <option value="1">Código</option>
                                <option value="2">Planta</option>
                                <option value="3">Contrata</option>
                                <option value="4">Honorario</option>
                            </select> 
                        </div>		 
                    </div>  
                    <div class="btn-group" style=" width:100%;">
                        <button type="submit" class="btn btn-primary">
                            INGRESAR
                        </button>
                    </div>  
                </form>
            </div> 
        </div> 
    @else
        <div class="card bg-light mb-3">
            <div class="text-muted" >
                <br>
                <h1><center><strong>ESTADÍSTICAS DE USO</strong></center></h1>
                <hr>
            </div> 
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <center><h5><strong>Funcionarios con mayor número de firmas durante "{{$mesFC}}"</strong></h5></center> 
                        <div class="row">
                            <div class="col">
                                <div id="container1"></div>
                                @if((Auth::user()->Root==1)  OR (Auth::user()->Root==2))
                                    <div id="ver">
                                        <div class="btn-group" style=" width:100%;">
                                            <button type="button" id="btnEnviar1" class="btn btn-success">DETALLES</button>
                                        </div> 
                                    </div> 
                                    <div id="Detalles" style="display:none">
                                        <div class="card-body table-responsive">
                                            <table table class="table table-striped"> 
                                                <thead> 
                                                    <tr>
                                                        <th>FUNCIONARIO</th> 
                                                        <th>N°</th>
                                                    </tr>
                                                </thead>  
                                                <tbody> 
                                                    @foreach($FuncionarioTodos as $post) 
                                                            <tr>
                                                                <td>
                                                                    {{$post->Nombres }}
                                                                </td>
                                                                <td>
                                                                    {{$post->NumeroFunc}}
                                                                </td>
                                                            </tr>
                                                    @endforeach   
                                                </tbody> 
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <center><h5><strong>Departamento o Dirección con mayores firmas durante "{{$mesFC}}"</strong></h5></center> 
                        <div class="row">
                            <div class="col">
                                <div id="container2"></div>
                                @if((Auth::user()->Root==1)  OR (Auth::user()->Root==2))
                                    <div id="ver2">
                                        <div class="btn-group" style=" width:100%;">
                                            <button type="button" id="btnEnviar2" class="btn btn-success">DETALLES</button>
                                        </div> 
                                    </div> 
                                    <div id="Detalles2" style="display:none">
                                        <div class="card-body table-responsive">
                                            <table table class="table table-striped"> 
                                                <thead> 
                                                    <tr>
                                                        <th>FUNCIONARIO</th> 
                                                        <th>N°</th>
                                                    </tr>
                                                </thead>  
                                                <tbody> 
                                                    @foreach($FirmadosDDTodos as $post) 
                                                            <tr>
                                                                <td>
                                                                    {{$post->Nombre }}
                                                                </td>
                                                                <td>
                                                                    {{$post->Numero_DD}}
                                                                </td>
                                                            </tr>
                                                    @endforeach   
                                                </tbody> 
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="container mt-5">
                            <center><h5><strong>Departamento o Dirección con mayores firmas durante el año "{{$Anio}}"</strong></h5></center> 
                            <div class="row">
                                <div class="col"> 
                                <div id="container3"></div>
                                    @if((Auth::user()->Root==1)  OR (Auth::user()->Root==2))
                                        <div id="ver3">
                                            <div class="btn-group" style=" width:100%;">
                                                <button type="button" id="btnEnviar3" class="btn btn-success">DETALLES</button>
                                            </div> 
                                        </div> 
                                        <div id="Detalles3" style="display:none">
                                            <div class="card-body table-responsive">
                                                <table table class="table table-striped"> 
                                                    <thead> 
                                                        <tr>
                                                            <th>FUNCIONARIO</th> 
                                                            <th>N°</th>
                                                        </tr>
                                                    </thead>  
                                                    <tbody> 
                                                        @foreach($AnioTodos as $post) 
                                                                <tr>
                                                                    <td>
                                                                        {{$post->Nombre }}
                                                                    </td>
                                                                    <td>
                                                                        {{$post->Numero_DD}}
                                                                    </td>
                                                                </tr>
                                                        @endforeach   
                                                    </tbody> 
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>  
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
@endif
@endsection   
@section('scripts') 
<script type="text/javascript">

        $(document).ready(function(){               
            $(document).on('click', '#btnEnviar1', function(){ 
                $("#Detalles").show();
                $("#ver").show();
            }); 
        }); 

        $(document).ready(function(){               
            $(document).on('click', '#btnEnviar2', function(){ 
                $("#Detalles2").show();
                $("#ver2").show();
            }); 
        }); 


        $(document).ready(function(){               
            $(document).on('click', '#btnEnviar3', function(){ 
                $("#Detalles3").show();
                $("#ver3").show();
            }); 
        }); 

























Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    })
});

Highcharts.chart('container1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie' 
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    }, 
    plotOptions: {
        pie: { 
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: '',
        colorByPoint: true,
        data: <?= $DataFunc  ?>
    }],
    
    credits: {
        enabled: false
    },
    <?php   if((Auth::user()->Root==1)  OR (Auth::user()->Root==2)) { ?>
       
                exporting: {
                enabled: true
                }

    <?php   }
            else {  ?>

                exporting: {
                enabled: false
                }

    <?php   }   ?>
    
});

Highcharts.chart('container2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie' 
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    }, 
    plotOptions: {
        pie: { 
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: '',
        colorByPoint: true,
        data: <?= $data  ?>
    }],
    
    credits: {
        enabled: false
    },

    <?php   if((Auth::user()->Root==1)  OR (Auth::user()->Root==2)) { ?>
       
       exporting: {
       enabled: true
       }

    <?php   }
            else {  ?>

       exporting: {
       enabled: false
       }

    <?php   }   ?>
});

Highcharts.chart('container3', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie' 
    },
    title: {
        text:  '' 
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    }, 
    plotOptions: {
        pie: { 
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: '',
        colorByPoint: true,
        data: <?= $DatatAnio  ?>
    }],
    
    credits: {
        enabled: false
    },

    <?php   if((Auth::user()->Root==1)  OR (Auth::user()->Root==2)) { ?>
       
       exporting: {
       enabled: true
       }

    <?php   }
            else {  ?>

       exporting: {
       enabled: false
       }

    <?php   }   ?>
});
</script>   
@endsection