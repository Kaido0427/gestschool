@extends('layouts.app')

@section('title', 'Gestion du personnel')
@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste du personnel</h3>

                        @if (auth()->user()->type=="admin")
                                <a class="btn btn-primary float-right" href="{{ route('personals.create') }}">Ajouter</a>
                        @elseif ( auth()->user()->type=="personal")
                            @foreach ($roles as $role )
                                @if ($role->slug =="create_personals" )
                                <a class="btn btn-primary float-right" href="{{ route('personals.create') }}">Ajouter</a>

                                @endif
                            @endforeach
                        @endif
                                              
                    </div>
                    <div class="card-body">

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                    
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nom </th>
                                    <th>Prénom(s)</th>
                                    <th>Adresse </th>
                                    <th>Email </th>
                                    <th>Téléphone </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($personals as $personal)
                                    <tr>
                                    <td>{{ $personal['name']}}</td>
                                    <td>{{ $personal['firstname']}}</td>
                                    <td>{{ $personal['address']}}</td>
                                    <td>{{ $personal['email']}}</td>
                                    <td>{{ $personal['phone']}}</td>
                                    <td>
                                        <div class="tools">
                                            @if (auth()->user()->type=="admin")
                                                <button  title="editer" type="button" class="btn bg-primary btn-xs"> 
                                                    <a href="/personals/{{$personal->id}}/edit"><i class="fas fa-edit "></i></a> 
                                                </button> 
                                                    @if ($personal['is_active'])
                                                        <button  title="Desactivé" type="button" class="btn bg-primary btn-xs"> 
                                                                                                
                                                            <a href="#" onclick="$('#user_desactive_form').attr('action','{{ url('user/'.$personal->id.'/desactivate') }}');
                                                                    $('.user_name').text('{{{ $personal->name.' '.$personal->firsname }}}');$('#modal_desactive_user').modal()" 
                                                                    class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                    data-original-title="Desactivé">
                                                                <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                                            </a>
                                                        </button>
                                                    @else
                                                        <button  title="Activé" type="button" class="btn bg-danger btn-xs"> 
                                                                                                                            
                                                            <a href="#" onclick="$('#user_active_form').attr('action','{{ url('user/'.$personal->id.'/desactivate') }}');
                                                                    $('.user_name').text('{{{ $personal->name.' '.$personal->firsname }}}');$('#modal_active_user').modal()" 
                                                                    class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                    data-original-title="Activé">
                                                                <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                                            </a>
                                                        </button>
                                                    @endif
                                            @else
                                                @foreach ($roles as $role )
                                                    @if ( $role->slug =="update_personals" )
                                                        <button  title="editer" type="button" class="btn bg-primary btn-xs"> 
                                                            <a href="/personals/{{$personal->id}}/edit"><i class="fas fa-edit "></i></a> 
                                                        </button>                                                                                                    
                                                        @if ($personal['is_active'])
                                                            <button  title="Desactivé" type="button" class="btn bg-primary btn-xs"> 
                                                                                                    
                                                                <a href="#" onclick="$('#user_desactive_form').attr('action','{{ url('user/'.$personal->id.'/desactivate') }}');
                                                                        $('.user_name').text('{{{ $personal->name.' '.$personal->firsname }}}');$('#modal_desactive_user').modal()" 
                                                                        class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                        data-original-title="Desactivé">
                                                                    <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                                                </a>
                                                            </button>
                                                        @else
                                                            <button  title="Activé" type="button" class="btn bg-danger btn-xs"> 
                                                                                                                                
                                                                <a href="#" onclick="$('#user_active_form').attr('action','{{ url('user/'.$personal->id.'/desactivate') }}');
                                                                        $('.user_name').text('{{{ $personal->name.' '.$personal->firsname }}}');$('#modal_active_user').modal()" 
                                                                        class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                                        data-original-title="Activé">
                                                                    <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                                                </a>
                                                            </button>
                                                        @endif

                                                    @endif
                                                @endforeach 
                                            @endif
                            
                                        </div>
                                    </td>
                                    
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom(s)</th>
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