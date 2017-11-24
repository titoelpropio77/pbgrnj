  
{!!Form::hidden('id',null,['class'=>'form-control','readonly'])!!}

<div class="form-group">
    {!!Form::label('numero','Numero:')!!}
    {!!Form::text('numero',null,['class'=>'form-control','onkeypress'=>'return bloqueo_de_punto(event)'])!!}
</div>
<div class="form-group">
    {!!Form::label('nombre','Nombre:')!!}
    {!!Form::text('nombre',null,['class'=>'form-control'])!!}
</div>
<div class="form-group">
    {!!Form::label('capacidad','Capacidad:')!!}
    {!!Form::text('capacidad',null,['class'=>'form-control','placeholder'=>'Ingresa La Capacidad Del Silo','onkeypress'=>'return numerosmasdecimal(event)'])!!}
</div>
<div class="form-group">
    {!!Form::label('cantidad','Cantidad Actual:')!!}
    {!!Form::text('cantidad',null,['class'=>'form-control','placeholder'=>'Ingresa La Cantidad Del Silo','onkeypress'=>'return numerosmasdecimal(event)'])!!}
</div>
<div class="form-group">
    {!!Form::label('cantidad_minima','Cantidad Minima:')!!}
    {!!Form::text('cantidad_minima',null,['class'=>'form-control','placeholder'=>'Ingresa La Cantidad Minima Del Silo','onkeypress'=>'return numerosmasdecimal(event)'])!!}
</div>
<div class="form-group">
    {!!Form::label('id_tipo','Tipo de Alimento:')!!}
    {!!Form::select('id_alimento',$alimento,null,array('class'=>'form-control'))!!}
</div>
