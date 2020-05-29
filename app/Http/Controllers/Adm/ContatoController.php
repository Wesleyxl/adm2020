<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contato;
use App\News;
use Validator;
use Helper;

class ContatoController extends Controller
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

    // mostrar todos os dados 
    public function index()
    {
        $contatos = Contato::orderBy('id', 'desc')->paginate(10);

        return view('adm/contato/contato-home', array(
            'contatos' => $contatos,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // retorna a view de cadastro
    public function create()
    {
        return view('adm/contato/contato-create', array(
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // validação e armazenamento de dados cadastrados
    public function store(Request $request)
    {
        // validando os dados recebidos
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string',
            'resumo' => 'required|string',
            'texto' => 'required|string',
            'email' => 'required|email',
            'telefone' => 'required|string',
        ]);

        // redirecionanod caso houver algum erro
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // armazenandos dados no banco de dados
        $contatos = new Contato();
        $contatos['title'] = $request->input('titulo');
        $contatos['resume'] = $request->input('resumo');
        $contatos['text'] = $request->input('texto');
        $contatos['email'] = $request->input('email');
        $contatos['telephone'] = $request->input('telefone');
        $contatos['time'] = date('H:i:d');
        $contatos['date'] = date('d/m/Y');
        $contatos['status'] = "Não lido";

        // salvando e redirecionando
        if ($contatos->save()) {
            return redirect('adm/contato')->with('success', 'Dados cadastrado com sucesso');
        }
    }

    // retorna a view de edição
    public function edit($id)
    {
        $contatos = Contato::find($id);
        $contatos['status'] = "Lido";
        $contatos->save();

        return view('adm/contato/contato-edit', array(
            'contato' => $contatos,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // recenbendo dados para serem atualizados
    public function update(Request $request, $id)
    {
        // validando os dados recebidos
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string',
            'resumo' => 'required|string',
            'texto' => 'required|string',
            'email' => 'required|email',
            'telefone' => 'required|string',
        ]);

        // redirecionanod caso houver algum erro
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // armazenandos dados no banco de dados
        $contatos = Contato::find($id);
        $contatos['title'] = $request->get('titulo');
        $contatos['resume'] = $request->get('resumo');
        $contatos['text'] = $request->get('texto');
        $contatos['email'] = $request->get('email');
        $contatos['telephone'] = $request->get('telefone');
        $contatos['time'] = date('H:i:d');
        $contatos['date'] = date('d/m/Y');
        $contatos['status'] = "Não lido";

        // redirecionando com mensagem de sucesso
        if ($contatos->save()) {
            return redirect('/adm/contato/')->with('success', 'Seus dados foram editados com sucesso');
        }
    }

    // buscando dados
    public function search(Request $request) 
    {
        $search = $request['busca'];

        $contatos = Contato::where('title', 'like', '%'.$search.'%')->orderBy('id', 'desc')->paginate(15);

        return view('adm/contato/contato-search', array(
            'contatos' => $contatos,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // apagando dados e fotos solicitados
    public function destroy($id)
    {
        // apagando dados no bando e redirecionando 
        $contatos = Contato::find($id)->delete();
        return redirect('/adm/contato/')->with('delete', 'Seus dados foram removidos com sucesso');
    }
}
