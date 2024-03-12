@extends('layouts.app')
@section('title', 'Ajout d\'emploi de temps')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <form method="POST" enctype="multipart/form-data"  action="/classe/add-time-usage">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                                                                    
                            <label for="exampleInputFile">Charger l'emploi du temps (pdf, PDF)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="id" id="id" type="hidden" value="{{ $classe->id}}">
                                    <input name="time_usage" type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choisir le fichier</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Enregister</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>  

@stop
