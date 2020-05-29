@extends('layouts.adm')
@section('content')

    <!-- links and config -->
    <link rel="stylesheet" href="{{ URL::to('public/adm/css/contato-home.css') }}">

    <!-- end links and config -->

    <div class="container">
        <div class="form-area">
            <div class="container" id="contatos-show">
                <h1 class="titulo" style="text-align: center;">contatos</h1>
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
        
                <div id="content">
                    <table class="table table-striped table-dark">
                        <thead>
                          <tr>
                            <th scope="col"><i class="fas fa-tools"></i></th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Hora / data</th>
                            <th scope="col">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($contatos as $contato)
                                <tr>
                                    <th>
                                        <a class="tools-icons" href="{{ url('/adm/contato/editar/'.$contato['id']) }}"><i class="fas fa-pencil-alt"></i></a>
                                        <a class="tools-icons2" href="{{ url('/adm/contato/delete/'.$contato['id']) }}"><i class="fas fa-trash-alt"></i></a>
                                    </th>
                                    <td><a href="{{ url('/adm/contato/editar/'.$contato['id']) }}">{{ Helper::limitString($contato['title'], 30) }}</a></td>
                                    <td><a href="{{ url('/adm/contato/editar/'.$contato['id']) }}">{{ $contato['telephone'] }}</a></td>
                                    <td><a href="{{ url('/adm/contato/editar/'.$contato['id']) }}">{{ $contato['date'] . " - ".Helper::noSeg($contato['time'])}}</a></td>
                                    <td>
                                        @if ($contato['status'] == "Não lido")
                                            <a style="color: red; font-weight: bolder;" href="{{ url('/adm/contato/editar/'.$contato['id']) }}">{{ $contato['status'] }}</a>
                                        @else 
                                            <a style="color: white; font-weight: bolder;" href="{{ url('/adm/contato/editar/'.$contato['id']) }}">{{ $contato['status'] }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $contatos->links() }}
                    <a class="btn btn-success" href="{{ url('/adm/home') }}" download="contatosexl.xls"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Gerar Relatório Excel</a>
                </div>
                
                
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
                    url: "{{ url('/adm/contato/search/') }}",
                    data: {busca: buscar},
                    success: function(retorno){
                        $('#content').html(retorno);
                    }
                });
            }, 800)
        });
    </script>
    <!-- end scripts -->
@endsection