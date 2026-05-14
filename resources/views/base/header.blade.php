<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Painel de Bolsas')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Painel de administração de bolsas universitárias" name="description">
    <meta content="Universidade" name="author">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link href="{{ asset('assets/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <div class="wrapper">

        <div class="leftside-menu">

            <a href="index.html" class="logo text-center logo-light">
                <p class="mb-2" style="font-size: 22px; color: #c6d0dd; font-weight: 500;">
                    SIBOLSAVE
                </p>
            </a>

            <a href="('index.html')" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="assets/images/logo-dark.png" alt="" height="16">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo_sm_dark.png" alt="" height="16">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <ul class="side-nav">

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false"
                            aria-controls="sidebarDashboards" class="side-nav-link">
                            <i class="uil-apps"></i>
                            <span class="badge bg-success float-end"></span>
                            <span>Menu</span>
                        </a>

                        <div class="collapse" id="sidebarDashboards">
                            <ul class="side-nav-second-level">

                                @can('excluir')
                                    <li>
                                        <a href="{{ route('admin.index') }}">
                                            <i class="uil-home"></i> Inicio
                                        </a>
                                    </li>
                                @endcan

                                @can('exclu')
                                    <li>
                                        <a href="{{ route('student.index') }}">
                                            <i class="uil-home"></i> Inicio
                                        </a>
                                    </li>
                                @endcan

                                @can('excluir')
                                    <li>
                                        <a href="{{ route('faculties.index') }}">
                                            <i class="uil-book"></i> Faculdade
                                        </a>
                                    </li>
                                @endcan

                                @can('excluir')
                                    <li>
                                        <a href="{{ route('departments.index') }}">
                                            <i class="uil-building"></i> Departamento
                                        </a>
                                    </li>
                                @endcan
                                @can('excluir')
                                    <li>
                                        <a href="{{ route('courses.index') }}">
                                            <i class="uil-book-open"></i> Cursos
                                        </a>
                                    </li>
                                @endcan
                                @can('excluir')
                                    <li>
                                        <a href="{{ route('users.index') }}">
                                            <i class="uil-users-alt"></i> Estudante
                                        </a>
                                    </li>
                                @endcan
                                <li>
                                    <a href="{{ route('scholarships.index') }}">
                                        <i class="uil uil-gift"></i>
                                        <span>Bolsas</span>
                                    </a>
                                </li>
                                @can('excluir')
                                    @can('exclu')
                                        <li>
                                            <a href="{{ route('notifications.index') }}">
                                                <i class="uil uil-gift"></i>
                                                <span>Notificações</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endcan

                                <li>
                                    <a href="{{ route('messages.index') }}">
                                        <i class="uil uil-message"></i>
                                        <span>Mensagens</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('applications.index') }}">
                                        <i class="uil uil-file-alt"></i>
                                        <span>Candidaturas</span>
                                    </a>
                                </li>

                                @can('excluir')
                                    <li>
                                        <a href="{{ route('reports.index') }}">
                                            <i class="uil uil-analytics"></i>
                                            <span>Relatório</span>
                                        </a>
                                    </li>
                                @endcan


                            </ul>
                        </div>
                    </li>

                </ul>
                <div class="clearfix"></div>

            </div>
        </div>
        <div class="content-page">
            <div class="content">

                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">

                        <li class="dropdown notification-list d-lg-none">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-search noti-icon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                <form class="p-3">
                                    <input type="text" class="form-control" placeholder="Pesquisar ..."
                                        aria-label="Pesquisar">
                                </form>
                            </div>
                        </li>

                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('assets/images/flags/moc.PNG') }}" alt="bandeira-moc"
                                    class="me-0 me-sm-1" height="12">
                                <span class="align-middle d-none d-sm-inline-block">Português</span>
                                <i class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu">
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <img src="{{ asset('assets/images/flags/us.jpg') }}" alt="user-image"
                                        class="me-1" height="12">
                                    <span class="align-middle">Inglês</span>
                                </a>
                            </div>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-bell noti-icon"></i>
                                @if ($unreadNotificationsCount > 0)
                                    <span class="noti-icon-badge"></span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <small class="text-dark">{{ $unreadNotificationsCount }} nova(s)</small>
                                        </span>Notificações
                                    </h5>
                                </div>

                                @forelse($headerNotifications as $notification)
                                    <a href="{{ route('notifications.read', $notification->id) }}"
                                        class="dropdown-item notify-item {{ $notification->is_read ? '' : 'active' }}">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-bell-outline"></i>
                                        </div>
                                        <p class="notify-details mb-1">
                                            {{ $notification->title }}
                                            <small class="text-muted d-block">
                                                {{ \Illuminate\Support\Str::limit($notification->message, 60) }}
                                            </small>
                                            <small class="text-muted">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </p>
                                    </a>
                                @empty
                                    <div class="dropdown-item text-muted">
                                        Nenhuma notificação encontrada.
                                    </div>
                                @endforelse

                                <a href="{{ route('notifications.index') }}"
                                    class="dropdown-item text-center text-primary notify-item notify-all">
                                    Ver todas
                                </a>

                            </div>
                        </li>

                        <li class="dropdown notification-list d-none d-sm-inline-block">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-mail noti-icon"></i>
                                @if ($unreadMessagesCount > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $unreadMessagesCount }}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <small class="text-dark">{{ $unreadMessagesCount }} nova(s)</small>
                                        </span>Mensagens
                                    </h5>
                                </div>

                                @forelse($headerMessages as $message)
                                    <a href="{{ route('messages.chat', $message->sender_id === Auth::id() ? $message->receiver_id : $message->sender_id) }}"
                                        class="dropdown-item notify-item {{ $message->is_read ? '' : 'active' }}">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-message-text-outline"></i>
                                        </div>
                                        <p class="notify-details mb-1">
                                            {{ optional($message->sender)->name ?? 'Utilizador' }}
                                            <small class="text-muted d-block">
                                                {{ \Illuminate\Support\Str::limit($message->message, 60) }}
                                            </small>
                                            <small class="text-muted">
                                                {{ $message->created_at->diffForHumans() }}
                                            </small>
                                        </p>
                                    </a>
                                @empty
                                    <div class="dropdown-item text-muted">
                                        Nenhuma mensagem encontrada.
                                    </div>
                                @endforelse

                                <a href="{{ route('messages.index') }}"
                                    class="dropdown-item text-center text-primary notify-item notify-all">
                                    Abrir mensagens
                                </a>
                            </div>
                        </li>

                        <li class="notification-list">
                            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                <i class="dripicons-gear noti-icon"></i>
                            </a>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <i class="mdi mdi-account-circle me-7" style="font-size: 24px;"></i>
                                </span>
                                <span>
                                    <span class="account-user-name">{{ Auth::user()->name }}</span>
                                    <span class="account-position">
                                        {{ Auth::user()->access_level == 1 ? 'Administrador Geral' : 'Estudante' }}
                                    </span>
                                </span>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">

                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Bem Vindo!</h6>
                                </div>

                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>Meu perfil</span>
                                </a>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item notify-item">
                                        <i class="mdi mdi-logout me-1"></i>
                                        <span>Sair</span>
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <div class="app-search dropdown d-none d-lg-block">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control dropdown-toggle" placeholder="Pesquisar..."
                                    id="top-search">
                                <span class="mdi mdi-magnify search-icon"></span>
                                <button class="input-group-text btn-primary" type="submit">Pesquisar</button>
                            </div>
                        </form>

                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">

                        </div>
                    </div>
                </div>
                @yield('content')

            </div>
            <div class="end-bar">

                <div class="rightbar-title">
                    <a href="javascript:void(0);" class="end-bar-toggle float-end">
                        <i class="dripicons-cross noti-icon"></i>
                    </a>
                    <h5 class="m-0">Settings</h5>
                </div>

                <div class="rightbar-content h-100" data-simplebar="">

                    <div class="p-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                        </div>

                        <h5 class="mt-3">Color Scheme</h5>
                        <hr class="mt-1">

                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="light"
                                id="light-mode-check" checked="">
                            <label class="form-check-label" for="light-mode-check">Light Mode</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="dark"
                                id="dark-mode-check">
                            <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                        </div>

                        <h5 class="mt-4">Width</h5>
                        <hr class="mt-1">

                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="width" value="fluid"
                                id="fluid-check" checked="">
                            <label class="form-check-label" for="fluid-check">Fluid</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="width" value="boxed"
                                id="boxed-check">
                            <label class="form-check-label" for="boxed-check">Boxed</label>
                        </div>

                        <h5 class="mt-4">Left Sidebar</h5>
                        <hr class="mt-1">

                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="theme" value="default"
                                id="default-check">
                            <label class="form-check-label" for="default-check">Default</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="theme" value="light"
                                id="light-check" checked="">
                            <label class="form-check-label" for="light-check">Light</label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="theme" value="dark"
                                id="dark-check">
                            <label class="form-check-label" for="dark-check">Dark</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="compact" value="fixed"
                                id="fixed-check" checked="">
                            <label class="form-check-label" for="fixed-check">Fixed</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="compact" value="condensed"
                                id="condensed-check">
                            <label class="form-check-label" for="condensed-check">Condensed</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="compact" value="scrollable"
                                id="scrollable-check">
                            <label class="form-check-label" for="scrollable-check">Scrollable</label>
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-primary" id="resetBtn">Reset to Default</button>
                            <a href="../../product/hyper-responsive-admin-dashboard-template/index.htm"
                                class="btn btn-danger mt-3" target="_blank">
                                <i class="mdi mdi-basket me-1"></i> Purchase Now
                            </a>
                        </div>

                    </div>
                </div>

            </div>
            <div class="rightbar-overlay"></div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                document.getElementById('scholarshipType').addEventListener('change', function() {
                    const desc = document.getElementById('description');
                    const req = document.getElementById('requirements');

                    const requisitos = `Dados Sociais e Económicos:
* Bilhete
* Atestado de pobreza
* Declaração de bairro
* Declaração de agregado familiar
* Declaração de rendimento

Dados Académicos:
* Aproveitamento acadêmico`;

                    if (this.value === "Completa") {
                        desc.value = "Inserção de inscrição, ajuda de custos com alimentação e moradia";
                        req.value = requisitos;
                    } else if (this.value === "Parcial") {
                        desc.value = "Inserção de inscrição";
                        req.value = requisitos;
                    } else {
                        desc.value = "";
                        req.value = "";
                    }
                });

                document.querySelectorAll('.scholarshipTypeEdit').forEach(function(sel) {
                    sel.addEventListener('change', function() {
                        const id = this.dataset.id;
                        const desc = document.getElementById("description" + id);
                        const req = document.getElementById("requirements" + id);

                        const requisitos = `Dados Sociais e Económicos:
* Bilhete
* Atestado de pobreza
* Declaração de bairro
* Declaração de agregado familiar
* Declaração de rendimento

Dados Académicos:
* Aproveitamento acadêmico`;

                        if (this.value === "Completa") {
                            desc.value = "Inserção de inscrição, ajuda de custos com alimentação e moradia";
                            req.value = requisitos;
                        } else if (this.value === "Parcial") {
                            desc.value = "Inserção de inscrição";
                            req.value = requisitos;
                        } else {
                            desc.value = "";
                            req.value = "";
                        }

                    });
                });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

            <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
            <script src="{{ asset('assets/js/app.min.js') }}"></script>

            <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
            <script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
            <script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>

            <script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
            <script src="{{ asset('assets/js/app.min.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
