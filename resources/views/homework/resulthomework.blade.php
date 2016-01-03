@extends('app')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

	@section('content')

	<?php

	$count=count($sent);
	$i=1;
	$j=0;
	?>

	<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default">
					<div class="panel-heading" align="center">ผลการส่งการบ้าน</div>

						<div class="panel-body">

	<div class="table-responsive">

	<table class="table table-bordered" id="example" cellspacing="0" width="100%" >
			<thead>
				<tr>
				<th>No</th>
			   <th>รหัส</th>
				@foreach($homework as $key)
				   <th>{{$key->name}}</th>

				@endforeach
				</tr>
			</thead>
			<tfoot>
						<tr>
						<th>No</th>
					   <th>รหัส</th>
						@foreach($homework as $key1)
						   <th>{{$key1->name}}</th>

						@endforeach
						</tr>


			</tfoot>

			<tbody>
			@foreach($sent as $item)
				<tr>
					<td>{{$i++}}</td>
					<td>{{$item->student_id}}</td>
				   @foreach($homework as $key2)
				   <?php
					$sql=DB::select('select * from homework_student where homework_id = ? and student_id=?
									  and course_id=? and section=?
									  ',array($key2->id,$item->student_id,$course['course'],$course['sec']));
					$hw=count($sql);

					if($hw>0){
					   if($sql[0]->status==1){
					   echo "<td>ok</td>";
					   }elseif($sql[0]->status==2){
						  echo "<td>late</td>";
						  }elseif($sql[0]->status==3){
						  echo "<td>!!!</td>";
						  }else{

							 echo "<td>No</td>";
							}

							}else{
							echo "<td>No</td>";
							}
					?>

					@endforeach


				</tr>

			  @endforeach
		   </tbody>
		</table>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>


	@endsection
	@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>

      <script type="text/javascript">

    $(document).ready(function() {
        $('#example').dataTable( {
            "order": [[ 0, "desc" ]],
            "scrollX": true
        } );
    } );

        </script>

    @endsection
