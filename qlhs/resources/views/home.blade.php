<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý học sinh</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  
    <link rel="stylesheet" href={{asset('assets/css/bootstrap.css') }}>
   @yield('css')

    <link rel="stylesheet" href={{asset('assets/vendors/iconly/bold.css')}} >
    <link rel="stylesheet" href={{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css')}} >
    <link rel="stylesheet" href={{asset('assets/vendors/bootstrap-icons/bootstrap-icons.css')}} >
    <link rel="stylesheet" href={{asset('assets/css/app.css')}} >
    <link rel="shortcut icon" href={{asset('assets/images/favicon.svg')}}  type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href={{asset('#')}} ><img src={{ asset('assets/images/logo/logo.png') }} alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href={{asset('#')}} class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        
                    @if(Auth::user()->isAdmin)
                    <li class="sidebar-item active ">
                        <a href={{asset('dashboard')}} class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                        <li class="sidebar-item">
                            <a href={{asset('danhsachgiaovien')}} class='sidebar-link'>    
                                <span>Quản lý giáo viên</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href={{asset('danhsachlop')}} class='sidebar-link'>
                                <span>Quản lý lớp</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href={{asset('user')}} class='sidebar-link'>
                                <span>Quản lý người dùng</span>
                            </a>
                        </li>
                    @else
                    <li class="sidebar-item">
                        <a href={{asset('dashboardClass')}} class='sidebar-link'>    
                        <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                    <a href={{asset('student_list')}} class='sidebar-link'>    
                        <span>Quản lý học sinh</span>
                    </a>
                    </li>

                    @endif
                    
                    
                        
                        {{-- <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}}  class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Components</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Alert</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Badge</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Breadcrumb</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Button</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Card</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Carousel</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Dropdown</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >List Group</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Modal</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Navs</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Pagination</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Progress</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Spinner</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Tooltip</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}}  class='sidebar-link'>
                                <i class="bi bi-collection-fill"></i>
                                <span>Extra Components</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Avatar</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Sweet Alert</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Toastify</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Rating</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Divider</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Layouts</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Default Layout</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>1 Column</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Vertical with Navbar</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Horizontal Menu</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Forms &amp; Tables</li>

                        <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-hexagon-fill"></i>
                                <span>Form Elements</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Input</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Input Group</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Select</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Radio</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Checkbox</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Textarea</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  ">
                            <a href={{asset('#')}}  class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>Form Layout</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}}  class='sidebar-link'>
                                <i class="bi bi-pen-fill"></i>
                                <span>Form Editor</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Quill</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >CKEditor</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Summernote</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>TinyMCE</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  ">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Table</span>
                            </a>
                        </li>

                        <li class="sidebar-item  ">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                                <span>Datatable</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Extra UI</li>

                        <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-pentagon-fill"></i>
                                <span>Widgets</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Chatbox</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Pricing</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >To-do List</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-egg-fill"></i>
                                <span>Icons</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Bootstrap Icons </a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Fontawesome</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Dripicons</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>Charts</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >ChartJS</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >Apexcharts</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  ">
                            <a href={{asset('#')}}  class='sidebar-link'>
                                <i class="bi bi-cloud-arrow-up-fill"></i>
                                <span>File Uploader</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}}  class='sidebar-link'>
                                <i class="bi bi-map-fill"></i>
                                <span>Maps</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>Google Map</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >JS Vector Map</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Pages</li>

                        <li class="sidebar-item  ">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-envelope-fill"></i>
                                <span>Email Application</span>
                            </a>
                        </li>

                        <li class="sidebar-item  ">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-chat-dots-fill"></i>
                                <span>Chat Application</span>
                            </a>
                        </li>

                        <li class="sidebar-item  ">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-image-fill"></i>
                                <span>Photo Gallery</span>
                            </a>
                        </li>

                        <li class="sidebar-item  ">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-basket-fill"></i>
                                <span>Checkout Page</span>
                            </a>
                        </li> --}}

                        <li class="sidebar-item has-sub">
                            <a href={{asset('logout')}} class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Logout</span>
                            </a>
                    
                        </li>

                        {{-- <li class="sidebar-item  has-sub">
                            <a href={{asset('#')}} class='sidebar-link'>
                                <i class="bi bi-x-octagon-fill"></i>
                                <span>Errors</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href={{asset('#')}}>403</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >404</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href={{asset('#')}} >500</a>
                                </li>
                            </ul>
                        </li> --}}

                        {{-- <li class="sidebar-title">Raise Support</li>

                        <li class="sidebar-item  ">
                            <a href="https://zuramai.github.io/mazer/docs"  class='sidebar-link'>
                                <i class="bi bi-life-preserver"></i>
                                <span>Documentation</span>
                            </a>
                        </li> --}}

                        {{-- <li class="sidebar-item  ">
                            <a href={{asset('#')}}  class='sidebar-link'>
                                <i class="bi bi-puzzle"></i>
                                <span>Contribute</span>
                            </a>
                        </li> --}}

                        {{-- <li class="sidebar-item  ">
                            <a href={{asset('#')}}class='sidebar-link'>
                                <i class="bi bi-cash"></i>
                                <span>Donate</span>
                            </a>
                        </li> --}}

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            @yield('content')

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href={{asset('#')}}>A. Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src={{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}} ></script>
    <script src={{asset('assets/js/bootstrap.bundle.min.js')}} ></script>

    @yield('scripts')
</body>

</html>