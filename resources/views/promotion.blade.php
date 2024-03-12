@extends('layouts.app')

@section('title', 'Promotions')

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">

                            <h3 class="card-title">Liste des promotions </h3>
                            @if (auth()->user()->type == 'admin')
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                    data-target="#add-promotion"> Ajouter </button>
                            @elseif (auth()->user()->type == 'personal')
                                @foreach ($roles as $role)
                                    @if ($role->slug == 'create_promotions')
                                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                            data-target="#add-promotion"> Ajouter </button>
                                    @endif
                                @endforeach
                            @endif


                            <div class="modal fade" id="add-promotion" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h4 class="modal-title">Ajouter une promotion</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('promotions.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="name">Nom de la promotion</label>
                                                        <input type="text" class="form-control" required id="name"
                                                            name="name" placeholder="Nom de la promotion">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promotionLists as $promotion)
                                        <tr>
                                            <td>{{ $promotion['name'] }}</td>
                                            <td>
                                                @if (auth()->user()->type == 'admin')
                                                    <button title="editer" type="button" class="btn bg-primary btn-xs">
                                                        <a href="/promotions/{{ $promotion->id }}/edit"><i
                                                                class="fas fa-edit "></i></a>
                                                    </button>
                                                @else
                                                    @foreach ($roles as $role)
                                                        @if ($role->slug == 'update_promotions')
                                                            <button title="editer" type="button"
                                                                class="btn bg-primary btn-xs">
                                                                <a href="/promotions/{{ $promotion->id }}/edit"><i
                                                                        class="fas fa-edit "></i></a>
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Libellé</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="modal fade" id="editPromo_modal" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Modifier une promotion </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>

                                    @if (count($promotionLists))
                                        <form method="POST" action="{{ route('promotions.update', $promotion) }}">
                                            @csrf
                                            @method('PATCH')

                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="name">Nom de la promotion</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $promotion['name'] }}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Enregister</button>

                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
