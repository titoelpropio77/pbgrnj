@extends('layouts.admin')
	@section('content')
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    @include('alerts.request')

	{!!Form::model($galpon,['route'=>['galpon.update',$galpon->id],'method'=>'PUT'])!!}
		@include('galpon.forms.galponupdate')
	{!!Form::submit('Actializar',['class'=>'btn btn-primary'])!!}
	{!!Form::close()!!}
	</div>
</div>
	@endsection