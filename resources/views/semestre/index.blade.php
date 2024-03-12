@extends('layouts.app')

@section('title', 'Liste des Semestres')

@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des semestres</h3>
                            @if (auth()->user()->type == 'admin')
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                    data-target="#add-ue">
                                    Ajouter
                                </button>
                            @elseif(auth()->user()->type == 'personal')
                                @foreach ($roles as $role)
                                    @if ($role->slug == 'create_semetres')
                                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                            data-target="#add-ue">
                                            Ajouter
                                        </button>
                                    @endif
                                @endforeach
                            @endif


                            <div class="modal fade" id="add-ue" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ajouter un semestre</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('semestres.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="name">Libellé</label>
                                                        <input type="text" class="form-control" required id="name"
                                                            name="name" placeholder="Semestre 1">
                                                    </div>
                                                  


                                                    <div class="form-group">
                                                        <label>Niveau d'étude</label>
                                                        <select required name="level_id" class="custom-select select2">
                                                            <option value="">Choissir le niveau </option>
                                                            @foreach ($levels as $level)
                                                                <option value="{{ $level->id }}" @selected(old('level') == $level)>
                                                                    {{ $level->name }} @if($level->code) ({{ $level->code}}) @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Enregister</button>

                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
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
                                        <th>Niveau d'étude</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semestres as $semestre)
                                        <tr>
                                            <td>{{ $semestre['name'] }}</td>
                                            <td>{{ $semestre->level->name }}</td>
                                            <td>
                                                <div class="tools">

                                                    @if (auth()->user()->type == 'admin')
                                                        <button title="editer" type="button" class="btn bg-primary btn-xs">
                                                            <a href="/semestres/{{ $semestre->id }}/edit"><i
                                                                    class="fas fa-edit "></i></a>
                                                        </button>
                                                    @else
                                                        @foreach ($roles as $role)
                                                            @if ($role->slug == 'update_ues')
                                                                <button title="editer" type="button"
                                                                    class="btn bg-primary btn-xs">
                                                                    <a href="/semestres/{{ $semestre->id }}/edit"><i
                                                                            class="fas fa-edit "></i></a>
                                                                </button>
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
                                        <th>Libellé</th>
                                        <th>Code</th>

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


    <script>
        function editLevel(el) {
            var link = $(el) //refer `a` tag which is clicked
            console.log('data', link.data('ue'))
            let ue = link.data('ue')
            var modal = $("#editLevel_modal") //your modal
            console.log({
                ue
            })
            modal.find('#name').val(ue.name);
            modal.find('#level_name').val(ue.level_name);
        }
    </script>
@stop
