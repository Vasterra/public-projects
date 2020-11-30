@extends('layouts/home')

@section('content')
<div>
	<data-table maxoverview="{{ config('app.options.max_count_overview') }}" maxcomment="{{ config('app.options.max_count_comment') }}"></data-table>
</div>
@endsection