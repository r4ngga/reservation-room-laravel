@extends('template/main')

@section('title','Home')
@section('container')
      <section class="slider_section">
         <div id="myCarousel" class="carousel slide banner-main" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <img class="first-slide" src="/template_bootstrap/wise/images/banner2.png" sizes="100%" alt="First slide">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <h1>Best service</h1>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and </p>
                        <a  href="#">Read More</a>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <img class="second-slide" src="/template_bootstrap/wise/images/room1.jpg" sizes="100%" alt="Second slide">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <h1>Comfort lodging</h1>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and </p>
                        <a  href="#">Read More</a>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <img class="third-slide" src="/template_bootstrap/wise/images/pool2.jpg" sizes="100%" alt="Third slide">
                  <div class="container">
                     <div class="carousel-caption relative" style="color: black">
                        <h1 style="color: black">Full service</h1>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and </p>
                        <a  href="#">Read More</a>
                     </div>
                  </div>
               </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <i class='fa fa-angle-left'></i>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <i class='fa fa-angle-right'></i>
            </a>
         </div>
      </section>
      <!-- about  -->
      <div id="about" class="about top_layer">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>About Informations</h2>
                     <span>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and </span>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="img-box">
                     <figure><img src="/template_bootstrap/wise/images/about.png" alt="img"/></figure>
                     <a href="#">read more</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end abouts -->
      <!-- service -->
      <div id="service" class="service">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Services </h2>
                     <span>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of <br>using Lorem Ipsum is that it has a more-or-less normal distribution of letters,</span>
                  </div>
               </div>
            </div>
         </div>
         <div class="container margin-r-l">
            <div class="row">
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 thumb">
                  <div class="service-box">
                     <figure>
                        <a href="/template_bootstrap/wise/images/1.jpg" class="fancybox" rel="ligthbox">
                        <img  src="/template_bootstrap/wise/images/1.jpg" class="zoom img-fluid "  alt="">
                        </a>
                        <span class="hoverle">
                        <a href="/template_bootstrap/wise/images/1.jpg" class="fancybox" rel="ligthbox">Food</a>
                        </span>
                     </figure>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 thumb">
                  <div class="service-box">
                     <figure>
                        <a href="/template_bootstrap/wise/images/2.jpg" class="fancybox" rel="ligthbox">
                        <img  src="/template_bootstrap/wise/images/2.jpg" class="zoom img-fluid "  alt="">
                        </a>
                        <span class="hoverle">
                        <a href="/template_bootstrap/wise/images/1.jpg" class="fancybox" rel="ligthbox">Fashion</a>
                        </span>
                     </figure>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 thumb">
                  <div class="service-box">
                     <figure>
                        <a href="/template_bootstrap/wise/images/3.jpg" class="fancybox" rel="ligthbox">
                        <img  src="/template_bootstrap/wise/images/3.jpg" class="zoom img-fluid "  alt="">
                        </a>
                        <span class="hoverle">
                        <a href="/template_bootstrap/wise/images/3.jpg" class="fancybox" rel="ligthbox">Booking</a>
                        </span>
                     </figure>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 thumb">
                  <div class="service-box">
                     <figure>
                        <a href="/template_bootstrap/wise/images/4.jpg" class="fancybox" rel="ligthbox">
                        <img  src="/template_bootstrap/wise/images/4.jpg" class="zoom img-fluid "  alt="">
                        </a>
                        <span class="hoverle">
                        <a href="/template_bootstrap/wise/images/4.jpg" class="fancybox" rel="ligthbox">Marketing</a>
                        </span>
                     </figure>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 thumb">
                  <div class="service-box">
                     <figure>
                        <a href="/template_bootstrap/wise/images/5.jpg" class="fancybox" rel="ligthbox">
                        <img  src="/template_bootstrap/wise/images/5.jpg" class="zoom img-fluid "  alt="">
                        </a>
                        <span class="hoverle">
                        <a href="/template_bootstrap/wise/images/5.jpg" class="fancybox" rel="ligthbox">Design</a>
                        </span>
                     </figure>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                  <div class="service-box">
                     <figure>
                        <a href="/template_bootstrap/wise/images/6.jpg" class="fancybox" rel="ligthbox">
                        <img  src="/template_bootstrap/wise/images/6.jpg" class="zoom img-fluid "  alt="">
                        </a>
                        <span class="hoverle">
                        <a href="/template_bootstrap/wise/images/6.jpg" class="fancybox" rel="ligthbox">Making Food</a>
                        </span>
                     </figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end service -->
      <!-- Download -->

      <!-- end Download -->
      <!-- Testimonial -->
      <div id="testimonial" class="testimonial">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h3>Testimonial</h3>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                  <div id="testimonial_slider" class="carousel slide banner-bg" data-ride="carousel">
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img class="first-slide" src="/template_bootstrap/wise/images/testimonial-img2.jpg">
                           <div class="container">
                              <div class="carousel-caption relat">
                                 <h3>Luka due</h3>
                                 <span><i class="fa fa-quote-left"></i> ( foundery )<i class="fa fa-quote-right"></i></span>
                                 <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem  </p>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <img class="second-slide" src="/template_bootstrap/wise/images/testimonial-img2.jpg">
                           <div class="container">
                              <div class="carousel-caption relat">
                                 <h3>Luka due</h3>
                                 <span><i class="fa fa-quote-left"></i> ( foundery )<i class="fa fa-quote-right"></i></span>
                                 <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem  </p>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <img class="third-slide" src="/template_bootstrap/wise/images/testimonial-img.png">
                           <div class="container">
                              <div class="carousel-caption relat">
                                 <h3>Luka due</h3>
                                 <span><i class="fa fa-quote-left"></i> ( foundery )<i class="fa fa-quote-right"></i></span>
                                 <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem  </p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <a class="carousel-control-prev" href="#testimonial_slider" role="button" data-slide="prev"> <i class='fa fa-angle-right'></i></a> <a class="carousel-control-next" href="#testimonial_slider" role="button" data-slide="next"> <i class='fa fa-angle-left'></i></a>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                  <div class="contact">
                     <h3>Contact Us</h3>
                     <form>
                        <div class="row">
                           <div class="col-sm-12">
                              <input class="contactus" placeholder="Name" type="text" name="Name">
                           </div>
                           <div class="col-sm-12">
                              <input class="contactus" placeholder="Phone" type="text" name="Email">
                           </div>
                           <div class="col-sm-12">
                              <input class="contactus" placeholder="Email" type="text" name="Email">
                           </div>
                           <div class="col-sm-12">
                              <textarea class="textarea" placeholder="Message" type="text" name="Message"></textarea>
                           </div>
                           <div class="col-sm-12">
                              <button class="send">Send</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end Testimonial -->
      <!--  footer -->

         @endsection()
