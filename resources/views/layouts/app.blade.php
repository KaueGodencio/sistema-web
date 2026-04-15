<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Web - Gestão</title>

    <!-- Bootstrap 4.6 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Premium CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @yield('styles')
</head>

<body>

    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h4 class="mb-0 text-primary font-weight-bold">SISTEMA WEB</h4>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ Request::is('fornecedores*') ? 'active' : '' }}">
                    <a href="{{ route('fornecedores.index') }}"><i class="fas fa-truck mr-2"></i> Fornecedores</a>
                </li>
                <li class="{{ Request::is('produtos*') ? 'active' : '' }}">
                    <a href="{{ route('produtos.index') }}"><i class="fas fa-boxes mr-2"></i> Produtos</a>
                </li>
                <li class="{{ Request::is('pedidos*') ? 'active' : '' }}">
                    <a href="{{ route('pedidos.index') }}"><i class="fas fa-shopping-cart mr-2"></i> Pedidos</a>
                </li>
            </ul>
        </nav>


        <!-- Page Content -->
        <div id="content" class="p-0">


            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="d-flex justify-content-end justify-content-md-start mt-3 mb-3">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary shadow-sm">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>


                @yield('content')
            </div>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <script>
        $(document).ready(function() {
            @if($errors->any())
                $('.modal.fade').modal('show');
            @endif
        });
    </script>
    @yield('scripts')
</body>

</html>