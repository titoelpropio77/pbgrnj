

<div class="form-group">
    {!!Form::label('nombre','Nombre:')!!}
    {!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Ingresa El Nombre De La Vacuna'])!!}
</div>

<div class="form-group">
    {!!Form::label('detalle','Metodo De Aplicacion:')!!}
    {!!Form::textarea('detalle',null,['class'=>'form-control','rows'=>'3','placeholder'=>'Ingresa El Metodo De Aplicacion'])!!}
</div>

<?php /*<div class="form-group">
  {!!Form::label('precio','Precio:')!!}*/ ?>
  {!!Form::hidden('precio',null,['id'=>'precio','class'=>'form-control','rows'=>'3','placeholder'=>'Ingrese El Precio','onkeypress'=>'return numerosmasdecimal(event)'])!!}
<!--/div-->