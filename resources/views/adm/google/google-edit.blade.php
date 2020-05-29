@extends('layouts.adm')
@section('content')

    <!-- links e confih -->
    <link rel="stylesheet" href="{{ URL::to('/public/adm/css/google-create.css') }}">
    <!-- end links e config -->

    <div class="container">
        <div class="form-area">
            <div class="form-box">

                <div class="title-area">
                    <h1>Google Meta tag - Editar</h1>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/adm/google') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="pagina">Página</label>
                        <input type="text" name="pagina" id="pagina" class="form-control @error('pagina') is-invalid @enderror" placeholder="Página" value="{{ $google['pagina'] }}">
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" rows="3" class="form-control @error('descricao') is-invalid @enderror" placeholder="Descrição" >{{ $google['descricao'] }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="conteudo">Conteúdo</label>
                        <textarea name="conteudo" id="conteudo" rows="5" class="form-control @error('conteudo') is-invalid @enderror" placeholder="Conteúdo" >{{ $google['conteudo'] }}</textarea>
                        <span class="text-danger">Atenção: As palavras chaves devem ser separadas por vírgulas e pertinente ao conteúdo da respectiva página.</span>
                    </div>

                    <div class="btn-area">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                        <a href="{{ url('/adm/google') }}" class="btn btn-primary">Voltar</a>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- scripts -->

    <!-- end scripts -->

@endsection