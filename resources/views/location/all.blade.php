@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
	    <div class="col-md-12 align-right">            
		    <a href="{{ route('location.create') }}" class="btn btn-primary">Add New Locations</a>
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
                            <th>Location Name</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Action</th>     
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($locations as $location)
                            
                            <tr>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->user->name }}</td>
                                <td>{{ $location->created_at }}</td>
                                <td>
                                    <form action="{{ route('location.destroy', $location->id) }}" method="POST" id="deleteLocation{{$location->id}}">

                                        <a href="{{ route('location.edit', $location->id) }}" class="btn btn-primary">Update</a>
                       
                                        @csrf
                                        @method('DELETE')
                          
                                        <button type="button" onclick="delete_location({{ $location->id }});" name="delete_btn" class="btn btn-danger">Delete</button>

                                    </form>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>

             
                {{ $locations->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
