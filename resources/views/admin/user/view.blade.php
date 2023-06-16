@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('js/admin/misc.js') }}"></script>
<script src="{{ asset('js/admin/tinymce.min.js') }}"></script>
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
				<h4 class="card-title">User Detail</h4>
					<p class="card-description">
						Personal info
					</p>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label font-weight-bold">Name</label>
								<div class="col-sm-9">
									{{ $users->name }}
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label font-weight-bold">Email</label>
								<div class="col-sm-9">
									{{ $users->email }}
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label font-weight-bold">Mobile</label>
								<div class="col-sm-9">
									{{ !empty($users->mobile) ? $users->mobile : 'N/A' }}
								</div>
							</div>
						</div>
					</div>
					<!-- <p class="card-description">
					Address
					</p>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Address 1</label>
								<div class="col-sm-9">
									<input type="text" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">State</label>
								<div class="col-sm-9">
									<input type="text" class="form-control">
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection