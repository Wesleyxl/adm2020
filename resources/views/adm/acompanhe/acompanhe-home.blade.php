@extends('layouts.adm')
@section('content')

    <!-- links and config -->
    <link rel="stylesheet" href="{{ URL::to('/public/adm/css/acompanhe-home.css') }}">
    <!-- end links and config -->

    <div class="container">
        <div class="form-area">

            <div class="title-area">
                <h1>Acompanhe</h1>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('delete'))
                <div class="alert alert-warning">
                    {{ $message }}
                </div>
            @endif
            
            <div class="busca-area">
                <input class="form-control mr-sm-2" type="search" placeholder="buscar" aria-label="Search" id="buscar">      
            </div>

            <div class="table-area" id="table">

                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                        <th scope="col"><i class="fas fa-tools"></i></th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Hora / data da publicação</th>
                        <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($acompanhe === null)
                            <h3>Nada para mostrar</h3>
                        @else
                            <tr>
                                <th>
                                    <a class="tools-icons" href="{{ url('/adm/acompanhe/edit/'.$new['id']) }}"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="tools-icons2" href="{{ url('/adm/acompanhe/delete/'.$new['id']) }}"><i class="fas fa-trash-alt"></i></a>
                                </th>
                                <td><a href="{{ url('/adm/acompanhe/edit/'.$new['id']) }}">{{ Helper::limitString($new['title'], 40) }}</a></td>
                                <td><a href="{{ url('/adm/acompanhe/edit/'.$new['id']) }}">{{ $new['author'] }}</a></td>
                                <td><a href="{{ url('/adm/acompanhe/edit/'.$new['id']) }}">{{ $new['time']. " ". $new['date'] }}</a></td>
                                <td>
                                    <a style="color: white; font-weight: bolder;" href="{{ url('/adm/acompanhe/edit/'.$new['id']) }}">Conteúdo Atual</a>
                                </td>
                            </tr>
                            
                            @foreach ($acompanhe as $item)
                                <tr>
                                    <th>
                                        <a class="tools-icons" href="{{ url('/adm/acompanhe/edit/'.$item['id']) }}"><i class="fas fa-pencil-alt"></i></a>
                                        <a class="tools-icons2" href="{{ url('/adm/acompanhe-apagar/'.$item['id']) }}"><i class="fas fa-trash-alt"></i></a>
                                    </th>
                                    <td><a href="{{ url('/adm/acompanhe/edit/'.$item['id']) }}">{{ Helper::limitString($item['title'], 40) }}</a></td>
                                    <td><a href="{{ url('/adm/acompanhe/edit/'.$item['id']) }}">{{ $item['author'] }}</a></td>
                                    <td><a href="{{ url('/adm/acompanhe/edit/'.$item['id']) }}">{{ $item['time']. " ". $item['date'] }}</a></td>
                                    <td>
                                        @if ($item['datePost'] > strtotime(date('Y/m/d H:i:d')))
                                            <span class="text-danger">Conteúdo Pendente</span>
                                        @else
                                            <span class="text-success">Conteúdo Publicado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if ($acompanhe != null)
                    {{ $acompanhe->links() }}
                @endif

            </div>

        </div>
    </div>

    <!-- scripts -->
    <script>
        var timeout = null;
        $('body').on('keyup', '#buscar', function(e){

            var buscar = $('#buscar').val();
            clearTimeout(timeout);

            timeout = setTimeout(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: "{{ url('/adm/acompanhe/search/') }}",
                    data: {busca: buscar},
                    success: function(retorno){
                        $('#table').html(retorno);
                    }
                });
            }, 800)
        });
    </script>
    <!-- end scripts -->

@endsection