@extends('layouts.admin')
	@section('content')
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    @include('alerts.request')
<H3>ACTUALIZAR TEMPERATURA</H3><br>
	{!!Form::model($temperatura,['route'=>['temperatura.update',$temperatura->id],'method'=>'PUT'])!!}
		@include('temperatura.forms.temperatura')
	{!!Form::submit('ACTUALIZAR',['class'=>'btn btn-primary'])!!}
	{!!Form::close()!!}
	</div>
</div>
@endsection