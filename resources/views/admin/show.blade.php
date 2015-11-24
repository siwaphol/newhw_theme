@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Admin</div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                   <th>ID.</th><th>username</th><th>Name</th><th>email</th>
                               </tr>
                               @foreach($admin as $item)
                               <tr>
                                   <td>{{ $item->id }}</td><td>{{ $item->username }}</td><td>{{ $item->firstname_th." ".$item->lastname_th }}</td><td>{{ $item->email }}</td>
                               </tr>
                               @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection