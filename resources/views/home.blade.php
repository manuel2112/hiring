@extends('layouts.app')

@section('content')

@if (Auth::check()) 
    <meta name="user_id" content="{{ Auth::user()->id }}" />
@endif 

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" id="app-vue">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
