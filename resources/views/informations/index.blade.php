@extends('layouts.app')

@section('title', 'liste d\'informations')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title "> Toutes les informations</h3>
                            @if (auth()->user()->type != 'student')
                                <a class="btn btn-primary float-right" href="{{ route('informations.create') }}">Ajouter</a>
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
                                            <th>Descriptions</th>
                                            <th>fichiers </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($informations as $information)
                                            <tr>
                                                <td>{{ $information['created_at'] }}</td>
                                                <td>{{ $information['description'] }}</td>
                                                <td>{{ $information['file'] }}</td>
                                                <td>
                                                    <button title="supprimer" type="button" class="btn bg-info btn-xs">
                                                        <a href="{{ asset('uploads/' . $information['file']) }}"
                                                            target="_blank"><i class="fas fa-eye "></i></a>
                                                    </button>




                                                    @if (auth()->user()->type == 'admin')
                                                        <button title="supprimer" type="button"
                                                            class="btn bg-danger btn-xs">

                                                            <a href="#"
                                                                onclick="$('#delete_information_form').attr('action','{{ url('/informations/' . $information->id) }}');
                                               $('#modal_delete_information').modal()"
                                                                class="list-icons-item text-danger-800" data-popup="tooltip"
                                                                title="" data-container="body"
                                                                data-original-title="Activé">
                                                                <i class="fas fa-trash "></i>
                                                        </button>
                                                    @endif
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Dates </th>
                                            <th>Descriptions</th>
                                            <th>fichiers </th>
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
