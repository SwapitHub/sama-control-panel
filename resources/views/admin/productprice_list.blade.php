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
                                <small>Diamond Admin panel</small>
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-right">
                            <li class="breadcrumb-item">
                                <a href="{{ url('dashboard') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ $backtrack }}">Products</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
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
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="project-status">
                                    <div class="table-responsive profile-table">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td>Product Name :</td>
                                                    <td><a href="{{ route('admin.product.edit', ['id' => $product->id]) }}"><b
                                                                class="font-bold">{{ $product->name }}</b></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Product Sku :</td>
                                                    <td><b class="font-bold">{{ $product->sku }}</b>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Internal Sku :</td>
                                                    <td><b>{{ $product->internal_sku }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Status :</td>
                                                    <td><span
                                                            class="text-capitalize badge badge-{{ $product->status == 'true' ? 'success' : 'primary' }}">{{ $product->status }}</span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="image">
                                    <img src="{{ $product->default_image_url }}" alt="Product Image" height="150"
                                        width="150">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Price</h5>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation " novalidate action="{{ route('admin.product.add') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_sku" value="{{ $product->sku }}">
                                <div class="form-group row">
                                    <label for="menuname" class="col-xl-3 col-md-4"><span>*</span> Metal
                                        Type</label>
                                    <div class="col-md-8">
                                        <select name="metalType" required class="form-control">
                                            <option selected disabled>--select--</option>
                                            <option value="18kt" {{ old('metalType') == '18kt' ? 'selected' : '' }}>18kt
                                            </option>
                                            <option value="Platinum"
                                                {{ old('metalType') == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                                        </select>
                                        @error('metalType')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="slug" class="col-xl-3 col-md-4"><span>*</span> Metal Color</label>
                                    <div class="col-md-8">
                                        <select name="metalColor" required class="form-control">
                                            <option selected disabled>--select--</option>
                                            <option value="White" {{ old('metalColor') == 'White' ? 'selected' : '' }}>
                                                White</option>
                                            <option value="Yellow" {{ old('metalColor') == 'Yellow' ? 'selected' : '' }}>
                                                Yellow</option>
                                            <option value="Pink" {{ old('metalColor') == 'Pink' ? 'selected' : '' }}>Pink
                                            </option>
                                        </select>
                                        @error('metalColor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="slug" class="col-xl-3 col-md-4"><span>*</span> Diamond Quality</label>
                                    <div class="col-md-8">
                                        <select name="diamondQuality" required class="form-control">
                                            <option selected disabled>--select--</option>
                                            <option value="SI1, G"
                                                {{ old('diamondQuality') == 'SI1, G' ? 'selected' : '' }}>SI1, G</option>
                                            <option value="LAB GROWN VS-SI1, E/F/G"
                                                {{ old('diamondQuality') == 'LAB GROWN VS-SI1, E/F/G' ? 'selected' : '' }}>
                                                LAB GROWN VS-SI1, E/F/G</option>
                                        </select>
                                        @error('diamondQuality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="slug" class="col-xl-3 col-md-4"><span>*</span> Finish Level</label>
                                    <div class="col-md-8">
                                        <select name="finishLevel" required class="form-control">
                                            <option selected disabled>--select--</option>
                                            <option value="Semi-mount"
                                                {{ old('finishLevel') == 'Semi-mount' ? 'selected' : '' }}>Semi-mount
                                            </option>
                                            <option value="Complete"
                                                {{ old('finishLevel') == 'Complete' ? 'selected' : '' }}>Complete</option>
                                            <option value="Polished Blank (no stones)"
                                                {{ old('finishLevel') == 'Polished Blank (no stones)' ? 'selected' : '' }}>
                                                Polished Blank (no stones)</option>
                                        </select>
                                        @error('finishLevel')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="image" class="col-xl-3 col-md-4"><span>*</span>
                                        Price</label>
                                    <div class="col-md-8">
                                        <input class="form-control" id="price" name="price" type="number" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @error('combination')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary d-block">Save</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                    <div class="table-responsive ">
                                        <table class="table all-package order-datatable" id="">
                                            <thead>
                                                <tr>
                                                    {{-- <th>SR</th> --}}
                                                    <th>Metal Type</th>
                                                    <th>Metal Color</th>
                                                    <th>Diamond Quality</th>
                                                    <th>Finish Level</th>
                                                    <th>Diamond Type</th>
                                                    <th>Reference Price</th>
                                                    <th>Discount Percentage</th>
                                                    <th>price</th>
                                                    <th>Options</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($prices as $index => $item)
                                                    <tr>
                                                        {{-- <td data-field="text">{{ $index + 1 }}</td> --}}
                                                        {{-- <td data-field="text">{{ $item->id }}</td> --}}
                                                        <td data-field="text">{{ $item->metalType }} </td>
                                                        <td data-field="text">{{ $item->metalColor }}</td>
                                                        <td data-field="text">{{ $item->diamondQuality }}</td>
                                                        <td data-field="text">{{ $item->finishLevel }}</td>
                                                        <td data-field="text">{{ $item->diamond_type == 'natural'?'Natural':'Lab grown'; }}</td>
                                                        <td data-field="text">${{ $item->reference_price ?? 0 }}</td>
                                                        <td data-field="text">{{ $item->discount_percentage ?? 0 }}%</td>
                                                        <td data-field="text">${{ $item->price ?? 0 }}</td>

                                                        <td>
                                                            <a href="javascript:void(0)"
                                                                onclick="editPrice({{ $item->id }},{{ $item->price }})">
                                                                <i class="fa fa-edit" title="Edit"></i>
                                                            </a>

                                                            {{-- <a href="javascript:void(0)" title="Delete Language"
                                                                onclick="deleteItem('{{ url('delete-product-subcategory') }}/{{ $item->id }}')">
                                                                <i class="fa fa-trash" title="Delete"></i>
                                                            </a> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="PriceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Price </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="priceForm" method="POST">
                    @csrf
                    <div class="modal-body">
                         <div class="form-group">
                            <label for="Price">Price</label>
                            <input type="number" name="price" class="form-control" id="priceProduct">
                            <input type="hidden" class="form-control" id="id">
                         </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function editPrice(id,price) {
                $("#PriceModal").modal('show');
                $("#priceProduct").val(price);
                $("#id").val(id);
                var url = "{{ route('admin.productprice.edit', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $("#priceForm").attr('action', url);

            }
        </script>
    @endpush
@endsection
