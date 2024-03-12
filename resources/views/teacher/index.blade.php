@extends('layouts.app')

@section('title', 'Gestion des enseignants')
@section('content')


<section class="content">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des Professeurs</h3>

                            @if (auth()->user()->type=="admin")

                                <a class="btn btn-primary float-right" href="{{ route('teachers.create') }}">Ajouter</a>

                            @elseif ( auth()->user()->type=="personal")
                                    @foreach ($roles as $role )
                                        @if ($role->slug =="create_teachers")
                                        <a class="btn btn-primary float-right" href="{{ route('teachers.create') }}">Ajouter</a>

                                        @endif
                                    @endforeach
                            @endif
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                            {{ session('success') }}
                        </div>
                        @endif

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Noms </th>
                                    <th>Prénoms </th>
                                    <th>Adresse </th>
                                    <th>Email </th>
                                    <th>Téléphone </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>        
                            @foreach ($teachers as $teacher)
                                    <tr>
                                    <td>{{ $teacher['name']}}</td>
                                    <td>{{ $teacher['firstname']}}</td>
                                    <td>{{ $teacher['address']}}</td>
                                    <td>{{ $teacher['email']}}</td>
                                    <td>{{ $teacher['phone']}}</td>
                                    <td>
                                        <div class="tools">
                                            @if (auth()->user()->type=="admin")
                                                        <button  title="editer" type="button" class="btn bg-primary btn-xs"> 
                                                            <a href="/teachers/{{$teacher->id}}/edit"><i class="fas fa-edit "></i></a> 
                                                        </button>                                                      
                                                    @if ($teacher['is_active'])
                                                        <button  title="Desactivé" type="button" class="btn bg-primary btn-xs"> 
                                                                                                
                                                            <a href="#" onclick="$('#user_desactive_form').attr('action','{{ url('user/'.$teacher->id.'/desactivate') }}');
                                                                    $('.user_name').text('{{{ $teacher->name.' '.$teacher->firsname }}}');$('#modal_desactive_user').modal()" 
                                                                    class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                    data-original-title="Desactivé">
                                                                <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                                            </a>
                                                        </button>
                                                    @else
                                                        <button  title="Activé" type="button" class="btn bg-danger btn-xs"> 
                                                                                                                            
                                                            <a href="#" onclick="$('#user_active_form').attr('action','{{ url('user/'.$teacher->id.'/desactivate') }}');
                                                                    $('.user_name').text('{{{ $teacher->name.' '.$teacher->firsname }}}');$('#modal_active_user').modal()" 
                                                                    class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                    data-original-title="Activé">
                                                                <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                                            </a>
                                                        </button>
                                                    @endif
                                            @else
                                                @foreach ($roles as $role )
                                                    @if ( $role->slug =="update_teachers" )
                                                        <button  title="editer" type="button" class="btn bg-primary btn-xs"> 
                                                            <a href="/teachers/{{$teacher->id}}/edit"><i class="fas fa-edit "></i></a> 
                                                        </button>                                                                                                               
                                                        @if ($teacher['is_active'])
                                                            <button  title="Desactivé" type="button" class="btn bg-primary btn-xs"> 
                                                                                                    
                                                                <a href="#" onclick="$('#user_desactive_form').attr('action','{{ url('user/'.$teacher->id.'/desactivate') }}');
                                                                        $('.user_name').text('{{{ $teacher->name.' '.$teacher->firsname }}}');$('#modal_desactive_user').modal()" 
                                                                        class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                        data-original-title="Desactivé">
                                                                    <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                                                </a>
                                                            </button>
                                                        @else
                                                            <button  title="Activé" type="button" class="btn bg-danger btn-xs"> 
                                                                                                                                
                                                                <a href="#" onclick="$('#user_active_form').attr('action','{{ url('user/'.$teacher->id.'/desactivate') }}');
                                                                        $('.user_name').text('{{{ $teacher->name.' '.$teacher->firsname }}}');$('#modal_active_user').modal()" 
                                                                        class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                        data-original-title="Activé">
                                                                    <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                                                </a>
                                                            </button>
                                                        @endif

                                                    @endif
                                                @endforeach 
                                            @endif
                            
                                            <button  title="Initialiser le mot de passe de {{$teacher['name'] }} {{$teacher['firstname'] }}" type="button" class="btn bg-warning btn-xs"> 

                                                <a href="#" onclick="$('#init_password_form').attr('action','{{ url('/user/'.$teacher->id.'/init-password') }}');
                                                           $('.user_name').text('{{{  $teacher->name.' '.$teacher->firsname }}}');$('#modal_init_password').modal()" 
                                                           class="list-icons-item text-warning-800" data-popup="tooltip" title="" data-container="body" 
                                                           data-original-title="Activé">
                                                           <i class="fa fa-key" aria-hidden="true"></i>
                                               </a>
                                       </button>
                                        </div>
                                    </td>
                                    
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>Adresse </th>
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
@stop