@extends('layouts.adm')
@section('content')

    <!-- links e config -->
    <link rel="stylesheet" href="{{ URL::to('/public/adm/css/contato-create.css') }}">
    <!-- end links e config -->

    <div class="container">

        <div class="form-area">
            <div class="form-box">

                <div class="title-area">
                    <h1>Contato - Cadastro</h1>
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

                <form action="{{ url('/adm/contato') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="titulo">Titulo</label>
                                <input type="text" id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror" placeholder="Titulo" value="{{ old('titulo') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefone">Telefone</label>
                                <input type="text" id="telefone" name="telefone" class="form-control @error('telefone') is-invalid @enderror" placeholder="Titulo" value="{{ old('telefone') }}" onkeypress="$(this).mask('(00) 00000-0000')">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="resumo">Resumo</label>
                                <textarea name="resumo" id="resumo" class="form-control @error('resumo') is-invalid @enderror" rows="3" placeholder="Resumo">{{ old('resumo') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="texto">Texto</label>
                                <textarea name="texto" id="texto" class="form-control @error('texto') is-invalid @enderror" rows="5" placeholder="Resumo">{{ old('texto') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="btn-area">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                        <a href="{{ url('/adm/contato') }}" class="btn btn-primary">Voltar</a>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- scripts -->
    
    <!-- end scripts -->

@endsection