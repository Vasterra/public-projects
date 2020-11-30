<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                
                <div class="mb-3 d-flex justify-content-between align-items-xl-center">
                    <h3 class="h3">User Forecasts</h3>
                    <div class="h6 bg-light pt-2 pb-2 pr-3 pl-3"><a href="/users/profile/{{ $user->id }}" class="_link">{{ $user->name }}</a></div>
                </div>

                @if(session('success-delete'))
                <div class="alert alert-danger mb-3">{{ session('success-delete') }}</div>
                @endif

                @if(count($forecasts))
                    @foreach($forecasts as $forecast)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="mb-3">
                                <small class="d-inline-block font-italic">Date: {{ $forecast->date }}</small>
                                <small class="d-inline-block font-italic border-left pl-3 ml-3">Company: {{ $forecast->company_name }}</small>                                
                            </div>
                            <div>
                                <a href="/users/forecast/{{ $forecast->id }}/{{ $user->id }}" class="_link">{{ $forecast->overview }}</a>
                            </div>
                        </div>
                    @endforeach
                    {{ $forecasts->links() }}
                @else
                    <p>No Forecasts found.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>