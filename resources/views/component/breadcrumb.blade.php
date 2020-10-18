<section class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">{{ env('APP_NAME') }}</a>
            </li>
            @foreach($breadcrumbs as $key => $url)
                @if($url !== null)
                    <li class="breadcrumb-item">
                        <a href="{{ $url }}">{{ $key }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{ $key }}</li>
                @endif
            @endforeach
        </ol>
    </nav>
</section>
