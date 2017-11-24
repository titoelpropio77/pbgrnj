@extends ('layouts.admin')
@section ('content')
@include('alerts.cargando')
<div id='loading' style="display: none" ><img src='{{asset('images/loading.gif')}}' style='margin:0 auto; position: absolute; top: 50%; left: 50%; margin: -30px 0 0 -30px;'></div>
@include('galpon.modal_alimento')
@include('galpon.modal_alimento')

@include('galpon.modals.modal')
<?php
$cont = 0;
$x = 1;
$x2 = 9;
$cantidad = 0;
$alimento = "";
$id = 0;
$cantidad_granel = 0;
$contador_consumo = 0; //cuenta el array consumo para desactivar el boton control alimento
$total_consumo = count($consumo);
$contador_consumo2 = 0; //cuenta el array consumo para desactivar el boton control alimento
$total_consumo2 = count($consumo2);
$contador_v = 0;
$contador_v2 = 0;
$auxdias = 0;
$dias = 0;
$detalle_vacuna = [];
$detalle_vacuna2 = [];
$id_alimento=0;
$id_control=0;
$control_1 = array();
$con_control = 0;
$cantidad = 0;
?>

<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
<div class="alert alert-danger alert-dismissible" role="alert" hidden="true" id="mensaje" onLoad="">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<div class="table-responsive" style="height: 100%; width:100%">
    <!--esta tabla muestra la cantidad de cada silo y su silo-->
    <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            @foreach($silo as $sil)
            <?php if ($sil->cantidad_minima > $sil->cantidad): ?>
            <th style="background: #d73925; color: white; font-size: 12pt">  
            <center><samp style="  color: rgb(39, 12, 42);
  font-weight: bold;
  font-size: 14pt;">{{$sil->tipo}}</samp>:<span>{{$sil->nombre}}</span> → {{$sil->cantidad}} Kg</center>
            </th>
        <?php else: ?>
            <th style="background: #008d4c; color: white; font-size: 12pt">
            <center><samp style="  color: rgb(39, 12, 42);
  font-weight: bold;
  font-size: 14pt;">{{$sil->tipo}}</samp>:<span>{{$sil->nombre}} → {{$sil->cantidad}} kg</center></th>
        <?php endif ?>

        @endforeach
        </thead>
    </table>

     <!--esta tabla muestra la cantidad de cada silo y su silo-->
    <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
        @foreach($galpon as $gal)
            <?php   
            $verificar2 = DB::select("select grupo_control_alimento.id as id_control,alimento.id as id_alimento,
             (grupo_edad_temp.cantidad *".$gal->cantidad_actual.") as cantidad,alimento.tipo from alimento, edad,grupo_control_alimento,control_alimento_galpon,grupo_edad,grupo_temperatura,grupo_edad_temp where edad.id=control_alimento_galpon.id_edad and control_alimento_galpon.id_control_alimento=grupo_control_alimento.id and grupo_control_alimento.id=grupo_edad_temp.id_control and grupo_edad_temp.id_edad=grupo_edad.id and grupo_edad_temp.id_temp=grupo_temperatura.id and edad.id=".$gal->id_edad." and alimento.id=grupo_edad.id_alimento and grupo_edad.edad_min<=".$gal->edad." and grupo_edad.edad_max>=".$gal->edad." and grupo_temperatura.temp_min<=".$temperatura[0]->temperatura." and grupo_temperatura.temp_max>=".$temperatura[0]->temperatura);

            if (count($verificar2)!=0) {
                $control_1[$con_control]= $verificar2;

                $con_control++;
            }
 ?>

        @endforeach
         @foreach($galpon2 as $gal)
            <?php   
            $verificar3 = DB::select("select grupo_control_alimento.id as id_control,alimento.id as id_alimento,
             (grupo_edad_temp.cantidad *".$gal->cantidad_actual.") as cantidad,alimento.tipo from alimento, edad,grupo_control_alimento,control_alimento_galpon,grupo_edad,grupo_temperatura,grupo_edad_temp where edad.id=control_alimento_galpon.id_edad and control_alimento_galpon.id_control_alimento=grupo_control_alimento.id and grupo_control_alimento.id=grupo_edad_temp.id_control and grupo_edad_temp.id_edad=grupo_edad.id and grupo_edad_temp.id_temp=grupo_temperatura.id and edad.id=".$gal->id_edad." and alimento.id=grupo_edad.id_alimento and grupo_edad.edad_min<=".$gal->edad." and grupo_edad.edad_max>=".$gal->edad." and grupo_temperatura.temp_min<=".$temperatura[0]->temperatura." and grupo_temperatura.temp_max>=".$temperatura[0]->temperatura);

            if (count($verificar3)!=0) {
                $control_1[$con_control]= $verificar3;

                $con_control++;
            }
 ?>

        @endforeach
        @foreach($cria_recria as $gal)
         <?php 

 $verificar = DB::select("select grupo_control_alimento.id as id_control,alimento.id as id_alimento, (grupo_edad_temp.cantidad *".$gal->cantidad_actual.") as cantidad,alimento.tipo from alimento, edad,grupo_control_alimento,control_alimento_galpon,grupo_edad,grupo_temperatura,grupo_edad_temp where edad.id=control_alimento_galpon.id_edad and control_alimento_galpon.id_control_alimento=grupo_control_alimento.id and grupo_control_alimento.id=grupo_edad_temp.id_control and grupo_edad_temp.id_edad=grupo_edad.id and grupo_edad_temp.id_temp=grupo_temperatura.id and edad.id=".$gal->id_edad." and alimento.id=grupo_edad.id_alimento and grupo_edad.edad_min<=".$gal->edad." and grupo_edad.edad_max>=".$gal->edad." and grupo_temperatura.temp_min<=".$temperatura[0]->temperatura." and grupo_temperatura.temp_max>=".$temperatura[0]->temperatura);
                 if (count($verificar) != 0) {
                    $control_1[$con_control] = $verificar;
                $con_control++;
                 }

        ?>
        @endforeach
        @foreach($silo as $sil)
            <?php
            $cantidad = 0;
            $resta = 0;
            for ($i = 0; $i < count($control_1); $i++) {
                if ($sil->tipo == $control_1[$i][0]->tipo) {
                    $cantidad = $cantidad + $control_1[$i][0]->cantidad;
                    $resta = $sil->cantidad;
                }
            }
if ($cantidad >= $sil->cantidad) {
                echo ' <th style="background: #FDC30D; color: rgb(50, 18, 199); font-size: 12pt">
        <center><samp  >' . $sil->tipo . ':' . $sil->nombre . ' → 0 dias</samp></center></th>';
            } else {


                $contar_dias = 0;
                while (true && ($resta - $cantidad) > 0) {
                    $resta = $resta - $cantidad;
                    $contar_dias++;
                    if ($resta <= 0) {
                        break;
                    }
                }
                echo ' <th style="background: #FDC30D; color:rgb(50, 18, 199); font-size: 12pt">
        <center><samp  >' . $sil->tipo . ':' . $sil->nombre . ' → ' . $contar_dias . ' dias</samp></center></th>';
            }
            ?>
        @endforeach

        </thead>
    </table>


    <div ><font size="5">TEMPERATURA: <span id="temperatura">{{$temperatura[0]->temperatura}}</span> ºC</font></div>
<div  class=""><font style="margin:0 auto" size="5">POSTURA  TOTAL: <span id="porcentaje_total"></span></font></div>
    <div class="col-sm-2 col-md-2  col-sm-2  col-xs-12 pull-right" style="width: 7%; margin: 0px; padding: 0px">
        <div class="form-group">
            <button class="btn btn-danger" onclick="mostrarceldas()" id="btnmostrar" >MOSTRAR</button>                      
        </div>
    </div>
    <div class="col-sm-1  col-md-2  col-sm-2  col-xs-12 pull-right" style=" margin: 0px; padding: 0px">
        <div class="form-group">
            <div class='input-group date' id='datetimepicker10'>
                <input type='text' class="form-control" id="fecha1" style="font-size:20px;text-align:center" />
                <span class="input-group-addon ">
                    <span class="fa fa-calendar" aria-hidden="true"></span>  <!--span class="glyphicon glyphicon-calendar"></span-->
                </span>
            </div>
        </div>
    </div>

    <table border=1 class="table-striped  table-condensed table-hover" style="height: 450px; width: 100%" id="tablagalpon">
        <tr height=27 style='height:20.25pt'>
            <td height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt' align="center"><font size=2>ALIMENTAR</font></td>



            @foreach($galpon as $gal) <?php
            $control = DB::select("select grupo_control_alimento.id as id_control,alimento.id as id_alimento, grupo_edad_temp.cantidad,alimento.tipo from alimento, edad,grupo_control_alimento,control_alimento_galpon,grupo_edad,grupo_temperatura,grupo_edad_temp where grupo_edad.deleted_at IS NULL and grupo_temperatura.deleted_at IS NULL and edad.id=control_alimento_galpon.id_edad and control_alimento_galpon.id_control_alimento=grupo_control_alimento.id and grupo_control_alimento.id=grupo_edad_temp.id_control and grupo_edad_temp.id_edad=grupo_edad.id and grupo_edad_temp.id_temp=grupo_temperatura.id and edad.id=".$gal->id_edad." and alimento.id=grupo_edad.id_alimento and grupo_edad.edad_min<=".$gal->edad." and grupo_edad.edad_max>=".$gal->edad." and grupo_temperatura.temp_min<=".$temperatura[0]->temperatura." and grupo_temperatura.temp_max>=".$temperatura[0]->temperatura);
           $alimento_guardado=DB::select("select * from cambiar_alimento,alimento where cambiar_alimento.id_alimento=alimento.id and cambiar_alimento.estado=1 and cambiar_alimento.deleted_at IS NULL and cambiar_alimento.id_edad=".$gal->id_edad);

                       for ($i = $x; $i <= $gal->numero; $i++) {
                if (count($control) != 0) {//verifica que exista un control alimento para esaa edad y temperatura
                    $cantidad = $control[0]->cantidad * $gal->cantidad_actual;
                    $id_control= $control[0]->id_control;
                      $cantidad  =number_format(  $cantidad,2,".","");  
                    $alimento = $control[0]->tipo;
                    $id_alimento=$control[0]->id_alimento;
                    $cantidad_granel = $control[0]->cantidad;
                } else {//caso contrario todo se coloca en 0
                    $cantidad = 0;
                    $cantidad_granel = 0;
                    $alimento = "";
                    $id = 0;
                }
                if ($i != $gal->numero) {
                    echo " <td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'></td>";
                } else {

                    if (count($consumo) == 0) {//entra cuando no existe ningun consumo el dia actual
                        if (count($alimento_guardado)!=0) {// si en caso a cambiado de alimento por aqui va entrar y desactivado el control
                             echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(1,". $gal->id_edad .",". $id_control.",".$alimento_guardado[0]->id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero . ">" . $alimento_guardado[0]->tipo . "</span>: <span id=cantidad_g" . $gal->numero . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span> <span  data-status=1 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg. </button></td> ";
                        }else{
                            echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(0,". $gal->id_edad .",". $id_control.",".$id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero . ">" . $alimento . "</span>: <span id=cantidad_g" . $gal->numero . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span> <span  data-status=1 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg. </button></td> ";
                        }
                       
                    } else {

                        if ($consumo[$contador_consumo]->numero_galpon == $gal->numero) {

                            echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'>"
                            . "<button disabled   class='btn btn-danger' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(0,". $gal->id_edad .",". $id_control.",".$id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")>"
                            . "<span data-status=0 id=id_alimento" . $gal->numero . ">" . $consumo[$contador_consumo]->tipo . ":</span> <span data-status=0 id=cantidad_g" . $gal->numero . ">" . $consumo[$contador_consumo]->cantidad . "</span> <span data-status=0 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span>"
                            . " <span data-status=0 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg.
                        </button></td> ";
                       
                            if ($total_consumo - 1 > $contador_consumo) {
                                $contador_consumo++;
                            }
                        } else {
                             if (count($alimento_guardado)!=0) {// si en caso a cambiado de alimento por aqui va entrar y le agrego en los parametros 1 cuando entra y 0 cuando no 
                           echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(1,". $gal->id_edad .",". $id_control.",".$alimento_guardado[0]->id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero . ">" . $alimento_guardado[0]->tipo . "</span>: <span id=cantidad_g" . $gal->numero . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span> <span  data-status=1 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg. </button></td> ";  }
                             else{
                                echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal'
                             onclick=cargar_modal(0,". $gal->id_edad .",". $id_control.",".$id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero . ">" . $alimento . "</span>: <span data-status=1 id=cantidad_g" . $gal->numero . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span> <span data-status=1 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg.</button></td> ";
                             }
                        }
                    }
                }
            } $x = $gal->numero + 1;
            ?> 
            @endforeach   <?php
            for ($i = $x; $i < 9; $i++) {
                echo " <td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'></td>";
            } $x = 1;
            ?> 
        </tr> 

        <tr height=27 style='height:20.25pt' align="center">
            <td colspan=1 height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt'><font size=2>VACUNA</font></td>
            @foreach($galpon as $gal)   <?php
            for ($i = $x; $i <= $gal->numero; $i++) {
                if ($i != $gal->numero) {
                    echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
                } else {
                    if (count($lista2) != 0 && $contador_v < count($lista2)) {//
                        if ($lista2[$contador_v][0]->galpon == $gal->numero) {

                            for ($j = 0; $j < count($lista2[$contador_v]); $j++) {

                                $dias = $lista2[$contador_v][$j]->dias;
                                $detalle = $lista2[$contador_v][$j]->detalle;
                                if ($j - 1 >= 0) {//CUANDO TIENE MAS DE UNA VACUNA
                                    if ($lista2[$contador_v][$j - 1]->dias == $dias) {

                                        echo "<font size=3> <button class='btn-sm btn-info' id='vacuna" . $lista2[$contador_v][$j]->id . "' onclick='cargar_id_control_vacuna(" . $lista2[$contador_v][$j]->id_control_vacuna . "," . $lista2[$contador_v][$j]->precio . "," . $lista2[$contador_v][$j]->id . ")' data-toggle='modal' data-target='#myModalConsumo'>" . $lista2[$contador_v][$j]->nombre . "</button></font>";
                                    } else {
                                        $j = count($lista2[$contador_v]);
                                    }
                                } else {
                                    if ($j == 0) {//AQUI SE ENTRA CUANDO ES LA PRIMERA VACUNA
                                        if ($lista2[$contador_v][$j]->dias == 0) {
                                            echo "<td colspan=2 class=xl83 style='border-left:none; width:10.75%'><font size=3>Días:<span id='dias" . $gal->numero . "' style='color:red'>HOY</span> 
                          <button class='btn-sm btn-info' id='vacuna" . $lista2[$contador_v][$j]->id . "' onclick='cargar_id_control_vacuna(" . $lista2[$contador_v][$j]->id_control_vacuna . "," . $lista2[$contador_v][$j]->precio . ", " . $lista2[$contador_v][$j]->id . ")' data-toggle='modal' data-target='#myModalConsumo'>" . $lista2[$contador_v][$j]->nombre . "</button><br><button class='btn-sm btn-info'  onclick='LPostergacionVacuna(".$gal->id_edad.")'  data-toggle='modal' data-target='#ModalListaPost'>+</button>
                           </font>";  // <span id='vacuna".$gal->numero."'>".$lista2[$contador_v][$j]->nombre."</span>, 
                                        } else {
                                            echo '<td colspan=2 class=xl83 style=border-left:none; width:10.75%><font size=3> Días:<span id=dias' . $gal->numero . ' style=color:red>' . $lista2[$contador_v][$j]->dias . '</span>  <button class="btn-sm btn-info" id=vacuna' . $lista2[$contador_v][$j]->id . ' data-toggle=modal data-target=#myModalConsumo 
                            onclick=cargar_id_control_vacuna(' . $lista2[$contador_v][$j]->id_control_vacuna . ',' . $lista2[$contador_v][$j]->precio . ',' . $lista2[$contador_v][$j]->id . ') >' . $lista2[$contador_v][$j]->nombre . '</button><br><button class="btn-sm btn-info"  onclick="LPostergacionVacuna('.$gal->id_edad.')"  data-toggle="modal" data-target="#ModalListaPost">+</button></font>';
                                        }
                                    }
                                }
                            }
                            echo "</td>";
                            $contador_v++;
                        } else {
                            echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'>"
                            . " <button class='btn-sm btn-info'   onclick='LPostergacionVacuna(".$gal->id_edad.")'  data-toggle='modal' data-target='#ModalListaPost'>+</button></td>";
                        }
                    } else {
                        echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'>"
                        . "<button class='btn-sm btn-info' onclick='LPostergacionVacuna(".$gal->edad.")'  data-toggle='modal' data-target='#ModalListaPost'>+</button>"
                        . "</td>";
                    }
                }
            } $x = $gal->numero + 1;
            ?>                      
            @endforeach <?php
            for ($i = $x; $i < 9; $i++) {
                echo " <td colspan=2  class=xl83 style='border-left:none; width:10.75%'></td>";
            } $x = 1;
            ?> 
        </tr> 

        <tr height=22 style='height:16.5pt; background-color: YellowGreen' align='center'>
            <td colspan=1 height=22 class=xl81 style='border-right:.5pt solid black;height:16.5pt; width:8%'><font size=2>EDAD</font></td>
            @foreach($galpon as $gal) <?php
            for ($i = $x; $i <= $gal->numero; $i++) {
                if ($i != $gal->numero) {
                    echo " <td colspan=2  class=xl83 style='border-left:none; width:10.75%'></td>";
                } else {
                    echo "<td colspan=2 class=xl83 style='border-left:none; width:10.75%'><font size=3><font size=3><span id='edad" . $gal->numero . "'>" . $gal->edad . "</span></font></td> ";
                }
            } $x = $gal->numero + 1;
            ?>                  
            @endforeach <?php
            for ($i = $x; $i < 9; $i++) {
                echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
            } $x = 1;
            ?>                              
        </tr>
        
        <tr height=27 style='height:20.25pt; background-color: #f5bca9' align='center' >
            <td colspan=1 height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt'><font size=2>CANTIDAD ACTUAL</font></td>
            @foreach($galpon as $gal) <?php
            for ($i = $x; $i <= $gal->numero; $i++) {
                if ($i != $gal->numero) {
                    echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
                } else {
                    echo "<td colspan=2  class=xl83 style='border-left:none; width:10.75%' ><font size=3><span id='cant_actual" . $gal->numero . "'>" . $gal->cantidad_actual . "</span></td>";
                }
            } $x = $gal->numero + 1;
            ?>                  
            @endforeach <?php
            for ($i = $x; $i < 9; $i++) {
                echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
            } $x = 1;
            ?> 
        </tr>   

        <tr height=27 style='height:20.25pt' align='center'>
            <td colspan=1 height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt'><font size=2>MUERTAS</font></td>
            @foreach($galpon as $gal)  <?php
            for ($i = $x; $i <= $gal->numero; $i++) {
                if ($i != $gal->numero) {
                    echo "<td colspan=2 class=xl83 style='border-left:none;width:10.75%'></td>";
                } else {
                    echo "<td colspan=2  class=xl83 style='border-left:none; width:10.75%'><font size=3><span id='muerta" . $gal->numero . "'>" . $gal->total_muerta . "</span></td> ";
                }
            } $x = $gal->numero + 1;
            ?>                  
            @endforeach  <?php
            for ($i = $x; $i < 9; $i++) {
                echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
            } $x = 1;
            ?> 
        </tr> 

        <tr height=23 style='height:17.25pt; background-color: orange' align='center'>
            <td colspan=1 height=23 class=xl105 style='border-right:.5pt solid black;height:17.25pt'><font size=2>GALPON Nro</font></td>
            @foreach($galpon as $gal)  <?php
            for ($i = $x; $i <= $gal->numero; $i++) {
                if ($i != $gal->numero) {
                    echo " <td colspan=2  class=xl83 style='border-left:none; width:10.75%'>Vacio</td>";
                } else {
                    echo "<td colspan=2 class=xl83 style='border-left:none; width:10.75%'><font size=3><span  id='galpon" . $gal->numero . "'>GALPON " . $gal->numero . "</span></td> ";
                }
            } $x = $gal->numero + 1;
            ?> 
            @endforeach <?php
            for ($i = $x; $i < 9; $i++) {
                echo " <td colspan=2  class=xl83 style='border-left:none; width:10.75%'>Vacio</td>";
            } $x = 1;
            ?>                   
        </tr>

        <tr height=22 style='height:16.5pt' align='center'>
            <td rowspan=2 align=center class=xl71 style='border-bottom:.5pt solid black'><font size=2>MAÑANA</font></td>
            <?php
            if (count($postura_huevo) == 0) {
                for ($i = $x; $i <= 8; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input  id='c1g" . $i . "' type='text' onclick='extraer_id(" . $i . ")' class='form-control' onchange='guardar_huevo()'  onkeypress='return bloqueo_de_punto(event)'> </td>
                            <td rowspan=6 class=xl74 style='border-bottom:.5pt solid black;border-top:none'> <font color=red> MUERTAS </font> <br> <font color=red size='4'><span id='gmd" . $i . "'>0</span></font>
                            <input  onchange='guardar_huevo()'  type='number'  id='mg" . $i . "' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'>  </td>";
                }
            } else {
                foreach ($postura_huevo as $key => $pos) {
                    for ($i = $x; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo " <td class=xl72 style='border-left:none'> <input  id='c1g" . $i . "' type='text' onclick='extraer_id(" . $i . ")' class='form-control'  onchange='guardar_huevo()'   onkeypress='return bloqueo_de_punto(event)'> </td>
                            <td rowspan=6 class=xl74 style='border-bottom:.5pt solid black;border-top:none'> <font color=red> MUERTAS </font> <br> <font color=red size='4'><span id='gmd" . $i . "'>0</span></font>
                            <input  onchange='guardar_huevo()'  type='number'  id='mg" . $i . "' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'>  </td>";
                        } else {
                            echo "<td class=xl72 style='border-left:none'> <input id='c1g" . $i . "' value='" . $pos->celda1 . "' type='text'  onchange='guardar_huevo()'  onclick='return limpia(this),extraer_id(" . $i . ")' onBlur='return verificar(this)' class='form-control' style='font-size: 16px;text-align:center'  onkeypress='return bloqueo_de_punto(event)' > </td> 
                            <td rowspan=6 class=xl74 style='border-bottom:.5pt solid black;border-top:none'><font color=red> MUERTAS </font><br> <font color=red size='4'><span id='gmd" . $i . "'>" . $pos->cantidad_muertas . "</span></font>  <input  onchange='guardar_huevo()'  type='number' id='mg" . $i . "' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'></td>";
                        }//else
                    } //for
                    $x = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x; $i < 9; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input  id='c1g" . $i . "' type='text' onclick='extraer_id(" . $i . ")' class='form-control'  onchange='guardar_huevo()'   onkeypress='return bloqueo_de_punto(event)'> </td>
                            <td rowspan=6 class=xl74 style='border-bottom:.5pt solid black;border-top:none'> <font color=red> MUERTAS </font> <br> <font color=red size='4'><span id='gmd" . $i . "'>0</span></font>
                            <input  onchange='guardar_huevo()'  type='number'  id='mg" . $i . "' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td>";
                } $x = 1;
            }
            ?> 



        </tr>

        <tr height=22 style='height:16.5pt'>
            <?php
            if (count($postura_huevo) == 0) {
                for ($i = $x; $i <= 8; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' id='c2g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                }
            } else {
                foreach ($postura_huevo as $key => $pos) {
                    for ($i = $x; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' id='c2g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                        } else {
                            echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' type='text' style='font-size: 16px;text-align:center' value='" . $pos->celda2 . "' id='c2g" . $i . "'class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='return limpia(this),extraer_id(" . $i . ")' onBlur='return verificar(this)'></td>";
                        }//else
                    } //for
                    $x = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x; $i < 9; $i++) {
                    echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' id='c2g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                } $x = 1;
            }
            ?> 



        </tr>

        <tr height=22 style='height:16.5pt'>
            <td rowspan=2 align=center class=xl71 style='border-bottom:.5pt solid black'><font size=2>TARDE</font></td>
            <?php
            if (count($postura_huevo) == 0) {
                for ($i = $x; $i <= 8; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' id='c3g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                }
            } else {
                foreach ($postura_huevo as $key => $pos) {
                    for ($i = $x; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo " <td class=xl72 style='border-left:none'> <input  onchange='guardar_huevo()' id='c3g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                        } else {
                            echo "<td class=xl72 style='border-left:none'> <input  onchange='guardar_huevo()'type='text' style='font-size: 16px;text-align:center' value='" . $pos->celda3 . "' id='c3g" . $i . "'class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='return limpia(this),extraer_id(" . $i . ")' onBlur='return verificar(this)'></td>";
                        }//else
                    } //for
                    $x = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x; $i < 9; $i++) {
                    echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' id='c3g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                } $x = 1;
            }
            ?> 


        </tr>

        <tr height=22 style='height:16.5pt'>
            <?php
            if (count($postura_huevo) == 0) {
                for ($i = $x; $i <= 8; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' id='c4g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                }
            } else {
                foreach ($postura_huevo as $key => $pos) {
                    for ($i = $x; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' id='c4g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                        } else {
                            echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' type='text' style='font-size: 16px;text-align:center' value='" . $pos->celda4 . "' id='c4g" . $i . "'class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='return limpia(this),extraer_id(" . $i . ")' onBlur='return verificar(this)'></td>";
                        }//else
                    } //for
                    $x = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x; $i < 9; $i++) {
                    echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' id='c4g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                } $x = 1;
            }
            ?>        
        </tr>

        <tr height=22 style='height:16.5pt' align=center>
            <td colspan=1 height=22 class=xl81 style='border-right:.5pt solid black;height:16.5pt;border-left:none'><font size=2>TOTAL GALPON</font></td>
            <?php
            if (count($postura_huevo) == 0) {
                for ($i = $x; $i <= 8; $i++) {
                    echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='total_galpones" . $i . "'>0</span></font></td>";
                }
            } else {
                foreach ($postura_huevo as $key => $pos) {
                    for ($i = $x; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='total_galpones" . $i . "'>0</span></font></td>";
                        } else {
                            echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='total_galpones" . $i . "'>" . $pos->cantidad_total . "</span></font> </td>";
                        }//else
                    } //for
                    $x = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x; $i < 9; $i++) {
                    echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='total_galpones" . $i . "'>0</span></font></td>";
                } $x = 1;
            }
            ?>        

        </tr>

        <tr height=22 style='height:16.5pt' align=center>
            <td colspan=1 height=22 class=xl81 style='border-right:.5pt solid black; height:16.5pt;border-left:none'><font size=2>POSTURA %</font></td>
            <?php
            if (count($postura_huevo) == 0) {
                for ($i = $x; $i <= 8; $i++) {
                    echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='ph" . $i . "'>0</span></font></td>";
                }
            } else {
                foreach ($postura_huevo as $key => $pos) {
                    for ($i = $x; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='ph" . $i . "'>0</span></font></td>";
                        } else {
                            echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='ph" . $i . "'>" . $pos->postura_p . " %</span></font> </td>";
                        }//else
                    } //for
                    $x = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x; $i < 9; $i++) {
                    echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='ph" . $i . "'>0</span></font></td>";
                } $x = 1;
            }
            ?>        

        </tr>

        @foreach($galpon as $gal)
        <input type="hidden" id="id_fase_galpon{{$gal->numero}}" value="{{$gal->id_fase_galpon}}">
        @endforeach                   
    </table>
