<!-- Simple Empty State Component -->
<div class="text-center py-5">
    <div class="mb-4">
        <img src="{{ asset('assets/images/svg-graphics/empty-products.svg') }}"
             alt="{{ $title ?? 'Tidak ada data' }}"
             class="img-fluid"
             style="max-width: 200px; opacity: 0.7;">
    </div>

    <h4 class="text-muted mb-3">{{ $title ?? 'Tidak Ada Data' }}</h4>
    <p class="text-muted mb-4">{{ $description ?? 'Belum ada data yang tersedia saat ini.' }}</p>

    @if(isset($actionUrl) && isset($actionText))
        <a href="{{ $actionUrl }}" class="btn btn-success">
            @if(isset($actionIcon))
                <i class="{{ $actionIcon }} me-2"></i>
            @endif
            {{ $actionText }}
        </a>
    @endif
</div>
