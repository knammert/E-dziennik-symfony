@extends('layouts.master')

@section('contentPage')
<div class="row mr-1">
    <div class="col-lg-12 ">
        <div class="float-left">
            <h2>Plan lekcji</h2>
        </div>
        @if (Auth::user()->role == 3)
            <div class="float-right row mb-2">
                <!-- Wyszukiwarka użytkowników -->
                <form class="form-inline" action="{{ route('calendarIndex') }}">
                    <div class="form-row">
                        @php
                            $typeClassId = $typeClassId ?? '';
                        @endphp
                        <div class="col-auto">

                            <select class='custom-select mr-sm-2' name="typeClassId" id="typeClassId" style='width:150px;'>
                                @foreach ($activities as $activitie)

                                    <option @if ( Request::get('typeClassId')  == $activitie->id) selected @endif value="{{$activitie->id}}"> Klasa: {{$activitie->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary mr-3" type="sumbit">Wyszukaj</button>
                    </div>
                </form>
            </div>
        @endif

    <table class="table shadow-lg p-3 mb-5 bg-white" style='border-collapse: separate;'>

        <thead class='thead-light'>
            <th width="125">Czas</th>
            @foreach($weekDays as $day)
                <th>{{ $day }}</th>
            @endforeach
        </thead >
        <tbody>
            @php
                $i=0;
            @endphp
            @foreach($calendarData as $time => $days)
                <tr >
                    <td class="table-light">
                    <b> {{ $time }}</b>
                    @foreach($days as $value)
                        @if (is_array($value))
                        @php
                            $i++;
                            if($i==4 && $value != 1){
                                $i=0;
                            }
                            $background_colors = array('#037bfc', '#fca503', '#b103fc', '#ed6d05', '#fc0356');
                            $rand_background = $background_colors[$i];
                        @endphp
                            <td rowspan="{{ $value['rowspan'] }}" class="align-middle text-center text-white "
                            style="border-radius: 20px; 40px; background-color:{{$rand_background}}; opacity:0.8;">
                                Przedmiot: {{ $value['subject_name'] }}<br>
                                @if (Auth::user()->role == 1)
                                Nauczyciel: {{ $value['teacher_name']}} {{$value['teacher_surname'] }}
                                @elseif ((Auth::user()->role == 2))
                                Klasa: {{ $value['class_name']}}
                                @else
                                Nauczyciel: {{ $value['teacher_name']}} {{$value['teacher_surname'] }}
                                Klasa: {{ $value['class_name']}}<br>
                                @endif
                            </td>
                        @elseif ($value === 1)
                            <td ></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    @endsection
