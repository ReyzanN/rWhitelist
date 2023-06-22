@extends('layouts.admin.app')

@section('title','Admin - Logs')

@section('content')
    @include('layouts.admin.nav')

    <div class="container">

        <div class="row mt-5">
            @include('layouts.admin.errors')
        </div>

        <div class="row mt-5">
            <div class="d-flex justify-content-center align-items-center">
                <div class="card" style="width: 18rem;">
                    <div class="card-img-top d-flex justify-content-center align-items-center">
                        <i class="bi bi-newspaper" style="font-size: 3rem"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Gestion des log</h5>
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('log.clear.routing.all') }}"><button class="btn btn-primary">Clear routing log</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="bi bi-stack"></i>&nbsp;Statistique
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
