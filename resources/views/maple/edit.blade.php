@extends('layouts.admin')
	@section('content')
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    @include('alerts.request')
<H3>ACTUALIZAR TIPO DE MAPLE</H3><br>
	{!!Form::model($maple,['route'=>['maple.update',$maple->id],'method'=>'PUT'])!!}
		@include('maple.forms.maple')
	{!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary'])!!}
	{!!Form::close()!!}
	</div>
</div>
@endsection