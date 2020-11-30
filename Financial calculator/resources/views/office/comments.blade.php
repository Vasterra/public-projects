@extends('layouts/office')

@section('content')
<div>
	<h1 class="h4 mb-4">{{ $title }}</h1>
	
	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">

		@if(session('success-delete-comment'))
		<div class="_red mb-3">{{ session('success-delete-comment') }}</div>
		@endif

		@if(count($comments))
			@foreach($comments as $comment)
				<div class="mb-4 pb-4 border-bottom">
					<div class="mb-4">
						<span class="d-inline-block font-italic">Date: {{ $comment->date }}</span>
						<span class="d-inline-block font-italic border-left pl-3 ml-3">Company: {{ $comment->company_name }}</span>
						<span class="d-inline-block border-left pl-3 ml-3">
							<a href="/office/comments/edit/{{ $comment->id }}" class="_link">Edit</a>
						</span>
					</div>
					<div>
						{{ $comment->comment }}
					</div>
				</div>
			@endforeach
			{{ $comments->links() }}
		@else
			<p>No comments found.</p>
		@endif		
	</div>
	
</div>
@endsection