@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
	    <div class="col-md-12 align-right">            
            <h3 class="panel-heading"><strong>Roles</strong></h3>
		</div>
	</div>

    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">                 

                @if (session('status'))
                    <div class="panel-body">
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

		        <table class="table table-bordered table-striped">
		            <thead>
		                <tr>
		                    <th>Role</th>
		                    <th>Permissions</th>
		                    <th>Operation</th>
		                </tr>
		            </thead>

		            <tbody>
		                @foreach ($roles as $role)
		                <tr>
		                    <td>{{ $role->name }}</td>
		                    <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>
		                    <td>
		                    	<a href="{{ route('role.edit', $role->id) }}" class="btn btn-info pull-left">Edit</a>
		                    </td>
		                </tr>
		                @endforeach
		            </tbody>

		        </table>

		    </div>
		</div>
    </div>
</div>

@endsection