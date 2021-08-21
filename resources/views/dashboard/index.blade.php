@extends('layouts.page')

@section('content')
    <h2>Dashboard</h2>
    <div x-data="{ open: false }">
        <button x-on:click="open = !open">Toggle Alpine JS</button>

        <span x-cloak x-show="open">
            Alpine Content...
        </span>
    </div>
@endsection
