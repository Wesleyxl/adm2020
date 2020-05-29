<!DOCTYPE html>
<html lang="en">
<head>
    
    <!-- metas tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- end metas tags -->

    <!-- link css -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::to('/public/adm/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('/public/adm/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ URL::to('/public/adm/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('/public/adm/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ URL::to('/public/adm/css/layout.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- end link css -->

    <script src="{{ URL::to('/public/adm/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <title>Area Administrativa</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- notification menu -->
        <ul class="navbar-nav ml-auto notification">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user"></i>
                    @if (count($notiContato) <= 0)
                        <span class="">
                            
                        </span>        
                    @else
                        <span class="badge badge-danger navbar-badge">
                            {{ count($notiContato) }}
                        </span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    @if (count($notiContato) <= 0)
                         <!-- Message Start -->
                         <div class="media">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                   <p class="text-md text-center">Não há registro</p>
                                </h3>
                            </div>
                        </div>
                        <!-- Message End -->
                    @else
                        @foreach ($notiContato as $item)
                            <a href="{{ url('/adm/contato/editar/'.$item['id']) }}" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            {{ Helper::limitString($item['title'], 10) }}
                                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">{{ Helper::limitString($item['resume'], 15) }}</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{ Helper::runningTime($item['created_at']) }}</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                        @endforeach
                        
                    @endif
                    <div class="dropdown-divider"></div>
                
                    <a href="{{ url('/adm/contato') }}" class="dropdown-item dropdown-footer">Ver Todos os contatos</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-envelope"></i>
                    @if (count($notiNews) <= 0)
                        <span class="e"></span>       
                    @else
                    <span class="badge badge-danger navbar-badge">
                            {{ count($notiNews) }}
                        </span>
                    @endif
                    
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    @if (count($notiNews) <= 0)
                         <!-- Message Start -->
                         <div class="media">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    <p class="text-md text-center">Não há registro</p>
                                </h3>
                            </div>
                        </div>
                        <!-- Message End -->
                    @else
                        @foreach ($notiNews as $item)
                        <a href="{{ url('/adm/news/editar/'.$item['id']) }}" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        {{ Helper::limitString($item['title'], 10) }}
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">{{ $item['telephone'] }}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{ Helper::runningTime($item['created_at']) }} </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        @endforeach
                        
                    @endif
                    <a href="{{ url('/adm/news') }}" class="dropdown-item dropdown-footer">Ver Todas as news</a>
                </div>
            </li>
            
            <li class="nav-item dropdown menu-logout">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <span class="wellcome-title">Bem Vindo!</span> {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Sair') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ URL::to('/public/adm/dist/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
                    <!--<img src="{{ URL::to('/public/adm/img/logo.png') }}" alt="">-->
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
                    <!-- Acompanhe -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="far fa-newspaper"></i>
                            <p class="ml-10">
                                Acompanhe 
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/adm/acompanhe/create') }}" class="nav-link">
                                    <i class="fas fa-plus"></i>
                                    <p>Cadastrar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/adm/acompanhe/') }}" class="nav-link">
                                    <i class="fas fa-pencil-alt"></i>
                                    <p>Editar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/adm/acompanhe/order') }}" class="nav-link">
                                    <i class="fas fa-arrows-alt"></i>
                                    <p>Ordernar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end acompanhe -->

                    <!-- news -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="far fa-envelope"></i>
                            <p class="ml-10">
                                News
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/adm/news/create') }}" class="nav-link">
                                    <i class="fas fa-plus"></i>
                                    <p>Cadastrar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/adm/news/') }}" class="nav-link">
                                    <i class="fas fa-pencil-alt"></i>
                                    <p>Editar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end news -->

                    <!-- contato -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user"></i>
                            <p class="ml-10">
                                Contato
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/adm/contato/create') }}" class="nav-link">
                                    <i class="fas fa-plus"></i>
                                    <p>Cadastrar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/adm/contato/') }}" class="nav-link">
                                    <i class="fas fa-pencil-alt"></i>
                                    <p>Editar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end contato -->

                    <!-- Google -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fab fa-google-plus-g"></i>
                            <p class="ml-10">
                                Google Meta Tags
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/adm/google/create') }}" class="nav-link">
                                    <i class="fas fa-plus"></i>
                                    <p>Cadastrar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/adm/google') }}" class="nav-link">
                                    <i class="fas fa-pencil-alt"></i>
                                    <p>Editar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end google -->

                    <!-- Dados Usuarios -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-lock"></i>
                            <p class="ml-10">
                                Dados de usuários
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/adm/dados-usuario/') }}" class="nav-link">
                                    <i class="fas fa-pencil-alt"></i>
                                    <p>Editar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end usuario -->

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
    
                <div class="div">
                    @yield('content')
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content --><!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2020 <a href="http://adminlte.io">Engenho de Imagens</a>.</strong>
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 2.2020
        </div>
    </footer>


</div>
<!-- ./wrapper -->

    <!-- scripts js -->
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ URL::to('/public/adm/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 4 -->
    <script src="{{ URL::to('/public/adm/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ URL::to('/public/adm/dist/js/adminlte.js') }}"></script>
    <!-- end scripts -->

</body>
</html>