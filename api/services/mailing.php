<?php 

function descadastrar_email(){
    
    $body = body(['email', 'hash', 'motivos']);

    $hashc = hash('sha256', $body['email'].config('salt'));
    
    if($hashc != $body['hash'])
        response("Erro de validação", 500);
    
    $email = $body['email'];
    $hash = $body['hash'];
    
    $q = _query("SELECT loc_id FROM mailing WHERE email LIKE '$email' AND hash_id = '$hash' AND ativo = 1");
    
    if($q->rowCount()==0)
        response("Email não existe ou não está mais ativo", 500);

    $loc_id = $q -> fetchAssoc()['loc_id'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://emailmarketing.locaweb.com.br/api/v1/accounts/".config("accid")."/contacts/".$loc_id);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = [
        'Content-Type: application/json',
        'X-Auth-Token: '.config("acckey")
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_exec ($ch);
    // $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);

    try {
        _exec("UPDATE mailing SET ativo = 0 WHERE hash_id = '$hash'");
        $insert = "INSERT INTO motivos (text) VALUES ";
        foreach ($body['motivos'] as $value)
            $insert .= "('$value'),";
        $insert = substr($insert, 0, -1);
        _exec($insert);
    } catch(\Exception $e) {
        response("Erro ao tentar descadastrar usuário - 2", 500);
    }
    

}