</div>



<br>  <!--TABLA2-->
<?php
$contador = DB::select("SELECT COUNT(*)as contador from edad,fases_galpon,galpon,fases WHERE edad.id_galpon=galpon.id and edad.id=fases_galpon.id_edad and fases.id=fases_galpon.id_fase and fases.nombre='PONEDORA' and edad.estado=1 and galpon.numero>8");
if ($contador[0]->contador != 0) {
    ?>


    <table border=1 class="table-striped  table-condensed table-hover" style="height: 450px; width: 100%" id="tablagalpon2">
        <tr height=27 style='height:20.25pt'>
            <td height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt' align="center"><font size=2>ALIMENTAR</font></td>

            @foreach($galpon2 as $gal) <?php

 $control = DB::select("select grupo_control_alimento.id as id_control,alimento.id as id_alimento, grupo_edad_temp.cantidad,alimento.tipo from alimento, edad,grupo_control_alimento,control_alimento_galpon,grupo_edad,grupo_temperatura,grupo_edad_temp where grupo_edad.deleted_at IS NULL and grupo_temperatura.deleted_at IS NULL and edad.id=control_alimento_galpon.id_edad and control_alimento_galpon.id_control_alimento=grupo_control_alimento.id and grupo_control_alimento.id=grupo_edad_temp.id_control and grupo_edad_temp.id_edad=grupo_edad.id and grupo_edad_temp.id_temp=grupo_temperatura.id and edad.id=".$gal->id_edad." and alimento.id=grupo_edad.id_alimento and grupo_edad.edad_min<=".$gal->edad." and grupo_edad.edad_max>=".$gal->edad." and grupo_temperatura.temp_min<=".$temperatura[0]->temperatura." and grupo_temperatura.temp_max>=".$temperatura[0]->temperatura);
   $alimento_guardado=DB::select("select * from cambiar_alimento,alimento where cambiar_alimento.id_alimento=alimento.id and cambiar_alimento.estado=1 and cambiar_alimento.deleted_at IS NULL and cambiar_alimento.id_edad=".$gal->id_edad);

            for ($i = $x2; $i <= $gal->numero; $i++) {
                if (count($control) != 0) {//verifica que exista un control alimento para esaa edad y temperatura
                    $cantidad = $control[0]->cantidad * $gal->cantidad_actual;
                    $id_control= $control[0]->id_control;
                      $cantidad  =number_format(  $cantidad,2,".",",");  
                    $alimento = $control[0]->tipo;
                    $id_alimento=$control[0]->id_alimento;
                    $cantidad_granel = $control[0]->cantidad;
                } else {//caso contrario todo se coloca en 0
                    $cantidad = 0;
                    $cantidad_granel = 0;
                    $alimento = "";
                    $id = 0;
                }
                if ($i != $gal->numero) {
                    echo " <td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'></td>";
                } else {
                    if (count($consumo2) == 0) {//entra cuando no existe ningun consumo el dia actual
                         if (count($alimento_guardado)!=0) {
                        echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(1,". $gal->id_edad .",". $id_control.",".$alimento_guardado[0]->id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero . ">" . $alimento_guardado[0]->tipo . "</span>: <span id=cantidad_g" . $gal->numero . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span> <span  data-status=1 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg. </button></td> "; }
                        else{
                            echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(0,". $gal->id_edad .",". $id_control.",".$id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero . ">" . $alimento . "</span>: <span id=cantidad_g" . $gal->numero . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span> <span  data-status=1 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg. </button></td>";
                        }

                    } else {

                        if ($consumo2[$contador_consumo2]->numero_galpon == $gal->numero) {

                            echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'>"
                            . "<button disabled   class='btn btn-danger' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(". $id_control.",".$id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")>"
                            . "<span data-status=0 id=id_alimento" . $gal->numero . ">" . $consumo2[$contador_consumo2]->tipo . ":</span> <span data-status=0 id=cantidad_g" . $gal->numero . ">" . $consumo2[$contador_consumo2]->cantidad . "</span> <span data-status=0 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span>"
                            . " <span data-status=0 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg.
                        </button></td> ";
                            if ($total_consumo2 - 1 > $contador_consumo2) {
                                $contador_consumo2++;
                            }
                        } else {
                             if (count($alimento_guardado)!=0) {// si en caso a cambiado de alimento por aqui va entrar y le agrego en los parametros 1 cuando entra y 0 cuando no 
                            echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal'
                             onclick=cargar_modal(". $id_control.",".$id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero . ">" . $alimento . "</span>: <span data-status=1 id=cantidad_g" . $gal->numero . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span> <span data-status=1 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg.</button></td> ";} 
                             else{
                                echo "<td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal'
                             onclick=cargar_modal(0,". $gal->id_edad .",". $id_control.",".$id_alimento."," . $gal->numero . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero . ">" . $alimento . "</span>: <span data-status=1 id=cantidad_g" . $gal->numero . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero . "'>" . $cantidad_granel . "</span> <span data-status=1 hidden id=id_control" . $gal->numero . ">" . $id . "</span> Kg.</button></td> ";
                             }

                        }
                    }
                }
            } 
    $x2 = $gal->numero + 1;
    ?> 
            @endforeach   <?php
        for ($i = $x2; $i < 17; $i++) {
            echo " <td colspan=2 align='center' class=xl83 style='border-left:none; width:10.75%'></td>";
        } $x2 = 9;
    ?> 
        </tr>

        <tr height=27 style='height:20.25pt' align="center">
            <td colspan=1 height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt'><font size=2>VACUNA</font></td>
            @foreach($galpon2 as $gal)   <?php
    

          for ($i = $x2; $i <= $gal->numero; $i++) {
                if ($i != $gal->numero) {
                    echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
                } else {
                    if (count($lista3) != 0 && $contador_v2 < count($lista3)) {//
                        if ($lista3[$contador_v2][0]->galpon == $gal->numero) {

                            for ($j = 0; $j < count($lista3[$contador_v2]); $j++) {

                                $dias = $lista3[$contador_v2][$j]->dias;
                                $detalle = $lista3[$contador_v2][$j]->detalle;
                                if ($j - 1 >= 0) {//CUANDO TIENE MAS DE UNA VACUNA
                                    if ($lista3[$contador_v2][$j - 1]->dias == $dias) {

                                        echo "<font size=3> <button class='btn-sm btn-info' id='vacuna" . $lista3[$contador_v2][$j]->id . "' onclick='cargar_id_control_vacuna(" . $lista3[$contador_v2][$j]->id_control_vacuna . "," . $lista3[$contador_v2][$j]->precio . "," . $lista3[$contador_v2][$j]->id . ")' data-toggle='modal' data-target='#myModalConsumo'>" . $lista3[$contador_v2][$j]->nombre . "</button></font>";
                                    } else {
                                        $j = count($lista3[$contador_v2]);
                                    }
                                } else {
                                    if ($j == 0) {//AQUI SE ENTRA CUANDO ES LA PRIMERA VACUNA
                                        if ($lista3[$contador_v2][$j]->dias == 0) {
                                            echo "<td colspan=2 class=xl83 style='border-left:none; width:10.75%'><font size=3>Días:<span id='dias" . $gal->numero . "' style='color:red'>HOY</span> 
                          <button class='btn-sm btn-info' id='vacuna" . $lista3[$contador_v2][$j]->id . "' onclick='cargar_id_control_vacuna(" . $lista3[$contador_v2][$j]->id_control_vacuna . "," . $lista3[$contador_v2][$j]->precio . ", " . $lista3[$contador_v2][$j]->id . ")' data-toggle='modal' data-target='#myModalConsumo'>" . $lista3[$contador_v2][$j]->nombre . "</button><br><button class='btn-sm btn-info'  onclick='LPostergacionVacuna(".$gal->id_edad.")'  data-toggle='modal' data-target='#ModalListaPost'>+</button>
                           </font>";  // <span id='vacuna".$gal->numero."'>".$lista2[$contador_v][$j]->nombre."</span>, 
                                        } else {
                                            echo '<td colspan=2 class=xl83 style=border-left:none; width:10.75%><font size=3> Días:<span id=dias' . $gal->numero . ' style=color:red>' . $lista3[$contador_v2][$j]->dias . '</span>  <button class="btn-sm btn-info" id=vacuna' . $lista3[$contador_v2][$j]->id . ' data-toggle=modal data-target=#myModalConsumo 
                            onclick=cargar_id_control_vacuna(' . $lista2[$contador_v2][$j]->id_control_vacuna . ',' . $lista3[$contador_v2][$j]->precio . ',' . $lista3[$contador_v2][$j]->id . ') >' . $lista3[$contador_v2][$j]->nombre . '</button><br><button class="btn-sm btn-info"  onclick="LPostergacionVacuna('.$gal->id_edad.')"  data-toggle="modal" data-target="#ModalListaPost">+</button></font>';
                                        }
                                    }
                                }
                            }
                            echo "</td>";
                            $contador_v++;
                        } else {
                            echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'>"
                            . " <button class='btn-sm btn-info'   onclick='LPostergacionVacuna(".$gal->id_edad.")'  data-toggle='modal' data-target='#ModalListaPost'>+</button></td>";
                        }
                    } else {
                        echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'>"
                        . "<button class='btn-sm btn-info' onclick='LPostergacionVacuna(".$gal->edad.")'  data-toggle='modal' data-target='#ModalListaPost'>+</button>"
                        . "</td>";
                    }
                }
            }  $x2 = $gal->numero + 1;
    ?>                      
            @endforeach <?php
        for ($i = $x2; $i < 17; $i++) {
            echo " <td colspan=2  class=xl83 style='border-left:none; width:10.75%'></td>";
        } $x2 = 9;
    ?> 
        </tr>  

        <tr height=22 style='height:16.5pt; background-color: YellowGreen' align='center'>
            <td colspan=1 height=22 class=xl81 style='border-right:.5pt solid black;height:16.5pt; width:8%'><font size=2>EDAD</font></td>
            @foreach($galpon2 as $gal) <?php
        for ($i = $x2; $i <= $gal->numero; $i++) {
            if ($i != $gal->numero) {
                echo " <td colspan=2  class=xl83 style='border-left:none; width:10.75%'></td>";
            } else {
                echo "<td colspan=2 class=xl83 style='border-left:none; width:10.75%'><font size=3><span id='edad" . $gal->numero . "'>" . $gal->edad . "</span></td> ";
            }
        } $x2 = $gal->numero + 1;
    ?>                  
            @endforeach <?php
        for ($i = $x2; $i < 17; $i++) {
            echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
        } $x2 = 9;
    ?>                              
        </tr>
        <tr height=27 style='height:20.25pt; background-color: #f5bca9' align='center' >
            <td colspan=1 height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt'><font size=2>CANTIDAD ACTUAL</font></td>
            @foreach($galpon2 as $gal) <?php
        for ($i = $x2; $i <= $gal->numero; $i++) {
            if ($i != $gal->numero) {
                echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
            } else {
                echo "<td colspan=2  class=xl83 style='border-left:none; width:10.75%' ><font size=3><span id='cant_actual" . $gal->numero . "'>" . $gal->cantidad_actual . "</span></td>";
            }
        } $x2 = $gal->numero + 1;
    ?>                  
            @endforeach <?php
        for ($i = $x2; $i < 17; $i++) {
            echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
        } $x2 = 9;
    ?> 
        </tr>   

        <tr height=27 style='height:20.25pt' align='center'>
            <td colspan=1 height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt'><font size=2>MUERTAS</font></td>
            @foreach($galpon2 as $gal)  <?php
        for ($i = $x2; $i <= $gal->numero; $i++) {
            if ($i != $gal->numero) {
                echo "<td colspan=2 class=xl83 style='border-left:none;width:10.75%'></td>";
            } else {
                echo "<td colspan=2  class=xl83 style='border-left:none; width:10.75%'><font size=3><span id='muerta" . $gal->numero . "'>" . $gal->total_muerta . "</span></td> ";
            }
        } $x2 = $gal->numero + 1;
    ?>                  
            @endforeach  <?php
        for ($i = $x2; $i < 17; $i++) {
            echo " <td colspan=2 class=xl83 style='border-left:none; width:10.75%'></td>";
        } $x2 = 9;
    ?> 
        </tr> 

        <tr height=23 style='height:17.25pt; background-color: orange' align='center'>
            <td colspan=1 height=23 class=xl105 style='border-right:.5pt solid black;height:17.25pt'><font size=2>GALPON Nro</font></td>
            @foreach($galpon2 as $gal)  <?php
        for ($i = $x2; $i <= $gal->numero; $i++) {
            if ($i != $gal->numero) {
                echo " <td colspan=2  class=xl83 style='border-left:none; width:10.75%'>Vacio</td>";
            } else {
                echo "<td colspan=2 class=xl83 style='border-left:none; width:10.75%'><font size=3><span  id='galpon" . $gal->numero . "'>GALPON " . $gal->numero . "</span></td> ";
            }
        } $x2 = $gal->numero + 1;
    ?> 
            @endforeach <?php
        for ($i = $x2; $i < 17; $i++) {
            echo " <td colspan=2  class=xl83 style='border-left:none; width:10.75%'>Vacio</td>";
        } $x2 = 9;
    ?>                   
        </tr>   

        <tr height=22 style='height:16.5pt' align='center'>
            <td rowspan=2 align=center class=xl71 style='border-bottom:.5pt solid black'><font size=2>MAÑANA</font></td>
            <?php
            if (count($postura_huevo2) == 0) {
                for ($i = $x2; $i <= 16; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  id='c1g" . $i . "' type='text' onclick='extraer_id(" . $i . ")' class='form-control'  onkeypress='return bloqueo_de_punto(event)'> </td>
                  <td rowspan=6 class=xl74 style='border-bottom:.5pt solid black;border-top:none'> <font color=red> MUERTAS </font> <br> <font color=red size='4'><span id='gmd" . $i . "'>0</span></font>
                  <input type='number'  id='mg" . $i . "' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'>  </td>";
                }
            } else {
                foreach ($postura_huevo2 as $key => $pos) {
                    for ($i = $x2; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'   id='c1g" . $i . "' type='text' onclick='extraer_id(" . $i . ")' class='form-control'  onkeypress='return bloqueo_de_punto(event)'> </td>
                  <td rowspan=6 class=xl74 style='border-bottom:.5pt solid black;border-top:none'> <font color=red> MUERTAS </font> <br> <font color=red size='4'><span id='gmd" . $i . "'>0</span></font>
                  <input type='number'  id='mg" . $i . "' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'>  </td>";
                        } else {
                            echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  id='c1g" . $i . "' value='" . $pos->celda1 . "' type='text' onclick='return limpia(this),extraer_id(" . $i . ")' onBlur='return verificar(this)' class='form-control' style='font-size: 16px;text-align:center'  onkeypress='return bloqueo_de_punto(event)' > </td> 
                  <td rowspan=6 class=xl74 style='border-bottom:.5pt solid black;border-top:none'><font color=red> MUERTAS </font><br> <font color=red size='4'><span id='gmd" . $i . "'>" . $pos->cantidad_muertas . "</span></font>  <input type='number' onchange='guardar_huevo()'  id='mg" . $i . "' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'></td>";
                        }//else
                    } //for
                    $x2 = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x2; $i < 17; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input  id='c1g" . $i . "' type='text' onclick='extraer_id(" . $i . ")' class='form-control'  onchange='guardar_huevo()'  onkeypress='return bloqueo_de_punto(event)'> </td>
                  <td rowspan=6 class=xl74 style='border-bottom:.5pt solid black;border-top:none'> <font color=red> MUERTAS </font> <br> <font color=red size='4'><span id='gmd" . $i . "'>0</span></font>
                  <input type='number' onchange='guardar_huevo()'   id='mg" . $i . "' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td>";
                } $x2 = 9;
            }
            ?>                                                                        
        </tr> 

        <tr height=22 style='height:16.5pt'>
            <?php
            if (count($postura_huevo2) == 0) {
                for ($i = $x2; $i <= 16; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  id='c2g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                }
            } else {
                foreach ($postura_huevo2 as $key => $pos) {
                    for ($i = $x2; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo " <td class=xl72 style='border-left:none'> <input  onchange='guardar_huevo()'  id='c2g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                        } else {
                            echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()' type='text' style='font-size: 16px;text-align:center' value='" . $pos->celda2 . "' id='c2g" . $i . "'class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='return limpia(this),extraer_id(" . $i . ")' onBlur='return verificar(this)'></td>";
                        }//else
                    } //for
                    $x2 = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x2; $i < 17; $i++) {
                    echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  id='c2g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                } $x2 = 9;
            }
            ?> 
        </tr>    


        <tr height=22 style='height:16.5pt'>
            <td rowspan=2 align=center class=xl71 style='border-bottom:.5pt solid black'><font size=2>TARDE</font></td>
            <?php
            if (count($postura_huevo2) == 0) {
                for ($i = $x2; $i <= 16; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  id='c3g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                }
            } else {
                foreach ($postura_huevo2 as $key => $pos) {
                    for ($i = $x2; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  id='c3g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                        } else {
                            echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  type='text' style='font-size: 16px;text-align:center' value='" . $pos->celda3 . "' id='c3g" . $i . "'class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='return limpia(this),extraer_id(" . $i . ")' onBlur='return verificar(this)'></td>";
                        }//else
                    } //for
                    $x2 = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x2; $i < 17; $i++) {
                    echo "<td class=xl72 style='border-left:none'> <input  onchange='guardar_huevo()'  id='c3g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                } $x2 = 9;
            }
            ?> 


        </tr>

        <tr height=22 style='height:16.5pt'>
            <?php
            if (count($postura_huevo2) == 0) {
                for ($i = $x2; $i <= 16; $i++) {
                    echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  id='c4g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                }
            } else {
                foreach ($postura_huevo2 as $key => $pos) {
                    for ($i = $x2; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo " <td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  id='c4g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                        } else {
                            echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  type='text' style='font-size: 16px;text-align:center' value='" . $pos->celda4 . "' id='c4g" . $i . "'class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='return limpia(this),extraer_id(" . $i . ")' onBlur='return verificar(this)'></td>";
                        }//else
                    } //for
                    $x2 = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x2; $i < 17; $i++) {
                    echo "<td class=xl72 style='border-left:none'> <input onchange='guardar_huevo()'  id='c4g" . $i . "' type='text' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(" . $i . ")'> </td> ";
                } $x2 = 9;
            }
            ?>        
        </tr>   


        <tr height=22 style='height:16.5pt' align=center>
            <td colspan=1 height=22 class=xl81 style='border-right:.5pt solid black;height:16.5pt;border-left:none'><font size=2>TOTAL GALPON</font></td>
            <?php
            if (count($postura_huevo2) == 0) {
                for ($i = $x2; $i <= 16; $i++) {
                    echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='total_galpones" . $i . "'>0</span></font></td>";
                }
            } else {
                foreach ($postura_huevo2 as $key => $pos) {
                    for ($i = $x2; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='total_galpones" . $i . "'>0</span></font></td>";
                        } else {
                            echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='total_galpones" . $i . "'>" . $pos->cantidad_total . "</span></font> </td>";
                        }//else
                    } //for
                    $x2 = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x2; $i < 17; $i++) {
                    echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='total_galpones" . $i . "'>0</span></font></td>";
                } $x2 = 9;
            }
            ?>        

        </tr>

        <tr height=22 style='height:16.5pt' align=center>
            <td colspan=1 height=22 class=xl81 style='border-right:.5pt solid black; height:16.5pt;border-left:none'><font size=2>POSTURA %</font></td>
            <?php
            if (count($postura_huevo2) == 0) {
                for ($i = $x2; $i <= 16; $i++) {
                    echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='ph" . $i . "'>0</span></font></td>";
                }
            } else {
                foreach ($postura_huevo2 as $key => $pos) {
                    for ($i = $x2; $i <= $pos->numero; $i++) {
                        if ($i != $pos->numero) {
                            echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='ph" . $i . "'>0</span></font></td>";
                        } else {
                            echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='ph" . $i . "'>" . $pos->postura_p . " %</span></font> </td>";
                        }//else
                    } //for
                    $x2 = $pos->numero + 1; //para controlar el  numero del galpon que le toca iniciar en el for
                } //foreach
                for ($i = $x2; $i < 17; $i++) {
                    echo "<td class=xl83 style='border-top:none;border-left:none'><font size=4><span id='ph" . $i . "'>0</span></font></td>";
                } $x2 = 9;
            }
            ?>        

        </tr>                   
    </table>
    @foreach($galpon2 as $gal)
    <input type="hidden" id="id_fase_galpon{{$gal->numero}}" value="{{$gal->id_fase_galpon}}">
    @endforeach  

    <?php
}
?>

<br>

</div>

{!!Html::script('js/script.js')!!}
@endsection





