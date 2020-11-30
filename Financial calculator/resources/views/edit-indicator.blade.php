<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Forecast data &rarr; Edit forecast data
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                
                @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="d-flex justify-content-end">
                    <form action="/indicators/delete" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $indicator->id }}">
                        <button type="submit" class="btn btn-light">Delete</button>
                    </form>
                </div>

                <form action="/indicators/update" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $indicator->name }}">
                    </div>
                    <div class="form-group">
                        <label for="order">Оrder</label>
                        <input type="number" name="order" id="order" class="form-control" value="{{ $indicator->order }}">
                    </div>                    
                    <input type="hidden" name="id" value="{{ $indicator->id }}">
                    <div class="pt-2 pb-2">                        
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>