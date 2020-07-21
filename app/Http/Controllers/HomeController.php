<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use App\News;
use App\Acompanhe;

class HomeController extends Controller
{

    public function __construct() {
    
        date_default_timezone_set("America/Sao_Paulo");
        $this->today = strtotime("now");

    }

    public function index()
    {
        $atual =  Acompanhe::where('datePost', '<=', $this->today)->where('order', '=', null)->orderBy('id', 'desc')->get()->first();
        if ($atual === null) {
            $atual = Acompanhe::where('datePost', '<=', $this->today)->orderBy('order', 'asc')->get()->first();
        }
        
        return view("pages/home/home", array(
            'atula' => $atual
        ));
    }

    public function sucesso() {

        $atual =  Acompanhe::where('datePost', '<=', $this->today)->where('order', '=', null)->orderBy('id', 'desc')->get()->first();
        if ($atual === null) {
            $atual = Acompanhe::where('datePost', '<=', $this->today)->orderBy('order', 'asc')->get()->first();
        }

        return view("pages/home/sucesso", array(
            'atual' => $atual
        ));

    }

    public function submit(Request $request) {

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'whatsapp' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInputs();
        }
 
        $news = new News();
        $news['title'] = $request->input('nome');
        $news['telephone'] = $request->input('whatsapp');

        if ($news->save()) {
            return redirect('/sucesso');
        }

    }
}
