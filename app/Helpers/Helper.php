<?php

namespace App\Helpers;

Class Helper
{

    // FUNÇÃO PARA RETORNAR DADOS CONSTANTES NO SITE
    public static function getItem($data)
    {
        $array = array(
            // Dados Gerais
            'APP_NAME' => 'NovaADM',
            'cliente' => '',
            'IMG_OTIMIZE' => 'http://localhost/public/upload/acompanhe/imgOptmize.php',
            'emailSend' => 'adm@engenhodeimagens.com.br',

            // whats number
            'link-whats1' => "https://api.whatsapp.com/send?phone=55",
            'whats1' => "",
            'link-whats2' => "https://api.whatsapp.com/send?phone=55",
            'whats2' => '',

            // telefones numner 
            'link-number1' => 'tel:+55',
            'number1' => '',
            'link-number2' => 'tel:+55',
            'number1' => '',

            // endereços
            'endereco1' => '',
            'linkEndereco1' => '',

            // social medias 
            'facebook' => '',
            'shareFacebook' => 'http://facebook.com/share.php?u=',
            'instagram' => '',
            'shareWhatsapp' => 'https://api.whatsapp.com/send?text=',
            'twitter' => '',
            'shareTwitter' => 'http://twitter.com/intent/tweet?text=&amp;url=',
            'youtube' => '',
            'email' => '',
            'shareEmail' => 'mailto:?body=',
        );

        if (isset($array[$data])){
            return $array[$data];
        }else {
           return "nada encontrado";
        }
    }

    // FUNÇÃO PARA MOSTRAR O MES EM STRING
    public static function showMonth($mes) 
    {
        $mes = (int)$mes;
        if($mes == 1){
            $mes = 'Janeiro';
        }else if($mes == 2){
            $mes = 'Fevereiro';
        }else if($mes == 3){
            $mes = 'Março';
        }else if($mes == 4){
            $mes = 'Abril';
        }else if($mes == 5){
            $mes = 'Maio';
        }else if($mes == 6){
            $mes = 'Junho';
        }else if($mes == 7){
            $mes = 'Julho';
        }else if($mes == 8){
            $mes = 'Agosto';
        }else if($mes == 9){
            $mes = 'Setembro';
        }else if($mes == 10){
            $mes = 'Outubro';
        }else if($mes == 11){
            $mes = 'Novembro';
        }else if($mes == 12){
            $mes = 'Dezembro';
        }

        return $mes;

    }

    // FUNÇÃO PARA FORMATAR URL PARA URL AMIGÁVEL
    public static function cleanUrl($string) 
    {
        $table = array(
            '/'=>'', '('=>'', ')'=>'',
        );
        // Traduz os caracteres em $string, baseado no vetor $table
        $string = strtr($string, $table);
        $string= preg_replace('/[,.;:`´^~\'"]/', null, iconv('UTF-8','ASCII//TRANSLIT',$string));
        $string= strtolower($string);
        $string= str_replace(" ", "-", $string);
        $string= str_replace("---", "-", $string);
        
        return $string;
    }

    // FUNÇÃO PARA TIRAR OS SEGUNDOS DA HORA
    public static function noSeg($time)
    {
        $time = explode(":", $time);
        list($hora, $min, $seg) = $time;

        return $hora.':'.$min;
    }

    // FUNÇÕES PARA EXIBIR TIPOS DIFERENTES DE DATAS
    public static function formatDate($data, $tipo)
    {

        $data = explode("/", $data);
        list($dia, $mes, $ano) = $data;
    
        
        if($tipo == 1){

            return $ano.'-'.$mes.'-'.$dia;

        }elseif($tipo == 2){

            return $dia.'-'.$mes.'-'.$ano;

        }elseif($tipo == 3){
    
            $mes = static::showMonth($mes);

            return $dia.' '.substr($mes, 0, 3).' '.$ano;
    
        }
        elseif($tipo == 4){
    
            $mes = static::showMonth($mes);
        
            return $dia.' '.$mes.' '.$ano;
    
        }
        elseif($tipo == 5){
    
            $mes = static::showMonth($mes);

            return $dia.' de '.$mes.' de '.$ano;
    
        }
    
    }

    // FUNÇÃO PARA LIMITAR QUANTIDADE DE CARACTERES NA PÁGINA //
    public static function limitString($string,$limit)
    {

        $count_string = strlen($string);
        $str = '';

        if($count_string < $limit){
        $str = $string;
        }else{

            for($index = 0; $index <= $limit; $index++){
        
                if($index == $limit){
                $str = $str.'...';
                }else{
                $str = $str.$string[$index];
                }

            }

        }

        return $str;

    }

    // FUNÇÃO PARA CONVERTER DATA E HORA PARA TIMESTAP
    public static function toTimestamp($date, $time) 
    {

        $dataForm = static::formatDate($date,1);
        
        return strtotime($dataForm. " ".$time);

    }

    // FUNÇÃO PARA EXIBIR O TEMPO CORRIDO
    public static function runningTime($dateTime) 
    {
        // data e hora atual
        $now = strtotime(date('Y/m/d H:i:s'));
        $time = strtotime($dateTime);
        $diff = $now - $time;

        // quebrando 
        $seconds = $diff;
        $minutes = round($diff / 60);
        $hours = round($diff / 3600);
        $days = round($diff / 86400);
        $weeks = round($diff / 604800);
        $months = round($diff / 2419200);
        $years = round($diff / 29030400);

        // exibindo a diferencia de tempo
        if ($seconds <= 60) return"1 min atrás";
        else if ($minutes <= 60) return $minutes==1 ?'1 min atrás':$minutes.' min atrás';
        else if ($hours <= 24) return $hours==1 ?'1 hrs atrás':$hours.' hrs atrás';
        else if ($days <= 7) return $days==1 ?'1 dia atras':$days.' dias atrás';
        else if ($weeks <= 4) return $weeks==1 ?'1 semana atrás':$weeks.' semanas atrás';
        else if ($months <= 12) return $months == 1 ?'1 mês atrás':$months.' meses atrás';
        else return $years == 1 ? 'um ano atrás':$years.' anos atrás';
    }

}