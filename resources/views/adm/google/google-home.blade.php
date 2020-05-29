@extends('layouts.adm')
@section('content')

    <!-- links and config -->
    <link rel="stylesheet" href="{{ URL::to('public/adm/showgoogle.css') }}">

    <!-- end links and config -->

    <div class="container">
        <div class="form-area">
            <div class="container" id="google-show">
                <h1 class="titulo" style="text-align: center;">Google</h1>
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
    
                <div id="content">
                    <table class="table table-striped table-dark">
                        <thead>
                          <tr>
                            <th scope="col">Pagina</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($google as $item)
                                <tr>
                                    <td>
                                        <a class="tools-icons" href="{{ url('/adm/google/editar/'.$item['id']) }}"><i class="fas fa-pencil-alt"></i></a>
                                        <a class="tools-icons2" href="{{ url('/adm/item/delete/'.$item['id']) }}"><i class="fas fa-trash-alt"></i></a>
                                        <a href="{{ url('/adm/google/editar/'.$item['id']) }}">{{ Helper::limitString($item['title'], 30) }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                
            </div>
        </div>
    </div>

@endsection