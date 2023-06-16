@extends('layouts.admin.app')

@section('content')
<style type="text/css">
	.table th img, .table td img{
		width: 100px;
    	height: auto;
    	border-radius: 0;
	}
</style>
<div class="content-wrapper">
	<div class="row">
		<div class="col-12 grid-margin">
		  <div class="card">
		    <div class="card-body">
		      <h4 class="card-title">Home page Layout Manage</h4>
		      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
	                @if(Session::has('alert-' . $msg))
	                    <h4 class="font-weight-light alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</h4>
	                @endif
	            @endforeach
		      <div class="page-description">
			  <div class="col-md-2 float-left">
					<a href="{{route('admin.banner.add')}}" class="btn btn-primary">Add New</a>
				</div>
				<div class="col-md-10 float-right">
		      {!! Form::model($layouts, ['route' => ['admin.banner.list'], 'class' => 'cmxform', 'method' => 'GET', 'novalidate'] ) !!}
			      	<div class="input-group col-lg-3 col-md-3 col-sm-3 float-right">
	                	{!! Form::text('search', null, array('id' => 'search-field', 'class'=>'form-control', 'placeholder' => __('Search...'))) !!}
	                	<button type="submit" class="btn btn-info">
	                		<span class="input-group-product_extra d-flex align-items-center">
		                		<i class="icon-magnifier icons"></i>
		                	</span>
	                	</button>
			      	</div>
			     {!! Form::close() !!}
				 </div>
		      	<div class="clearfix"></div>
		      	@if($request->search != null)
			      	<div class="input-group col-lg-12 col-md-12 col-sm-12" style="font-size: 13px;">
			      		Searched for "{{ $request->search }}".&nbsp;&nbsp;<a href="{{ route('admin.banner.list') }}">Clear Search</a>
			      	</div>
		      	@endif
		      </div>
		      <div class="row">
		        <div class="table-sorter-wrapper col-lg-12 table-responsive">
		          <table id="sortable-table-2" class="table table-striped">
		            <thead>
		              	<tr>
			                <th>#</th>
			                <th class="sortStyle">
			                	Title
			                </th>
			                <th class="sortStyle">
			                	{!! CustomPaginator::sort('created_at', 'Created') !!}
			                </th>
			                <th class="sortStyle">Status</th>
			                <th class="sortStyle">Action</th>
		              	</tr>
		            </thead>
		            <tbody>
		            	<?php $i = ($layouts->currentPage() - 1) * $layouts->perPage() + 1; ?>
		            	@if($layouts->count() == 0)
							<tr>
								<td colspan="5">No records found!</td>
							</tr>
		            	@endif
		            	@foreach($layouts as $key => $banner)
							<tr>
								<td>{{ $i + $key }}</td>
								<td>{{ $banner->layout_title }}</td>
								<td>{{ date('d/m/Y' , strtotime($banner->created_at)) }}</td>
								<td>
									<label class="badge @if($banner->status == 'A') badge-success @elseif($banner->status == 'I') badge-danger @endif">
										@if($banner->status == 'A')
											Live
										@elseif($banner->status == 'I')
											Block
										@endif
									</label>
								</td>
								<td>
									<a href="{{ route('admin.layout.edit', base64_encode($banner->id).'?redirect='.urlencode($request->fullUrl())) }}">
										<i class="fas fa-pencil-alt"></i>
									</a>
									<a onclick="return confirm('Are you sure you want to delete the layout?')" href="{{ route('admin.layout.delete', base64_encode($banner->id)) }}">
										<i class="fas fa-trash-alt"></i>
									</a>

									@if($banner->status == 'I')
										<a onclick="return confirm('Are you sure you want to unblock the layout?')" href="{{ route('admin.layout.status', [base64_encode($banner->id), $banner->status]) }}"><i class="fas fa-lock" title="Click to unblock"></i></a>
									@elseif($banner->status == 'A')
										<a onclick="return confirm('Are you sure you want to block the layout?')" href="{{ route('admin.layout.status', [base64_encode($banner->id), $banner->status]) }}"><i class="fas fa-unlock" title="Click to block"></i></a>
									@endif
									</a>
								</td>								
							</tr>
						@endforeach
		            </tbody>
		          </table>
		        </div>
		      </div>
		     	<div style="font-size: 15px;">
		     		Showing {{ $layouts->firstItem() }} to {{ $layouts->lastItem() }} of {{ $layouts->total() }} entries
		     	</div>
		      	<div class="text-center-pagination">
					{{ $layouts->appends(request()->input())->links() }}
				</div>
		    </div>
		  </div>
		</div>
	</div>
</div>

@endsection