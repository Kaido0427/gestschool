@extends('layouts.app')

@section('title', 'Liste des UEs')

@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Unités d'enseignement</h3>
                            @if (auth()->user()->type == 'admin')

                                <a class="btn btn-primary float-right" href="{{ route('ues.create') }}">Ajouter</a>
                            @elseif(auth()->user()->type == 'personal')
                                @foreach ($roles as $role)
                                    @if ($role->slug == 'create_ues')
                                        <a class="btn btn-primary float-right" href="{{ route('ues.create') }}">Ajouter</a>
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
                                        <th>Libellé</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Semestre</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ues as $ue)
                                        <tr>
                                            <td>{{ $ue['name'] }}</td>
                                            <td>{{ $ue['code'] }}</td>
                                            <td>{{ $ue['type'] }}</td>
                                            <td>
                                                @foreach ($ue->semestres->unique('id') as $semestre)
                                                    {{ $semestre->name }} <strong>({{ $semestre->level->code }})</strong>
                                                    @if (!$loop->last)
                                                        |
                                                    @endif
                                                @endforeach

                                            </td>

                                            <td>
                                                <div class="tools">

                                                    @if (auth()->user()->type == 'admin')
                                                        <button title="editer" type="button" class="btn bg-primary btn-xs">
                                                            <a href="/ues/{{ $ue->id }}/edit"><i
                                                                    class="fas fa-edit "></i></a>
                                                        </button>
                                                    @else
                                                        @foreach ($roles as $role)
                                                            @if ($role->slug == 'update_ues')
                                                                <button title="editer" type="button"
                                                                    class="btn bg-primary btn-xs">
                                                                    <a href="/ues/{{ $ue->id }}/edit"><i
                                                                            class="fas fa-edit "></i></a>
                                                                </button>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    <button title="supprimer" type="button" class="btn bg-danger btn-xs">

                                                        <a href="#"
                                                            onclick="$('#delete_ue_form').attr('action','{{ url('/ues/' . $ue->id) }}');
                                       $('#delete_ue').modal()"
                                                            class="list-icons-item text-danger-800" data-popup="tooltip"
                                                            title="" data-container="body"
                                                            data-original-title="Activé">
                                                            <i class="fas fa-trash "></i>
                                                    </button>
                                                </div>

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>

                                        <th>Libellé</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Semestre</th>
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
