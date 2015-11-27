@extends('app')

@section('content')
<!-- Simple login form -->
<form method="POST" action="{{ url('/auth/login') }}" class="login-container">
	<div class="panel panel-body login-form">
		<div class="text-center">
			<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
			<h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
		</div>

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

		<div class="form-group has-feedback has-feedback-left">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Username" name="email">
                <span class="input-group-addon" id="basic-addon2">@cmu.ac.th</span>
            </div>
			<div class="form-control-feedback">
				<i class="icon-user text-muted"></i>
			</div>
		</div>

		<div class="form-group has-feedback has-feedback-left">
			<input type="password" class="form-control" placeholder="Password" name="password">
			<div class="form-control-feedback">
				<i class="icon-lock2 text-muted"></i>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
		</div>

	</div>
</form>
<!-- /simple login form -->
@endsection

