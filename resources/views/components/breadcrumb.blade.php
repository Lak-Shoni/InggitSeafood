<!-- components/breadcrumb.blade.php -->
@if (isset($breadcrumbs) && count($breadcrumbs) > 0)
    <ol class="breadcrumb" style="background: none; padding: 0; margin: 0;">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
            @endif
        @endforeach
    </ol>
@endif
