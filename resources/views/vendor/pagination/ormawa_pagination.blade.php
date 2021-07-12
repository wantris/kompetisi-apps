@if ($paginator->hasPages())
     <div class="blog-pagination">
        <div class="btn-toolbar justify-content-center mb-15">
            <div class="btn-group">

            @if($paginator->onFirstPage())
                <a class="disabled btn btn-outline-primary prev"><i class="fa fa-angle-double-left"></i></a>
            @else
                 <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn btn-outline-primary prev"><i class="fa fa-angle-double-left"></i></a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <a class="disabled btn btn-outline-primary">{{$element}}</a>
                @endif

                @if (is_array($element))
                    @foreach($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="btn btn-primary current">{{$page}}</span>
                        @else
                           <a href="{{ $url }}" class="btn btn-outline-primary">{{$page}}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{$paginator->nextPageUrl()}}" rel="next" class="btn btn-outline-primary next"><i class="fa fa-angle-double-right"></i></a>
            @else
                <a class="btn btn-outline-primary next disabled"><i class="fa fa-angle-double-right"></i></a>
            @endif

            </div>
        </div>
    </div>
@endif