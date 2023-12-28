<div class="col-md-12 col-sm-12 d-flex justify-content-center">
    <div>
        <div>
            <nav aria-label="Page navigation example">
                <ul class="pagination mt-2">

                    <li onclick="prevPagi()"
                        class="page-item prev {{ $allrequest->currentPage() == 1 ? 'disabled' : '' }}">
                        <span class="page-link" role="button"></span>
                    </li>


                    @foreach ($allrequest->getUrlRange(1, $allrequest->lastPage()) as $page => $url)
                        @if ($page == $allrequest->currentPage())
                            <li class="page-item active" aria-current="page"><span
                                    class="page-link" role="button">{{ $page }}</span></li>
                        @else
                            <li onclick="numberPagi({{ $page }})" class="page-item"><span
                                    class="page-link" role="button">{{ $page }}</span>
                            </li>
                        @endif
                    @endforeach


                    <li onclick="nextPagi()" class="page-item next {{ $allrequest->hasMorePages() ? '' : 'disabled' }}">
                        <span class="page-link" role="button"></span>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    // pagination prev btn
    function prevPagi(){
        if ({{ $allrequest->currentPage() }} != 1) {

            let params = new URLSearchParams(window.location.search);

            params.set("page", {{ $allrequest->currentPage() }} - 1);
            window.location.href = window.location.origin + window.location.pathname + "?" + params;
        }
    }

    // pagination next btn
    function nextPagi(){
        // if ({{ $allrequest->hasMorePages() }}) {
            let params = new URLSearchParams(window.location.search);
            params.set("page", {{ $allrequest->currentPage() + 1 }});
            window.location.href = window.location.origin + window.location.pathname + "?" + params;
        // }
    }


    // pagination number btn
    function numberPagi(number) {
        // if ({{ $allrequest->hasMorePages() }}) {
            let params = new URLSearchParams(window.location.search);
            params.set("page", number);
            window.location.href = window.location.origin + window.location.pathname + "?" + params;
        // }
    }
</script>
