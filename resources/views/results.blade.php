@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Recommendation') }} <a style="float:right" href="/home"> << Back </a> </div>

                <div class="card-body">

                    <ul class="list-group">
                        @foreach($data as $result)
                            <li class="list-group-item d-flex justify-content-between align-items-center ">
                                {{ $result['text']  }}
                                <span class="badge badge-primary badge-pill"> {{ $result['score']  }}%</span>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
