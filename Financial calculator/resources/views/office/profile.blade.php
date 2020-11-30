@extends('layouts/office')

@section('content')
<div>
	<h1 class="h4 mb-4">{{ $title }}</h1>
	
	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">
		<h5 class="h6 mb-5 _red">Name and Email</h5>		

		@if(session('success-info'))
		<div class="text-success mb-3">{{ session('success-info') }}</div>
		@endif		

		<form action="{{ route('update-personal-info') }}" method="post">
			@csrf
			<div class="row mb-3">
				<div class="col-2 text-right">
					<label for="name">Name</label>
				</div>
				<div class="col-10">
					<input type="text" id="name" name="name" value="{{ Auth::user()->name }}" class="form-control" required="required">
					@error('name')
					    <div class="_red">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-2 text-right">
					<label for="email">Email</label>
				</div>
				<div class="col-10">
					<input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="form-control" required="required">
					@error('email')
					    <div class="_red">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="pt-2 d-flex justify-content-end">
				<button type="submit" class="btn btn-success">Save</button>
			</div>			
		</form>
	</div>

	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">
		<h5 class="h6 mb-5 _red">Password</h5>		

		<form action="{{ route('update-personal-password') }}" method="post">
			@csrf
			<div class="row mb-3">
				<div class="col-2 text-right">
					<label for="password">New Password</label>
				</div>
				<div class="col-10">
					<input type="password" id="password" name="password" value="" class="form-control" required="required">
					@error('password')
					    <div class="_red">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-2 text-right">
					<label for="password_confirmation">Confirm Password</label>
				</div>
				<div class="col-10">
					<input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control" required="required">
					@error('password_confirmation')
					    <div class="_red">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="pt-2 d-flex justify-content-end">
				<button type="submit" class="btn btn-success">Save</button>
			</div>
		</form>
	</div>

	<div class="bg-white pl-5 pr-5 pb-5 pt-4 mb-5 box-content">		
		<h5 class="h6 mb-5 _red">Delete Account</h5>
		<form action="{{ route('delete-account') }}" method="post">
			@csrf
			<div class="mb-3">
				<span class="d-inline-block mr-2">
					<input id="delete_account_confirm" name="delete_account_confirm" type="checkbox">
				</span>
				<label for="delete_account_confirm">I confirm the deletion of my account</label>
			</div>
			<div class="mb-3">
				<button class="btn btn-outline-danger">Delete Account</button>
			</div>
		</form>		
	</div>
	
</div>
@endsection