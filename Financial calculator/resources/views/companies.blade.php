<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Companies
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

                @if(session('success-delete'))
                <div class="alert alert-danger">{{ session('success-delete') }}</div>
                @endif
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h3">Companies</h3>
                    <a href="{{ route('add-company') }}" class="btn btn-secondary" >Add company</a>                    
                </div>

                @if(count($companies))

                <table class="table">
                    <tbody>                        
                        <tr class="bg-light">
                            <td>Company</td>
                            <td>Currency</td>
                            <td>Units</td>
                            <td>End year</td>
                            <td>Visibility</td>
                            <td></td>
                        </tr>
                        @foreach($companies as $item)                        
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->currency }} - {{ $item->currency_symbol }}</td>
                            <td>{{ $item->units }} - {{ $item->units_symbol }}</td>
                            <td>{{ $item->yearfinish }}</td>
                            <td>
                                @if($item->visible)
                                <span>Yes</span>
                                @else
                                <span>No</span>
                                @endif                                
                            </td>
                            <td><a href="/companies/edit/{{ $item->id }}" class="_link">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $companies->links() }}
                @endif

            </div>
        </div>
    </div>
</x-app-layout>