@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="margin-top: 100px">
                    <div class="card-header">@isset($session) Edit session @else Add session @endisset</div>

                    <div class="card-body">
                        <form method="POST" action="/submit-session">
                            @csrf

                            <div class="form-group row">
                                <label for="date_time" class="col-md-4 col-form-label text-md-right">Date</label>

                                <div class="col-md-6">
                                    <input id="date_time" type="datetime-local" class="form-control @error('date_time') is-invalid @enderror" name="date_time"
                                        @if(old('date_time')!=null)
                                            value="{{date("Y-m-d", strtotime(old('date_time')))}}T{{date("H:i", strtotime(old('date_time')))}}"
                                        @else
                                            @isset($session)
                                                value="{{date("Y-m-d", strtotime($session->date_time))}}T{{date("H:i", strtotime($session->date_time))}}"
                                            @endisset
                                        @endif>

                                    @error('date_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="hall_size" class="col-md-4 col-form-label text-md-right">Hall Size</label>

                                <div class="col-md-6">
                                    <select id="hall_size" class="form-control @error('hall_size') is-invalid @enderror" name="hall_size" required>
                                        <option value="32"
                                                @if(old('hall_size')!=null)
                                                    @if(old('hall_size')==32)
                                                        selected
                                                    @endif
                                                @else
                                                    @if(isset($session) && $session->hall_size==32) selected @endif
                                                @endif>
                                            small: 32 seats
                                        </option>
                                        <option value="54"
                                                @if(old('hall_size')!=null)
                                                    @if(old('hall_size')==54)
                                                        selected
                                                    @endif
                                                @else
                                                    @if(isset($session) && $session->hall_size==54) selected @endif
                                                @endif>
                                            medium: 54 seats
                                        </option>
                                        <option value="98"
                                                @if(old('hall_size')!=null)
                                                    @if(old('hall_size')==98)
                                                        selected
                                                    @endif
                                                @else
                                                    @if(isset($session) && $session->hall_size==98) selected @endif
                                                @endif>
                                            large: 98 seats
                                        </option>
                                    </select>

                                    @error('hall_size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @isset($session)
                                <input type="hidden" name="action" value="edit" >
                                <input type="hidden" name="id" value="{{$session->id}}">
                            @else
                                <input type="hidden" name="action" value="add" >
                                <input type="hidden" name="movie_id" value={{$movie_id}}>
                            @endisset

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @isset($session)
                                            Edit
                                        @else
                                            Add
                                        @endisset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
