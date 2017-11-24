@extends ('layouts.admin')
@section ('content')
@include('alerts.cargando')
@include('cria-recria.modal_alimento')
@include('cria-recria.mensaje')
@include('galpon.modals.modal')
<?php $cont = 0;$x=1; 
$cantidad=0;
$alimento="";
$id=0;
$cantidad_granel=0;
$contador_consumo=0;//cuenta el array consumo para desactivar el boton control alimento
$total_consumo=count($consumo);
$contador_v=0;
$auxdias=0;
$dias=0;
  $id_control=0;
  $id_alimento=0;
$control_1 = array();
$con_control = 0;
$cantidad = 0;
?>
<input type="hidden" name="_token" value="{{ csrf_token()}}" id="token">
<div class="row" style="height: 100%; width:100%"> 

<table class="table table-striped table-bordered table-condensed table-hover">
<thead>
  @foreach($silo as $sil)
<?php if ($sil->cantidad_minima > $sil->cantidad): ?>
    <th style="background: #d73925; color: white; font-size: 12pt">  <center><samp>{{$sil->tipo}}:{{$sil->nombre}} → {{$sil->cantidad}} Kg</samp></center></th>
<?php else: ?>
    <th style="background: #008d4c; color: white; font-size: 12pt">  <center><samp>{{$sil->tipo}}:{{$sil->nombre}} → {{$sil->cantidad}} kg</samp></center></th>
<?php endif ?>

  @endforeach
</thead>
</table>

