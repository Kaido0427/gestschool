@extends('layouts.app')
@section('title', 'Ajout de matieres')
@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ajout de matiere à la classe {{ $classe->name }}</h3>
           
                </div>
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    

                 

                </div>
                    
                    </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>


@stop