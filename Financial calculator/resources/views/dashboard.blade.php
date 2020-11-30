<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

                @if(count($data))
                <div class="row">
                    @foreach($data as $item)
                    <div class="col-6 mb-4">
                        <div class="card text-center">
                          <div class="card-body">
                            <h4 class="card-title h4">{{ $item['title'] }}</h5>
                            <p class="card-text">{{ $item['title_2'] }}</p>
                            <p class="h3">
                                {{ $item['count'] }}
                                @if(isset($item['new']) && $item['new'])
                                <span class="d-inline-block h6 text-success">+{{ $item['new'] }}</span>
                                @endif
                            </p>
                            <a href="{{ route($item['route']) }}" class="btn btn-primary">{!! $item['btn_text'] !!}</a>
                          </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
