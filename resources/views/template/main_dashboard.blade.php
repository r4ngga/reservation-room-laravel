<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>@yield('title')</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="/template_bootstrap/wise/css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="/template_bootstrap/wise/css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="/template_bootstrap/wise/css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="/template_bootstrap/wise/images/favicon.png" type="image/gif" />
      <!-- datatables -->
      <link rel="stylesheet" type="text/css" href="/template_bootstrap/datatables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" type="text/css" href="/template_bootstrap/datatables/DataTables-1.13.6/css/dataTables.bootstrap.css">
      <link rel="stylesheet" type="text/css" href="/template_bootstrap/datatables/DataTables-1.13.6/css/jquery.dataTables.min.css">

      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="/template_bootstrap/wise/css/jquery.mCustomScrollbar.min.css">
      <script type="text/javascript" src="/template_bootstrap/wise/js/jquery-3.0.0.min.js"></script>
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
      <style>
        .main-footer {
           /* position: initial; */
           position: absolute;
           /* position:unset; */
           left: 0;
           bottom: 0;
           right: 0;
           /* width: 100%; */
           /* background-color: red;
           color: white; */
           /* text-align: center; */
        }

        .list-navbar{
            padding: 6px 10px 0px 10px !important;
        }
      </style>
      @yield('style')
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="/template_bootstrap/wise/images/loading.gif" alt="#" /></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                  <div class="full">
                     <div class="center-desk">
                        @if(auth()->user()->role=="1" || auth()->user()->role==1)
                        <div class="logo"> <a href="{{('/admin-dashboard')}}">MyRR</a> </div>
                        @else
                        <div class="logo"> <a href="{{('/userdashboard')}}">MyRR</a> </div>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                  <div class="menu-area">
                     <div class="limit-box">
                        <nav class="main-menu">
                           <ul class="menu-area-main">
                              <li> <a href="{{('/myaccount')}}">My Account</a></li>
                              @if(auth()->user()->role=="1" || auth()->user()->role==1)
                              <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                                      Manage Data
                                    </a>
                                    <div class="dropdown-menu" >
                                      <a href="{{('room')}}">Rooms Data</a>
                                      <a href="{{('users')}}">Users Data</a>
                                      <a href="{{ ('religions') }}">Religions</a>
                                      <a href="#">Promotions Data</a>
                                      <a href="#">Events Data</a>
                                    </div>
                              </li>
                              <li><a href="{{('reservation')}}">Confirmation</a></li>
                              <li><a href="{{('logs')}}">Logs</a></li>
                              @elseif(auth()->user()->role=="2" || auth()->user()->role==2)
                              <li> <a href="{{('/userdashboard')}}">My Reservation</a> </li>
                              {{-- <li> <a href="{{ route('client') }}">My Reservation</a> </li> --}}
                              <li> <a href="{{ route('rooms') }}">Reservation</a> </li>
                              @endif
                              <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                                      Account
                                    </a>
                                    <div class="dropdown-menu" >
                                    @if(auth()->user()->role=="2" || auth()->user()->role==2)
                                      <a href="{{('/history')}}">My History</a>
                                    @endif
                                      <a href="{{('/setting')}}">Setting</a>
                                      <a href="{{('/logout')}}">Log out</a>
                                    </div>
                              </li>
                              {{-- <li> <a href="{{('/logout')}}">Log out</a> </li> --}}
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- end header inner -->
      </header>

      @yield('container')
      <!-- end header -->

      <!-- about  -->

      <!-- end abouts -->
      <!-- service -->

      <!-- end service -->
      <!-- Download -->


      <!-- end Download -->
      <!-- Testimonial -->


      <!-- end Testimonial -->
      <!--  footer -->

         <div class="fixed-bottom" >
            {{-- <div class="container">
               <div class="row">
                  <div class="col-lg-2 col-md-6 col-sm-12 width">
                     <div class="address">
                        <h3>Address</h3>
                        <i><img src="/template_bootstrap/wise/icon/3.png">Locations</i>
                     </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-12 width">
                     <div class="address">
                        <h3>Menus</h3>
                        <i><img src="/template_bootstrap/wise/icon/2.png">Locations</i>
                     </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-12 width">
                     <div class="address">
                        <h3>Useful Linkes</h3>
                        <i><img src="/template_bootstrap/wise/icon/1.png">Locations</i>
                     </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-12 width">
                     <div class="address">
                        <h3>Social Media </h3>
                        <ul class="contant_icon">
                           <li><img src="/template_bootstrap/wise/icon/fb.png" alt="icon"/></li>
                           <li><img src="/template_bootstrap/wise/icon/tw.png" alt="icon"/></li>
                           <li><img src="/template_bootstrap/wise/icon/lin (2).png" alt="icon"/></li>
                           <li><img src="/template_bootstrap/wise/icon/instagram.png" alt="icon"/></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 width">
                     <div class="address">
                        <h3>Newsletter </h3>
                        <input class="form-control" placeholder="Enter your email" type="type" name="Enter your email">
                        <button class="submit-btn" data-toggle="modal" data-target="#modalComingSoon">Subscribe</button>
                     </div>
                  </div>
               </div>
            </div> --}}
            <div class="copyright">
                    <p>Copyright &copy; {{date('Y')}} All Right Reserved By Rangga Wisnu Aji M</a></p>
            </div>
        </div>

         <div class="modal fade" id="modalComingSoon" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Coming soon </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  This feature coming soon development
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          @yield('scripts')
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
      <script type="text/javascript" src="/template_bootstrap/wise/js/bootstrap.bundle.min.js"></script>

      <script type="text/javascript" src="/template_bootstrap/wise/js/jquery.min.js"></script>
      <script type="text/javascript" src="/template_bootstrap/wise/js/popper.min.js"></script>

      {{-- <script src="/template_bootstrap/wise/js/plugin.js"></script> --}}
      <!-- sidebar -->
      <script type="text/javascript" src="/template_bootstrap/wise/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script type="text/javascript" src="/template_bootstrap/wise/js/custom.js"></script>
      <script type="text/javascript" src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
      <script type="text/javascript" src="{{ asset('template_bootstrap/datatables/DataTables-1.13.6/js/dataTables.bootstrap.js') }}"></script>
      <script type="text/javascript" src="{{ asset('template_bootstrap/datatables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js') }}"></script>

      <script src="template_bootstrap/datatables/DataTables-1.13.6/js/jquery.dataTables.min.js"></script>

      <script type="text/javascript">

        $(document).ready(function(){
            $('#tableLogs').DataTable({
                pageLength: 5,
                lengthMenu: [[5, 10, 20], [5, 10, 20]],
                // columnDefs: [
                    // {
                    // targets: [0],
                    // visible: false,
                    // searchable: false,
                    // pageLength: 5,
                    // lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]]
                //     }
                // ],
            });
        })

        $(document).ready(function(){
            $('#tableRooms').DataTable({
                pageLength: 5,
                lengthMenu: [[5, 10, 20], [5, 10, 20]],
            });
        })

        $(document).ready(function(){
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });

            $(".zoom").hover(function(){

                $(this).addClass('transition');
            }, function(){

                $(this).removeClass('transition');
            });
        });

      </script>
   </body>
</html>
