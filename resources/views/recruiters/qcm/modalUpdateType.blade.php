<form method="post" action="{{ route('qcm.questionType.update') }}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ $QT->id }}">
    <div class="row text-black">
        <div class="mb-3 col-12">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="label" name="label" placeholder="Type" value="{{ $QT->title }}">
                <label for="label">Type</label>
            </div>
        </div>
    </div>
    <div class="row text-black">
        <div class="mb-3 col-12">
            <div class="form-floating mb-3">
                <select class="form-select"  name="active" id="active" aria-label="Default select example">
                    <option selected value="1">Activé</option>
                    <option value="0">Désactivé</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center align-items-center">
        <button type="submit" class="btn btn-warning w-75">Modifier</button>
    </div>
</form>
