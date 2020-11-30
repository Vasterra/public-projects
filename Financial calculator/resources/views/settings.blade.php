<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Settings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

                <h3 class="h3 mb-4">Order of items</h3>

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

                <div class="mb-4">
                    <form action="{{ route('save-order') }}" method="post">
                        @csrf                    
                        <div class="form-group">
                            <label for="value">Order</label>                        
                            <textarea name="value" id="value" rows="15" class="form-control">{{ $order->value }}</textarea>
                        </div>
                        <div class="form-group">
                            @foreach($indicators as $item)
                            <span class="d-inline-block p-1 mr-2 mb-2 bg-light border">{{ $item->name }}</span>
                            @endforeach
                            <br>
                            <span class="d-inline-block p-1 mr-2 mb-2 bg-light border">Empty</span>
                            @foreach($formulas as $item)
                            <span class="d-inline-block p-1 mr-2 mb-2 bg-light border">{{ $item->title }}</span>
                            @endforeach
                        </div>
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <div class="pt-2 pb-2">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
                <hr class="mb-4">
                <h3 class="h3 mb-4">Formulas</h3>
                <div class="mb-4">
                    <form action="{{ route('save-formulas') }}" method="post">
                        @csrf                        
                        @foreach($formulas as $formula)
                        <div class="form-group">
                            <div class="bg-light p-3">
                            <div class="mb-2">{{ $formula->title }}</div>                            
                                <div class="row mb-1">
                                    <div class="col-2">
                                        <label class="text-muted">Name</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="formulas[{{ $formula->id }}][name]" class="form-control" value="{{ $formula->name }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label class="text-muted">Value</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="formulas[{{ $formula->id }}][value]" class="form-control" value="{{ $formula->value }}">
                                    </div>
                                </div>
                            </div>                           
                        </div>
                        @endforeach
                        <div class="pt-2 pb-2">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>

                <hr class="mb-4">

                <h3 class="h3 mb-4">Years</h3>
                <div class="mb-4">
                    <form action="{{ route('save-years') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="bg-light p-3">                                                      
                                <div class="row mb-1">
                                    <div class="col-2">
                                        <label class="text-muted">Start year</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="number" name="years[start]" class="form-control" value="{{ $years->start }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label class="text-muted">End year</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="number" name="years[finish]" class="form-control" value="{{ $years->finish }}">
                                    </div>
                                </div>
                            </div>                           
                        </div>                        
                        <div class="pt-2 pb-2">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>