@extends('layouts.app')

@section('title', 'Gestion des étudiants')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des Etudiants</h3>

                            @if (auth()->user()->type=="admin")
                                <a class="btn btn-primary float-right" href="{{ route('students.create') }}">Ajouter</a>
                            @elseif ( auth()->user()->type=="personal")
                                    @foreach ($roles as $role )
                                        @if ($role->slug =="create_students" )
                                <a class="btn btn-primary float-right" href="{{ route('students.create') }}">Ajouter</a>

                                        @endif
                                    @endforeach
                            @endif
               
                    </div>
                    <div class="card-body">
                        <div class="panel-body">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    {{ session('success') }}
                                </div>
                            @endif
                            @if($errors)
                                @foreach ($errors->all() as $error)

                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                        {{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom & Prénom(s) </th>
                                    <th>Date de naissance</th>
                                    <th>Lieu de naissance</th>
                                    <th>Nationalité</th>
                                    <th>Classe </th>
                                    <th>Email </th>
                                    <th>Téléphone </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($students as $student)
                                    <tr>
                                    <td>{{ $student['matricule']}}</td>
                                    <td>{{ $student['name'] ." ".$student['firstname']}}</td>
                                    <td>{{ explode(" ", $student['birth_day'])[0]}} </td>
                                    <td>{{ $student['birth_place']}}</td>
                                    <td>{{ $student['nationality']}}</td>
                                    <td>
                                    {{ count($student->studentPromotionClasses) ?$student->studentPromotionClasses[0]['mclass']['name']:"" }}

                                    </td>
                                    <td>{{ $student['email']}}</td>
                                    <td>{{ $student['phone']}}</td>
                                    <td>
                                        <div class="tools">
                                            @if (auth()->user()->type=="admin")
                                                <button  title="editer" type="button" class="btn bg-primary btn-xs"> 
                                                    <a href="/students/{{$student->id}}/edit"><i class="fas fa-edit "></i></a> 
                                                </button> 
                                                
                                                @if ($student['is_active'])
                                                        <button  title="Desactivé" type="button" class="btn bg-primary btn-xs"> 
                                                                                                
                                                            <a href="#" onclick="$('#user_desactive_form').attr('action','{{ url('user/'.$student->id.'/desactivate') }}');
                                                                    $('.user_name').text('{{{ $student->name.' '.$student->firsname }}}');$('#modal_desactive_user').modal()" 
                                                                    class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                    data-original-title="Desactivé">
                                                                <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                                            </a>
                                                        </button>
                                                @else
                                                        <button  title="Activé" type="button" class="btn bg-danger btn-xs"> 
                                                                                                                            
                                                            <a href="#" onclick="$('#user_active_form').attr('action','{{ url('user/'.$student->id.'/desactivate') }}');
                                                                    $('.user_name').text('{{{ $student->name.' '.$student->firsname }}}');$('#modal_active_user').modal()" 
                                                                    class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                    data-original-title="Activé">
                                                                <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                                            </a>
                                                        </button>
                                                @endif
                                                <button  title="Initialiser le mot de passe de {{$student['name'] }} {{$student['firstname'] }}" type="button" class="btn bg-warning btn-xs"> 

                                                         <a href="#" onclick="$('#init_password_form').attr('action','{{ url('/user/'.$student->id.'/init-password') }}');
                                                                    $('.user_name').text('{{{  $student->name.' '.$student->firsname }}}');$('#modal_init_password').modal()" 
                                                                    class="list-icons-item text-warning-800" data-popup="tooltip" title="" data-container="body" 
                                                                    data-original-title="Activé">
                                                                    <i class="fa fa-key" aria-hidden="true"></i>
                                                        </a>
                                                </button>

                                                <button  title="Voir la carte de: {{$student['name'] }} {{$student['firstname'] }}" type="button" class="btn bg-info btn-xs"> 
                                                    <a target="_blank" href="{{route('student.carte', ['id'=>$student->id])}}"><i class="fa fa-id-card"></i></a> 
                                                </button> 

                                              {{--   <button  title="Voir les bulletins de: {{$student['name'] }} {{$student['firstname'] }}" type="button" class="btn bg-primary btn-xs"> 
                                                    <a href="student/{{$student->id}}/bulletins">
                                                        Bulletin
                                                    </a>
                                                </button> --}}
                                                <button  title="Voir la photo de profil de: {{$student['name'] }} {{$student['firstname'] }}" type="button" class="btn bg-primary btn-xs"> 
                                                    <a target="_blank" href="students/{{$student->id}}/profil">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                </button>
                                                @if ($student->avatar)
                                                    <button  title="Télécharger la carte de: {{$student['name'] }} {{$student['firstname'] }}" type="button" class="btn bg-primary btn-xs"> 
                                                    <a target="_blank" href="download/students/{{$student->id}}/carte">
                                                        <i class="fa fa-sharp fa-solid fa-arrow-down" aria-hidden="true"></i>
                                                    </a>
                                                </button>
                                                @endif
                                                <form id="nightForm">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $student->id }}">
                                                    <button id="nightBtn" class="btn btn-warning btn-xs" data-state="{{ $student->night ? 'night' : 'day' }}" data-user-id="{{ $student->id }}">
                                                        @if ($student->night)
                                                            <i class="fas fa-moon"></i>
                                                        @else
                                                            <i class="fas fa-sun"></i>
                                                        @endif
                                                    </button>
                                                </form>
                                                
                                                
                                            @else
                                                @foreach ($roles as $role )
                                                    @if ( $role->slug =="update_students" )

                                                        <button  title="editer" type="button" class="btn bg-primary btn-xs"> 
                                                            <a href="/students/{{$student->id}}/edit"><i class="fas fa-edit "></i></a> 
                                                        </button>                                                         
                                                        @if ($student['is_active'])
                                                            <button  title="Desactivé" type="button" class="btn bg-primary btn-xs"> 
                                                                                                    
                                                                <a href="#" onclick="$('#user_desactive_form').attr('action','{{ url('user/'.$student->id.'/desactivate') }}');
                                                                        $('.user_name').text('{{{ $student->name.' '.$student->firsname }}}');$('#modal_desactive_user').modal()" 
                                                                        class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                        data-original-title="Desactivé">
                                                                    <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                                                </a>
                                                            </button>
                                                        @else
                                                            <button  title="Activé" type="button" class="btn bg-danger btn-xs"> 
                                                                                                                                
                                                                <a href="#" onclick="$('#user_active_form').attr('action','{{ url('user/'.$student->id.'/desactivate') }}');
                                                                        $('.user_name').text('{{{ $student->name.' '.$student->firsname }}}');$('#modal_active_user').modal()" 
                                                                        class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                        data-original-title="Activé">
                                                                    <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                                                </a>
                                                            </button>
                                                        @endif

                                                    @endif
                                                    @if ($role->slug =="init_password")
                                                    <button  title="Initialiser le mot de passe de {{$student['name'] }} {{$student['firstname'] }}" type="button" class="btn bg-danger btn-xs"> 
                                                    <a href="/students/{{$student->id}}/init-password"> <i class="fa fa-key" aria-hidden="true"></i></a>
                                                    </button>                                                        
                                                    @endif
                                                @endforeach 
                                            @endif

                                        </div>

                                        <button type="button" class="btn btn-info  btn-xs"
                                        title="Voir les bulletins"> <a style="color: white;"
                                            href="bulletins/{{ $student->id }}"
                                            data-id="{{ $student->id }}"><i
                                                class="fas fa-book "></i></a>
                                    </button>
                                    </td>
                                    
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Matricule</th>
                                <th>Nom & Prénom(s) </th>
                                <th>Date de naissance</th>
                                <th>Lieu de naissance</th>
                                <th>Nationalité</th>
                                <th>Classe </th>
                                <th>Email </th>
                                <th>Téléphone </th> 
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
            
                </div>
            </div>
        </div>
    </div>
        @include('includes._activate_modal')
