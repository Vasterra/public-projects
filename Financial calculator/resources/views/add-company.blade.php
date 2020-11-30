<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Companies &rarr; {{ $title }}
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

                @if($company->id)
                <div class="d-flex justify-content-end">
                    <form action="/companies/delete" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $company->id }}">
                        <button type="submit" class="btn btn-light">Delete</button>
                    </form>
                </div>
                @endif

                <form action="/add-company/save" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $company->id }}">

                    <div class="form-group">
                        <label for="name">Name company</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $company->name  }}">
                    </div>

                    <div class="row mb-4">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="currency">Currency</label> 
                                <select name="currency" id="currency" class="form-control">
                                    {!! $currency_options !!}
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="units">Units</label>
                                <select name="units" id="units" class="form-control">
                                    {!! $units_options !!}
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="yearfinish">End year for the client</label>
                                <select name="yearfinish" id="yearfinish" class="form-control">
                                    {!! $yearfinish_options !!}
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="d-block">Visibility</label>
                                <div class="form-check form-check-inline">
                                  <input type="checkbox" name="visible" id="visible" class="form-check-input"  value="1" 
                                  @if($company->visible)
                                  checked
                                  @endif
                                  >
                                  <label class="form-check-label" for="visible">Visible</label>
                                </div>
                            </div>
                        </div>
                    </div>             
                    
                    <data-addcompany companyid="{{ $company->id }}"></data-addcompany>
                    
                </form>

            </div>
        </div>
    </div>
</x-app-layout>