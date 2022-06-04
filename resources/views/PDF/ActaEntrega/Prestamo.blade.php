<?php
 

    $SelecID_Funcionario_T;
    
    $Materia;
    $Titulo_T;
    $Acta;
    $Equipo1;

    $NombreEmisor;
    $ApellidosEmisor;

    $Datos =  DB::table('Funcionarios') 
    ->leftjoin('LugarDeTrabajo', 'Funcionarios.ID_Funcionario_T', '=', 'LugarDeTrabajo.ID_Funcionario_LDT')
    ->leftjoin('DepDirecciones', 'LugarDeTrabajo.ID_DepDirecciones_LDT', '=', 'DepDirecciones.ID_DepDir')
    ->select('Nombres','Apellidos','Nombre_DepDir')
    ->where('ID_Funcionario_T', '=',$SelecID_Funcionario_T)->first();


    $token='ggg';
    $ID_DestinoDocumento='ggg';
    $codificado='ggjhhhjhjhjg';

    $contenido='sgd.municipalidadcurico.cl/MostrarDocumentoQR/'.$ID_DestinoDocumento.'/'.$token.'';

    $NuevaRuta = substr($codificado, 0, -4);
    $NuevaRuta2 = $NuevaRuta.'.png';

    $qrimage= public_path('../public/QR/'.$NuevaRuta.'.png');
    \QRCode::url($contenido)->setOutfile($qrimage)->png();

    $NuevaRuta2="../public/QR/".$NuevaRuta2;

?>
<head>
  <meta charset="UTF-8">
  <title>Documento PDF</title>
  <style>
       h4{
    text-align: center;
    text-transform: uppercase;
    }
    #ContenidoIzqHead { 
      margin-top: -10px;
      margin-left: 00px;

    }

    #ContenidoDercHead { 
      margin-top: 0px;
        margin-right: 00px;
    
    }
    
    #ContenidoIzqHead2 {  
      margin-left: 00px;
      width: 460px;
    }

    #FechaPrincipalHead { 
        width: 120px; 
        font-size: 13px;
        margin-left: 160px;
    }
    #ContenidoDercHead2 { 
      margin-right: 20px;
      width: 100px;
   
    }
    
  
    #ContenidoDercHeadAbajo { 
        margin-left: 500px;
        margin-right: 0px;
        margin-top: 0px;
    }
    #ContenidoDercHeadAbajo2 { 
        margin-left: 400px;
        margin-right: 0px;
        margin-top: 0px;
    }
    #TablaIzq { 
      width: 400px; 
      font-size: 11px;
      margin-right: 0px;
      margin-top: 0px;
    }
    #TablaDer { 
      width: 300px; 
      font-size: 11px;
      margin-left: 0px;
      margin-top: 0px;
    }
    #TablaIzqF { 
      width: 350px; 
      font-size: 11px;
      margin-right: 0px;
      margin-top: 0px;
    }
    #TablaDerF { 
      width: 350px; 
      font-size: 11px;
      margin-left: 0px;
      margin-top: 0px;
    }
  </style>
