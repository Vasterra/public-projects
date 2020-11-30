@extends('layouts/office')

@section('content')
<div>
	<h1 class="h4 mb-4">{{ $title }}</h1>
	
	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">

		<div class="pl-4 pr-4 pb-2 pt-2 mb-4" style="background-color: #f4f4f4;">
			<span class="d-inline-block">Created: {{ $comment->date }}</span>
			<span class="d-inline-block border-left pl-3 ml-3">Company: {{ $comment->company_name }}</span>
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
		<div class="text-success">{{ session('success') }}</div>
		@endif

		<form action="{{ route('office-comment-update') }}" method="post">			
			@csrf
			<input type="hidden" value="{{ $comment->id }}" name="id">
			<div class="row">				
				<div class="col-2 text-right">
					<label for="comment">Comment</label>
				</div>
				<div class="col-10">
					<div class="mb-4">
						<textarea rows="5" name="comment" type="text" class="form-control">{{ $comment->comment }}</textarea>
					</div>
					<div class="d-flex justify-content-end">						
						<button type="submit" class="btn btn-success">Save</button>
					</div>
				</div>
			</div>
			
		</form>
		
	</div>

	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">		
		<h5 class="h6 _red mb-4">Delete Comment</h5>
		<form action="{{ route('office-delete-comment') }}" method="post">
			@csrf
			<input type="hidden" name="id" value="{{ $comment->id }}">
			<div class="mb-3">
				<span class="d-inline-block mr-2">
					<input id="delete_comment_confirm" name="delete_comment_confirm" type="checkbox">
				</span>
				<label for="delete_comment_confirm">I confirm the deletion of the Comment</label>
			</div>
			<div class="mb-3">
				<button type="submit" class="btn btn-outline-danger">Delete Comment</button>
			</div>
		</form>
	</div>
	
</div>
@endsection