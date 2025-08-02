<!-- Top Bar -->
<div class="bg-success text-white py-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small>
                    <i class="bi bi-truck me-1"></i>
                    Gratis ongkir untuk pembelian minimal Rp 100.000
                </small>
            </div>
            <div class="col-md-6 text-md-end">
                <small>
                    <i class="bi bi-telephone me-1"></i>
                    Hotline: 021-123-4567
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold text-success" href="{{ route('homepage') }}">
            <i class="bi bi-shop me-2"></i>
            FreshCart
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Search bar untuk desktop -->
            <div class="mx-auto d-none d-lg-flex" style="width: 400px;">
                <form action="{{ route('search') }}" method="GET" class="w-100">
                    <div class="input-group search-input-group">
                        <input type="text" name="q" class="form-control search-input"
                               placeholder="Cari produk..." aria-label="Search"
                               value="{{ request('q') }}" autocomplete="off">
                        <button class="btn btn-success" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <!-- Search Suggestions Dropdown -->
                    <div class="search-suggestions dropdown-menu w-100" style="display: none;"></div>
                </form>
            </div>

            <!-- Right side items -->
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <!-- Mobile Search -->
                <li class="nav-item d-lg-none mb-2">
                    <form action="{{ route('search') }}" method="GET" class="w-100">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control"
                                   placeholder="Cari produk..." aria-label="Search"
                                   value="{{ request('q') }}">
                            <button class="btn btn-success" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </li>

                <!-- User Authentication -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-bag me-2"></i>Pesanan Saya</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @if(Auth::user()->hasRole('admin'))
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="btn btn-outline-success w-100 w-lg-auto me-lg-2 mb-2 mb-lg-0" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success w-100 w-lg-auto" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i>
                            Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .search-input-group {
        position: relative;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-height: 400px;
        overflow-y: auto;
    }

    .suggestion-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f8f9fa;
        cursor: pointer;
        transition: background-color 0.2s ease;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: inherit;
    }

    .suggestion-item:hover {
        background-color: #f8f9fa;
        color: inherit;
        text-decoration: none;
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    .suggestion-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 12px;
        background-color: #f8f9fa;
    }

    .suggestion-content {
        flex: 1;
    }

    .suggestion-name {
        font-size: 0.9rem;
        margin-bottom: 2px;
        color: #333;
    }

    .suggestion-price {
        font-size: 0.8rem;
        color: #0aad0a;
        font-weight: 600;
    }

    .search-input:focus {
        box-shadow: none;
        border-color: #0aad0a;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const suggestionsContainer = document.querySelector('.search-suggestions');
    let searchTimeout;

    if (searchInput && suggestionsContainer) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            clearTimeout(searchTimeout);

            if (query.length < 2) {
                hideSuggestions();
                return;
            }

            // Debounce search requests
            searchTimeout = setTimeout(() => {
                fetchSuggestions(query);
            }, 300);
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-input-group')) {
                hideSuggestions();
            }
        });

        // Show suggestions when focusing on input (if there's content)
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2) {
                fetchSuggestions(this.value.trim());
            }
        });
    }

    function fetchSuggestions(query) {
        fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Suggestions response:', data); // Debug log
            displaySuggestions(data.suggestions);
        })
        .catch(error => {
            console.error('Search suggestions error:', error);
            hideSuggestions();
        });
    }

    function displaySuggestions(suggestions) {
        console.log('Displaying suggestions:', suggestions); // Debug log

        if (suggestions.length === 0) {
            hideSuggestions();
            return;
        }

        let html = '';
        suggestions.forEach(suggestion => {
            // Ensure we have a valid URL with fallback
            const productUrl = suggestion.url || `{{ url('/product') }}/${suggestion.slug}`;
            console.log('Product URL for', suggestion.name, ':', productUrl); // Debug log

            html += `
                <a href="${productUrl}" class="suggestion-item">
                    ${suggestion.image
                        ? `<img src="${suggestion.image}" alt="${suggestion.name}" class="suggestion-image">`
                        : `<div class="suggestion-image d-flex align-items-center justify-content-center bg-light">
                             <i class="bi bi-image text-muted"></i>
                           </div>`
                    }
                    <div class="suggestion-content">
                        <div class="suggestion-name">${suggestion.name}</div>
                        <div class="suggestion-price">${suggestion.price}</div>
                    </div>
                </a>
            `;
        });

        suggestionsContainer.innerHTML = html;
        suggestionsContainer.style.display = 'block';
    }

    function hideSuggestions() {
        if (suggestionsContainer) {
            suggestionsContainer.style.display = 'none';
        }
    }
});
</script>

<!-- Categories Menu -->
<div class="bg-light border-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <!-- Mobile toggle for categories -->
            <button class="navbar-toggler d-lg-none border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#categoriesNav">
                <i class="bi bi-grid-3x3-gap me-1"></i>
                <small>Menu</small>
            </button>

            <!-- Mobile search button -->
            <div class="d-lg-none ms-auto">
                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="categoriesNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold py-3" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-grid-3x3-gap me-1"></i>
                            Semua Kategori
                        </a>
                        <ul class="dropdown-menu">
                            @forelse($categories as $category)
                                @if($category->children->isNotEmpty())
                                    <!-- Parent category with children -->
                                    <li>
                                        <h6 class="dropdown-header text-success">
                                            {{ $category->name }}
                                            @if($category->total_products_count > 0)
                                                <small class="text-muted">({{ $category->total_products_count }})</small>
                                            @endif
                                        </h6>
                                    </li>
                                    @foreach($category->children as $child)
                                        <li>
                                            <a class="dropdown-item ps-4" href="{{ route('categories.show', $child->slug) }}">
                                                <i class="bi bi-arrow-right-short me-1"></i>
                                                {{ $child->name }}
                                                @if($child->products_count > 0)
                                                    <small class="text-muted">({{ $child->products_count }})</small>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                    @unless($loop->last)
                                        <li><hr class="dropdown-divider"></li>
                                    @endunless
                                @else
                                    <!-- Single category without children -->
                                    <li>
                                        <a class="dropdown-item" href="{{ route('categories.show', $category->slug) }}">
                                            <i class="bi bi-tag me-2"></i>
                                            {{ $category->name }}
                                            @if($category->products_count > 0)
                                                <small class="text-muted">({{ $category->products_count }})</small>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @empty
                                <li>
                                    <span class="dropdown-item-text text-muted">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Belum ada kategori tersedia
                                    </span>
                                </li>
                            @endforelse

                            @if($categories->isNotEmpty())
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item fw-bold text-success" href="{{ route('categories.index') }}">
                                        <i class="bi bi-grid-3x3-gap me-2"></i>
                                        Lihat Semua Kategori
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3" href="{{ route('homepage') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3" href="{{ route('products.new') }}">Produk Terbaru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3" href="{{ route('promotions') }}">Promo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3" href="{{ route('about') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3" href="{{ route('contact') }}">Kontak</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Mobile search form -->
        <div class="collapse d-lg-none pb-3" id="mobileSearch">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari produk...">
                <button class="btn btn-success" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
