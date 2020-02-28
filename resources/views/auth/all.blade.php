@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
	    <div class="col-md-12 align-right">            
		    <a href="{{ route('user.create') }}" class="btn btn-primary">Add New User</a>
            <a href="{{ route('role.index') }}" class="btn btn-primary">Update Role Permission</a>
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
    
                <table class="table">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Action</th>     
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($users as $user)
                            
                            <tr>
                                <td>{{ $user->name }}</th>    
                                <td>{{ $user->email }}</td>
                                <td>{{ ($user->is_active) ? 'Active' : 'Inactive' }}</td>
                                <td>{{ str_replace(array('[',']','"'),'', $user->getRoleNames()) }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" id="deleteUser{{ $user->id }}">

                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Update</a>
                       
                                        @csrf
                                        @method('DELETE')
                          
                                        <button type="button" onclick="delete_user({{ $user->id }});" name="delete_btn" class="btn btn-danger">Delete</button>

                                    </form>

                                    <form action="{{ ($user->is_active) ? route('user.inactive', $user->id) : route('user.active', $user->id) }}" method="POST" id="activeUser">

                                        @csrf
                                        
                                        @method('PATCH')


                                        @can('publish campaign')
                                            <button type="submit" name="delete_btn" class="btn btn-info">{{ ($user->is_active) ? 'Make Inctive' : 'Make Active'  }}</button>
                                        @endcan

                                    </form>

                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>

             
                {{ $users->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
