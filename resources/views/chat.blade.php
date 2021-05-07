@extends('layouts.app')

@section('content')
<div class="container">
    <chat currentuserid={{ auth()->user()->id }} />
</div>
@endsection