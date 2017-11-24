@extends('layouts.admin')
@section('content')
@include('alerts.cargando')
@include('alerts.success')
@include('alerts.request')
@include('control_vacuna.modal')

<style type="text/css">
    table{
        border-spacing: 0px;
        border-collapse: separate;
    }
    td{
        padding: 5px;
    }
</style>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel panel-green">
        <div class="panel-heading">
              <ul class="nav nav-pills">
                <li class="active"><a href="{!!URL::to('vacuna')!!}">REGISTRAR VACUNAS</a></li>
                <li class="active"><a href="{!!URL::to('lista_control_vacuna')!!}">LISTA DE CONTROL DE VACUNAS</a></li>    
                <li class="active"><a href="{!!URL::to('vacuna_emergente')!!}">LISTA DE VACUNAS EMERGENTES</a></li>                                    
                <li class="active"><a href="{!!URL::to('consumo_vacuna_emergente')!!}">LISTA CONSUMO VACUNAS</a></li> 

            </ul>
        </div> 
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
           

<div class="pull-left"> <font size="6">CONTROL DE VACUNAS </font>   <font size="6" id="xxx"> </font> </div>

<div class="pull-right"><button class="btn btn-danger" onclick="mostrar_vacunas()">MOSTRAR</button>
<button class="btn btn-success" id="btn_agregar" data-toggle='modal' data-target='#myModalControl' onclick="cargar_id()">AGREGAR</button></div> 
<div class="pull-right">{!!Form::select('id_galponcv',[],null,['id'=>'id_galponcv'])!!} </div>   

    <input type="hidden" name="_token" value="{{ csrf_token()}}" id="token">
    <table width="1445">    
    <!--table class="table table-striped table-bordered table-condensed table-hover"-->
        <thead bgcolor=black style="color: white; font-size: 16px">
        <th width="160"><center>EDAD</center></th>
        <th width="110"><center>VACUNA</center></th>
        <th width="500"><center>METODO DE APLICACION</center></th>
        <th width="350"><center>ESTADO</center></th>
        </thead>
    </table>

    <div style="overflow-x:auto; height: 500px">    
    <table style="table-layout:fixed">
        <tbody id="datos_vac">
            
        </tbody>
    </table>
    </div>

  </div>
</div>
<script src="{{asset('js/control_vacuna.js')}}"></script> 
@endsection




