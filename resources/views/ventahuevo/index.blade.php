@extends ('layouts.admin')
@section ('content')
@include('alerts.success')
@include('alerts.cargando')
@include('alerts.errors')
 <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
	@include('ventahuevo.modal')	
<style type="text/css">
    table{
        border-spacing: 0px;
        border-collapse: separate;
    }
    td{
        padding: 5px;
    }
</style>
<div class="pull-left"><h1>LISTA VENTA DE HUEVOS DESCARTES</h1></div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
    <div class="col-sm-1 col-md-1  col-sm-1  col-xs-12 pull-right" style="width: 15%; margin: 0px; padding: 0px">
      <div class="form-group"> <a href="detalleventahuevo" class="btn btn-success">AGREGAR</a> </div>
    </div>

    <div class="col-sm-1 col-md-1  col-sm-1  col-xs-12 pull-right" style="width: 15%; margin: 0px; padding: 0px">
      <div class="form-group"> <button class="btn btn-danger" onclick="cargar_lista_venta_huevo()">MOSTRAR</button> </div>
    </div>

    <div class="col-sm-3  col-md-3  col-sm-3  col-xs-12 pull-right" style=" margin: 0px; padding: 0px">
      <div class="form-group">
        <div class='input-group date' id='datetimepicker1'>
          <input type='text' class="form-control" id="fecha_fin" style="font-size:20px;text-align:center" />
          <span class="input-group-addon ">
             <span class="fa fa-calendar" aria-hidden="true"></span> 
          </span>
        </div>
      </div>
    </div>

    <div class="col-sm-1 col-md-1  col-sm-1  col-xs-12 pull-right" style="margin: 0px; padding: 0px">
      <div class="form-group">  <B>HASTA: </B> </div>
    </div>

    <div class="col-sm-3  col-md-3  col-sm-3  col-xs-12 pull-right" style=" margin: 0px; padding: 0px">
      <div class="form-group">
        <div class='input-group date' id='datetimepicker2'>
          <input type='text' class="form-control" id="fecha_inicio" style="font-size:20px;text-align:center" />
          <span class="input-group-addon ">
             <span class="fa fa-calendar" aria-hidden="true"></span> 
          </span>
        </div>
      </div>
    </div>

    <div class="col-sm-1 col-md-1  col-sm-1  col-xs-12 pull-right" style="margin: 0px; padding: 0px">
      <div class="form-group">  <B>DESDE: </B> </div>
    </div>    
</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">	
	<!--div class="pull-left"> <h1>LISTA DE VENTAS DE MAPLES</h1> </div>
	<div class="pull-right"> <a href="detalleventahuevo" class="btn btn-success">AGREGAR</a></div-->		
	<!---table class="table table-striped table-bordered table-condensed table-hover"-->
  <table width="1445">  
		<tr align="center" style="background-color: black; color: white">
			<td width=500>FECHA</td>
			<td width=500>SALDO</td>
			<td width=500>OPCION</td>				
		</tr>
  </table>

  <div style="overflow-x:auto; height: 500px">
  <table style="table-layout:fixed">
		@if(Auth::user()==null) 
      <tbody id="datos_huevos" data-status=0></tbody>      
    @endif  
    
    @if(Auth::user()!=null) 
      <tbody id="datos_huevos" data-status=1></tbody>
    @endif  
  </table>
  </div>

		<?php /*@foreach($venta_huevo as $can)
		<tr align="center">
			<td>{{ $can->fecha}}</td>
			<td>{{ $can->precio}} Bs.</td>
			<td><button id="detalle{{$can->id}}" class="btn btn-primary" data-toggle='modal' data-target='#myModal' onclick="cargartabla_ventahuevo({{$can->id}})"><i class="fa fa-navicon" aria-hidden="true"></i> DETALLE</button> 
			<button id="detalle{{$can->id}}" class="btn btn-danger" data-toggle='modal' data-target='#myModal_anular' onclick="cargartabla_anular_huevo({{$can->id}})"><i class="fa fa-remove" aria-hidden="true"></i> ANULAR VENTA</button> 
			<!--{!!link_to_route('ventahuevo.show', $title = 'ANULAR VENTA', $parameters = $can->id, $attributes = ['class'=>'btn btn-danger'])!!}--></td>						
		</tr>					
		@endforeach*/ ?>
	<?php //{!!$venta_huevo->render()!!} ?>
	</div>
</div>

<script src="{{asset('js/ventahuevo.js')}}"></script> 
@endsection
