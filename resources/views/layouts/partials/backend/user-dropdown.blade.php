<li class="dropdown ms-4">
    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="../assets/images/avatar/avatar-1.jpg" alt="" class="avatar avatar-md rounded-circle" />
    </a>

    <div class="dropdown-menu dropdown-menu-end p-0">
        <div class="lh-1 px-5 py-4 border-bottom">
            <h5 class="mb-1 h6">{{ Auth::user()->name }}</h5>
            <small>{{ Auth::user()->email }}</small>
        </div>

        <ul class="list-unstyled px-2 py-3">
            <li>
                <a class="dropdown-item" href="">Profile</a>
            </li>
        </ul>
        <div class="border-top px-5 py-3">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link p-0 text-decoration-none text-start"
                    style="border: none; background: none; color: inherit; font-size: inherit;">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</li>
