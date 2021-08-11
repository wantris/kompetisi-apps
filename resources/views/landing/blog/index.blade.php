        
@extends('template')

@section('title', 'Blog')



@section('content')
  <!-- Hero Area Start-->
  <div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('assets/img/service/blog-banner.png')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Area End -->
<!--================Blog Area =================-->
<section class="blog_area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">
                    @foreach ($blogs as $blog)
                        <article class="blog_item">
                            <div class="blog_item_img">
                                <img class="card-img rounded-0" src="{{url('assets/img/blog/'.$blog->image_name)}}" alt="">
                                <a href="#" class="blog_item_date">
                                    <h3>{{$blog->created_at->isoFormat('d')}}</h3>
                                    <p>{{$blog->created_at->isoFormat('MMM')}} </p>
                                </a>
                            </div>

                            <div class="blog_details">
                                <a class="d-inline-block" href="{{route('blog.detail', $blog->slug)}}">
                                    <h2>{{$blog->title}}</h2>
                                </a>
                                {!!$blog->Konten_excerpt!!}
                            </div>
                        </article>
                    @endforeach

                    <div class="pagination-area pb-115 text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12">
                                    {{ $blogs->links('vendor.pagination.event_pagination') }}
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
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Search Keyword'">
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
                        <h3 class="widget_title">Blog Terbaru</h3>
                        @foreach ($recents as $recent)
                            <div class="media post_item">
                                @php
                                    $title =  Str::words($recent->title, '5');
                                @endphp
                                <img style="width:50px; height:50px" src="{{url('assets/img/blog/'.$blog->image_name)}}" alt="{{$title}}">
                                <div class="media-body">
                                    <a href="single-blog.html">
                                        <h3>{{$title}}</h3>
                                    </a>
                                    <p>{{$recent->created_at->isoFormat('MMM, d Y')}}</p>
                                </div>
                            </div>
                        @endforeach
                    </aside>

                </div>
            </div>
        </div>
    </div>
</section>
<!--================Blog Area =================-->

@endsection
