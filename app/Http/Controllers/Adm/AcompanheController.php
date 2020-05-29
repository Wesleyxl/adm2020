<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Acompanhe;
use App\Contato;
use App\News;
use Validator;
use Helper;


class AcompanheController extends Controller
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
        // trazendo os dados que nao foram agendadas
        $new = Acompanhe::where('datePost', '<', $this->today)->where('order', '=', null)->orderBy('id', 'desc')->get()->first();
        if ($new === null) {
            $new = Acompanhe::where('datePost', '<', $this->today)->orderBy('order', 'asc')->get()->first();
        }

        // validando se os dados são nulos
        if ($new === null) {
            $acompanhe = null;
        } else {
            // trazendo todos os post com excessao do dado new
            $acompanhe = Acompanhe::where('id', '<>', $new['id'])->orderBy('id', 'desc')->paginate(10);
        }

        return view('adm/acompanhe/acompanhe-home', array(
            'new' => $new,
            'acompanhe' => $acompanhe,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // retorna a view de cadastro 
    public function create()
    {
        return view('adm/acompanhe/acompanhe-create', array(
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // validação e armazenamento de dados cadastrados
    public function store(Request $request)
    {
        // validando os dados recebidos
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:200',
            'resumo' => 'required|string',
            'autor' => 'required|string',
            'conteudo' => 'required|string',
        ]);

        // redirecionando caso houver algum erro
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // armazenandos dados no banco de dados
        $acompanhe = new Acompanhe();
        $acompanhe['title'] = $request->input('titulo');
        $acompanhe['subtitle'] = $request->input('resumo');
        $acompanhe['text'] = $request->input('conteudo');
        $acompanhe['author'] = $request->input('autor');
        $acompanhe['url'] = Helper::cleanUrl($request->input('titulo'));
        $acompanhe['date'] = $request->input('date');
        $acompanhe['time'] = $request->input('time');
        $acompanhe['type'] = $request->input('type');
        $acompanhe['datePost'] = Helper::toTimestamp($acompanhe['date'], $acompanhe['time']);

        // verificando status
        if ($acompanhe['datePost'] > $this->today) {
            $acompanhe['status'] = "Pendente";
        } else {
            $acompanhe['status'] = "Publicado";
        }

        // verificando se foi feito algum upload de imagem
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = env('APP_NAME')."-".Helper::toTimestamp($acompanhe['date'], $acompanhe['time']).".".$image->getClientOriginalExtension();
            $name2 = env('APP_NAME')."-".Helper::toTimestamp($acompanhe['date'], $acompanhe['time']).".webp";
            $request->file('image')->move(public_path('upload/acompanhe/'), $name);

            // amarzena o caminho no banco
            $acompanhe['image'] = "public/upload/acompanhe/".$name2;

            // nome da foto para ser otimizada
            $data = array(
                'nome' => $name,
                'nome2' => $name2
            );
            $ch = curl_init();
            
            // localização da função para otimizar 
            curl_setopt($ch, CURLOPT_URL, env('IMG_OTIMIZE'));
            
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $resp = curl_exec($ch);
            curl_close($ch);
        }

        // redirecionando com mensagem de sucesso
        if ($acompanhe->save()) {
            return redirect('/adm/acompanhe/')->with('success', 'Seus dados foram cadastrado com sucesso');
        }        
    }

    // retorna a view de edição
    public function edit($id)
    {
        $acompanhe = Acompanhe::find($id);

        return view('adm/acompanhe/acompanhe-edit', array(
            'acompanhe' => $acompanhe,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));
    }

    // recenbendo dados para serem atualizados
    public function update(Request $request, $id)
    {
        // validando os dados recebidos
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:200',
            'resumo' => 'required|string',
            'autor' => 'required|string',
            'conteudo' => 'required|string',
        ]);

        // redirecionando caso houver algum erro
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // armazenando dados patualizados
        $acompanhe = Acompanhe::find($id);
        $acompanhe['title'] = $request->get('titulo');
        $acompanhe['subtitle'] = $request->get('resumo');
        $acompanhe['text'] = $request->get('conteudo');
        $acompanhe['author'] = $request->get('autor');
        $acompanhe['url'] = Helper::cleanUrl($request->get('titulo'));
        $acompanhe['date'] = $request->get('date');
        $acompanhe['time'] = $request->get('time');
        $acompanhe['type'] = $request->get('type');
        $acompanhe['datePost'] = Helper::toTimestamp($acompanhe['date'], $acompanhe['time']);

        // verificando status
        if ($acompanhe['datePost'] > $this->today) {
            $acompanhe['status'] = "Pendente";
        } else {
            $acompanhe['status'] = "Publicado";
        }

        // verificando se foi feito algum upload de imagem
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = env('APP_NAME')."-".Helper::toTimestamp($acompanhe['date'], $acompanhe['time']).".".$image->getClientOriginalExtension();
            $name2 = env('APP_NAME')."-".Helper::toTimestamp($acompanhe['date'], $acompanhe['time']).".webp";
            $request->file('image')->move(public_path('upload/acompanhe/'), $name);

            // amarzena o caminho no banco
            $acompanhe['image'] = "public/upload/acompanhe/".$name2;

            // nome da foto para ser otimizada
            $data = array(
                'nome' => $name,
                'nome2' => $name2
            );

            $ch = curl_init();
            
            // localização da função para otimizar 
            curl_setopt($ch, CURLOPT_URL, env('IMG_OTIMIZE'));
            
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $resp = curl_exec($ch);
            curl_close($ch);
        }

        // redirecionando com mensagem de sucesso
        if ($acompanhe->save()) {
            return redirect('/adm/acompanhe/')->with('success', 'Seus dados foram editados com sucesso');
        }
    }

    // retorna a view de ordenação
    public function order()
    {
        $acompanhe = Acompanhe::where('datePost', '<', $this->today)->where('order', '=', null)->orderBy('id', 'desc')->paginate(15);
        
        if ($acompanhe->total() <= 0) {
            $acompanhe = Acompanhe::where('datePost', '<', $this->today)->orderBy('order', 'asc')->paginate(15);
        }
       
        return view('adm/acompanhe/acompanhe-order', array(
            'acompanhe' => $acompanhe,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));

    }

    // orderna os dados recebidos
    public function orderned(Request $request) 
    {
        $dados = explode(',',$request['cad_id_item']);
        $ordem = 1; 

        $erray = array();
        foreach($dados as $item) {
            $id = $item;
            $acompanhe = Acompanhe::find($id);
            $erray['array '.$ordem] = $acompanhe;
            $erray['order '.$ordem] = $ordem;
            $acompanhe['order'] = $ordem;
            $acompanhe->save();
            $ordem++;
        }
        return "Dados ordernados com sucesso!";
    }

    // buscando dados
    public function search(Request $request)
    {
        // criando uma variavel de busca
        $search = $request['busca'];

        // trazendo os dados que nao foram agendadas
        $new = Acompanhe::where('datePost', '<', $this->today)->where('order', '=', null)->orderBy('id', 'desc')->get()->first();
        if ($new === null) {
            $new = Acompanhe::where('datePost', '<', $this->today)->orderBy('order', 'asc')->get()->first();
        }
        // validando se os dados são nulos
        if ($new === null) {
            $acompanhe = Acompanhe::where('title', 'like', '%'.$search.'%')->orderBy('id', 'desc')->paginate(15);
        } else {
            // trazendo todos os post com excessao do dado new
            $acompanhe = Acompanhe::where('title', 'like', '%'.$search.'%')->where('id', '<>', $new['id'])->orderBy('id', 'desc')->paginate(14);
        }
        return view('adm/acompanhe/acompanhe-search', array(
            'acompanhe' => $acompanhe,
            'new' => $new,
            'notiNews' => $this->notiNews,
            'notiContato' => $this->notiContato,
        ));

    }

    // apagando dados e fotos solicitados
    public function destroy($id)
    {
        // listando caminhos das fotos
        $storage = Acompanhe::find($id);
        if ($storage['image'] != null) {
            unlink($storage['image']);
        }

        // apagando dados no bando e redirecionando 
        $acompanhe = Acompanhe::find($id)->delete();
        return redirect('/adm/acompanhe')->with('delete', 'Seus dados foram removidos com sucesso');
    }
}
