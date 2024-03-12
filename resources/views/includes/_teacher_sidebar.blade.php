<li class="nav-item menu-open">
    <a href="{{ route('teacher.dasboard')}}" class="nav-link active"><i class="nav-icon fas fa-tachometer-alt"></i>
        <p> Tableau de bord </p>
    </a>

</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Profil
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('changePasswordGet')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Mot de passe </p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('teacher.classe') }}" class="nav-link">
        <i class="nav-icon fas fa-tree"></i>
        <p>
            Mes classes
            <i class="fas  right"></i>
        </p>
    </a>
</li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas "></i>
            <p>
            Information
            <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('informations.index')}}" class="nav-link">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <p>Voir les informations</p>
                </a>
            </li>
        </ul>
    </li>