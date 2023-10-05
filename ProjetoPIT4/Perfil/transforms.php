<?php

function transformaImagemRank($rank, $tipo)
{
    $prefixo = '';

    // Define o prefixo baseado no tipo de jogo
    if ($tipo === 'patente') {
        $prefixo = 'csgo_';
    } elseif ($tipo === 'elo') {
        $prefixo = 'lol_';
    }

    $imagens = array(
        'Ferro I' => 'ferro.png',
        'Ferro II' => 'ferro.png',
        'Ferro III' => 'ferro.png',
        'Ferro IV' => 'ferro.png',
        'Bronze I' => 'bronze.png',
        'Bronze II' => 'bronze.png',
        'Bronze III' => 'bronze.png',
        'Bronze IV' => 'bronze.png',
        'Prata I' => $prefixo . 'prata1.png',
        'Prata II' => $prefixo . 'prata2.png',
        'Prata III' => $prefixo . 'prata3.png',
        'Prata IV' => $prefixo . 'prata4.png',
        'Prata de Elite' => 'prataelite.png',
        'Prata de Elite Mestre' => 'prataelitem.png',
        'Ouro I' => $prefixo . 'ouro1.png',
        'Ouro II' => $prefixo . 'ouro2.png',
        'Ouro III' => $prefixo . 'ouro3.png',
        'Ouro IV' => 'ouro4.png',
        'Platina I' => 'platina.png',
        'Platina II' => 'platina.png',
        'Platina III' => 'platina.png',
        'Platina IV' => 'platina.png',
        'Mestre Guardião I' => 'ak1.png',
        'Mestre Guardião II' => 'ak2.png',
        'Mestre Guardião Elite' => 'akx.png',
        'Diamante I' => 'diamante.png',
        'Diamante II' => 'diamante.png',
        'Diamante III' => 'diamante.png',
        'Diamante IV' => 'diamante.png',
        'Mestre' => 'mestre.png',
        'Grão-Mestre' => 'gmestre.png',
        'Desafiante' => 'desafiante.png',
        'Distinto Mestre Guardião' => 'xerife.png',
        'Águia Lendaria I' => 'aguia.png',
        'Águia Lendaria II' => 'aguia2.png',
        'Mestre Supremo de Primeira Classe' => 'supremo.png',
        'Global Elite' => 'global.png'
    );

    if (array_key_exists($rank, $imagens)) {
        $nomeImagem = $imagens[$rank];
        $caminhoImagem = '../img/' . $tipo . '/' . $nomeImagem;
        return $caminhoImagem;
    }

    return '../img/nada.png';
}

function transformaRegiao($regiao)
{
    $regioes = array(
        'Brasil' => 'brasil.png',
        'América Latina do Sul' => 'las.png',
        'Argentina' => 'argentina.png',
        'Chile' => 'chile.png',
        'Bolivia' => 'bolivia.png',
        'Paraguai' => 'paraguai.png',
        'Venezuela' => 'venezuela.png'
    );

    if (array_key_exists($regiao, $regioes)) {
        $nomeImagem = $regioes[$regiao];
        $caminhoImagem = '../img/regiao/' . $nomeImagem;
        return $caminhoImagem;
    }

    return '../img/nada.png';
}

function transformaId($patente, $elo)
{
    if ($patente === '' || $patente === null) {
        return 'elo-label';
    } else if ($elo === '' || $elo === null) {
        return 'patente-label';
    } else {
        return 'patente-label';
    }
}
