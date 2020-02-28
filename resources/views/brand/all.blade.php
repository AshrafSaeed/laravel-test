@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
	    <div class="col-md-12 align-right">            
		    <a href="{{ route('brand.create') }}" class="btn btn-primary">Add New Brand</a>
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
                            <th>Brand Name</th>
                            <th>Brand Description</th>
                            <th>Brand Image</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Action</th>     
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($brands as $brand)
                            
                            <tr>
                                <td>{{ $brand->name }}</th>    
                                <td>{{ $brand->description }}</td> 
                                <td><img src="{{ asset('storage/app/'.$brand->media->path) }}" ></td>
                                <td>{{ $brand->user->name }}</td>
                                <td>{{ $brand->created_at }}</td>
                                <td>
                                    <form action="{{ route('brand.destroy', $brand->id) }}" method="POST" id="deleteBrand{{ $brand->id }}">

                                        <a href="{{ route('brand.edit', $brand->id) }}" class="btn btn-primary">Update</a>
                       
                                        @csrf
                                        @method('DELETE')
                          
                                        <button type="button" onclick="delete_brand({{ $brand->id }});" name="delete_btn" class="btn btn-danger">Delete</button>

                                    </form>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>

             
                {{ $brands->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
