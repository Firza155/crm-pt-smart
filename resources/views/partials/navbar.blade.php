<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand fw-bold text-white" href="#">
            CRM PT Smart
        </a>

        {{-- Toggle mobile --}}
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#crmNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="crmNavbar">

            {{-- Left menu --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- SALES --}}
                @if(auth()->user()->role === 'sales')
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/sales/dashboard">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/sales/leads">
                            Leads
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/sales/products">
                            Produk
                        </a>
                    </li>
                @endif

                {{-- MANAGER --}}
                @if(auth()->user()->role === 'manager')
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/manager/dashboard">
                            Dashboard
                        </a>
                    </li>

                    {{-- UI approval project --}}
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/manager/projects">
                            Project Approval
                        </a>
                    </li>

                    {{-- UI history project --}}
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/manager/projects/history">
                            Riwayat Project
                        </a>
                    </li>

                    {{-- UI create user --}}
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/manager/users/create">
                            Tambah User
                        </a>
                    </li>
                @endif
            </ul>

            {{-- Right menu --}}
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item me-3">
                    <span class="text-white-50 small">
                        {{ auth()->user()->email }} ({{ ucfirst(auth()->user()->role) }})
                    </span>
                </li>

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn btn-sm btn-outline-light">
                            Logout
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>
