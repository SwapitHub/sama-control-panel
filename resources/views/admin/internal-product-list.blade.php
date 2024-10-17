@extends('layouts.layout')
@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>Internal Products
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
                            <li class="breadcrumb-item">Products</li>
                            <li class="breadcrumb-item active">Products List</li>
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
                        <div class="card-header" style="display:initial">

                            <div class="row" role="group" aria-label="Basic outlined example">
                                <div class="col-md-8">
                                    <form method="GET" class="row gx-3 gy-2 align-items-center">

                                        <div class="col-sm-3">
                                            <label class="visually-hidden" for="specificSizeInputName">Name</label>
                                            <input type="text" name="filter" class="form-control"
                                                value="{{ request()->input('filter') }}"
                                                placeholder="search by SKU,NAME,ENTITY ID">
                                        </div>
                                        <div class="col-sm-3">
                                            <select class="form-select" id="specificSizeSelect" name="type">
                                                <option value="all"
                                                    {{ request()->input('type') == 'all' ? 'selected' : '' }}>All</option>
                                                <option value="parent_product"
                                                    {{ request()->input('type') == 'parent_product' ? 'selected' : '' }}>
                                                    Parent
                                                    Product</option>
                                                <option value="child_product"
                                                    {{ request()->input('type') == 'child_product' ? 'selected' : '' }}>
                                                    Child
                                                    Product</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <select class="form-select" id="specificSizeSelect" name="menu">
                                                <option value="all"
                                                    {{ request()->input('menu') == 'all' ? 'selected' : '' }}>All</option>

                                            </select>
                                        </div>

                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 float-right">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#addModal">import <i class="fa fa-upload"></i></button>
                                    <a href="{{ route('internal.products.export') }}" type="button"
                                        class="btn btn-primary">Export <i class="fa fa-download"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-desi">
                                <table class="all-package coupon-table table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Sku</th>
                                            <th>on parent sku</th>
                                            {{-- <th>Sama Sku</th>
                                            <th>sama parent sku </th> --}}
                                            <th>fractionsemimount</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $index => $item)

                                            <tr>


                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->sama_sku }}</td>
                                                <td>{{ $item->sama_parent_sku }}</td>

                                                <td>{{ $item->fractionsemimount }}</td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div
                                class="dataTables_paginate paging_simple_numbers d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $list->firstItem() }} to {{ $list->lastItem() }} of total
                                    {{ $list->total() }} entries
                                </div>
                                <div class="float-end">
                                    <p>{{ $list->links() }}</p>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- Modal -->

        {{-- create product model --}}
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Import</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form action="{{ route('sama.product.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Menu</label>
                                <select name="menu" id="" required class="form-control">
                                    <option selected disabled>choose menu</option>
                                    @foreach ($menus  as $menu)
                                        <option value="{{ $menu->name }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="file" name="excel_file" class="form-control" accept=".xlsx, .xls, .csv">
                                <span class="errors"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
        @endpush
    @endsection