</head>
    <table width="100%" border="0">
        <tr>
  	        <td>
  	            <div id="ContenidoIzqHead">
                    <center>
                        <img src="../public/Imagenes/escudo.png" width="90" height="90"/><br>
                        <p style="font-size: 7pt"> MUNICIPALIDAD DE CURICÓ<br>
                        {{$Datos->Nombre_DepDir }}</p>
                    </center>  
      	        </div>
    	    </td>
            <td>
                <div id="FechaPrincipalHead"></div>
            </td>
            <td>
                <div id="ContenidoDercHead">
                    <center>
                        <img src="../public/Imagenes/logo2.png" width="220" height="70"/>
                    </center> 
                    <br>
                    <center><p style="font-size: 13pt">CURICÓ, 17/05/2022<br>
                        <strong>ACTA Nº {{$Acta}}</strong><br>
                        <strong>MAT.: {{ $Materia}}</strong></p>
                    </center>  
                </div>
            </td>
        </tr>
    </table>
    <table>    
        <tbody>
            <tr> 
                <td style="font-size: 13pt">
                    DE : <strong> {{ $NombreEmisor }} {{ $ApellidosEmisor }}</strong>
                </td>
            </tr>
            <tr>
                <td style="font-size: 13pt">
                    A : <strong> {{$Datos->Nombres }}{{$Datos->Apellidos }}</strong>
                </td>
            </tr>
            <tr>
                <td style="font-size: 12pt">
                <br>
                    Junto con saludar, se hace entrega a Usted de o los siguientes equipos, para ser utilizado en
                    las funciones propias de su labor.<br><br>
                    Cabe señalar que el equipo es de propiedad de la I. Municipalidad de Curicó y el usuario será
                    responsable de su uso y deberá efectuar el pago correspondiente de este cuando ocurra una de las
                    siguientes situaciones:<br><br>
                    Pérdida, robo, hurto o falla del equipo producto de la incorrecta manipulación del usuario.
                    También es importante informar que el equipo debe ser devuelto una vez finalizado su periodo
                    de trabajo o cuando las decisiones del servicio así lo requieran.<br><br>
                    El equipamiento es el siguiente:<br>
                </td>
            </tr>
            <tr> 
                <td style="font-size: 13pt">
                °:  @if(!empty($Equipo1))<strong>{{$Equipo1}}</strong>@endif 
                    @if(!empty($Equipo2))<strong>, {{$Equipo2}} </strong>@endif
                    @if(!empty($Equipo3))<strong>, {{$Equipo3}} </strong>@endif
                    @if(!empty($Equipo4))<strong>, {{$Equipo4}} </strong>@endif
                    @if(!empty($Equipo5))<strong>, {{$Equipo5}} </strong>@endif
                    @if(!empty($Equipo6))<strong>, {{$Equipo6}} </strong>@endif
                    @if(!empty($Equipo7))<strong>, {{$Equipo7}} </strong>@endif
                    @if(!empty($Equipo8))<strong>, {{$Equipo8}} </strong>@endif
                </td>
            </tr>
            <tr>
                <td style="font-size: 12pt"><br>
                    Declaro recibir conforme y a mi entera satisfacción el equipamiento antes individualizados,
                    comprometiéndome a dar fiel cumplimento a las instrucciones antes señalada y firmando para
                    constancia.
                </td>
            </tr>
        </tbody>
    </table> 
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <table width="100%" border="0">
  	    <td>
            <div id="ContenidoIzqHead2"> 
            <p style="font-size: 12pt"> 
            <strong>Distribución :   
                    @if(!empty($Correo1))<strong>{{$Correo1}}</strong>@endif 
                    @if(!empty($Correo2))<strong>, {{$Correo2}} </strong>@endif
                    @if(!empty($Correo3))<strong>, {{$Correo3}} </strong>@endif
                    @if(!empty($Correo4))<strong>, {{$Correo4}} </strong>@endif
                    @if(!empty($Correo5))<strong>, {{$Correo5}} </strong>@endif
                    @if(!empty($Correo6))<strong>, {{$Correo6}} </strong>@endif
                    @if(!empty($Correo7))<strong>, {{$Correo7}} </strong>@endif
                    @if(!empty($Correo8))<strong>, {{$Correo8}} </strong>@endif

            <p>
            <p style="font-size: 10pt"> 
                °La indicada<br>
                °Archivo Informática<br>
                °Dep. Inventario</p>
            </div> 
    	</td>
        <td>
            <div id="FechaPrincipalHead"></div>
    	</td>
    	<td>
    	  <div id="ContenidoDercHead2">
            <img src='{{ $NuevaRuta2 }}' width="100" height="100" align="left">
    	  </div>
        </td>
    </table>
    <br>
    <center><p style="font-size: 9pt"> <strong>Firmado electrónicamente de acuerdo con la ley N° 19.799</strong></p></center>
 

  

   

    
      

  



