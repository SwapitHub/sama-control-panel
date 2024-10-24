@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Diamond Shape List
							<small>Diamond Admin panel</small>
						</h3>
					</div>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb pull-right">
						<li class="breadcrumb-item">
							<a href="{{ route('admin.dashboard') }}">
								<i data-feather="home"></i>
							</a>
						</li>
						<li class="breadcrumb-item">Product Management</li>
						<li class="breadcrumb-item active">Diamond shape list</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->

	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<a href="{{ route('admin.addshape') }}" type="button" class="btn btn-primary add-row mt-md-0 mt-2">Add
						Shape</a>
					</div>

					<div class="card-body">
						<div class="table-responsive table-desi">
							<table class="table all-package table-category " id="editableTable">
								<thead>
									<tr>
										<th>
											<span type="button"
											class="badge badge-primary  add-row delete_all"><i class="fa fa-trash"></i></span>
										</th>
										<th>Shape</th>
										<!--th>Slug</th-->
										<th>Image</th>
										<th>Status</th>
										<!--th>Order</th-->
										<th>Option</th>
									</tr>
								</thead>

								<tbody>
									@foreach($shapeList as $item)
									<tr><input type="hidden" value="{{ url($prifix.'/deleteshape') }}" name="url" id="url"></tr>
									<tr data-row-id="{{ $item->id }}">
										<td>
											<input class="checkbox_animated check-it" type="checkbox"
											value="" id="flexCheckDefault" data-id="{{ $item->id }}">
										</td>
										<td data-field="name"> <span data-bs-toggle="tooltip" data-bs-placement="top" title="slug: {{ $item->slug }}">{{ $item->shape }}</span> <span  data-bs-toggle="tooltip" data-bs-placement="top" title="Order" class="badge badge-dark">{{ $item->order_number }}</span></td>

										<!--td data-field="slug">{{ $item->slug }}</td-->
										<td data-field="image"><a href="{{ asset('storage/app/public') }}/{{ $item->icon }}" target="_blank"><img src="{{ env('AWS_URL') }}public/{{ $item->icon }}"/></a></td>

										<td data-field="status">
											<span class="badge badge-{{ ($item->status =='true')?'success':'primary' }}">{{ ($item->status =='true')?'Active':'Inactive' }}</span>
										</td>
										<!--td data-field="order_number">{{ $item->order_number }}</td-->
										<td>
											<a href="{{ route('admin.editshape',['id'=>$item->id]) }}">
												<i class="fa fa-edit" title="Edit"></i>
											</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
							<div class="dataTables_paginate paging_simple_numbers d-flex justify-content-between align-items-center">
								<div>
									Showing {{ $shapeList->firstItem() }} to {{ $shapeList->lastItem() }} of total {{$shapeList->total()}} entries
								</div>
								<div class="float-end">
									<p>{{ $shapeList->links() }}</p>
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
