<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-5">
                
                <div class="mb-3 d-flex justify-content-between align-items-xl-center">
                    <h3 class="h3">User Forecast</h3>
                    <data-accept-forecast forecastid="{{ $forecast->id }}" checked="{{ $forecast->checked }}"></data-accept-forecast>
                    <div class="h6 bg-light pt-2 pb-2 pr-3 pl-3"><a href="/users/profile/{{ $user->id }}" class="_link">{{ $user->name }}</a></div>
                </div>

                <div class="row mb-4">
                    <div class="col-2 text-right">
                        <h5 class="h6"><label>Forecast Overview</label></h5>
                    </div>
                    <div class="col-10">
                        <div>
                            <textarea class="form-control" rows="5" readonly="readonly">{{ $forecast->overview }}</textarea>
                        </div>                        
                    </div>
                </div>

                <div class="mb-4">
                    <data-forecast-table companyid="{{ $forecast->company_id }}" forecastid="{{ $forecast->id }}" userid="{{ $forecast->user_id }}" type="{{ $forecast->type }}"></data-forecast-table>
                </div>

            </div>            
                
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <h5 class="h5 mb-5">Delete User Forecast</h5>
                <form action="{{ route('user-delete-forecast') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $forecast->id }}">
                    <input type="hidden" name="user" value="{{ $forecast->user_id }}">
                    <div class="mb-3">
                        <span class="d-inline-block mr-2">
                            <input id="delete_forecast_confirm" name="delete_forecast_confirm" type="checkbox">
                        </span>
                        <label for="delete_forecast_confirm">Confirm forecast deletion</label>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-outline-danger">Delete Forecast</button>
                    </div>
                </form>
            </div>

            

        </div>
    </div>
</x-app-layout>