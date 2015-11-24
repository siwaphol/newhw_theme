@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h2>ข้อมูลผู้ใช้งาน</h2></div>

				<div class="panel-body">
					<h3>ชื่อ : {{Auth::user()->name}}</h3>  <br/>
					<h3>คณะ :</h3> <br/>
					@if(Auth::user()->role == "student")
					    <h3>รหัสนักศึกษา</h3> : <br/>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection