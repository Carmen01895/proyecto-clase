@php
    $homeRoute = '#';
    if(Auth::user()->id_rol == 3) { // Empleado
        $homeRoute = route('tickets.historial');
    } elseif(Auth::user()->id_rol == 2) { // Jefe
        $homeRoute = route('gestion.tickets');
    } elseif(Auth::user()->id_rol == 1) { // Admin
        // Si no tienes una "home" de admin, puedes poner 'gestion' o dejarlo en '#'
        $homeRoute = route('gestion'); 
    }
@endphp

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #4e73df, #1cc88a);">
    <div class="container">
        
        {{-- LOGO DINÁMICO: Redirige a la 'home' de cada rol --}}
        <a class="navbar-brand text-white d-flex align-items-center" href="{{ $homeRoute }}">
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

                {{-- ======================================================= --}}
                {{-- SECCIÓN: EMPLEADO (ID: 3)                               --}}
                {{-- ======================================================= --}}
                @if(Auth::user()->id_rol == 3)
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
                @endif


                {{-- ======================================================= --}}
                {{-- SECCIÓN: JEFE (ID: 2)                                   --}}
                {{-- ======================================================= --}}
                @if(Auth::user()->id_rol == 2)
                    {{-- Vista Principal --}}
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('gestion.tickets') ? 'active' : '' }}"
                           href="{{ route('gestion.tickets') }}">
                            Inicio
                        </a>
                    </li>

                    {{-- Reportes --}}
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('reportes.index') ? 'active' : '' }}" 
                           href="{{ route('reportes.index') }}">
                            Reportes
                        </a>
                    </li>

                    {{-- Departamentos --}}
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('departamentos.*') ? 'active' : '' }}" href="{{ route('departamentos.index') }}">
                            Departamentos
                        </a>
                    </li>

                    {{-- Usuarios --}}
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('gestion') ? 'active' : '' }}"
                           href="{{ route('gestion') }}">
                            Usuarios
                        </a>
                    </li>
                @endif


                {{-- ======================================================= --}}
                {{-- SECCIÓN: ADMIN (ID: 1)                                  --}}
                {{-- ======================================================= --}}
                @if(Auth::user()->id_rol == 1)
                     {{-- Si el admin necesita links de texto, van aquí.
                          Si solo son iconos, se manejan abajo en la sección común. --}}
                @endif


                {{-- ======================================================= --}}
                {{-- ICONOS (PERFIL, DETALLES, LOGOUT)                       --}}
                {{-- ======================================================= --}}

                {{-- 1. ICONO PERFIL (Para TODOS: Empleado, Jefe y Admin) --}}
                <li class="nav-item ms-3">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('perfil*') ? 'active' : '' }}"
                       href="{{ route('perfil') }}" title="Mi perfil">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 4.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zm0 8a5.5 5.5 0 0 1-4.473-2.344c.03-1.463 2.948-2.266 4.473-2.266 1.526 0 4.444.803 4.473 2.266A5.5 5.5 0 0 1 8 12.5z"/>
                        </svg>
                    </a>
                </li>

                {{-- 2. ICONO DETALLES (SOLO ADMIN) --}}
                @if(Auth::user()->id_rol == 1)
                <li class="nav-item ms-3">
                    {{-- Puse '#' porque no tengo la ruta, cámbiala cuando la tengas --}}
                    <a class="nav-link text-white d-flex align-items-center" href="#" title="Detalles">
                        {{-- Icono de Info/Detalles --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </a>
                </li>
                @endif

                {{-- 3. ICONO LOGOUT (Para TODOS) --}}
                {{-- Aunque solo dijiste iconos para Jefe y Admin, el Empleado también necesita salir --}}
                <li class="nav-item ms-3">
                    <form method="GET" action="{{ route('logout') }}" class="d-inline">
                        <button type="submit" class="nav-link btn btn-link text-white p-0 d-flex align-items-center" title="Cerrar Sesión">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M6 2a1 1 0 0 0-1 1v2H4V3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2h1v2a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H6z"/>
                                <path d="M.146 8.354a.5.5 0 0 1 0-.708L3.793 4H3.5a.5.5 0 0 1 0-1h3.5a.5.5 0 0 1 .5.5V7a.5.5 0 0 1-1 0V5.207L.146 8.354z"/>
                            </svg>
                        </button>
                    </form>
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

{{-- Asegúrate de incluir el script de Bootstrap si no está en el layout padre --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}