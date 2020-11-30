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
                    <h3 class="h3">User Comment</h3>                    
                    <data-accept-comment commentid="{{ $comment->id }}" checked="{{ $comment->checked }}"></data-accept-comment>         
                    <div class="h6 bg-light pt-2 pb-2 pr-3 pl-3 d-inline-block"><a href="/users/profile/{{ $user->id }}" class="_link">{{ $user->name }}</a></div>
                </div>

                <div class="row mb-4">
                    <div class="col-2 text-right">
                        <h5 class="h6"><label>Comment</label></h5>
                    </div>
                    <div class="col-10">
                        <div>
                            <textarea class="form-control" rows="5" readonly="readonly">{{ $comment->comment }}</textarea>
                        </div>                        
                    </div>
                </div>                

            </div>            
                
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <h5 class="h5 mb-5">Delete User Comment</h5>
                <form action="{{ route('user-delete-comment') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $comment->id }}">
                    <input type="hidden" name="user" value="{{ $comment->user_id }}">
                    <div class="mb-3">
                        <span class="d-inline-block mr-2">
                            <input id="delete_comment_confirm" name="delete_comment_confirm" type="checkbox">
                        </span>
                        <label for="delete_comment_confirm">Confirm comment deletion</label>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-outline-danger">Delete Comment</button>
                    </div>
                </form>
            </div>            

        </div>
    </div>
</x-app-layout>