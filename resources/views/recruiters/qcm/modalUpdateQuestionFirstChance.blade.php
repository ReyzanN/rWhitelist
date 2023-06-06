<div class="modal-header text-white">
    <h1 class="modal-title fs-5" id="QFTUpdate">Question N°{{ $Q->id }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body text-white">
    <form method="post" action="{{ route('qcm.questionFirstChance.update') }}">
        <input type="hidden" value="{{ $Q->id }}" name="id">
        @csrf
        <div class="row text-black">
            <div class="mb-3 col-12">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="questionUpdate" name="question" placeholder="Type" value="{{ $Q->question }}" readonly>
                    <label for="question">Question</label>
                </div>
            </div>
        </div>
        <div class="row text-black">
            <div class="mb-3 col-12">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Entrez la réponse" id="answerUpdate" name="answer" style="height: 130px" maxlength="1000" readonly>{{ $Q->answer }}</textarea>
                    <label for="answer">Réponse Type</label>
                </div>
            </div>
        </div>
        <div class="row text-black">
            <div class="mb-3 col-12">
                <div class="form-floating mb-3">
                    <select class="form-select"  name="idTypeQuestion" id="idTypeQuestionUpdate" aria-label="Default select example" disabled>
                        @foreach($QuestionTypeActive as $QTA)
                            <option value="{{ $QTA->id }}" {{ $QTA->isSelected($Q->idTypeQuestion) }}>{{ $QTA->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row text-black">
            <div class="mb-3 col-12">
                <div class="form-floating mb-3">
                    <select class="form-select"  name="active" id="activeUpdate" aria-label="Activation" disabled>
                        <option value="1">Activée</option>
                        <option value="0">Désactivée</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-4">
                <button type="button" class="btn btn-warning" onclick="myFunction()" id="ButtonUpdateFirstChance"><i class="bi bi-pencil"></i></button>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-warning" disabled id="ButtonUpdateFirstChanceConfirm">Cliquez pour valider</button>
            </div>
        </div>
    </form>
</div>
