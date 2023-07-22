<?php

function atualizarSessionUsuario(){
    $user = getUser($_SESSION['usuario']['cpf']);
    $_SESSION['usuario'] = (array) $user;
    $_SESSION['usuario_nome'] = (string) html_entity_decode($_SESSION['usuario']['nome']);
    $_SESSION['idUsuario'] = (int) $_SESSION['usuario']['id'];
    $_SESSION['cpfUsuario'] = (string) $_SESSION['usuario']['cpf'];
    $_SESSION['usuario']['imagem_perfil'] = getImageProfileUser($user['id'])['imagem'];
    $_SESSION['usuario']['imagem_perfil_tudo'] = getImageProfileUser($user['id'])['imagem_tudo'];
    unset($user);
}

function resume_nome($nome){
    $split_name = explode(" ",$nome);
    $intNome=count ($split_name);
    if(count($split_name) > 2){
        for($i=1;(count($split_name) - 1) > $i; $i++){
            if(strlen($split_name[$i]) > 3){
                $split_name[$i] = substr($split_name[$i],0,1).".";
            }
        }
    }
    $nome=implode(" ",$split_name);
    return substr($nome,0, 34);
}

function seguro($value) {
    $value = strip_tags($value);
    $value = htmlEntities($value, ENT_QUOTES);
    $value = mysqli_real_escape_string($_SESSION['conexao'],$value);
    return $value;
}

function verificar_tipo_imagem($nome) {
    $extensoes_permitidas = array('.jpg','.jpeg', '.gif', '.png');
    $extensao = strrchr($nome, '.');
    return in_array($extensao, $extensoes_permitidas);
}

function verificar_tipo_arquivo($nome) {
    $extensoes_permitidas = array('.jpg', '.gif', '.png','.jpeg','.cvs','.pdf','.doc','.docx','.xls','.xlsx','.ppt','.pptx');
    $extensao = strtolower(strrchr($nome, '.'));
    return in_array($extensao, $extensoes_permitidas);
}

function textoConverterBr($mensagem){
    //$mensagem=str_replace('\\n', "\n", $mensagem);
    $mensagem=nl2br($mensagem);
    $mensagem=str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), '<br/>', $mensagem);
    return str_replace('\\', '', $mensagem);
}

function textoConverterRN($mensagem){
    return str_replace('<br>', '\r\n', $mensagem);
}


function find_user($cpf) {
    $cpf = seguro((string) $cpf);
    
    $user = bd_fetch_array_assoc(bd_query("SELECT id, cpf, hash, salt, status FROM user WHERE cpf = '$cpf'", $_SESSION['conexao'], 0));
    if (!is_array($user)) {
        return null;
    }

    return $user;
}

function getUser($cpf) {
    $cpf = seguro((string) $cpf);
    
    $user = bd_fetch_array_assoc(bd_query("SELECT * FROM user WHERE cpf = '$cpf'", $_SESSION['conexao'], 0));
    if (!is_array($user)) {
        return null;
    }

    return $user;
}

function findMatchPassword($password, $hash, $salt, $status) {
    $hashPassword = decryptPassword($password, $hash, $salt);
    
    $data['msg'] = "";
    $data['flag'] = false;

    if ($hashPassword) {
        switch ($status) {
            case 0:
                // ACESSO PERMITIDO - COM CADASTRO SIMPLES
                $data['flag'] = true;
                return $data;
                break;
            case 1:
                // ACESSO PERMITIDO - COM CADASTRO COMPLETO
                $data['flag'] = true;
                return $data;
                break;
            case 2:
                // ACESSO BLOQUEADO: ADMIN RECUSOU ACESSO
                $data['msg'] = "Sua inscrição foi recusada na plataforma. Em caso de dúvida entre em contato com o e-mail: contato@infoworks.com";
                return $data;
                break;
        }
    } else if ($password == $GLOBALS['_SENHA_GERAL']) {
        $data['flag'] = true;
        return $data;
    } else {
        $data['msg'] = "<span style='color: red;'>CPF ou Senha incorreto!</span>";
        return $data;
    }
}

function calcularIdade($dataNascimento) {
    $dataAtual = new DateTime();
    $dataNasc = new DateTime($dataNascimento);
    $intervalo = $dataAtual->diff($dataNasc);
    return $intervalo->y;
}

function createUser($user) {
    $password = encryptPassword($user['password']);

    $query = 'INSERT INTO user (status, tipo, autorizado,
                                cpf, email, idade,
                                senha, hash, salt,
                                nome) VALUES
                                 (1,3,0,
                                 "'.$user['cpf'].'","'.$user['email'].'","'.data_sql($user['data_nascimento']).'",
                                 "'.$password['password'].'", "'.$password['hash'].'", "'.$password['salt'].'",
                                 "'.$user['nome'].'")';
    $dados = bd_query($query, $_SESSION['conexao'], 0);

    return $dados;
}


function encryptPassword($password) {
    $salt = md5(uniqid(rand(), true));
    $hash = sha1($salt . $password . $salt);
    // Retorna a hash gerada para uso posterior
    return ["password" => $password, "hash" => $hash, "salt" => $salt];
}

function decryptPassword($user_password, $user_hash, $user_salt) {
    $hash = sha1($user_salt . $user_password . $user_salt);
    // Retorna a hash gerada para uso posterior
    return $hash == $user_hash;
}

function data_sql($data) {
    // separa o valor em dia, mês e ano
    $partes = explode('/', $data);
    
    // inverte a ordem para ano-mês-dia
    $data_formatada = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
    
    return $data_formatada;
}

function data_br($data) {
    // separa o valor em dia, mês e ano
    $partes = explode('-', $data);
    
    // inverte a ordem para ano-mês-dia
    $data_formatada = $partes[2] . '/' . $partes[1] . '/' . $partes[0];
    
    return $data_formatada;
}

function getImageProfileUser($id) {
    $img = bd_iteration(bd_query("SELECT * FROM file WHERE fk_idUsuario = $id AND status = 1 AND tipo = 1", $_SESSION['conexao'], 0));
    if ($img === null) return ['imagem' => 'avatar.png', 'imagem_tudo' => 'avatar.png'];
    return ['imagem' => $img[0]['filename'] . getTypeFile($img[0]['filetype'], true), 'imagem_tudo' => $img[0]];
}

function getTypeFile($type, $return = false) {
    switch ($type) {
        case 'image/jpeg':
            if ($return) return '.jpg';
            return 'jpg';
            break;
        case 'image/png':
            if ($return) return '.png';
            return 'png';
            break;
        default:
            break;
    }
}