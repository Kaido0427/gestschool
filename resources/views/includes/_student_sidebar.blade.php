<li class="nav-item menu-open">
    <a href="{{ route('student.dasboard') }}" class="nav-link active"><i class="nav-icon fas fa-tachometer-alt"></i>
        <p> Tableau de bord </p>
    </a>

</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Gestion de profil
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('changePasswordGet') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Mot de passe </p>
            </a>
            <a href="{{ route('addProfil', ['id' => Auth::user()->id]) }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ajout de photo de profil </p>
            </a>
            <a href="{{ route('student.mycarte', ['id' => Auth::user()->id]) }}" class="nav-link">
                <i class="fa fa-id-card"></i>
                <p>Ma carte </p>
            </a>
        </li>
    </ul>
</li>


<li class="nav-item">
    <a href="{{ route('bulletin.of.student') }}" class="nav-link">
        <i class="nav-icon fas fa-tree"></i>
        <p>
            Mes bulletins
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tree"></i>
        <p>
            Scolarité
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('classe.emploie') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Voir l'emploi du temps</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('student.classe.matiere') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Voir les matières</p>
            </a>
        </li>
        <li class="nav-item">
            <a href='{{ asset('uploads') }}' target="_blank" class="nav-link">
                <i class="far fa-circle nav-icon"></i>

                <p>Programme des cours</p>
            </a>
        </li>
    </ul> 
</li>
<li class="nav-item">
    <a href="{{ route('informations.index') }}" class="nav-link">
        <i class="nav-icon fas "></i>
        <p>
            Informations partagées
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('class.synopsis') }}" class="nav-link">

        <p>Synopse des offres</p>

    </a>
</li>
