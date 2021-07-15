@if ($paginator->hasPages())
    <div class="single-wrap d-flex justify-content-center">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">

                @if($paginator->onFirstPage())
                    <li class="page-item"><a class="page-link disabled"><span class="ti-angle-left"></span></a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"><span class="ti-angle-left"></span></a></li>
                @endif

                @foreach ($elements as $element)

                    @if (is_string($element))
                        <li class="page-item"><a class="page-link">{{$element}}</a></li>
                    @endif

                    @if (is_array($element))
                        @foreach($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active"><a class="page-link">{{$page}}</a></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{$page}}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{$paginator->nextPageUrl()}}"><span class="ti-angle-right"></span></a></li>
                @else
                    <li class="page-item"><a class="page-link"><span class="ti-angle-right"></span></a></li>
                @endif
                {{-- <li class="page-item active"><a class="page-link" href="#">01</a></li>
                <li class="page-item"><a class="page-link" href="#">02</a></li>
                <li class="page-item"><a class="page-link" href="#">03</a></li>
                <li class="page-item"><a class="page-link" href="#"><span class="ti-angle-right"></span></a></li> --}}
            </ul>
        </nav>
    </div>
@endif