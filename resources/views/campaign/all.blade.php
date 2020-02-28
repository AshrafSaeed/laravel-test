@extends('layouts.app')

@section('content')
<div class="container">
    
    @can('create campaign')
        <div class="row">
    	    <div class="col-md-12 align-right">            
    		    <a href="{{ route('campaign.create') }}" class="btn btn-primary">Add New Campaign</a>
    		</div>
    	</div>
    @endcan
    
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
                            <th>Campaign Name</th>
                            <th>Campaign Brand</th>
                            <th>Campaign Location</th>
                            <th>Is Published</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Action</th>     
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($campaigns as $campaign)
                            
                            <tr>
                                <td>{{ $campaign->name }}</th>    
                                <td>{{ $campaign->brand->name }}</td>
                                <td>{{ $campaign->location->name }}</td>
                                <td>{{ ($campaign->is_publish) ? 'Publish' : 'Unpublish'  }}</td>
                                
                                <td>{{ $campaign->user->name }}</td>
                                <td>{{ $campaign->created_at }}</td>
                                <td>
                                    <form action="{{ route('campaign.destroy', $campaign->id) }}" method="POST" id="deleteCampaign{{ $campaign->id }}">

                                        @can('update campaign')
                                            <a href="{{ route('campaign.edit', $campaign->id) }}" class="btn btn-primary">Update</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')

                                        @can('update campaign')
                                            <button type="button" onclick="delete_campaign({{ $campaign->id }});" name="delete_btn" class="btn btn-danger">Delete</button>
                                        @endcan

                                    </form>

                                    <form action="{{ ($campaign->is_publish) ? route('campaign.unpublish', $campaign->id) : route('campaign.publish', $campaign->id) }}" method="POST" id="publishCampaign">

                                        @csrf
                                        
                                        @method('PATCH')


                                        @can('publish campaign')
                                            <button type="submit" name="delete_btn" class="btn btn-info">{{ ($campaign->is_publish) ? 'Unpublish' : 'Publish'  }}</button>
                                        @endcan

                                    </form>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>

             
                {{ $campaigns->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
