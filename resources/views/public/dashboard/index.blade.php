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
                            <div class="col-3 text-center">NON</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-9">Entretient</div>
                            <div class="col-3 text-center">OUI</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-9">Status Whitelist</div>
                            <div class="col-3 text-center">NON</div>
                        </div>
                    </div>
                </div>
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
                            <div class="col-3 text-center">NON</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-9">Entretient</div>
                            <div class="col-3 text-center">OUI</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-9">Status Whitelist</div>
                            <div class="col-3 text-center">NON</div>
                        </div>
                    </div>
                </div>
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
                            <div class="col-3 text-center">NON</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-9">Entretient</div>
                            <div class="col-3 text-center">OUI</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-9">Status Whitelist</div>
                            <div class="col-3 text-center">NON</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
