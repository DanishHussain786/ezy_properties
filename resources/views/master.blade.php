<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM Admin Panel</title>
    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{ asset('app-assets/dist/img/ico/favicon.png') }}" type="image/x-icon">
    <!-- Start Global Mandatory Style
    =====================================================================-->

    <!-- jquery-ui css -->
    <link href="{{ asset('app-assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Bootstrap -->
    <link href="{{ asset('app-assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">    
    <!-- Bootstrap rtl -->
    <!--<link href="assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>-->
    <!-- Lobipanel css -->
    <link href="{{ asset('app-assets/plugins/lobipanel/lobipanel.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Pace css -->
    <link href="{{ asset('app-assets/plugins/pace/flash.css') }}" rel="stylesheet" type="text/css">
    <!-- Font Awesome -->
    <link href="{{ asset('app-assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Pe-icon -->
    <link href="{{ asset('app-assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css') }}" rel="stylesheet" type="text/css">
    <!-- Themify icons -->
    <link href="{{ asset('app-assets/themify-icons/themify-icons.css') }}" rel="stylesheet" type="text/css">
    <!-- End Global Mandatory Style
       =====================================================================-->
    <!-- Start page Label Plugins 
       =====================================================================-->
    <!-- Emojionearea -->
    <link href="{{ asset('app-assets/plugins/emojionearea/emojionearea.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Monthly css -->
    <link href="{{ asset('app-assets/plugins/monthly/monthly.css') }}" rel="stylesheet" type="text/css">    
    <!-- End page Label Plugins 
    =====================================================================-->
    <!-- Start Theme Layout Style
    =====================================================================-->
    <!-- Theme style -->
    <link href="{{ asset('app-assets/dist/css/stylecrm.css') }}" rel="stylesheet" type="text/css">
    <!-- Fancy Box CSS Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('app-assets/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css">
    <!-- Select2 Library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap toggle css -->
    <link href="{{ asset('app-assets/plugins/bootstrap-toggle/bootstrap-toggle.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- toastr -->
    <link href="{{ asset('app-assets/plugins/toaster/toastr.min.css') }}?v={{ time() }}" rel="stylesheet">
    
    <!-- End Theme Layout Style
    =====================================================================-->
  </head>
  <body class="hold-transition sidebar-mini">
      <!--preloader-->
      <div id="preloader">
         <div id="status"></div>
      </div>
      <!-- Site wrapper -->
      <div class="wrapper">
        <header class="main-header" id="header_div">
          <a href="index-2.html" class="logo">
            <!-- Logo -->
            <span class="logo-mini">
              <img src="{{ asset('app-assets/dist/img/mini-logo.png') }}" alt="">
            </span>
            <span class="logo-lg">
              <img src="{{ asset('app-assets/dist/img/logo.png') }}" alt="">
            </span>
          </a>
          <!-- Header Navbar -->
          <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
              <!-- Sidebar toggle button-->
              <span class="sr-only">Toggle navigation</span>
              <span class="pe-7s-angle-left-circle"></span>
            </a>
            <!-- searchbar-->
            <a href="#search"><span class="pe-7s-search"></span></a>
            <div id="search">
              <button type="button" class="close">×</button>
              <form>
                <input type="search" value="" placeholder="Search.." />
                <button type="submit" class="btn btn-add">Search...</button>
              </form>
            </div>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <!-- Orders -->
                <li class="dropdown messages-menu">
                  <a href="#" class="dropdown-toggle admin-notification" data-toggle="dropdown">
                    <i class="pe-7s-cart"></i>
                    <span class="label label-primary">5</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <ul class="menu">
                        <li>
                          <!-- start Orders -->
                          <a href="#" class="border-gray">
                            <div class="pull-left">
                              <img src="{{ asset('app-assets/dist/img/basketball-jersey.png') }}" class="img-thumbnail" alt="User Image">
                            </div>
                            <h4>polo shirt</h4>
                            <p><strong>total item:</strong> 21</p>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <div class="pull-left">
                              <img src="{{ asset('app-assets/dist/img/shirt.png') }}" class="img-thumbnail" alt="User Image">
                            </div>
                            <h4>Kits</h4>
                            <p><strong>total item:</strong> 11</p>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <div class="pull-left">
                              <img src="{{ asset('app-assets/dist/img/football.png') }}" class="img-thumbnail" alt="User Image">
                            </div>
                            <h4>Football</h4>
                            <p><strong>total item:</strong> 16</p>
                          </a>
                        </li>
                        <li class="nav-list">
                          <a href="#" class="border-gray">
                            <div class="pull-left">
                              <img src="{{ asset('app-assets/dist/img/shoe.png') }}" class="img-thumbnail" alt="User Image">
                            </div>
                            <h4>Sports sheos</h4>
                            <p><strong>total item:</strong> 10</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <!-- Messages -->
                <li class="dropdown messages-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="pe-7s-mail"></i>
                    <span class="label label-success">4</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <ul class="menu">
                        <li>
                          <!-- start message -->
                          <a href="#" class="border-gray">
                            <div class="pull-left">
                              <img src="{{ asset('app-assets/dist/img/avatar.png') }}" class="img-circle" alt="User Image">
                            </div>
                            <h4>Ronaldo</h4>
                            <p>Please oreder 10 pices of kits..</p>
                            <span class="badge badge-success badge-massege"><small>15 hours ago</small></span>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <div class="pull-left">
                              <img src="{{ asset('app-assets/dist/img/avatar2.png') }}" class="img-circle" alt="User Image">
                            </div>
                            <h4>Leo messi</h4>
                            <p>Please oreder 10 pices of Sheos..</p>
                            <span class="badge badge-info badge-massege"><small>6 days ago</small></span>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <div class="pull-left">
                              <img src="{{ asset('app-assets/dist/img/avatar3.png') }}" class="img-circle" alt="User Image">
                            </div>
                            <h4>Modric</h4>
                            <p>Please oreder 6 pices of bats..</p>
                            <span class="badge badge-info badge-massege"><small>1 hour ago</small></span>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <div class="pull-left">
                              <img src="{{ asset('app-assets/dist/img/avatar4.png') }}" class="img-circle" alt="User Image">
                            </div>
                            <h4>Salman</h4>
                            <p>Hello i want 4 uefa footballs</p>
                            <span class="badge badge-danger badge-massege"><small>6 days ago</small></span>
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <div class="pull-left">
                              <img src="{{ asset('app-assets/dist/img/avatar5.png') }}" class="img-circle" alt="User Image">
                            </div>
                            <h4>Sergio Ramos</h4>
                            <p>Hello i want 9 uefa footballs</p>
                            <span class="badge badge-info badge-massege"><small>5 hours ago</small></span>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <!-- Notifications -->
                <li class="dropdown notifications-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="pe-7s-bell"></i>
                    <span class="label label-warning">7</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <ul class="menu">
                        <li>
                          <a href="#" class="border-gray">
                            <i class="fa fa-dot-circle-o color-green"></i>Change Your font style
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <i class="fa fa-dot-circle-o color-red"></i>check the system ststus..
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <i class="fa fa-dot-circle-o color-yellow"></i>Add more admin...
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <i class="fa fa-dot-circle-o color-violet"></i> Add more clients and order
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <i class="fa fa-dot-circle-o color-yellow"></i>Add more admin...
                          </a>
                        </li>
                        <li>
                          <a href="#" class="border-gray">
                            <i class="fa fa-dot-circle-o color-violet"></i> Add more clients and order
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <!-- Tasks -->
                <li class="dropdown tasks-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="pe-7s-note2"></i>
                    <span class="label label-danger">6</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <ul class="menu">
                        <li>
                          <!-- Task item -->
                          <a href="#" class="border-gray">
                            <span class="label label-success pull-right">50%</span>
                            <h3><i class="fa fa-check-circle"></i> Theme color should be change</h3>
                          </a>
                        </li>
                        <!-- end task item -->
                        <li>
                          <!-- Task item -->
                          <a href="#" class="border-gray">
                            <span class="label label-warning pull-right">90%</span>
                            <h3><i class="fa fa-check-circle"></i> Fix Error and bugs</h3>
                          </a>
                        </li>
                        <!-- end task item -->
                        <li>
                          <!-- Task item -->
                          <a href="#" class="border-gray">
                            <span class="label label-danger pull-right">80%</span>
                            <h3><i class="fa fa-check-circle"></i> Sidebar color change</h3>
                          </a>
                        </li>
                        <!-- end task item -->
                        <li>
                          <!-- Task item -->
                          <a href="#" class="border-gray">
                            <span class="label label-info pull-right">30%</span>
                            <h3><i class="fa fa-check-circle"></i> font-family should be change</h3>
                          </a>
                        </li>
                        <li>
                          <!-- Task item -->
                          <a href="#" class="border-gray">
                            <span class="label label-success pull-right">60%</span>
                            <h3><i class="fa fa-check-circle"></i> Fix the database Error</h3>
                          </a>
                        </li>
                        <li>
                          <!-- Task item -->
                          <a href="#" class="border-gray">
                            <span class="label label-info pull-right">20%</span>
                            <h3><i class="fa fa-check-circle"></i> data table data missing</h3>
                          </a>
                        </li>
                        <!-- end task item -->
                      </ul>
                    </li>
                  </ul>
                </li>
                <!-- Help -->
                <li class="dropdown dropdown-help hidden-xs">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="pe-7s-settings"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="profile.html">
                        <i class="fa fa-line-chart"></i> Networking
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa fa-bullhorn"></i> Lan settings
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-bar-chart"></i> Settings
                      </a>
                    </li>
                    <li>
                      <a href="login.html">
                        <i class="fa fa-wifi"></i> wifi
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- user -->
                <li class="dropdown dropdown-user">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('app-assets/dist/img/avatar5.png') }}" class="img-circle" width="45" height="45" alt="user">
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="profile.html">
                        <i class="fa fa-user"></i> User Profile
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-inbox"></i> Inbox
                      </a>
                    </li>
                    <li>
                      <a href="login.html">
                        <i class="fa fa-sign-out"></i> Signout
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </header>
        
        <!-- =============================================== -->
        <!-- Left side column. contains the sidebar -->

        @php $str_slug = Request::path(); @endphp
        <aside class="main-sidebar">
          <!-- sidebar -->
          <div class="sidebar">
            <!-- sidebar menu -->
            <ul class="sidebar-menu">
              @php $class = (strpos($str_slug, "dashboard") !== false) ? 'active' : ''; @endphp
              <li class="menu-item {{$class}}">
                <a href="index-2.html">
                  <i class="fa fa-tachometer"></i><span>Dashboard</span>
                  <span class="pull-right-container"></span>
                </a>
              </li>
              @php $class = (strpos($str_slug, "user") !== false) ? 'active' : ''; @endphp
              <li class="treeview menu-item {{$class}}">
                <a href="#">
                  <i class="fa fa-users"></i><span>Users</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{url('user/create')}}">Add User</a></li>
                  <li><a href="{{url('user')}}">List Users</a></li>
                </ul>
              </li>
              @php $class = (strpos($str_slug, "property") !== false) ? 'active' : ''; @endphp
              <li class="treeview menu-item {{$class}}">
                <a href="#">
                  <i class="fa fa-home"></i><span>Property</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{url('property/create')}}">Add Property</a></li>
                  <li><a href="{{url('property')}}">List Properties</a></li>
                </ul>
              </li>
              @php $class = (strpos($str_slug, "booking") !== false) ? 'active' : ''; @endphp
              <li class="treeview menu-item {{$class}}">
                <a href="#">
                  <i class="fa fa-home"></i><span>Bookings</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{url('booking')}}">Reservations</a></li>
                  <li><a href="{{url('booking/services')}}">Other Services</a></li>
                </ul>
              </li>
              @php $class = (strpos($str_slug, "account") !== false) ? 'active' : ''; @endphp
              <li class="treeview menu-item {{$class}}">
                <a href="#">
                  <i class="fa fa-home"></i><span>Accounts</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{url('account')}}?mode=pay_in">Payment In</a></li>
                  <li><a href="{{url('account')}}?mode=pay_out">Payment Out</a></li>
                  <li><a href="{{url('property')}}">Guest Services</a></li>
                </ul>
              </li>
              @php $class = (strpos($str_slug, "service") !== false) ? 'active' : ''; @endphp
              <li class="treeview menu-item {{$class}}">
                <a href="#">
                  <i class="fa fa-home"></i><span>Services</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{url('service/create')}}">Add Service</a></li>
                  <li><a href="{{url('service')}}">List Services</a></li>
                </ul>
              </li>
              @php $class = (strpos($str_slug, "info") !== false) ? 'active' : ''; @endphp
              <li class="treeview menu-item {{$class}}">
                <a href="#">
                  <i class="fa fa-home"></i><span>Information</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{url('info/create')}}">Company Information</a></li>
                  <li><a href="{{url('info')}}">Receipts Design</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        
        <div class="content-wrapper">

          <div id="imageModal">
            <span id="closeModal">&times;</span>
            <img class="modal-content" id="imageModalContent">
          </div>

          @yield('content-view')
        </div>
        <!-- /.content-wrapper -->
          
        <footer class="main-footer">
          <strong>Copyright &copy; 2023-2024 <a href="#">danishhussain.com</a>.</strong> All rights reserved.
        </footer>
      </div>
      <!-- /.wrapper -->
      
      <!-- Start Core Plugins
         =====================================================================-->
      <!-- jQuery -->
      <script src="{{ asset('app-assets/plugins/jQuery/jquery-1.12.4.min.js') }}" type="text/javascript"></script>
      <!-- jquery-ui -->
      <script src="{{ asset('app-assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js') }}" type="text/javascript"></script>
      <!-- Bootstrap -->
      <script src="{{ asset('app-assets/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
      <!-- lobipanel -->
      <script src="{{ asset('app-assets/plugins/lobipanel/lobipanel.min.js') }}" type="text/javascript"></script>
      <!-- Pace js -->
      <script src="{{ asset('app-assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
      <!-- SlimScroll -->
      <script src="{{ asset('app-assets/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
      <!-- FastClick -->
      <script src="{{ asset('app-assets/plugins/fastclick/fastclick.min.js') }}" type="text/javascript"></script>
      <!-- CRMadmin frame -->
      <script src="{{ asset('app-assets/dist/js/custom.js') }}" type="text/javascript"></script>
      <!-- Select2 Library -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
      <!-- ChartJs JavaScript -->
      <script src="{{ asset('app-assets/plugins/chartJs/Chart.min.js') }}" type="text/javascript"></script>
      <!-- Counter js -->
      <script src="{{ asset('app-assets/plugins/counterup/waypoints.js') }}" type="text/javascript"></script>
      <script src="{{ asset('app-assets/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
      <!-- Monthly js -->
      <script src="{{ asset('app-assets/plugins/monthly/monthly.js') }}" type="text/javascript"></script>
      <!-- iCheck js -->
      <script src="{{ asset('app-assets/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
      <!-- Bootstrap toggle -->
      <script src="{{ asset('app-assets/plugins/bootstrap-toggle/bootstrap-toggle.min.js') }}" type="text/javascript"></script>
      <!-- Dashboard js -->
      <script src="{{ asset('app-assets/dist/js/dashboard.js') }}" type="text/javascript"></script>
      <!-- END: Page JS-->
      <script src="{{ asset('app-assets/js/main.js') }}"></script>
      <!-- Toastr JS-->
      <script src="{{ asset('app-assets/plugins/toaster/toastr.js') }}?v={{ time() }}" type="text/javascript"></script>
      <!-- End Theme label Script
         =====================================================================-->
      
      @if (preg_match('/\buser\b/', Request::path() ))
        <script src="{{ asset('app-assets/js/user.js') }}"></script>
      @elseif (preg_match('/\bproperty\b/', Request::path() ))
        <script src="{{ asset('app-assets/js/property.js') }}"></script>
      @elseif (preg_match('/\bbooking\b/', Request::path() ))
        <script src="{{ asset('app-assets/js/booking.js') }}"></script>
      @elseif (preg_match('/\baccount\b/', Request::path() ))
        <script src="{{ asset('app-assets/js/account.js') }}"></script>
      @endif
   </body>
</html>

