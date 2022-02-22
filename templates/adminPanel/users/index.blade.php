@extends('layouts.master')

@section('contentPage')

<div class="float-left">
    <h2>Użytkownicy</h2>

</div>
<div class="float-right row mb-2 mr-2">
    <form class="form-inline" action="{{ route('users.index') }}">
        <div class="form-row">
            <label class="my-1 mr-2" for="phrase">Szukaj użytkownika:</label>
            <div class="col">
                <input type="text" class="form-control" name="phrase" placeholder="" value="{{ $phrase ?? '' }}">
            </div>
            @php
                $type = $type ?? '';
            @endphp
            <div class="col-auto">
                <select class='custom-select mr-sm-2' name="type" id="type">
                       <option value="0"> Wszyscy</option>
                        <option value="4"> Brak roli</option>
                        <option value="1"> Uczeń</option>
                        <option value="2"> Nauczyciel</option>
                        <option value="3"> Administrator</option>

                </select>
            </div>
            <button class="btn btn-primary" type="sumbit">Wyszukaj</button>
        </div>
    </form>
</div>

        <table class="table shadow-lg p-3 mb-5 bg-white rounded" >
            <thead class="thead-light">
            <tr>
                <th>Nr</th>
                <th>Imie</th>
                <th>Nazwisko</th>
                <th>PESEL</th>
                <th>Email</th>
                <th>Rola</th>
                <th>Klasa</th>
                <th >Akcja</th>
            </tr>
        </thead>
            <tbody class="">
                @foreach ($users as $user)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->pesel }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ( $user->role ==0)
                            Brak roli
                        @elseif ( $user->role == 1)
                            Uczeń
                        @elseif ( $user->role == 2)
                            Nauczyciel
                        @elseif ( $user->role ==  3)
                        Administrator
                        @endif
                    </td>
                    <td>
                        @if (isset($user->class_name->name))
                            {{$user->class_name->name}}
                        @else
                        Brak przypisanej
                        @endif

                    </td>
                    <td class="row">
                        <a
                        type="submit"
                        class="btn btn-warning mr-1 editModal"
                        data-toggle="modal"
                        data-target="#editUserModal-{{$user->id}}">
                        Edytuj
                    </a>

                        <form action="{{ route('adminPanel.subjects.index',$user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Usuń</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {!! $users->links() !!}
        </div>
        {{-- Modal --}}
        @foreach ($users as $user)
        <div class="modal fade" id="editUserModal-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="editUserModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModal">Edycja użytkownika</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                            <div class="modal-body">
                                <p>Imię: {{$user->name}}</p>
                                <p>Nazwisko: {{$user->surname}}</p>
                                <p>Email: {{$user->email}}</p>
                                <p>PESEL: {{$user->pesel}}</p>
                                <p>Data rejestracji: {{$user->created_at}}</p>
                                <p>Ostatnio modyfikowany: {{$user->updated_at}}</p>

                                <form action="{{ route('users.update',$user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <strong>Rola:</strong>
                                    <select type="text" name="role" id="role" class="form-control role">
                                        <option @if ($user->role =='0') selected @endif value="0">Brak roli</option>
                                        <option @if ($user->role =='1') selected @endif value="1">Uczeń</option>
                                        <option @if ($user->role =='2') selected @endif value="2">Nauczyciel</option>
                                        <option @if ($user->role =='3') selected @endif value="3">Administrator</option>
                                        @error('role')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </select>
                                </div>

                                <div class="form-group class_name_id">
                                    <strong>Klasa:</strong>
                                    <select type="text" name="class_name_id" id="class_name_id" class="form-control class_name_id">
                                        <option @if ($user->class_name_id =='0') selected @endif value="0">Brak klasy</option>
                                        @foreach ($classes as $class )
                                            <option @if ($user->class_name_id == $class->id) selected @endif value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach

                                        @error('class_name_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </select>

                                </div>
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                                    <button type="submit" class="btn btn-primary">Zatwierdź</button>
                                </form>
                         </div>
                </div>
            </div>
        </div>
        @endforeach
    @endsection
