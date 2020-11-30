<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Forecast data
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                
                @if(session('success-delete'))
                <div class="alert alert-danger">{{ session('success-delete') }}</div>
                @endif

                <h3 class="h3 mb-4">Forecast data</h3>

                @if(count($indicators))
                <table class="table mb-4"><tbody>
                    <tr class="bg-light">
                        <td>Name</td>
                        <td>Order</td>
                        <td></td>
                    </tr>
                @foreach($indicators as $item)
                    <tr class="indicator-{{ $item->id }}">
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->order }}</td>
                        <td><a href="/indicators/edit/{{ $item->id }}" class="_link">Edit</a></td>
                    </tr>
                @endforeach
                </tbody></table>
                @endif

                <h3 class="h3">Add forecast data</h3>

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

                <form action="/indicators/save" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="number" name="order" id="order" class="form-control" value="{{ old('order') }}">
                    </div>                    
                    <div class="pt-2 pb-2">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>