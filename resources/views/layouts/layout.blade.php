<!DOCTYPE html>
<html lang="en">
@php
    use App\Models\SiteInfo;
    $defaultMetaData = SiteInfo::first();
    if (!isset($info)) {
        $metedata = $defaultMetaData;
        $metedata['name'] = $defaultMetaData['name'];
        $metedata['favicon'] = $defaultMetaData['favicon'];
    } else {
        $metedata = $info;
        $metedata['name'] = $defaultMetaData['name'];
        $metedata['favicon'] = $defaultMetaData['favicon'];
    }
@endphp

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metedata['meta_description'] }}">
    <meta name="keywords" content="{{ $metedata['meta_keyword'] }}">
    <meta name="title" content="{{ $metedata['meta_title'] }}">
    <meta name="author" content="{{ $metedata['name'] }}">
    <link rel="icon" href="{{ env('AWS_URL') }}public/storage/{{ $metedata['favicon'] }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ env('AWS_URL') }}public/storage/{{ $metedata['favicon'] }}" type="image/x-icon">
    <title>{{ $webInfo->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google font-->
    <link rel="stylesheet"
        href=" {{ env('AWS_URL') }}admin-assets/admin/css2?family=Work+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet"
        href=" {{ env('AWS_URL') }}admin-assets/admin/css2-1?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" type="text/css"
        href=" {{ env('AWS_URL') }} {{ env('AWS_URL') }}admin-assets/admin/css/vendors/chartist.css">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href=" {{ env('AWS_URL') }}admin-assets/admin/css/vendors/font-awesome.css">
    <!-- Ico-font-->
    <link rel="stylesheet" type="text/css" href=" {{ env('AWS_URL') }}admin-assets/admin/css/vendors/icofont.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href=" {{ env('AWS_URL') }}admin-assets/admin/css/vendors/flag-icon.css">
    <!-- Dropzone css-->
    <link rel="stylesheet" type="text/css" href=" {{ env('AWS_URL') }}admin-assets/admin/css/vendors/dropzone.css">
    <!-- Datatables css-->
    <link rel="stylesheet" type="text/css" href=" {{ env('AWS_URL') }}admin-assets/admin/css/vendors/datatables.css">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href=" {{ env('AWS_URL') }}admin-assets/admin/css/vendors/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href=" {{ env('AWS_URL') }}admin-assets/admin/css/style.css">
    <!-- include summernote css/js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css"
        integrity="sha512-ZbehZMIlGA8CTIOtdE+M81uj3mrcgyrh6ZFeG33A4FHECakGrOsTPlPQ8ijjLkxgImrdmSVUHn1j+ApjodYZow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.21.1/tagify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/choices.js/1.1.6/styles/css/choices.min.css"
        integrity="sha512-/PTsSsk4pRsdHtqWjRuAL/TkYUFfOpdB5QDb6OltImgFcmd/2ZkEhW/PTQSayBKQtzjQODP9+IAeKd7S2yTXtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: Nunito;
            /* Change the font family to your desired font stack */
        }

        .custom-theme {
            display: none !important;
        }

        .error {
            color: red;
        }

        .invalid-feedback {
            display: block !important;
        }

        .pagination span.current {
            padding: 5px;
            border: 1px solid;
            font-weight: 750;
        }

        table th {
            text-transform: capitalize !important;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff !important;
            background-color: #ff4c3b !important;
            border-color: #ff4c3b !important;
        }

        .page-link {
            position: relative;
            display: block;
            color: #ff4c3b !important;
            text-decoration: none;
            background-color: #fff;
        }

        .pagination a {
            padding: none;
            border: 1px solid;
        }
    </style>
</head>

<body>
    <!-- page-wrapper Start-->
    {{ env('AWS_URL') }}
    <div class="page-wrapper unprintable">

        <!-- Page Header Start-->
        <div class="page-main-header">
            <div class="main-header-right row">
                <div class="main-header-left d-lg-none w-auto">
                    <div class="logo-wrapper">
                        <a href="{{ route('admin.dashboard') }}">
                            <img class="blur-up lazyloaded d-block d-lg-none"
                                src=" {{ env('AWS_URL') }}public/storage/{{ $webInfo->logo }}" alt="Logo"
                                style="width:100%">
                        </a>
                    </div>
                </div>
                <div class="mobile-sidebar w-auto">
                    <div class="media-body text-end switch-sm">
                        <label class="switch"><a href="javascript:void(0)"><i id="sidebar-toggle"
                                    data-feather="align-left"></i></a></label>
                    </div>
                </div>
                <div class="nav-right col">
                    <ul class="nav-menus">

                        <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                                    data-feather="maximize-2"></i></a></li>

                        <li class="onhover-dropdown"><i data-feather="bell"></i><span
                                class="badge badge-pill badge-primary pull-right notification-badge">3</span><span
                                class="dot"></span>
                            <ul class="notification-dropdown onhover-show-div p-0">
                                <li>Notification <span class="badge badge-pill badge-primary pull-right">3</span></li>
                                <li>
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="mt-0"><span><i class="shopping-color"
                                                        data-feather="shopping-bag"></i></span>Your order ready for
                                                Ship..!</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="mt-0 txt-success"><span><i class="download-color font-success"
                                                        data-feather="download"></i></span>Download Complete</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="mt-0 txt-danger"><span><i class="alert-color font-danger"
                                                        data-feather="alert-circle"></i></span>250 MB trash files</h6>
                                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="bg-light txt-dark"><a href="javascript:void(0)">All</a> notification</li>
                            </ul>
                        </li>
                        <li class="onhover-dropdown">
                            <div class="media align-items-center">
                                @if (!empty(Auth::user()->designation_icon))
                                    <img class="align-self-center pull-right img-50 blur-up lazyloaded"
                                        src=" {{ env('AWS_URL') }}public/storage/{{ Auth::user()->designation_icon }}"
                                        alt="{{ Auth::user()->name }}">
                                @else
                                    <img class="align-self-center pull-right img-50 blur-up lazyloaded"
                                        src="{{ asset('public') }}/user_icon.jpg"
                                        alt="{{ Auth::user()->name }}"></a>
                                @endif
                                <div class="dotted-animation"><span class="animate-circle"></span><span
                                        class="main-circle"></span>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div p-20">
                                <li><a href="{{ route('admin.profile') }}"><i data-feather="user"></i>Profile</a>
                                </li>
                                {{-- <li><a href="javascript:void(0)"><i data-feather="mail"></i>Inbox</a></li>
								<li><a href="javascript:void(0)"><i data-feather="lock"></i>Lock Screen</a></li> --}}
                                <li><a href="javascript:void(0)"><i data-feather="settings"></i>Settings</a></li>
                                <li><a href="javascript:void(0)" onclick="logout('{{ route('admin.logout') }}')"><i
                                            data-feather="log-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
                </div>
            </div>
        </div>
        <!-- Page Header Ends -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <!-- Page Sidebar Start-->
            <div class="page-sidebar">
                <div class="main-header-left d-none d-lg-block">
                    <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="blur-up lazyloaded"
                                src=" {{ env('AWS_URL') }}public/storage/{{ $webInfo->logo }}"
                                alt="{{ $webInfo->logo }}" style="width:100%"></a>
                    </div>
                </div>
                <div class="sidebar custom-scrollbar">
                    <a href="javascript:void(0)" class="sidebar-back d-lg-none d-block"><i class="fa fa-times"
                            aria-hidden="true"></i></a>
                    <div class="sidebar-user">
                        <a href="{{ route('admin.dashboard') }}">
                            @if (!empty(Auth::user()->designation_icon))
                                <img class="img-60 bg-white"
                                    src=" {{ env('AWS_URL') }}public/storage/{{ Auth::user()->designation_icon }}"
                                    alt="{{ Auth::user()->name }}">
                        </a>
                    @else
                        <img class="img-60" src="{{ asset('public') }}/user_icon.jpg"
                            alt="{{ Auth::user()->name }}"></a>
                        @endif
                        <div>
                            <h6 class="f-14">{{ Auth::user()->name }}</h6>
                            <p>{{ Auth::user()->designation }} </p>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li>
                            <a class="sidebar-header" href="{{ route('admin.dashboard') }}">
                                <i data-feather="home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="align-left"></i>
                                <span>Navigation</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.menus') }}">
                                        <i class="fa fa-circle"></i>Menu Lists
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.createmenu') }}">
                                        <i class="fa fa-circle"></i>Create Menu
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.categories') }}">
                                        <i class="fa fa-circle"></i>Category
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.subcategories') }}">
                                        <i class="fa fa-circle"></i>Subcategory</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="align-left"></i>
                                <span>Product Categories</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.catlist') }}">
                                        <i class="fa fa-circle"></i>Main Category
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.subcatlist') }}">
                                        <i class="fa fa-circle"></i>Subcategory
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="sliders"></i>
                                <span>Home content</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.homecontent') }}">
                                        <i class="fa fa-circle"></i>Home page contant
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.shopbycat.list') }}">
                                        <i class="fa fa-circle"></i>Shop by Category
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.style.list') }}">
                                        <i class="fa fa-circle"></i>Shop by style
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li>
						<a href="{{ route('admin.homecontent') }}" class="sidebar-header"><i
						data-feather="sliders"></i><span>Home content</span></a>
					</li> --}}
                        <li>
                            <a href="{{ route('admin.widget.list') }}" class="sidebar-header"><i
                                    data-feather="list"></i><span>Widget</span></a>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="shopping-bag"></i>
                                <span>Order Management</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('order.status') }}">
                                        <i class="fa fa-circle"></i>Order status
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sale.orders') }}">
                                        <i class="fa fa-circle"></i>Orders
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sale.transactions') }}">
                                        <i class="fa fa-circle"></i> Transactions
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sale.shipments') }}">
                                        <i class="fa fa-circle"></i> Shipments
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sale.invoices') }}">
                                        <i class="fa fa-circle"></i> Invoices
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sale.orders.refundlist') }}">
                                        <i class="fa fa-circle"></i> Returns
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="layers"></i>
                                <span>Sales Management</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('sale.report') }}">
                                        <i class="fa fa-circle"></i> Report
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sale.revenue') }}">
                                        <i class="fa fa-circle"></i> Revenue
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="box"></i>
                                <span>Product management</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>

                            <ul class="sidebar-submenu">
                                {{-- <li>
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-circle"></i>
                                        <span>manage category
                                        </span>
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </a>

                                    <ul class="sidebar-submenu">
                                        <li>
                                            <a href="{{ route('admin.categories') }}">
                                                <i class="fa fa-circle"></i>Category
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin.subcategories') }}">
                                                <i class="fa fa-circle"></i>Subcategory</a>
                                        </li>
                                    </ul>
                                </li> --}}
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-circle"></i>
                                        <span>Product attributes
                                        </span>
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </a>

                                    <ul class="sidebar-submenu">
                                        <li>
                                            <a href="{{ route('admin.carat') }}">
                                                <i class="fa fa-circle"></i>Carat
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.centerstone.list') }}">
                                                <i class="fa fa-circle"></i>Center Stone
                                            </a>
                                        </li>

                                    </ul>
                                </li>


                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-circle"></i>
                                        <span>manage product</span>
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </a>

                                    <ul class="sidebar-submenu">
                                        <li>
                                            <a href="{{ route('price.discount') }}">
                                                <i class="fa fa-circle"></i>Product price discount
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.product.dblist') }}">
                                                <i class="fa fa-circle"></i>Product list
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.diamondshape') }}">
                                                <i class="fa fa-circle"></i>Diamond shape
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.ringmetal') }}">
                                                <i class="fa fa-circle"></i>Ring Metal
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.metal.color') }}">
                                                <i class="fa fa-circle"></i>Ring Metal color
                                            </a>
                                        </li>
                                        <!---li>
                                        <a href="{{ route('admin.carat') }}">
                                        <i class="fa fa-circle"></i>Diamond carat
                                        </a>
                                        </li>
                                        <li>
                                        <a href="{{ route('admin.cut') }}">
                                        <i class="fa fa-circle"></i>Diamond cut
                                        </a>
                                        </li>
                                        <li>
                                        <a href="{{ route('admin.diamondcolor') }}">
                                        <i class="fa fa-circle"></i>Diamond color
                                        </a>
                                        </li>
                                        <li>
                                        <a href="{{ route('admin.diamondclarity') }}">
                                        <i class="fa fa-circle"></i>Diamond clarity
                                        </a>
                                        </li>
                                        <li>
                                        <a href="{{ route('admin.diamond') }}">
                                        <i class="fa fa-circle"></i>Manage Diamond
                                        </a>
                                        </li---->
                                        {{-- <li>
										<a href="{{ route('admin.ringstyle') }}">
											<i class="fa fa-circle"></i>Ring Style
										</a>
									</li> --}}

                                        {{-- <li>
										<a href="{{ route('admin.ringprong') }}">
											<i class="fa fa-circle"></i>Ring Prong
										</a>
									</li>
									<li>
										<a href="{{ route('admin.country') }}">
											<i class="fa fa-circle"></i>Country
										</a>
									</li> --}}
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-circle"></i>
                                        <span>Filter Attributes</span>
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </a>

                                    <ul class="sidebar-submenu">
                                        <li>
                                            <a href="{{ route('admin.gemstone.list') }}">
                                                <i class="fa fa-circle"></i>Gemstones
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin.shape.list') }}">
                                                <i class="fa fa-circle"></i>Gemstone Shape
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.color.list') }}">
                                                <i class="fa fa-circle"></i>Gemstone color
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="user"></i>
                                <span>Customer Manager</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.customer') }}">
                                        <i class="fa fa-circle"></i>Customer manager
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.customer.messagelist') }}">
                                        <i class="fa fa-circle"></i>Contact messages
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="image"></i>
                                <span>Manage Banner</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.addbanner') }}">
                                        <i class="fa fa-circle"></i>Add Banner
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.bannerlist') }}">
                                        <i class="fa fa-circle"></i>Banner List
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="image"></i>
                                <span>Blog</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.blog.catlist') }}">
                                        <i class="fa fa-circle"></i>category
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.blogtype.list') }}">
                                        <i class="fa fa-circle"></i>type
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.blog') }}">
                                        <i class="fa fa-circle"></i>Blog
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="image"></i>
                                <span>Localization</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.font') }}">
                                        <i class="fa fa-circle"></i>Fonts
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.country') }}">
                                        <i class="fa fa-circle"></i>Country
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.state') }}">
                                        <i class="fa fa-circle"></i>State
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('overnight.shipping') }}">
                                        <i class="fa fa-circle"></i>Overnight Delevery Charge
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li>
						<a class="sidebar-header" href="javascript:void(0)">
							<i data-feather="tool"></i>
							<span>Config Manager</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>

						<ul class="sidebar-submenu">
							{{-- <li>
								<a href="javascript:void(0)">
									<i class="fa fa-circle"></i>
									<span>Localization
									</span>
									<i class="fa fa-angle-right pull-right"></i>
								</a>

								<ul class="sidebar-submenu">
									<li>
										<a href="{{ route('admin.language') }}">
											<i class="fa fa-circle"></i>Language
										</a>
									</li>

									<li>
										<a href="{{ route('admin.currency') }}">
										<i class="fa fa-circle"></i>Currency</a>
									</li>
								</ul>
							</li> --}}

							<li>
								<a href="javascript:void(0)">
									<i class="fa fa-circle"></i>
									<span>Email Settings</span>
									<i class="fa fa-angle-right pull-right"></i>
								</a>

								<ul class="sidebar-submenu">
									<li>
										<a href="{{ route('template.list') }}">
											<i class="fa fa-circle"></i>Email template
										</a>
									</li>

									{{-- <li>
										<a href="{{ route('admin.emailsmtp') }}">
											<i class="fa fa-circle"></i>Smtp details
										</a>
									</li> --}}
								</ul>
							</li>
						</ul>
					</li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)">
                                <i data-feather="cpu"></i>
                                <span>CMS administration</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.cmscategory') }}">
                                        <i class="fa fa-circle"></i>CMS category
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.cmscontent') }}">
                                        <i class="fa fa-circle"></i>CMS Content
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.faqcategories') }}">
                                        <i class="fa fa-circle"></i>FAQ Categories
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.faqs') }}">
                                        <i class="fa fa-circle"></i>FAQ
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="sidebar-header" href="javascript:void(0)"><i
                                    data-feather="settings"></i><span>Settings</span><i
                                    class="fa fa-angle-right pull-right"></i></a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.siteinfo') }}"><i class="fa fa-circle"></i>Site
                                        Information
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.profile') }}"><i class="fa fa-circle"></i>Profile
                                    </a>
                                </li>
                                <!--li>
        <a href="javascript:void(0)" onclick="logout('{{ route('admin.logout') }}')"><i
        class="fa fa-circle"></i>Logout
        </a>
       </li-->
                            </ul>
                        </li>
                        <!--li>
      <a class="sidebar-header" href="javascript:void(0)"><i
      data-feather="users"></i><span>Administration</span><i
      class="fa fa-angle-right pull-right"></i></a>
      <ul class="sidebar-submenu">
      <li>
      <a href="{{ route('admin.siteinfo') }}"><i class="fa fa-circle"></i>Site
      Information
      </a>
      </li>
      <li>
      <a href="{{ url('admin/profile') }}"><i class="fa fa-circle"></i>Profile
      </a>
      </li>

      </ul>
     </li--->

                        <li>
                            <a class="sidebar-header" href="javascript:void(0)"><i
                                    data-feather="users"></i><span>Admin</span><i
                                    class="fa fa-angle-right pull-right"></i></a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{ route('admin.users.list') }}"><i class="fa fa-circle"></i>Users</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.role.list') }}"><i class="fa fa-circle"></i>Roles
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.permission.list') }}"><i
                                            class="fa fa-circle"></i>Permissions
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a onclick="logout('{{ route('admin.logout') }}')" class="sidebar-header"
                                href="javascript:void(0)"><i data-feather="log-out"></i><span>Logout</span></a>

                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page Sidebar Ends-->

            @yield('content')

            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 footer-copyright text-start">
                            {{ $webInfo->copyright }}
                        </div>
                        <div class="col-md-6 pull-right text-end">
                            <p class=" mb-0">Hand crafted & made with<i class="fa fa-heart"></i></p>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- footer end-->
        </div>
    </div>

    <!-- latest jquery-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/bootstrap.bundle.min.js"></script>

    <!-- feather icon js-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/icons/feather-icon/feather.min.js"></script>
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/icons/feather-icon/feather-icon.js"></script>

    <!-- Sidebar jquery-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/sidebar-menu.js"></script>
    <!-- Datatable js-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/datatables/jquery.dataTables.min.js"></script>
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/datatables/custom-basic.js"></script>



    <!--dropzone js-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/dropzone/dropzone.js"></script>
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/dropzone/dropzone-script.js"></script>

    <!--ckeditor js-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/editor/ckeditor/ckeditor.js"></script>
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/editor/ckeditor/ckeditor.custom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

    <!--Customizer admin-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/admin-customizer.js"></script>

    <!-- lazyload js-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/lazysizes.min.js"></script>

    <!--right sidebar js-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/chat-menu.js"></script>


    <!-- Chartist js-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/chart/chartist/chartist.js"></script>

    <!-- Chartjs -->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/chart/chartjs/chart.min.js"></script>
    <!-- Google chart js-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/chart/google/google-chart-loader.js"></script>
    <!--Report chart-->
    {{-- <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/admin-reports.js"></script> --}}
    {{-- <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/admin-reports.js"></script> --}}

    <!--script admin-->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/admin-script.js"></script>
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/custom.js"></script>

    <!-- include summernote css/js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <!--tagify cdn js--->
    <script src=" {{ env('AWS_URL') }}admin-assets/admin/js/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.21.1/jQuery.tagify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/1.1.6/choices.min.js"
        integrity="sha512-7PQ3MLNFhvDn/IQy12+1+jKcc1A/Yx4KuL62Bn6+ztkiitRVW1T/7ikAh675pOs3I+8hyXuRknDpTteeptw4Bw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('scripts')

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // $('#category_id').select2({
        //     selectOnClose: true
        // });
        $('.select2').select2({
            selectOnClose: true
        });
        const select = new Choices('.multichoose', {
            removeItems: true,
            searchPlaceholderValue: 'Type to search',
            removeItemButton: true
        });


        // The DOM element you wish to replace with Tagify
        var input = document.querySelector('.tagify');
        // initialize Tagify on the above input node reference
        new Tagify(input)
    </script>

</body>
@if (session('success'))
    <script>
        iziToast.success({
            title: 'OK',
            message: '{{ session('success') }}',
        });
    </script>
@endif
@if (session('error'))
    <script>
        iziToast.error({
            title: 'Error',
            message: '{{ session('error') }}',
        });
    </script>
@endif

</html>
