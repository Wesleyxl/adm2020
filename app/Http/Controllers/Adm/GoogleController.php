<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\GoogleMetaTag;
use App\Contato;
use App\News;

class GoogleController extends Controller
{
    // metodo construtor
    public function __construct()
    {
        // definindo timezone e data/hora atual
        date_default_timezone_set('America/Sao_Paulo');
        $this->today = strtotime('now');

        // notificçoes contatos e news
        $this->notiContato = Contato::where('status', '=', 'Não lido')->get()->all();
        $this->notiNews = News::where('status', '=', 'Não lido')->get()->all();
    }

    // retorna todos os dados
    public function index()
    {
        $google = GoogleMetaTag::orderBy('id', 'desc')->get()->all();

        return view ('adm/google/google-home', array(
            'google' => $google,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // retorna a view de cadastro 
    public function create()
    {
        return view('adm/google/google-create', array(
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // validação e armazenamento de dados cadastrados
    public function store(Request $request)
    {
        // validando os dados recebidos
        $validator = Validator::make($request->all(), [
            'pagina' => 'required|string',
            'descricao' => 'required|string',
            'conteudo' => 'required|string',
        ]);

        // redirecionando caso houver algum erro
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $google = new GoogleMetatag();
        $google['title'] = $request->input('pagina');
        $google['description'] = $request->input('descricao');
        $google['text'] = $request->input('conteudo');
        $google['status'] = "Não lido";
        $google['date'] = date('d/m/Y');
        $google['time'] = date('H:i:s');

        // redirecionando com mensagem de sucesso
        if ($google->save()) {
            return redirect('/adm/google/')->with('success', 'Dados cadastrados com sucesso');
        }
    }

    // retorna a view de edição
    public function edit($id)
    {
        $google = GoogleMetaTag::fiind($id);

        return view('adm/google/google-edit', array(
            'google' => $google,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // validação e armazenamento de dados editado
    public function update(Request $request, $id)
    {
        // validando os dados recebidos
        $validator = Validator::make($request->all(), [
            'titpaginale' => 'required|string',
            'descicao' => 'required|string',
            'conteudo' => 'required|string',
        ]);

        // redirecionando caso houver algum erro
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $google = GoogleMetatag::find($id);
        $google['title'] = $request->get('pagina');
        $google['description'] = $request->get('descicao');
        $google['text'] = $request->get('conteudo');
        $google['status'] = "Não lido";
        $google['date'] = date('d/m/Y');
        $google['time'] = date('H:i:s');

        // redirecionando com mensagem de sucesso
        if ($google->save()) {
            return redirect('/adm/google/')->with('edited', 'Dados atualizados com sucesso');
        }
    }

    // buscando dados
    public function search(Request $request) 
    {
        $search = $request['search'];

        $google = GoogleMetaTag::orderBy('id', 'desc')->where('title', 'like', '%'.$search.'%')->get()->all()->limit(20);

        return view('adm/google/google-search', array(
            'google' => $google,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // apagando dados e fotos solicitados
    public function destroy($id)
    {
        $google = GoogleMetaTag::find($id)->delete();

        return redirect('/adm/google')->with('delete', 'Dados removido com sucesso');
    }
}
