<div class="w-100">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('error') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div class="alert alert-info" role="alert">
            {{ session()->get('info') }}
        </div>
    @endif

    @if (session()->has('warning'))
        <div class="alert alert-warning" role="alert">
            {{ session()->get('warning') }}
        </div>
    @endif
</div>
