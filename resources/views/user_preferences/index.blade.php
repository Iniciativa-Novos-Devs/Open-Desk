@extends('layouts.page')

@section('content')
<div class="col-12">
    <h5>Preferencias do usuario</h5>

    <hr>

    <h6>Preferencias desta sessão</h6>
    <pre>
        {{ json_encode($session_user_preferences, 128) }}
    </pre>
</div>
@endsection
