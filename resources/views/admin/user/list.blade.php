@extends('layouts.admin.app')

@section('content')

<div class="content-wrapper">
	<div class="row">
		<div class="col-12 grid-margin">
		  <div class="card">
		    <div class="card-body">
		      <h4 class="card-title">Customer List</h4>
		      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
	                @if(Session::has('alert-' . $msg))
	                    <h4 class="font-weight-light alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</h4>
	                @endif
	            @endforeach
		      <div class="page-description">
		      	@if((Session::get('permissions.user_type') == 'A') || session()->has('permissions.user.add'))
			  	<div class="col-md-2 float-left">
					<a href="{{route('admin.user.add')}}" class="btn btn-primary">Add New</a>
				</div>
				@endif
				<div class="col-md-6 ">
				</div>
				<div class="col-md-4 float-right">
		      {!! Form::model($users, ['route' => ['admin.user.list'], 'class' => 'cmxform', 'method' => 'GET', 'novalidate'] ) !!}
			      	
					<div class="input-group pull-right">
	                	{!! Form::text('search', null, array('id' => 'search-field', 'class'=>'form-control', 'placeholder' => __('Search...'))) !!}
	                	<button type="submit" class="btn btn-info">
	                		<span class="input-group-addon d-flex align-items-center">
		                		<i class="icon-magnifier icons"></i>
		                	</span>
	                	</button>
						</div>
			      	
			     {!! Form::close() !!}
				 </div>
		      	<div class="clearfix"></div>
		      	@if($request->search != null)
			      	<div class="input-group col-lg-12 col-md-12 col-sm-12" style="font-size: 13px;">
			      		Searched for "{{ $request->search }}".&nbsp;&nbsp;<a href="{{ route('admin.user.list') }}">Clear Search</a>
			      	</div>
		      	@endif
		      </div>
			
		      	<div class="text-center-pagination">
					{{ $users->appends(request()->input())->links() }}
				</div>
		      <div class="row mt-2">
		        <div class="table-sorter-wrapper col-lg-12 table-responsive">
		          <table id="sortable-table-2" class="table table-striped">
		            <thead>
		              <tr>
		                <th>#</th>
		                <th class="sortStyle">
		                <!-- direction is by default true -->
		                	{!! CustomPaginator::sort('name', 'Name', ['direction' => true]) !!}
		                </th>
		                <th class="sortStyle">
		                	{!! CustomPaginator::sort('email', 'Email') !!}
		                </th>
		                <th class="sortStyle">Mobile Number</th>
						<!-- <th class="sortStyle">
		                	{!! CustomPaginator::sort('group_offer_id', 'Membership Levels') !!}
		                </th> -->
						
						<th class="sortStyle">
		                	{!! CustomPaginator::sort('last_login', 'Last Login') !!}
		                </th>
						
		                <th class="sortStyle">
		                	
							{!! CustomPaginator::sort('created_at', 'Signup Date') !!}
		                </th>
		                <th class="sortStyle">
						{!! CustomPaginator::sort('is_block', 'Status') !!}
						</th>
		                <th class="sortStyle">Action</th>
		              </tr>
		            </thead>
		            <tbody>
		            <?php $i = ($users->currentPage() - 1) * $users->perPage() + 1; ?>
		            	@if($users->count() == 0)
							<tr>
								<td colspan="8">No records found!</td>
							</tr>
		            	@endif
		            	@foreach($users as $key => $user)
							<tr>
								<td>{{ $i + $key }}</td>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ (isset($user->mobile) && !empty($user->mobile)) ? $user->mobile : 'N/A' }}</td>
								<!-- <td>{{ $user->title }}</td> -->
								<td>{{ date('d/m/Y' , strtotime($user->last_login)) }}</td>
								<td>{{ date('d/m/Y' , strtotime($user->created_at)) }}</td>
								<td>
									<label class="badge @if($user->is_block == 'N' && $user->status == 'A') badge-success @elseif($user->is_block == 'Y') badge-danger @elseif($user->is_block == 'N' && $user->status == 'I') badge-warning @endif">
										@if($user->is_block == 'Y')
											Blocked
										@elseif($user->is_block == 'N' && $user->status == 'A')
											Active
										@elseif($user->is_block == 'N' && $user->status == 'I')
											Inactive
										@endif
									</label>
								</td>
								<td>

									<div  class="nav-item nav-profile dropdown">
							            <a class="nav-link profile-image" href="#" data-toggle="dropdown" id="profileDropdown">
							            	<i class="fas fa-ellipsis-v"></i>
							            </a>
						            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

									<a target="_blank" href="{{ route('admin.orders.list','search='.urlencode($user->email)) }}" title="Orders">
										<i class="fas fa-shopping-cart"></i>
									</a>
									
									<!-- <a target="_blank" href="{{ route('admin.orders.wallet_balance','search='.urlencode($user->email)) }}" title="Wallet Balance">
										<i class="fas fa-money-check"></i>
									</a> -->
									
								<!-- 	<a title="Addesss" target="_blank" href="{{ route('admin.user.addAddress', base64_encode($user->id).'?redirect='.urlencode($request->fullUrl())) }}">
										<i class="fas fa-map-marked-alt"></i>
									</a>
									 -->
									@if((Session::get('permissions.user_type') == 'A') || session()->has('permissions.user.edit'))
									<a class="dropdown-item" title="Edit User" href="{{ route('admin.user.edit', base64_encode($user->id).'?redirect='.urlencode($request->fullUrl())) }}">
										<i class="fas fa-pencil-alt"></i> &nbsp;Edit
									</a>
									@endif
									
									<a class="dropdown-item text-danger" title="Delete User" onclick="return confirm('Are you sure you want to delete the user?')" href="{{ route('admin.user.delete', base64_encode($user->id)) }}">
										<i class="fas fa-trash-alt"></i>  &nbsp;&nbsp;Delete
									</a>
										@if($user->is_block == 'Y')
											<a class="dropdown-item" title="Update Status" onclick="return confirm('Are you sure you want to unblock the product?')" href="{{ route('admin.user.status', [base64_encode($user->id), $user->is_block]) }}">
											<i class="fas fa-lock" title="Click to unblock"></i> &nbsp;&nbsp;Unlock
										</a>
										@elseif($user->is_block == 'N')
											<a class="dropdown-item" title="Update Status" onclick="return confirm('Are you sure you want to block the product?')" href="{{ route('admin.user.status', [base64_encode($user->id), $user->is_block]) }}">
											<i class="fas fa-unlock" title="Click to block"></i> &nbsp;&nbsp;Lock
										</a>
										@endif
									
								</div>
								</div>
								</td>
							</tr>
						@endforeach
		            </tbody>
		          </table>
		        </div>
		      </div>
		     	<div style="font-size: 15px;">
		     		Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
		     	</div>
		      	<div class="text-center-pagination">
					{{ $users->appends(request()->input())->links() }}
				</div>
		    </div>
		  </div>
		</div>
	</div>
</div>

@endsection