
@extends('layouts.app')

@section('title', 'Gestion des niveaux d\'études')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Liste des Niveaux d'études</h3>
                @if (auth()->user()->type=="admin")
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add-level">
                      Ajouter
                    </button>
                @elseif(auth()->user()->type=="personal")
                  @foreach ($roles as $role )
                      @if ($role->slug =="create_levels")

                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add-level">
                          Ajouter
                        </button>
                      @endif
                  @endforeach
                @endif
             
               
                <div class="modal fade" id="add-level" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Ajouter un niveau d'étude</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    </div>
                    <form method="POST" action="{{ route('levels.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Libellé du niveaux d'étude</label>
                                    <input type="text" class="form-control" required id="name" name="name" placeholder="Example: Licence I">
                                </div>
                                <div class="form-group">
                                    <label for="code">Code du Niveau d'étude</label>
                                    <input type="text" class="form-control" required id="code" name="code" placeholder="Example: L1">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
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
                  @foreach ($levels as $level)

                <tr>
                  <td>{{ $level['name']}}</td>
                  <td>{{ $level['code']}}</td>
                  <td>
                    <div class="tools">
                  
                        @if (auth()->user()->type=="admin")
                                                
                            <a href="#" onclick="editLevel(this)"  data-target="#editLevel_modal" data-toggle="modal" data-id="{{$level->id}}" data-level="{{ $level}}"><i class="fas fa-edit "></i></a>
                            @else
                              @foreach ($roles as $role )
                                @if ( $role->slug =="update_levels")
                                  <a href="#" onclick="editLevel(this)"  data-target="#editLevel_modal" data-toggle="modal" data-id="{{$level->id}}" data-level="{{ $level}}"><i class="fas fa-edit "></i></a>
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
            
            <div class="modal fade" id="editLevel_modal" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Modifier une filière </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    @if(count($levels))
                                    <form method="POST" action="{{ route('levels.update', $level) }}">
                                        @csrf
                                        @method('PATCH')

                                        <div class="modal-body">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="name">Nom de la filière</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $level['name']}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="code">Code de la filière</label>
                                                    <input type="text" class="form-control" id="code" name="code"  value="{{ $level['code']}}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
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


<script>
function editLevel(el) {
  var link = $(el) //refer `a` tag which is clicked
  console.log('data',link.data('level'))
  let level = link.data('level')
  var modal = $("#editLevel_modal") //your modal
  console.log(name)
  modal.find('#name').val(level.name);
  modal.find('#code').val(level.code);
}
 
</script>
@stop