<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #4e73df, #1cc88a);">
    <div class="container">
        
        <a class="navbar-brand text-white d-flex align-items-center" href="{{ url('/') }}">
            
            <img 
                src="{{ asset('images/logo.png') }}" 
                alt="Logo Dulces Ricos" 
                class="me-2" 
                style="height: 30px; width: 30px; object-fit: contain;"
            >
            <strong>Dulces Ricos</strong>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('tickets.historial') ? 'active' : '' }}"
                       href="{{ route('tickets.historial') }}">
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('tickets.create') ? 'active' : '' }}"
                       href="{{ route('tickets.create') }}">
                        Crear Tickets
                    </a>
                </li>

                <li class="nav-item ms-3">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('perfil') ? 'active' : '' }}"
                       href="{{ route('perfil') }}" title="Mi perfil" aria-label="Mi perfil">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 4.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zm0 8a5.5 5.5 0 0 1-4.473-2.344c.03-1.463 2.948-2.266 4.473-2.266 1.526 0 4.444.803 4.473 2.266A5.5 5.5 0 0 1 8 12.5z"/>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .nav-link.active {
        font-weight: 600;
        border-bottom: 2px solid rgba(255,255,255,0.95);
        border-radius: 0;
    }
    .nav-link svg { display: block; }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>