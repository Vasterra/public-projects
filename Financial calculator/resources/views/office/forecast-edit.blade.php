@extends('layouts/office')

@section('content')
<div>
	<h1 class="h4 mb-4">{{ $title }}</h1>
	
	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">

		<div class="pl-4 pr-4 pb-2 pt-2 mb-4" style="background-color: #f4f4f4;">
			<span class="d-inline-block">Created: {{ $forecast->date }}</span>
			<span class="d-inline-block border-left pl-3 ml-3">Company: {{ $forecast->company_name }}</span>
		</div>

		@if($errors->any())
		<div class="_red mb-3">
		    <ul>
		        @foreach($errors->all() as $error)
		        <li>{{ $error }}</li>
		        @endforeach
		    </ul>
		</div>
		@endif

		@if(session('success'))
		<div class="text-success mb-3">{{ session('success') }}</div>
		@endif

		<form action="{{ route('office-forecast-update') }}" method="post">
			@csrf
			<input type="hidden" value="{{ $forecast->id }}" name="id">
			<div class="row">
				<div class="col-2 text-right">
					<h5 class="h6 _red"><label for="forecast">Forecast Overview</label></h5>
				</div>
				<div class="col-10">
					<div class="mb-4">
						<data-textarea datatext="{{ $forecast->overview }}" maxcount="{{ config('app.options.max_count_overview') }}" name="overview"></data-textarea>
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit" class="btn btn-success">Save</button>
					</div>
				</div>
			</div>
		</form>
		
	</div>

	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">		
		<data-forecast-table companyid="{{ $forecast->company_id }}" forecastid="{{ $forecast->id }}" userid="{{ $forecast->user_id }}"></data-forecast-table>
	</div>

	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">
		<h5 class="h6 _red mb-4">Delete Forecast</h5>
		<form action="{{ route('office-delete-forecast') }}" method="post">
			@csrf
			<input type="hidden" name="id" value="{{ $forecast->id }}">
			<div class="mb-3">
				<span class="d-inline-block mr-2">
					<input id="delete_forecast_confirm" name="delete_forecast_confirm" type="checkbox">
				</span>
				<label for="delete_forecast_confirm">I confirm the deletion of the Forecast</label>
			</div>
			<div class="mb-3">
				<button type="submit" class="btn btn-outline-danger">Delete Forecast</button>
			</div>
		</form>
	</div>
	
</div>
@endsection