<font size="5">TEMPERATURA: <span id="temperatura">{{$temperatura[0]->temperatura}}</span> ºC</font>
    <div class="col-sm-2 col-md-2  col-sm-2  col-xs-12 pull-right" style="width: 7%; margin: 0px; padding: 0px">
      <div class="form-group">
        <button class="btn btn-danger" onclick="mostrarcriamuertas()" id="btnmostrar" >MOSTRAR</button>                      
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
                <td height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt' align="center">ALIMENTAR</td>
                
               

                @foreach($cria_recria as $gal) <?php 
 $control = DB::select("select grupo_control_alimento.id as id_control,alimento.id as id_alimento, grupo_edad_temp.cantidad,alimento.tipo from alimento, edad,grupo_control_alimento,control_alimento_galpon,grupo_edad,grupo_temperatura,grupo_edad_temp where grupo_edad.deleted_at IS NULL and grupo_temperatura.deleted_at IS NULL and edad.id=control_alimento_galpon.id_edad and control_alimento_galpon.id_control_alimento=grupo_control_alimento.id and grupo_control_alimento.id=grupo_edad_temp.id_control and grupo_edad_temp.id_edad=grupo_edad.id and grupo_edad_temp.id_temp=grupo_temperatura.id and edad.id=".$gal->id_edad." and alimento.id=grupo_edad.id_alimento and grupo_edad.edad_min<=".$gal->edad." and grupo_edad.edad_max>=".$gal->edad." and grupo_temperatura.temp_min<=".$temperatura[0]->temperatura." and grupo_temperatura.temp_max>=".$temperatura[0]->temperatura);
   $alimento_guardado=DB::select("select * from cambiar_alimento,alimento where cambiar_alimento.id_alimento=alimento.id and cambiar_alimento.estado=1 and cambiar_alimento.deleted_at IS NULL and cambiar_alimento.id_edad=".$gal->id_edad);
     

                for ($i=$x; $i <=$gal->numero_fase;  $i++) { 
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
                    if ($i!=$gal->numero_fase) { echo " <td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'></td>"; } 
                    else{ 

                      if (count($consumo)==0) {
                          if (count($alimento_guardado)!=0) {// si en caso a cambiado de alimento por aqui va entrar y desactivado el control
                            echo "<td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(1,". $gal->id_edad .",". $id_control.",".$alimento_guardado[0]->id_alimento."," . $gal->numero_fase . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero_fase . ">" . $alimento_guardado[0]->tipo . "</span>: <span id=cantidad_g" . $gal->numero_fase . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero_fase . "'>" . $cantidad_granel . "</span> <span  data-status=1 hidden id=id_control" . $gal->numero_fase . ">" . $id . "</span> Kg. </button></td> ";
                       
                      } else{ echo "<td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(0,". $gal->id_edad .",". $id_control.",".$id_alimento."," . $gal->numero_fase . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero_fase . ">" . $alimento . "</span>: <span id=cantidad_g" . $gal->numero_fase . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero_fase . "'>" . $cantidad_granel . "</span> <span  data-status=1 hidden id=id_control" . $gal->numero_fase . ">" . $id . "</span> Kg. </button></td> ";
                            }
                      } 
                      else {
                      if ($consumo[$contador_consumo]->numero_fase==$gal->numero_fase) {
                          echo "<td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'><button disabled class='btn btn-danger' data-toggle='modal' data-target='#myModal'  onclick=cargar_modal(". $id_control.",".$id_alimento."," . $gal->numero_fase . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=0 id=id_alimento".$gal->numero_fase.">".$consumo[$contador_consumo]->tipo.":</span> <span id=cantidad_g".$gal->numero_fase.">".$consumo[$contador_consumo]->cantidad."</span> <span hidden id=c_granel_g".$gal->numero_fase.">". $cantidad_granel."</span> <span hidden id=id_control".$gal->numero_fase.">".$id."</span> kg. </button></td> ";
                            if ($total_consumo-1>$contador_consumo) {
                                $contador_consumo++;                             
                            } 
                        } else {
 if (count($alimento_guardado)!=0) {
                echo "<td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(1,". $gal->id_edad .",". $id_control.",".$alimento_guardado[0]->id_alimento."," . $gal->numero_fase . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero_fase . ">" . $alimento_guardado[0]->tipo . "</span>: <span id=cantidad_g" . $gal->numero_fase . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero_fase . "'>" . $cantidad_granel . "</span> <span  data-status=1 hidden id=id_control" . $gal->numero_fase . ">" . $id . "</span> Kg. </button></td> ";  }
                         
                          
                             else{
                      echo "<td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'><button class='btn btn-success' data-toggle='modal' data-target='#myModal' onclick=cargar_modal(0,". $gal->id_edad .",". $id_control.",".$id_alimento."," . $gal->numero_fase . "," . $gal->id_fase_galpon . "," . $cantidad . "," . $cantidad_granel . ")><span data-status=1 id=id_alimento" . $gal->numero_fase . ">" . $alimento  . "</span>: <span id=cantidad_g" . $gal->numero_fase . ">" . $cantidad . "</span> <span data-status=1 hidden id='c_granel_g" . $gal->numero_fase . "'>" . $cantidad_granel . "</span> <span  data-status=1 hidden id=id_control" . $gal->numero_fase . ">" . $id . "</span> Kg. </button></td> ";  }
                         

                             }
                        }

                      
                  }
                } $x=$gal->numero_fase+1; ?> 
                @endforeach   <?php  
                for ($i=$x; $i <=3 ; $i++) { 
                    echo " <td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'></td>";
                }   $x=1;  ?> 
            </tr> 


  <tr height=27 style='height:20.25pt' align="center">
      <td colspan=1 height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt'>VACUNA</td>


      @foreach($cria_recria as $gal)   <?php   

        for ($i=$x; $i <=$gal->numero_fase;  $i++) { 
          if ($i!=$gal->numero_fase) {echo " <td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'></td>"; } 
          else{ 
           
            if (count($lista2)!=0 && $contador_v<count($lista2)) {

//echo $lista2[$contador_v][0]->galpon,$gal->numero_fase;
             if ($lista2[$contador_v][0]->galpon==$gal->numero_fase) {
             

                for ($j=0; $j <count($lista2[$contador_v]) ; $j++) { 

                       $dias= $lista2[$contador_v][$j]->dias;
                        

                           if ($j-1>=0) {//CUNADO TIENE MAS DE UNA VACUNA
                            if ($lista2[$contador_v][$j-1]->dias==$dias) {
                           
                            echo "<font size=3> <button class='btn-sm btn-info' id='vacuna".$lista2[$contador_v][$j]->id."' onclick='cargar_id_control_vacuna(".$lista2[$contador_v][$j]->id_control_vacuna.",".$lista2[$contador_v][$j]->precio.",".$lista2[$contador_v][$j]->id.")' data-toggle='modal' data-target='#myModalConsumo'>".$lista2[$contador_v][$j]->nombre."</button></font>";
    
                            }
                            else{
                              $j =count($lista2[$contador_v]);
                            }
                            }else{

                            if ($j==0) {//AQUI SE ENTRA CUANDO ES LA PRIMERA VACUNA

                               if ($lista2[$contador_v][$j]->dias==0) {
                          echo "<td colspan=1 class=xl83 style='border-left:none; width:10.75%'><font size=3>Días:<span id='dias" . $gal->numero . "' style='color:red'>HOY</span> 
                          <button class='btn-sm btn-info' id='vacuna" . $lista2[$contador_v][$j]->id . "' onclick='cargar_id_control_vacuna(" . $lista2[$contador_v][$j]->id_control_vacuna . "," . $lista2[$contador_v][$j]->precio . ", " . $lista2[$contador_v][$j]->id . ")' data-toggle='modal' data-target='#myModalConsumo'>" . $lista2[$contador_v][$j]->nombre . "</button><br><button class='btn-sm btn-info'  onclick='LPostergacionVacuna(".$gal->id_edad.")'  data-toggle='modal' data-target='#ModalListaPost'>+</button>                          
                           </font>";  // <span id='vacuna".$gal->numero."'>".$lista2[$contador_v][$j]->nombre."</span>, 
                          }
                          else{
                              echo '<td colspan=1 class=xl83 style=border-left:none; width:10.75%><font size=3> Días:<span id=dias' . $gal->numero . ' style=color:red>' . $lista2[$contador_v][$j]->dias . '</span>  <button class="btn-sm btn-info" id=vacuna' . $lista2[$contador_v][$j]->id . ' data-toggle=modal data-target=#myModalConsumo 
                            onclick=cargar_id_control_vacuna(' . $lista2[$contador_v][$j]->id_control_vacuna . ',' . $lista2[$contador_v][$j]->precio . ',' . $lista2[$contador_v][$j]->id . ') >' . $lista2[$contador_v][$j]->nombre . '</button><br>'
                                      . '<button class="btn-sm btn-info"  onclick="LPostergacionVacuna('.$gal->id_edad.')"  data-toggle="modal" data-target="#ModalListaPost">+</button></font>';
                          }


                            }
                            }

                            }
                            echo "</td>";
                         $contador_v++;


/*
                if ($lista2[$contador_v][0]->dias==0) {
                 echo "<td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'><font size=3><span id='vacuna".$gal->numero_fase."'>".$lista2[$contador_v][0]->nombre."</span> Días:<span id='dias".$gal->numero_fase."' style='color:red'>HOY</span></font></td>";
           
                }
                else{
                  echo "<td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'><font size=3><span id='vacuna".$gal->numero_fase."'>".$lista2[$contador_v][0]->nombre."</span> Días:<span id='dias".$gal->numero_fase."' style='color:red'>".$lista2[$contador_v][0]->dias."</span></font></td>";
                  
                }
          
           $contador_v++;*/

         
            } 
            else{
              echo " <td colspan=1 class=xl83 style='border-left:none; width:10.75%'>"
                            . " <button class='btn-sm btn-info'   onclick='LPostergacionVacuna(".$gal->id_edad.")'  data-toggle='modal' data-target='#ModalListaPost'>+</button></td>";
            }
           
            }
            else{
                      echo " <td colspan=1 class=xl83 style='border-left:none; width:10.75%'>"
                            . " <button class='btn-sm btn-info'   onclick='LPostergacionVacuna(".$gal->id_edad.")'  data-toggle='modal' data-target='#ModalListaPost'>+</button></td>";

            }
                                                
          }
         }    $x=$gal->numero_fase+1;////se pone en cero para  reutilizar en la tabla 2 ?>                      
      @endforeach <?php  
          for ($i=$x; $i <=3 ; $i++) { 
               echo " <td colspan=1 align='center' class=xl83 style='border-left:none; width:10.75%'></td>";
          }   $x=1;   ?> 
  </tr>  

    <tr height=22 style='height:16.5pt; background-color: YellowGreen' align="center">
        <td colspan=1 height=22 class=xl81 style='border-right:.5pt solid black;height:16.5pt; width: 8%'>EDAD</td>
        @foreach($cria_recria as $gal) <?php                   
        for ($i=$x; $i <=$gal->numero_fase;  $i++) { 
            if ($i!=$gal->numero_fase) { echo " <td colspan=1 lass=xl83 style='border-left:none; width:10.75%'></td>"; } 
            else{ echo "<td colspan=1 class=xl83 style='border-left:none; width:10.75%'><font size=4><span id='edadg".$i."'>".$gal->edad."</span></font></td> ";}
        } $x=$gal->numero_fase+1; ?> 
        @endforeach   <?php  
        for ($i=$x; $i <=3 ; $i++) { 
             echo " <td colspan=1 lass=xl83 style='border-left:none; width:10.75%'></td>";
        }   $x=1;  ?> 
    </tr> 

    <tr height=27 style='height:20.25pt; background-color: #f5bca9' align="center">
        <td colspan=1 height=27 class=xl93 style='border-right:.5pt solid black;height:20.25pt'>CANTIDAD ACTUAL</td>
        @foreach($cria_recria as $gal) <?php                   
        for ($i=$x; $i <=$gal->numero_fase;  $i++) { 
            if ($i!=$gal->numero_fase) { echo "<td colspan=1 class=xl95 style='border-top:none;border-left:none'></td>"; } 
            else{ echo "<td colspan=1 class=xl95 style='border-top:none;border-left:none'><font size=4><span id='cant_actual".$i."'>".$gal->cantidad_actual."</span></td> ";}
        } $x=$gal->numero_fase+1; ?> 
        @endforeach   <?php  
        for ($i=$x; $i <=3 ; $i++) { 
              echo "<td colspan=1 class=xl95 style='border-top:none;border-left:none'></td>";
        }   $x=1;  ?> 
    </tr> 

    <tr height=26 style='height:19.5pt' align="center">
        <td colspan=1 height=26 class=xl98 style='border-right:.5pt solid black;height:19.5pt'>MUERTAS</td>
        @foreach($cria_recria as $gal) <?php                   
        for ($i=$x; $i <=$gal->numero_fase;  $i++) { 
            if ($i!=$gal->numero_fase) { echo "<td colspan=1 class=xl95 style='border-top:none;border-left:none'></td>"; } 
            else{ echo "<td colspan=1 class=xl95 style='border-top:none;border-left:none'><font size=4><span id='muerta".$i."'>".$gal->total_muerta."</span></td> ";}
        } $x=$gal->numero_fase+1; ?> 
        @endforeach   <?php  
        for ($i=$x; $i <=3 ; $i++) { 
              echo "<td colspan=1 class=xl95 style='border-top:none;border-left:none'></td>";
        }   $x=1;  ?> 
    </tr> 

    <tr height=23 style='height:17.25pt; background-color: orange' align="center">
        <td colspan=1 height=26 class=xl98 style='border-right:.5pt solid black;height:19.5pt'>FASES</td>
        @foreach($cria_recria as $gal) <?php                   
        for ($i=$x; $i <=$gal->numero_fase;  $i++) { 
            if ($i!=$gal->numero_fase) { echo "<td colspan=1 class=xl95 style='border-top:none;border-left:none'>Vacio</td>"; } 
            else{ echo "<td colspan=1 class=xl95 style='border-top:none;border-left:none'><font size=4><span id=fase".$gal->numero_fase." >".$gal->nombre."</span></td> ";}
        } $x=$gal->numero_fase+1; ?> 
        @endforeach   <?php  
        for ($i=$x; $i <=3 ; $i++) { 
              echo "<td colspan=1 class=xl95 style='border-top:none;border-left:none'>Vacio</td>";
        }   $x=1;  ?> 
    </tr>       

    <tr height=23 style='height:17.25pt; background-color: floralwhite' align="center">
        <td rowspan=3 > 

        </td>
        @foreach($gallina_muerta as $gal) <?php                   
        for ($i=$x; $i <=$gal->numero;  $i++) { 
            if ($i!=$gal->numero) { echo " <td rowspan=3 class=xl74 style='border-bottom:.5pt solid black;border-top:none'><br><br> <font color=red> MUERTAS </font> <br> <font color=red size='4'><span id='gmdc".$i."'>0</span></font>
                <input type='number' style='width: 150px; height: 40px; font-size: 30px; text-align: center' id='gm".$i."' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(".$i.")'><br><br> </td>"; } 
            else{ echo " <td rowspan=3 class=xl74 style='border-bottom:.5pt solid black;border-top:none'> <br><br><font color=red> MUERTAS </font> <br> <font color=red size='4'><span id='gmdc".$i."'>".$gal->cantidad_muertas."</span></font>
                <input type='number' style='width: 150px; height: 40px; font-size: 30px; text-align: center' id='gm".$i."' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(".$i.")'><br><br> </td>"; }
        } $x=$gal->numero+1; ?> 
        @endforeach   <?php  
        for ($i=$x; $i <=3 ; $i++) { 
              echo " <td rowspan=3 class=xl74 style='border-bottom:.5pt solid black;border-top:none'><br><br> <font color=red> MUERTAS </font> <br> <font color=red size='4'><span id='gmdc".$i."'>0</span></font>
                <input type='number' style='width: 150px; height: 40px; font-size: 30px; text-align: center' id='gm".$i."' class='form-control' onkeypress='return bloqueo_de_punto(event)' onclick='extraer_id(".$i.")'><br><br></td>";
        }   $x=1;  ?> 
    </tr>   
</table>

    @foreach($cria_recria as $gal)
        <input type='hidden' id='id_fase_galpon{{$gal->numero_fase}}' value="{{$gal->id_fase_galpon}}">
    @endforeach

</div>
{!!Html::script('js/criarecria.js')!!}
@endsection