</section>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        console.log('DOM chargé');
        console.log($('#nightBtn').length); // Vérifie si le sélecteur trouve le bouton
    
        // Utilisez la fonction .on() pour attacher le gestionnaire d'événements click
        $(document).on('click', '#nightBtn', function() {
            console.log('Bouton cliqué');
            var $button = $(this);
    
            // Désactiver le bouton pour éviter les clics multiples 
            $button.prop('disabled', true);
    
            // Changer l'icône par l'icône de chargement
            $button.html('<i class="fas fa-spinner fa-spin"></i>');
    
            // Récupérer l'ID de l'utilisateur à partir de l'attribut data-user-id
            var userId = $button.data('user-id');
    
            // Ajouter le jeton CSRF aux données de la requête
            var token = $('meta[name="csrf-token"]').attr('content');
            console.log('ID de l\'utilisateur :', userId);
    
            // Envoyer une requête AJAX pour basculer la valeur de 'night'
            $.ajax({
                url: '{{ route('students.night') }}',
                method: 'POST',
                data: {
                    _token: token,
                    user_id: userId
                },
                success: function(response) {
                    console.log('Requête AJAX réussie :', response);
    
                    // Mettre à jour l'icône et l'état en fonction de la réponse du serveur
                    var icon = response.night ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
                    var state = response.night ? 'night' : 'day';
                    $button.html(icon);
                    $button.attr('data-state', state); 
    
                    // Réactiver le bouton après 1 seconde
                    setTimeout(function() {
                        $button.prop('disabled', false);
                    }, 1000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Une erreur est survenue lors de la requête AJAX :', textStatus, errorThrown);
    
                    // Réactiver le bouton après 1 seconde
                    setTimeout(function() {
                        $button.prop('disabled', false);
                    }, 1000);
                }
            });
        });
    });
    </script>
@stop