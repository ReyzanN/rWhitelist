<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">{{ env('APP_NAME') }} - Logs</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('logs.index') }}"><i class="bi bi-house"></i>&nbsp;Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-newspaper"></i>&nbsp;Routing Logs
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('log.auth.view') }}"><i class="bi bi-person-check-fill"></i>&nbsp;User Routing Log</a></li>
                        <li><a class="dropdown-item" href="{{ route('log.guest.view') }}"><i class="bi bi-person-fill-dash"></i>&nbsp;Un-Auth Routing Logs</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-newspaper"></i>&nbsp;Logs
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('log.connection.view') }}"><i class="bi bi-door-open"></i>&nbsp;Connection Logs</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalSeeUser"><i class="bi bi-people"></i>&nbsp;Users Logs</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('log.action.view') }}"><i class="bi bi-newspaper"></i>&nbsp;All Logs - Actions</a></li>
                    </ul>
                </li>
            </ul>
            <a href="{{ route('dashPublic.index') }}"><button class="btn btn-outline-danger" type="submit">Quitter</button></a>
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="ModalSeeUser" tabindex="-1" aria-labelledby="ModalSeeUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ModalSeeUserLabel">Voir les logs d'un utilisateur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('log.user.view') }}" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="discordAccountId" name="discordAccountId" placeholder="XXXXXX">
                        <label for="discordAccountId">Discord Account ID</label>
                    </div>
                    <div class="mt-3 mb-3">
                        <button class="btn btn-success"><i class="bi bi-search"></i>&nbsp;Rechercher</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>
