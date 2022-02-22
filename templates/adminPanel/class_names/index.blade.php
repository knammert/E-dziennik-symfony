@extends('layouts.master')

@section('contentPage')

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <h2>Klasy</h2>
                </div>
                <div class="float-right">
                    {{-- <a class="btn btn-success" href="{{ route('adminPanel.class_names.create') }}"> Dodaj nową klasę</a> --}}
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                        Dodaj nową klasę
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Dodawanie nową klasę</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('adminPanel.class_names.store') }}" method="POST">
                            @csrf
                                <div class="form-group">
                                    <strong>Nazwa klasy:</strong>
                                    <input type="text" name="name" class="form-control">
                                </div>
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                                <button type="submit" class="btn btn-primary">Dodaj nową klasę</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>

        <table  class="table table-bordered shadow-lg p-3 mb-5 bg-white rounded">
            <tr>
                <th>Nr</th>
                <th>Nazwa klasy</th>

                <th width="280px">Akcja</th>
            </tr>
            @foreach ($class_names as $class_name)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $class_name->name }}</td>
                <td>
                    <form action="{{ route('adminPanel.class_names.destroy',$class_name->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Usuń klasę</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="d-flex justify-content-center">
        {!! $class_names->links() !!}
        </div>
    @endsection
