    <li class="nav-item menu-open">
        <a href="{{ route('admin.dashboard') }}" class="nav-link active"><i class="nav-icon fas fa-tachometer-alt"></i>
            <p> Tableau de bord </p>
        </a>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas "></i>
            <p>
                Profile
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('changePasswordGet') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mot de passe </p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
                Configuration
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>


        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('promotions.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Promotions</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sectors.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Filières</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('semestres.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Semestres</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ues.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>UE</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('levels.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Niveau d'étude</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('classes.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Classes</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('matieres.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Matières</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tree"></i>
            <p>
                Gestion
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('students.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Etudiants</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('teachers.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Professeurs</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('personals.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Personnels</p>
                </a>
            </li>
        </ul>
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
                <a href="{{ route('informations.create') }}" class="nav-link">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <p>Partager une information</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dateimportants.create') }}" class="nav-link">
                    <i class="fa fa-info-circle"></i>
                    <p>Date importantes</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="{{ route('add.synopsis') }}" class="nav-link">

            <p>Synopse des offres</p>

        </a>
    </li>
