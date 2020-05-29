@extends('layouts.adm')
@section('content')

   <!-- links and config -->
   <link rel="stylesheet" href="{{ URL::to('/public/adm/css/acompanhe-edit.css') }}">
   <script src="{{ URL::to('/public/ckeditor/ckeditor.js') }}"></script>
   <!-- end links and config -->

   <div class="container">
       <div class="form-area">
           <div class="form-box">

               <div class="title-area">
                   <h1>Acompanhe - Editar</h1>
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

               <form action="{{ url('/adm/acompanhe/edited/'.$acompanhe['id']) }}" method="post" enctype="multipart/form-data">

                    @csrf

                   <div class="form-group">
                       <label for="title">Titulo</label>
                       <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="title" name="titulo" placeholder="Titulo" value="{{ $acompanhe['title'] }}">
                       <span class="title-char-count"></span>
                   </div>

                   <div class="form-group">
                       <label for="subtitle">Resumo</label>
                       <textarea name="resumo" id="subtitle" rows="3" class="form-control @error('resumo') is-invalid @enderror" placeholder="Resumo">{{ $acompanhe['subtitle'] }}</textarea>
                       <span class="subtitle-char-count"></span>
                   </div>

                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="author">Autor</label>
                               <input type="text" id="author" class="form-control @error('autor') is-invalid @enderror" name="autor" placeholder="Autor" value="{{ $acompanhe['author'] }}">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="type">Tipo</label>
                               <select class="form-control" name="type" id="type">
                                <option selected value="{{ $acompanhe['type'] }}">{{ $acompanhe['type'] }}</option>
                                   <option value="texto" selected>Texto</option>
                                   <option value="video">Video</option>
                               </select>
                           </div>
                       </div>
                   </div>

                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="postNow">Publicar agora</label>
                               <input type="radio" class="postNow" name="postDate" id="postNow" checked onclick="hideData()">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="fomr-group">
                               <label for="postAfter">Agendar postagem</label>
                               <input type="radio" class="postAfter" name="postDate" id="postAfter" onclick="showData()">
                           </div>
                       </div>
                   </div>

                   <div class="row" id="hide">
                       <div class="col-md-4">
                           <div class="form-group">
                               <label for="time">Agendar Horário</label>
                               <input type="text" name="time" id="time" class="form-control" value="{{ $acompanhe['time'] }}" onkeyup="$(this).mask('00:00')">
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label for="date">Agendar Data</label>
                               <input type="text" name="date" id="date" class="form-control" value="{{ $acompanhe['date'] }}" onkeyup="$(this).mask('00/00/0000')">
                           </div>
                       </div>
                   </div>

                   <div class="row">
                       <div class="col-md-6">
                           <label>Imagem Principal</label>
                           <input id="uploadImage" class="file" type="file" name="image" onchange="PreviewImage();" style="display: block"/>
                           <span class="text-danger">Obs: formatos recomendados (.jpg .png) com 72dpi e tamanho maximo de 5MB</span>
                       </div>
                       <div class="col-md-6">
                           <div class="img-area">
                               <img src="{{ URL::to($acompanhe['image']) }}" id="uploadPreview"/>
                           </div>
                       </div>
                   </div>

                   <div class="row text-area">
                       <div class="col-md-12">
                           <div class="form-group">
                               <label for="text">Conteúdo</label>
                               <textarea class="form-control @error('conteudo') is-invalid @enderror" name="conteudo" id="text" cols="10" placeholder="Conteúdo" >{{ $acompanhe['text'] }}</textarea>
                           </div>
                           <script>
                               CKEDITOR.replace('text');
                           </script>
                       </div>
                   </div>

                   <div class="btn-area">
                       <button type="submit" class="btn btn-success">Editar</button>
                       <a href="{{ url('/adm/acompanhe') }}" class="btn btn-primary">Voltar</a>
                   </div>

               </form>
           </div>
       </div>
   </div>

   <!-- scripts -->
   <script type="text/javascript">

       function hideData(){
           $('#hide').css('display', 'none')
       }

       function showData(){
           $('#hide').css('display', 'flex')
       }

       function PreviewImage() {
           var oFReader = new FileReader();
           oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
   
           oFReader.onload = function (oFREvent) {
               document.getElementById("uploadPreview").src = oFREvent.target.result;
               $('#uploadPreview').css('opacity', 1);
           };
       };
   
   </script>
   <!-- end scripts -->

@endsection