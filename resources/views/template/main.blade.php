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
      <link rel="stylesheet" href="/template_bootstrap/wise/css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="/template_bootstrap/wise/css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="/template_bootstrap/wise/images/favicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="/template_bootstrap/wise/css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
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
                        <div class="logo"> <a href="index.html">MyRR</a> </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                  <div class="menu-area">
                     <div class="limit-box">
                        <nav class="main-menu">
                           <ul class="menu-area-main">
                              <li> <a href="{{('/')}}">Home</a> </li>
                              <li> <a href="#about">About</a> </li>
                              <li> <a href="#service"> Service</a> </li>
                              <li> <a href="#ContactUs">Contact us</a> </li>
                              {{-- <li> <a href="{{('/login')}}">Login</a> </li> --}}
                              <li> <a href="{{ route('login') }}">Login</a> </li>
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
      <footer id="ContactUs">
         <div class="footer">
            <div class="container">
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
            </div>
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
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="/template_bootstrap/wise/js/jquery.min.js"></script>
      <script src="/template_bootstrap/wise/js/popper.min.js"></script>
      <script src="/template_bootstrap/wise/js/bootstrap.bundle.min.js"></script>
      <script src="/template_bootstrap/wise/js/jquery-3.0.0.min.js"></script>
      <script src="/template_bootstrap/wise/js/plugin.js"></script>
      <!-- sidebar -->
      <script src="/template_bootstrap/wise/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="/template_bootstrap/wise/js/custom.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
      <script>
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
