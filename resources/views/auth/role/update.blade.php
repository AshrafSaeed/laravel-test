@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
	    <div class="col-md-12 align-right">            
	        <h3 class="panel-heading"><strong>Update {{ $role->name }} Role</strong></h3>	
	    </div>
	</div>

    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">  
            	 <form method="POST" action="{{ route('role.update', $role->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',  $role->name ) }}" required >

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

			        <div class="form-group row">
					    @foreach ($permissions as $permission)

                            <div class="col-md-3">

					        	<div class="checkbox">
								  	<label><input type="checkbox" value="{{ $permission->id }}" name="permissions[]" {{ ($role->hasPermissionTo($permission->id)) ? 'checked' : '' }} /> {{ ucfirst($permission->name) }}</label>
								</div>
							</div>

					    @endforeach

			        </div>

			        <div class="form-group">
	                    <div class="col-md-6 col-md-offset-4">
	                        <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('role.index') }}" class="btn btn-primary">Back</a>

	                    </div>
	                </div>

                </form>

            </div>
        </div>
    </div>
</div>


@endsection