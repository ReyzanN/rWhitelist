@if(Session::exists('Failure'))
    <div class="row d-flex justify-content-center align-items-center">
        <div class="alert alert-danger w-75 text-center" role="alert">
            <i class="bi bi-exclamation-triangle"></i>&nbsp;{{ Session::get('Failure') }}
        </div>
    </div>
@endif
@if(Session::exists('Success'))
    <div class="row d-flex justify-content-center align-items-center">
        <div class="alert alert-success w-75 text-center" role="alert">
            <i class="bi bi-check-circle"></i>&nbsp;{{ Session::get('Success') }}
        </div>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
