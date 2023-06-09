<div class="row col-3 bg-black rounded" id="navBloc">
    <div class="d-flex justify-content-center align-content-center">
        <img src="/img/dashLogo.png" alt="logo" class="imgLogo">
    </div>
    <div class="">
        @include('layouts.recruiters.errors')
        <div class="row">
            <p class="text-uppercase text-light text-opacity-75 text-center">Gestion whitelist</p>
            <ul class="text-center poppins">
                <li class="list-group-item">
                    <a href="{{ route('qcm.index') }}" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-patch-question"></i>&nbsp;Gestion QCM - Question</a>
                </li>
                <li class="list-group-item mt-2">
                    <a href="#" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-clock"></i>&nbsp;Gesiton Sessions</a>
                </li>
            </ul>
        </div>

        <div class="row mt-2 mb-2"></div>

        <div class="row">
            <p class="text-uppercase text-light text-opacity-75 text-center">Gestion candidats</p>
            <ul class="text-center poppins">
                <li class="list-group-item">
                    <a href="#" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-people"></i>&nbsp;Voir tous les candidats</a>
                </li>
                <li class="list-group-item mt-2">
                    <a href="{{ route('qcm.correction') }}" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-clipboard"></i>&nbsp;Correction QCM</a>
                </li>
                <li class="list-group-item mt-2">
                    <a href="#" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-person-slash"></i>&nbsp;Liste des bannis</a>
                </li>
            </ul>
        </div>

        <div class="row mt-2 mb-2"></div>

        <div class="row">
            <p class="text-uppercase text-light text-opacity-75 text-center">Gestion parrainages</p>
            <ul class="text-center poppins">
                <li class="list-group-item">
                    <a href="#" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-people"></i>&nbsp;Voirs les demandes</a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="link-underline link-underline-opacity-0 text-white HoverLinkCustomColor"><i class="bi bi-people"></i>&nbsp;Gestions parrainages</a>
                </li>
            </ul>
        </div>

    </div>
    <div class="d-flex justify-content-end align-content-end justify-items-end align-items-end poppins">
        <a href="{{ route('auth.logout') }}" class="link-underline link-underline-opacity-0 text-light text-opacity-50 HoverLinkCustomColor"><i class="bi bi-box-arrow-left"></i>&nbsp;Déconnexion</a>
    </div>
</div>
