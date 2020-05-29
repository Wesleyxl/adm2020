<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use App\Contato;

class ContatoController extends Controller
{
    public function __construct() {

        date_default_timezone_set("America/Sao_Paulo");
        $this->today = strtotime("now");

    }

    public function index() {
        return view('pages/contato/contato');
    }

    public function sucesso() {
        return view('pages/contato/sucesso');
    }

    public function submit(Request $requext) {

        $validator = Validator::make($request->all(), [
           'nome' => 'required|string' 
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInputs();
        }

        return redirect('/contato/sucesso');
    }
}
