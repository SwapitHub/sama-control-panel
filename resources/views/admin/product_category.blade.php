@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>{{ $title }}
							<small>Dimond Admin panel</small>
						</h3>
					</div>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb pull-right">
						<li class="breadcrumb-item">
							<a href="{{ url('admin/dashboard') }}">
								<i data-feather="home"></i>
							</a>
						</li>
						<li class="breadcrumb-item"><a href="{{ route($backtrack) }}">Product Category List</a></li>
						<li class="breadcrumb-item active">{{ $title }} </li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->

	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-12">
				<div class="card tab2-card">
					<div class="card-body">
						<ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
							<li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-bs-toggle="tab"
								href="#top-profile" role="tab" aria-controls="top-profile"
								aria-selected="true"><i data-feather="activity" class="me-2"></i>Product Category</a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ $url_action }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
									@csrf

									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>Category Name</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
											value="{!! old()?old('name'):$obj['name']??'' !!}" type="text" placeholder="Name">
											@error('name')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Slug </label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="slug" name="slug"
											value="{{ old('slug') }}" type="text" placeholder="{!! $obj['slug']??'slug' !!}">
											<small>(Leave blank if you want system generated)</small>
											@error('slug')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									{{-- <div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										<span>*</span>Image</label>
										<div class="col-xl-8 col-md-7">
											<input type="file" name="image" data-default-file="{{ old('image') ? old('image') : (isset($obj) && is_object($obj) && isset($obj->icon) ? asset('storage/app/public/' . $obj->icon) : '') }}"  class="form-control dropify">
											@error('image')
											<style> .dropify-wrapper { border:1px solid red;border-radius: 0.25rem; } </style>
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>

									</div> --}}
									{{-- <div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Order</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="order_number" value="{!! old()?old('order_number'):$obj['order_number']??'0' !!}" class="form-control">
										</div>

									</div> --}}
									<div class="form-group row">
										<label class="col-xl-3 col-md-4">Status</label>
										<div class="col-md-7">
											<div class="checkbox checkbox-primary">
												<input id="checkbox-primary-2"  type="checkbox" name="status"
												value="true" data-original-title="" {{ old('status') == 'true' || (isset($obj) && is_object($obj) && $obj->status == 'true') ? 'checked' : '' }} >
												<label for="checkbox-primary-2">Enable the category</label>
											</div>
										</div>
									</div>
									<div class="pull-left">
										<button type="submit" class="btn btn-primary submitBtn">Save <i
										class="fa fa-spinner fa-spin main-spinner d-none"></i></button>
									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
										</div>
										@endsection
