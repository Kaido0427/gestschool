@extends('layouts.app')
@section('title', 'Liste des étudiants de la classe')
@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des Etudiants de la classe {{ $classe['name']}}</h3>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        
                        <p>{{ $message }}</p>
                    </div>
                @endif
                    <div class="card-body">
                
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom </th>
                                    <th>Prénom(s)</th>
                                    <th>Adresse </th>
                                    <th>Email </th>
                                    <th>Téléphone </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classe['students'] as $student)
                                    <tr>
                                    <td>{{ $student['student']['matricule']}}</td>
                                    <td>{{ $student['student']['name']}}</td>
                                    <td>{{ $student['student']['firstname']}}</td>
                                    <td>{{ $student['student']['address']}}</td>
                                    <td>{{ $student['student']['email']}}</td>
                                    <td>{{ $student['student']['phone']}}</td>
                                    <td>
                                        <div class="tools">
                                        <a href="/students/{{$student['student']['id']}}/edit" id="editstudent"><i class="fas fa-edit "></i></a> 
                                        <a href="/student/{{ $student['student']['id'] }}/notes"><i class="fas fa-eye"></i></a>

                                        <button  title="Pass" type="button" class="btn bg-success btn-xs"> 
                                                                                                
                                            <a href="#" onclick="$('#student_pass_form').attr('action','{{ url('user/'.$student['student']['id'].'/pass') }}');
                                                    $('.user_name').text('{{{ $student['student']['name'].' '.$student['student']['firstname'] }}}');$('#student_pass').modal()" 
                                                    class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                    data-original-title="Desactivé">
                                                <i class="fa fa-check" aria-hidden="true"></i>

                                            </a>
                                        </button>
                                        <button  title="Pass" type="button" class="btn bg-danger btn-xs"> 
                                                                                                
                                            <a href="#" onclick="$('#student_fail_form').attr('action','{{ url('user/'.$student['student']['id'].'/fail') }}');
                                                    $('.user_name').text('{{{ $student['student']['name'].' '.$student['student']['firtsname'] }}}');$('#student_fail').modal()" 
                                                    class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                    data-original-title="Desactivé">
                                                <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                                                
                                            </a>
                                        </button>


                                        <button type="button" class="btn btn-info  btn-xs"
                                        title="Voir les bulletins"> <a style="color: white;"
                                            href="/bulletins/{{ $student['student']['id'] }}"
                                            data-id="{{ $student['student']['id'] }}"><i
                                                class="fas fa-book "></i></a>
                                    </button>

                                        <!--i class="fas fa-trash "></i-->                
     
                                        </div>
                                    </td>
                                    
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Matricule</th>
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
</section>

@include('includes._activate_modal')


@stop