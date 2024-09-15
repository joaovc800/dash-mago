<?php

require_once realpath(dirname(__DIR__, 1) . '/models/User.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

header('Content-Type: application/json');

$json = json_decode(file_get_contents('php://input'), true);

if(!isset($json['email']) || empty($json['email'])){
    Response::fail([], 'E-mail não informado.');
}

$result = DB::statement("SELECT * FROM magoautomation where email_login = '{$json['email']}'");

if($result['statement']){

    if(count($result['fetch']) > 0){
        $user = new User([
            "email" => $result['fetch'][0]['email_login'],
            "passwordhash" => $result['fetch'][0]['senha_login']
        ]);
    
        $informations = $user->getDetails();
    
        if(!$informations['active']){
            Response::fail([], 'Parece que sua assinatura não está ativa, renove para continuar usando os benefícios');
        }
    
        $maturity = new DateTime(datetime: $informations['maturity']);
        $current = new DateTime(date('Y-m-d')); 
    
        if($current > $maturity){
            Response::fail([], 'Parece que sua assinatura não está ativa, renove para continuar usando os benefícios');
        }
        
        $map = [
            'chip' => 'ficha',
            'gale' => 'gale',
            'initialBankroll' => 'banca_inicial',
            'currentBankroll' => 'banca_atual',
            'stoploss' => 'stoplos',
            'stopwin' => 'stopwin',
            'status' => 'status',
            'operations' => 'noperacoes'
        ];
        
        $collection = [];
        
        foreach ($map as $key => $column) {
            if (isset($json[$key])) {
                // Remove o prefixo "R$ " e converte para número decimal, se necessário
                if (strpos($json[$key], 'R$') === 0) {
                    $value = str_replace(['R$ ', '.'], ['', ','], $json[$key]);
                    $value = str_replace(',', '.', $value);
                    $value = str_replace('.', '', $value);
                } else {
                    $value = $json[$key];
                }
                
                $collection[$column] = $value;
            }
        }
        
        
        $update = $user->updateInformations($collection, $result['fetch'][0]['id']);
        
        if($update['statement']){
            Response::success($collection, 'Dados atualizados com sucesso!');
        }

    }else{
        Response::fail([], 'Usuário não encontrado');
    }
}

Response::fail([], 'Ocorreu um erro interno, por favor entre em contato com o administrador');