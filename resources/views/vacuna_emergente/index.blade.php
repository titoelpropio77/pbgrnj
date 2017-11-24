@extends('layouts.admin')
@section('content')
@include('alerts.cargando')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

@include('vacuna_emergente.modalagregar')

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel panel-green">
        <div class="panel-heading">
              <ul class="nav nav-pills">
                <li class="active"><a href="{!!URL::to('vacuna')!!}">REGISTRAR VACUNAS</a></li>
                <li class="active"><a href="{!!URL::to('lista_control_vacuna')!!}">LISTA DE CONTROL DE VACUNAS</a></li>  
                <li class="active"><a href="{!!URL::to('vacuna_emergente')!!}">LISTA DE VACUNAS EMERGENTES</a></li>   
                <li class="active"><a href="{!!URL::to('consumo_vacuna_emergente')!!}">LISTA DE CONSUMO VACUNAS</a></li>                                
            </ul>
        </div> 
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
 <div class="pull-left"> <h2>VACUNAS DE EMERGENCIA</h2> </div>
  <div class="pull-right"> <button class="btn btn-success"  data-toggle='modal' data-target='#ModalCreate'>AGREGAR</button> </div> <br><br>

                <input type="hidden" name="_token" value="{{ csrf_token()}}" id="token">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead bgcolor=black style="color: white">
                    <th><center>VACUNA</center></th>                    
                    <th><center>METODO DE APLICACION</center></th>
                    <!--th><center>PRECIO</center></th-->
                    <th><center>ESTADO</center></th>
                    <th><center>OPCION</center></th>
                    </thead>

                    @foreach ($vacuna as $vac)
                    <TR style="background-color:white" onmouseover="this.style.backgroundColor='#F6CED8'" onmouseout="this.style.backgroundColor='white'">    
                    <td align="center">{{$vac->nombre}}</td>
                    <td align="left">{{$vac->detalle}}</td>
                    <!--td align="center">{{$vac->precio}} Bs.</td-->
                    <td align="center">  <?php
                        if ($vac->estado == 1) {
                            echo '<button value="' . $vac->id . '" id="idbotonnestado" onclick="cambiarestado(0,this)" class="btn btn-success">ACTIVO</button>';
                        } else
                            echo '<button value="' . $vac->id . '" id="idbotonnestado"  onclick="cambiarestado(1,this)" class="btn btn-warning">INACTIVO</button>';
                        ?></center></td>
                    <td align="center">
                        {!!link_to_route('vacuna_emergente.edit', $title = 'ACTUALIZAR', $parameters = $vac->id, $attributes = ['class'=>'btn btn-primary','style'=>'color: white'])!!}
                        <button class="btn btn-info" data-toggle='modal' data-target='#ModalConsumoEmergente' onclick="cargar_modal_vac_emer({{$vac->id}},{{$vac->precio}},'{{$vac->nombre}}','{{$vac->detalle}}')">CONSUMIR VACUNA</button>
                        <button class="btn btn-danger" data-toggle='modal' data-target='#ModalEliminarVacunaEmergente' onclick="CargarModalEmerEliminar({{$vac->id}},'{{$vac->nombre}}')">ELIMINAR</button></td>
                    </TR>
                    @endforeach 
                </table>
                {!!$vacuna->render()!!}
            </div>
    </div>
<script src="{{asset('js/vacuna_emergente.js')}}"></script> 
@endsection




