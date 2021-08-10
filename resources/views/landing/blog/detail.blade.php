@extends('template')

@section('title', $slug)


@section('content')
 <!-- Hero Area Start-->
 <div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{url('assets/img/hero/about.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>{{$slug}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
 <!-- Hero Area End -->
 <!--================Blog Area =================-->
 <section class="blog_area single-post-area section-padding">
    <div class="container">
       <div class="row">
          <div class="col-lg-8 posts-list">
             <div class="single-post">
                <div class="feature-img">
                   <img class="img-fluid" src="{{url('assets/img/blog/'.$blog->image_name)}}" alt="">
                </div>
                <div class="blog_details">
                   <h2 class="mb-3">{{$blog->title}}
                   </h2>
                   {!!$blog->konten!!}
                </div>
             </div>
             <div class="navigation-top">
                <div class="d-sm-flex justify-content-between text-center">
                   <p class="like-info"><span class="align-middle"><i class="fa fa-heart"></i></span> Lily and 4
                      people like this</p>
                   <div class="col-sm-4 text-center my-2 my-sm-0">
                      <!-- <p class="comment-count"><span class="align-middle"><i class="fa fa-comment"></i></span> 06 Comments</p> -->
                   </div>
                   <ul class="social-icons">
                      <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                      <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                      <li><a href="#"><i class="fab fa-behance"></i></a></li>
                   </ul>
                </div>
                <div class="navigation-area">
                   <div class="row">
                      <div
                         class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                         <div class="thumb">
                            <a href="#">
                               <img class="img-fluid" src="{{url('assets/img/post/preview.png')}}" alt="">
                            </a>
                         </div>
                         <div class="arrow">
                            <a href="#">
                               <span class="lnr text-white ti-arrow-left"></span>
                            </a>
                         </div>
                         <div class="detials">
                            <p>Prev Post</p>
                            <a href="#">
                               <h4>Space The Final Frontier</h4>
                            </a>
                         </div>
                      </div>
                      <div
                         class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                         <div class="detials">
                            <p>Next Post</p>
                            <a href="#">
                               <h4>Telescopes 101</h4>
                            </a>
                         </div>
                         <div class="arrow">
                            <a href="#">
                               <span class="lnr text-white ti-arrow-right"></span>
                            </a>
                         </div>
                         <div class="thumb">
                            <a href="#">
                               <img class="img-fluid" src="{{url('assets/img/post/next.png')}}" alt="">
                            </a>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4">
             <div class="blog_right_sidebar">
                <aside class="single_sidebar_widget search_widget">
                   <form action="#">
                      <div class="form-group">
                         <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder='Search Keyword'
                               onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Keyword'">
                            <div class="input-group-append">
                               <button class="btns" type="button"><i class="ti-search"></i></button>
                            </div>
                         </div>
                      </div>
                      <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                         type="submit">Search</button>
                   </form>
                </aside>
                <aside class="single_sidebar_widget popular_post_widget">
                   <h3 class="widget_title">Recent Post</h3>
                   <div class="media post_item">
                      <img src="{{url('assets/img/post/post_1.png')}}" alt="post">
                      <div class="media-body">
                         <a href="single-blog.html">
                            <h3>From life was you fish...</h3>
                         </a>
                         <p>January 12, 2019</p>
                      </div>
                   </div>
                   <div class="media post_item">
                      <img src="{{url('assets/img/post/post_2.png')}}" alt="post">
                      <div class="media-body">
                         <a href="single-blog.html">
                            <h3>The Amazing Hubble</h3>
                         </a>
                         <p>02 Hours ago</p>
                      </div>
                   </div>
                   <div class="media post_item">
                      <img src="{{url('assets/img/post/post_3.png')}}" alt="post">
                      <div class="media-body">
                         <a href="single-blog.html">
                            <h3>Astronomy Or Astrology</h3>
                         </a>
                         <p>03 Hours ago</p>
                      </div>
                   </div>
                   <div class="media post_item">
                      <img src="{{url('assets/img/post/post_4.png')}}" alt="post">
                      <div class="media-body">
                         <a href="single-blog.html">
                            <h3>Asteroids telescope</h3>
                         </a>
                         <p>01 Hours ago</p>
                      </div>
                   </div>
                </aside>
             </div>
          </div>
       </div>
    </div>
 </section>
 <!--================ Blog Area end =================-->
@endsection