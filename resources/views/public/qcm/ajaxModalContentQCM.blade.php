<div class="row d-flex justify-content-center align-items-center">
    <div class="col-12">
        <div class="alert alert-secondary" role="alert">
            Vous avez maintenant le temps que vous voulez pour répondre, vous avez une série de 10 questions choisie aléatoirement. Chaque question est limitée à 1000 caractères par réponses. Bon courage
        </div>
    </div>
</div>
<form>
    <input type="hidden" name="QCMId" value="{{ $QCMId }}">
    @csrf
    @foreach($QuestionsList as $QL)
        <div class="d-flex justify-content-center align-items-center">
            <hr class="w-75">
        </div>
        <div class="row text-black">
            <div class="mb-3 col-12">
                <div class="form-floating mb-3 fw-bold">
                    <input type="text" class="form-control" id="questionUpdate" name="question" placeholder="Type" value="{{ $QL->Question()->question }}" readonly>
                    <label for="question">Question</label>
                </div>
            </div>
        </div>
        <div class="row text-black">
            <div class="mb-3 col-12">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Entrez la réponse" id="answerUpdate" name="answer[{{ $QL->id }}]" style="height: 130px" maxlength="1000"></textarea>
                    <label for="answer">Votre Réponse</label>
                </div>
            </div>
        </div>
    @endforeach
    <div class="d-flex justify-content-center align-items-center">
        <hr class="w-75">
    </div>
    <div class="row d-flex justify-content-center align-items-center">
        <button class="btn btn-primary bgPurpleButton w-25">J'ai fini !</button>
    </div>
</form>

