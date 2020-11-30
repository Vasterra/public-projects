<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Forecasts
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

                @if(session('success-delete'))
                <div class="alert alert-danger">{{ session('success-delete') }}</div>
                @endif
                
                <div class="mb-3">
                    <h3 class="h3">Forecasts</h3>                                        
                </div>

                @if(count($forecasts))
                    @foreach($forecasts as $forecast)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="mb-3">                                
                                <small class="d-inline-block font-italic">Date: {{ $forecast->date }}</small>
                                <small class="d-inline-block font-italic border-left pl-3 ml-3">User: {{ $forecast->user_name }}</small>
                                <small class="d-inline-block font-italic border-left pl-3 ml-3">Company: {{ $forecast->company_name }}</small>
                                @if(!$forecast->checked)
                                <div class="d-inline-block pl-2 pr-2 pt-1 pb-1 ml-3 bg-light">
                                    <small class="d-inline-block text-success">New!</small>
                                </div>
                                @endif
                            </div>
                            <div>
                                <a href="/users/forecast/{{ $forecast->id }}/{{ $forecast->user_id }}" class="_link">{{ $forecast->overview }}</a>
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