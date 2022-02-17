@extends('layouts.page')

@section('content')
<h2>Dashboard</h2>

<div class="row row-cols-1 row-cols-md-2 g-4">
    @foreach ($charts as $chart)
    <div class="{{ $chart['class'] ?? 'col-md-4 col-sm-12'}}">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $chart['title'] ?? null}}</h5>
                <div class="w-100">
                    {!! ($chart['chart'] ?? null) ? $chart['chart']->render() : '' !!}
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

</script>
@endsection
