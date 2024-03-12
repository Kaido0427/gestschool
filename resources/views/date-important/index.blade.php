@extends('layouts.app')

@section('title', 'liste des évènements')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title "> Tous les évenements</h3>
                            @if( auth()->user()->type ==="admin" )
                            
                                <a class="btn btn-primary float-right" href="{{ route('dateimportants.create') }}">Ajouter</a>
                            @endif

                        </div>
                        <div class="card-body">
                            <div>
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>

                                        <p>{{ $message }}</p>
                                    </div>
                                @endif
                            </div>

                            <div>
                                                
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Dates </th>
                                    <th>Evenements</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                    <td>{{ $event['date']}}</td>
                                    <td>{{ $event['event']}}</td>
                                    <td>
                                       
                                        <button  title="supprimer" type="button" class="btn bg-danger btn-xs"> 

                                        <a href="#" onclick="$('#delete_event_form').attr('action','{{ url('/dateimportants/'.$event->id) }}');
                                               $('#modal_delete_event').modal()" 
                                                class="list-icons-item text-danger-800" data-popup="tooltip" title="" data-container="body" 
                                                data-original-title="Activé">
                                                <i class="fas fa-trash "></i>
                                        </a>
                                        </button>
                                    </td>
                                    
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Dates </th>
                                <th>Evenements</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    @include('includes._activate_modal')

@stop
