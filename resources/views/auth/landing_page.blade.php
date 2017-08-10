@extends('app')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- Simple login form -->
    <div class="login-container">
        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                <h5 class="content-group">Login to your CMU account</h5>
            </div>

            <div class="form-group text-center">
                <a href="{{url("oauth/login")}}" class="btn btn-primary">Login By CMU Account</a>
            </div>
        </div>
    </div>
    <!-- /simple login form -->
@endsection

