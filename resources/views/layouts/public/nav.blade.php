<div class="row col-3 bg-black rounded" id="navBloc">
    <div class="d-flex justify-content-center align-content-center">
        <img src="/img/dashLogo.png" alt="logo" class="imgLogo">
    </div>
    <div class="">
        @include('layouts.public.errors')
        <div class="row d-flex justify-items-center align-items-center">
            <ul class="text-center poppins">
                <li class="list-group-item mt-2">
                    <a href="{{ route('dashPublic.index') }}" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-house"></i>&nbsp;Accueil</a>
                </li>
                <li class="list-group-item mt-2">
                    <a href="{{ route('dashPublic.profile') }}" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-person"></i>&nbsp;Mon Profil</a>
                </li>
                <li class="list-group-item mt-2">
                    <a href="#" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-info-circle"></i>&nbsp;Informations</a>
                </li>
                <li class="list-group-item mt-2">
                    <a href="#" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-chat-left"></i>&nbsp;Mes demandes</a>
                </li>
            </ul>
        </div>
        <div class="row mt-5"></div>
        <div class="row">
            <p class="text-uppercase text-light text-opacity-75 text-center">whitelist</p>
            <ul class="text-center poppins">
                @if(!auth()->user()->isWl())
                    <li class="list-group-item">
                        <a href="{{ route('qcm.candidate.index') }}" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-patch-question"></i>&nbsp;QCM</a>
                    </li>
                    <li class="list-group-item mt-2">
                        <a href="{{ route('candidate.sessions.view') }}" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-clock"></i>&nbsp;Sessions</a>
                    </li>
                @endif
                <li class="list-group-item mt-2">
                    <a href="#" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-people"></i>&nbsp;Demande de parrainage</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="d-flex justify-content-end align-content-end justify-items-end align-items-end poppins">
        <a href="{{ route('auth.logout') }}" class="link-underline link-underline-opacity-0 text-light text-opacity-50 HoverLinkCustomColor"><i class="bi bi-box-arrow-left"></i>&nbsp;Déconnexion</a>
    </div>
</div>
