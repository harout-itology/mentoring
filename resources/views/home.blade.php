@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Upload CSV') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <form method="POST" action="{{ route('mentoring.store') }}" enctype="multipart/form-data" >
                            @csrf
                            <div class="form-group row">
                                <label for="file" class="col-md-2 col-form-label">{{ __('CSV File:') }}</label>
                                <div class="col-md-8">
                                    <input id="file" type="file" class="form-control-file @error('file') is-invalid @enderror" name="file" required autofocus>
                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{!! $message  !!}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="header" id="header" checked value="1">
                                        <label class="form-check-label" for="header">
                                            {{ __('File contains header row?') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-2">
                                    <button type="submit" class="btn btn-outline-primary">
                                        {{ __('Parse CSV') }}
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-right">
                                    <a href="/files/employee.csv">CSV Example with full information</a>
                                </div>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
