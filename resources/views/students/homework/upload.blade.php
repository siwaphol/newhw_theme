@extends('app')

@section('css')

@endsection

@section('content')

    <div>
        <h3 align="center">{{$course_no}} || {{$courseWithTeaAssist->name}} || {{$section}} </h3>
    </div>

    <h4 align="center"> LECTURER </h4>
    @foreach($courseWithTeaAssist->teachers as $teacher)
        <h5 align="center">{{$teacher->firstname_en.' '.$teacher->lastname_en}} </h5>
    @endforeach

    <div class="content">

        <!-- Task manager table -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title">Homework</h6>
            </div>

            <div class="panel-body">
                <h2>123123</h2>
            </div>
            <!-- /task manager table -->
        </div>

        @endsection
        @section('script')
            <script type="text/javascript">
                $(function() {
                    $("input:file").change(function (){
                        var fileName = $(this).val();
                        var expectedName = $(this).attr("data-expected-name").split(",");
                        if(expectedName.indexOf(fileName)>-1){
                            console.log("should submit");
                            return;
                        }
                        console.log("should alert wrong file name");
                    });
                });
            </script>
@endsection