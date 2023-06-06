@extends('layouts.public.app')

@section('title','Dashboard')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.public.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-3 bg-black rounded BlocIndexDashBoard">
                    <div class="row">
                        <div class="col-9 text-white">
                            <p class="text-capitalize mt-1 fw-bold">Étapes whitelist</p>
                        </div>
                        <div class="col-3 text-light text-opacity-75">
                            <p class="text-capitalize mt-1">Status</p>
                        </div>
                    </div>
                    <div class="row mt-2"></div>
                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-9">Questionnaire</div>
                            <div class="col-3 text-center">
                                @if(auth()->user()->qcm)
                                    <i class="bi bi-check-circle" style="color: green"></i>
                                @else
                                    <i class="bi bi-question-circle" style="color: orange"></i>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-9">Entretient</div>
                            <div class="col-3 text-center">
                                @if(auth()->user()->appointment)
                                    <i class="bi bi-check-circle" style="color: green"></i>
                                @else
                                    <i class="bi bi-question-circle" style="color: orange"></i>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-9">Status Whitelist</div>
                            <div class="col-3 text-center">
                                @if(auth()->user()->isWl())
                                    <i class="bi bi-check-circle" style="color: green"></i>
                                @else
                                    <i class="bi bi-x-circle" style="color: red"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 bg-black rounded BlocIndexDashBoard">
                </div>
                <div class="col-3 bg-black rounded BlocIndexDashBoard">
                </div>
            </div>
        </div>
    </div>
@endsection
