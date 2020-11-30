<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

                <div class="mb-3">
                    <h3 class="h3">Users</h3>
                </div>

                @if(session('success-delete'))
                <div class="alert alert-danger mb-3">{{ session('success-delete') }}</div>
                @endif                

                @if(count($users))

                <table class="table">
                    <tbody>
                        <tr class="bg-light">
                            <td>Name</td>
                            <td>Email</td>
                            <td>Registered</td>
                            <td>Forecasts</td>
                            <td>Comments</td>
                        </tr>
                        @foreach($users as $user)
                        <tr>
                            <td><a href="/users/profile/{{ $user->id }}" class="_link">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->date }}</td>
                            <td>
                                @if( $user->count_forecasts )
                                <a href="/users/forecasts/{{ $user->id }}" class="_link">{{ $user->count_forecasts }}</a>
                                @else
                                    {{ $user->count_forecasts }}
                                @endif
                            </td>
                            <td>
                                @if( $user->count_comments )
                                <a href="/users/comments/{{ $user->id }}" class="_link">{{ $user->count_comments }}</a>
                                @else
                                    {{ $user->count_comments }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
                @endif

            </div>
        </div>
    </div>
</x-app-layout>