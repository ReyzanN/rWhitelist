@extends('layouts.recruiters.app')

@section('title', 'QCM')

@section('content')
    <div class="container-fluid top10vh text-white">
        <div class="row-cols-12 d-flex flex-row d-flex justify-content-center">
            @include('layouts.recruiters.nav')
            <div class="row col-9 d-flex justify-content-around poppins">
                <div class="col-11 bg-black rounded d-flex flex-column">
                    <div class="row">
                        <h1 class="mt-2">Gestion des QCM - Question</h1>
                    </div>
                    <div class="row d-flex">
                        <div class="d-flex flex-row justify-content-around align-items-center">
                            <p><span class="badge text-bg-light">Nombre de question en ligne : 100</span></p>
                            <p><span class="badge text-bg-light">Nombre de question par QCM : {{ env('APP_WHITELIST_QCM_QUESTION') }}</span></p>
                            <p><span class="badge text-bg-light">Nombre chance par candidat : {{ env('APP_WHITELIST_QCM_ATTEMPT') }}</span></p>
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#QFTadd"><i class="bi bi-plus-circle"></i>&nbsp;Ajouter une nouvelle question</button>
                            <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#typeQuestionQCM"><i class="bi bi-eye"></i>&nbsp;Voirs les thèmes de questions</button>
                        </div>
                        <hr class="mx-2 w-25">
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <table class="table text-white" id="QuestionList">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Thème</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date création</th>
                                    <th scope="col">Date modification</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Question as $Q)
                                    <tr>
                                        <th scope="row">{{ $Q->id }}</th>
                                        <td>{{ $Q->question }}</td>
                                        <td>{{ $Q->QuestionType()->title }}</td>
                                        <td>
                                            @if($Q->active)
                                                <span class="badge text-bg-success">En ligne</span>
                                            @else
                                                <span class="badge text-bg-danger">Hors ligne</span>
                                            @endif
                                        </td>
                                        <td>{{ $Q->parseDateToString($Q->created_at) }}</td>
                                        <td>{{ $Q->parseDateToString($Q->created_at) }}</td>
                                        <td>
                                            <button class="btn btn-primary bgPurpleButton"><i class="bi bi-eye"></i></button>
                                            <button class="btn btn-primary bgPurpleButton"><i class="bi bi-pencil"></i></button>
                                            <a href="{{ route('qcm.questionFirstChance.remove',$Q->id) }}" ><button class="btn btn-primary bgPurpleButton"><i class="bi bi-trash"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal QCM Type Question -->
    <div class="modal  modal-lg fade poppins text-white" id="typeQuestionQCM" tabindex="-1" aria-labelledby="typeQuestionQCM" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-black text-white">
                <div class="modal-header text-white">
                    <h1 class="modal-title fs-5" id="typeQuestionQCM">Type de question</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-white">
                    <div class="mt-2 mb-2">
                        <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#typeAdd"><i class="bi bi-plus-circle"></i>&nbsp;Ajouter un type de question</button>
                    </div>
                    <table class="table text-white">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Active</th>
                            <th scope="col">Création</th>
                            <th scope="col">Modification</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($QuestionType as $QT)
                            <tr>
                                <th scope="row">{{ $QT->id }}</th>
                                <td>{{ $QT->title }}</td>
                                <td>
                                    @if( $QT->active)
                                        <span class="badge text-bg-success">Activée</span>
                                    @else
                                        <span class="badge text-bg-danger">Non activée</span>
                                    @endif
                                </td>
                                <td>{{ $QT->parseDateToString($QT->created_at) }}</td>
                                <td>{{ $QT->parseDateToString($QT->updated_at) }}</td>
                                <td>
                                    <button class="btn btn-primary bgPurpleButton" data-bs-toggle="modal" data-bs-target="#editType" onclick="SearchAjax('{{ $QT->id }}','{{ route('qcm.questionType.ajax.update') }}','TypeQuestionUpdate','{{ csrf_token() }}')"><i class="bi bi-pencil"></i></button>
                                    <a href="{{ route('qcm.questionType.remove', $QT->id) }}"><button class="btn btn-primary bgPurpleButton"><i class="bi bi-trash"></i></button></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Type Modal -->
    <div class="modal fade" id="typeAdd" tabindex="-1" aria-labelledby="typeAdd" aria-hidden="true">
        <div class="modal-dialog poppins">
            <div class="modal-content bg-black text-white">
                <div class="modal-header text-white">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un type</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-white">
                    <form method="post" action="{{ route('qcm.questionType.add') }}">
                        @csrf
                        <div class="row text-black">
                            <div class="mb-3 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="label" name="label" placeholder="Type">
                                    <label for="label">Type</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-success w-75">Sauvegarder</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#typeQuestionQCM">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Question First Chance -->
    <div class="modal fade" id="QFTadd" tabindex="-1" aria-labelledby="QFTadd" aria-hidden="true">
        <div class="modal-dialog poppins">
            <div class="modal-content bg-black text-white">
                <div class="modal-header text-white">
                    <h1 class="modal-title fs-5" id="QFTadd">Ajouter une question</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-white">
                    <form method="post" action="{{ route('qcm.questionFirstChance.add') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="alert alert-secondary" role="alert">
                                    La limite de caractère de la réponse type est fixée à 1000 caractères. Par défaut, elle sera activée pour être présenté aux candidats. La selection d'un thème pour la question est obligatoire.
                                </div>
                            </div>
                        </div>
                        <div class="row text-black">
                            <div class="mb-3 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="question" name="question" placeholder="Type">
                                    <label for="question">Question</label>
                                </div>
                            </div>
                        </div>
                        <div class="row text-black">
                            <div class="mb-3 col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Entrez la réponse" id="answer" name="answer" style="height: 130px" maxlength="1000"></textarea>
                                    <label for="answer">Réponse Type</label>
                                </div>
                            </div>
                        </div>
                        <div class="row text-black">
                            <div class="mb-3 col-12">
                                <div class="form-floating mb-3">
                                    <select class="form-select"  name="idTypeQuestion" id="idTypeQuestion" aria-label="Default select example">
                                        @foreach($QuestionTypeActive as $QTA)
                                            <option value="{{ $QTA->id }}">{{ $QTA->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-success w-75">Sauvegarder</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Type Modal -->
    <div class="modal fade" id="editType" tabindex="-1" aria-labelledby="editType" aria-hidden="true">
        <div class="modal-dialog poppins">
            <div class="modal-content bg-black text-white">
                <div class="modal-header text-white">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Éditer un type</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-white" id="TypeQuestionUpdate">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#typeQuestionQCM">Retour</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/ajax/search.js"></script>
@endsection
