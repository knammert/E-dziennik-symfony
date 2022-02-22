@extends('layouts.master')

@section('contentPage')



        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <h2>Zajęcia</h2>
                </div>
                <div class="float-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                        Dodaj nowe zajęcia
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">
                       Dodaj zajęcia do kalendarza
                    </button>
                </div>

            </div>
        </div>



        <table  class="table table-bordered shadow-lg p-3 mb-5 bg-white rounded">
            <tr>
                <th>Nr</th>
                <th>Klasa</th>
                <th>Nazwa przedmiotu</th>
                <th>Przypisany nauczyciel</th>
                <th>Kalendarz</th>

                <th width="280px">Akcja</th>
            </tr>
            @foreach ($class_name_subjects as $class_name_subject)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $class_name_subject->class_name->name }}</td>
                <td>{{ $class_name_subject->subject->name }}</td>
                <td>{{ $class_name_subject->user->name }} {{ $class_name_subject->user->surname }}</td>
                <td>
                    @foreach ($class_name_subject->schedule as $obj)
                    @php
                        $weekMap = [
                        1 => 'PON',
                        2 => 'WT',
                        3 => 'ŚR',
                        4 => 'CZW',
                        5 => 'PT',
                        6 => 'SOB',
                        7 => 'ND'
                        ];
                        $dayOfTheWeek = $weekMap[$obj->weekday];
                    @endphp
                        {{ $dayOfTheWeek }}
                        {{ $obj->start_time }} -
                        {{ $obj->end_time }}<br>
                    @endforeach
                </td>
                <td>

                    <form action="{{ route('adminPanel.activities.destroy',$class_name_subject->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Usuń zajęcia</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="d-flex justify-content-center">
        {!! $class_name_subjects->links() !!}
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Dodawanie nowych zajęć</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('adminPanel.activities.store') }}" method="POST">
                                @csrf
                                    <div class="form-group">
                                        <strong>Klasa:</strong>
                                        <select type="text" name="class_name_id" id="class_name_id" class="form-control">
                                            @foreach ($class_names as $class_name)
                                                <option value="{{$class_name->id}}">{{$class_name->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <strong>Przedmiot:</strong>
                                        <select type="text" name="subject_id" id="subject_id" class="form-control">
                                            @foreach ($subjects as $subject)
                                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <strong>Nauczyciel:</strong>
                                        <select type="text" name="user_id" id="user_id" class="form-control">
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}} {{$user->surname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <strong>Dzień tygodnia:</strong>
                                        <select
                                            type="text"
                                            class="form-control @error('weekday') is-invalid @enderror"
                                            id="weekday"
                                            name="weekday">
                                            <option value="1">Poniedziałek</option>
                                            <option value="2">Wtorek</option>
                                            <option value="3">Środa</option>
                                            <option value="4">Czawartek</option>
                                            <option value="5">Piątek</option>
                                            <option value="6">Sobota</option>
                                            <option value="7">Niedziela</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <strong>Godzina rozpoczęcia:</strong>
                                        <input class="form-control lesson-timepicker {{ $errors->has('start_time') ? 'is-invalid' : '' }}"
                                        type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
                                        @if($errors->has('start_time'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('start_time') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <strong>Godzina zakończenia:</strong>
                                        <input class="form-control lesson-timepicker {{ $errors->has('end_time') ? 'is-invalid' : '' }}"
                                        type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                                        @if($errors->has('end_time'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('end_time') }}
                                            </div>
                                        @endif
                                    </div> --}}


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                                        <button type="submit" class="btn btn-primary">Dodaj nowe zajęcia</button>
                                    </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Dodawanie zajęć do kalendarza</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('adminPanel.storeSchedule') }}" method="POST">
                                @csrf
                                    <div class="form-group">
                                        <strong>Zajęcia:</strong>
                                        <select type="text" name="class_name_subject_id" id="class_name_subject_id" class="form-control">
                                            @foreach ($class_name_subjects as $subject)
                                                <option value="{{$subject->id}}">Zajęcia: {{$subject->subject->name}} {{$subject->class_name->name}} z {{$subject->user->name}} {{$subject->user->surname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <strong>Dzień tygodnia:</strong>
                                        <select
                                            type="text"
                                            class="form-control @error('weekday') is-invalid @enderror"
                                            id="weekday"
                                            name="weekday">
                                            <option value="1">Poniedziałek</option>
                                            <option value="2">Wtorek</option>
                                            <option value="3">Środa</option>
                                            <option value="4">Czawartek</option>
                                            <option value="5">Piątek</option>
                                            <option value="6">Sobota</option>
                                            <option value="7">Niedziela</option>
                                    </select>
                                    <div class="form-group">
                                        <strong>Godzina rozpoczęcia:</strong>
                                        <input class="form-control lesson-timepicker {{ $errors->has('start_time') ? 'is-invalid' : '' }}"
                                        type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
                                        @if($errors->has('start_time'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('start_time') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <strong>Godzina zakończenia:</strong>
                                        <input class="form-control lesson-timepicker {{ $errors->has('end_time') ? 'is-invalid' : '' }}"
                                        type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                                        @if($errors->has('end_time'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('end_time') }}
                                            </div>
                                        @endif
                                    </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                                        <button type="submit" class="btn btn-primary">Dodaj nowe zajęcia</button>
                                    </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
