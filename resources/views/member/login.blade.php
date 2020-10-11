@extends('basic')

@section('StyleSheet')
    <link rel="stylesheet" href="{{ asset('res/bootstrap-social-5.1.1.min.css') }}">
@endsection

@section('Content')
    <section class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="font-weight-light text-center my-1">Login</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('login.social', [ 'provider' => 'facebook', 'path' => request()->get('path') ]) }}" class="btn btn-facebook btn-block">
                            <i class="fab fa-facebook-f fa-tw"></i>
                            Sign in with Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('Footer', '')
