<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Acompanhe;
use Helper;

class AcompanheController extends Controller
{
    public function __construct() {

        date_default_timezone_set('America/Sao_Paulo');
        $this->today = strtotime('now');
    }

    public function index() {
    
        $post = Acompanhe::where('datePost', '<=', $this->today)->where('order', '=', null)->orderBy('id', 'desc')->get()->first();
        if ($post === null) {
            $post = Acompanhe::where('datePost', '<=', $this->today)->where('order', '<>', 'null')->orderBy('order', 'asc')->get()->first(); 
        }

        if ($post === null) {
            $links = null;
        } else {
            $links = Acompanhe::where('datePost', '<=', $this->today)->where('id', '<>', $post['id'])->where('order', '=', null)->orderBy('id', 'desc')->get()->all();
            if($links === null) {
                $links = Acompanhe::where('datePost', '<=', $this->today)->where('id', '<>', $post['id'])->where('order', '<>', null)->orderBy('order', 'asc')->get()->all();
            }
        }
        dd($post);

        return view('pages/acompanhe/acompanhe', array(
            'post' => $post,
            'links' => $links
        ));

    }

    public function show($url) {
        
        $post = Acompanhe::where('url', 'like', '%'.$url.'%')->get()->first();
        dd($post);
        if ($post === null) {
            $links = null;
        } else {
            $links = Acompanhe::where('datePost', '<=', $this->today)->where('id', '<>', $post['id'])->where('order', '=', null)->orderBy('id', 'desc')->get()->all();
            if($links === null) {
                $links = Acompanhe::where('datePost', '<=', $this->today)->where('id', '<>', $post['id'])->where('order', '<>', null)->orderBy('order', 'asc')->get()->all();
            }
        }
        
        return view('pages/acompanhe/acompanhe', array(
            'links' => $links,
            'post' => $post
        ));

    }
}
