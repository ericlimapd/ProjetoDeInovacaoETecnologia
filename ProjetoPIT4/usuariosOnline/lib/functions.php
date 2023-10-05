<?php 
function getIp(){
    return $_SERVER['REMOTE_ADDR'];
}

function getTime(){
    date_default_timezone_set('America/Sao_Paulo');
    return time() + (60 * 10);
}

function VerificaIpOnline($con){
    $ip = getIp();

    $sql = $con->prepare("SELECT * FROM usuarios_online WHERE ip = ?");
    $sql->bind_param("s", $ip);
    $sql->execute();

    return $sql->get_result()->num_rows;
}

function DeletaLinhas($con){
 $tempo = getTime() - (60 * 20);
 $sql = $con->prepare("DELETE FROM usuarios_online WHERE tempo < ?");
 $sql->bind_param("s", $tempo);
 $sql->execute();
}

function GravaIpOnline($con){
    DeletaLinhas($con);
    $ip = getIp();
    $tempo = getTime();

    if(VerificaIpOnline($con) <= 0){
        if(!$_SESSION['userLogin']){
            $sql = $con->prepare("INSERT INTO usuarios_online (tempo, ip) VALUES (?, ?);");
            $sql->bind_param("ss", $tempo, $ip);
            $sql->execute();
        }else if (!$_SESSION['userLogin']){
            $query = $con->prepare("INSERT INTO usuarios_online (tempo, ip) VALUES (?, ?);");
            $query->bind_param("ss", $tempo, $ip);
            $query->execute();
        }
    }else{
        if(!$_SESSION['userLogin']){
            $sql = $con->prepare("UPDATE usuarios_online SET tempo");
            $sql->bind_param("sss", $tempo, $ip, $ip);
            $sql->execute();
        }else if($_SESSION['userLogin']){
            $sql = $con->prepare("UPDATE usuarios_online SET tempo");
            $sql->bind_param("ssss", $tempo, $ip, $_SESSION['userLogin'], $ip);
            $sql->execute();
        }
    }
}

function pega_totalUsuariosOnline($con){
    $sql = $con->prepare("SELECT * FROM usuarios_online WHERE sessao IS NOT NULL");
    $sql->execute();
    return $sql->get_result()->num_rows;
}

function pega_totalVisitantesOnline($con){
    $sql = $con->prepare("SELECT * FROM usuarios_online WHERE sessao NULL");
    $sql->execute();
    return $sql->get_result()->num_rows;
}

echo GravaIpOnline($con);

date_default_timezone_set('America/Sao_Paulo');
echo $tempo = getTime() - (60 * 20);
echo "<br>Agora: ".date('d/m/Y H:i:s');
echo "<br>10 Minutos atrás: ".date('d/m/Y H:i:s', $tempo);

echo "<br>Total de usuários online: ".pega_totalVisitantesOnline($con);
echo "<br>Total de Visitantes online: ".pega_totalVisitantesOnline($con);


?>