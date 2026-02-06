
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | Universidade Save</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de Gestão de Bolsas" name="description" />
    <meta content="Universidade Save" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
  

</head>

<body class="loading authentication-bg">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

 <!-- Título do sistema -->
<div class="text-center w-75 m-auto">
    <p class="mb-2" 
       style="font-size: 18px; color: #3c434d; font-weight: 500;">
        Sistema Integrado de Candidatura de Bolsas da Universidade Save.
        <H4>(SIBOLSAVE)</H4>
    </p>
</div>

<!-- Logo -->
<div class="card-header text-center" 
     style="padding-top: 0; padding-bottom: 0; margin-bottom: -25px;">
    <a href="{{ route('login') }}">
        <span>
            <img src="{{ asset('assets/images/capela.AVIF') }}" 
                 alt="Logo" 
                 style="height: 210px; object-fit: contain; margin-bottom: -10px;">
        </span>
    </a>
</div>

<!-- Corpo -->
<div class="card-body" style="padding-top: 0; padding-bottom: 10px;">

    <div class="text-center w-75 m-auto" style="margin-top: -25px;">

        <p class="text-muted" 
           style="margin-top: 0; margin-bottom: 10px; font-size: 13px; height: 200;">
            Digite seu email e senha para acessar o sistema.
        </p>
    </div>

    <form action="{{ route('login.store') }}" method="POST">
        @csrf

        <div class="mb-2">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Entrar</button>

        <div class="text-center mt-2">
            <a href="{{ route('register') }}" class="btn btn-link">Registrar-se</a>
        </div>
    </form>
</div>

 <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted"> 2025 © Universidade Save 
                            </p>
                        </div>
                    </div>
</div>



    @if ($errors->any())
        <div class="mt-3 text-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>
</html>
