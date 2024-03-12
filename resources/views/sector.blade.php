@extends('layouts.app')

@section('title', 'Filière')

@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Filières</h3>

                            @if (auth()->user()->type == 'admin')
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                    data-target="#add-sector"> Ajouter </button>
                            @elseif (auth()->user()->type == 'personal')
                                @foreach ($roles as $role)
                                    @if ($role->slug == 'create_sectors')
                                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                            data-target="#add-sector"> Ajouter </button>
                                    @endif
                                @endforeach
                            @endif

                            <div class="modal fade" id="add-sector" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ajouter une filière </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('sectors.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="name">Nom de la filière</label>
                                                        <input type="text" class="form-control" required id="name"
                                                            name="name" placeholder="Example: Informatique de gestion">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="code">Code de la filière</label>
                                                        <input type="text" class="form-control" required id="code"
                                                            name="code" placeholder="Example: IG">
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
                                        <th>Code</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectors as $sector)
                                        <tr>
                                            <td>{{ $sector['name'] }}</td>
                                            <td>{{ $sector['code'] }}</td>
                                            <td>
                                                <div class="tools">
                                                    @if (auth()->user()->type == 'admin')
                                                        <a href="/sectors/{{ $sector->id }}/edit">
                                                            <i class="fas fa-edit "></i>
                                                        </a>
                                                    @else
                                                        @foreach ($roles as $role)
                                                            @if ($role->slug == 'update_sectors')
                                                                <a href="/sectors/{{ $sector->id }}/edit">
                                                                    <i class="fas fa-edit "></i>
                                                                </a>
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
                                        <th>code</th>
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
        function editSector(el) {
            var link = $(el) //refer `a` tag which is clicked
            let sector = link.data('sector')
            var modal = $("#editSector_modal") //your modal
            console.log(sector)
            modal.find('#name').val(sector.name);
            modal.find('#code').val(sector.code);
        }
    </script>

@stop
