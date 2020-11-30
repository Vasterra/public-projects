@extends('layouts/office')

@section('content')
<div>

	<h1 class="h4 mb-4">{{ $title }}</h1>

	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">

		@if(session('success-delete-forecast'))
		<div class="_red mb-3">{{ session('success-delete-forecast') }}</div>
		@endif

		@if(count($forecasts))
			@foreach($forecasts as $forecast)
				<div class="mb-4 pb-4 border-bottom">
					<div class="mb-4">
						<span class="d-inline-block font-italic">Date: {{ $forecast->date }}</span>
						<span class="d-inline-block font-italic border-left pl-3 ml-3">Company: {{ $forecast->company_name }}</span>
						<span class="d-inline-block border-left pl-3 ml-3">
							<a href="/office/forecasts/edit/{{ $forecast->id }}" class="_link">Edit</a>
						</span>
					</div>
					<div>
						{{ $forecast->overview }}
					</div>
				</div>
			@endforeach
			{{ $forecasts->links() }}
			
		@else
			<p>No forecasts found.</p>
		@endif		
	</div>
	
</div>
@endsection