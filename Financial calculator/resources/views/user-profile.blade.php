<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-4">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h3 class="h3">User Profile</h3>
                    <div>
                        <span class="d-inline-block mr-4">Forecasts:                            
                            @if( $user->count_forecasts )
                            <a href="/users/forecasts/{{ $user->id }}" class="_link">{{ $user->count_forecasts }}</a>
                            @else
                                {{ $user->count_forecasts }}
                            @endif
                        </span>
                        <span class="d-inline-block">Comments:                            
                            @if( $user->count_comments )
                            <a href="/users/comments/{{ $user->id }}" class="_link">{{ $user->count_comments }}</a>
                            @else
                                {{ $user->count_comments }}
                            @endif
                        </span>
                    </div>
                </div>                
                <div class="row mb-3">
                    <div class="col-2 text-right">
                        <label for="name">Registered</label>
                    </div>
                    <div class="col-10">
                        {{ $user->date }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2 text-right">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-10">
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" readonly="readonly">                        
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2 text-right">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-10">
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" readonly="readonly">                        
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <h5 class="h5 mb-5">Delete User Account</h5>
                <form action="{{ route('user-delete-account') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="mb-3">
                        <span class="d-inline-block mr-2">
                            <input id="delete_account_confirm" name="delete_account_confirm" type="checkbox">
                        </span>
                        <label for="delete_account_confirm">Confirm account deletion</label>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-outline-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>