<?php
// processar_respostas.php

// Receber as respostas do quiz em JSON
$data = json_decode(file_get_contents('php://input'), true);

// Inicializar as pontuações
$pontuacoes = [
    'visionario' => 0,
    'planejador' => 0,
    'pratico' => 0
];

// Contar as pontuações para cada tipo de perfil
foreach ($data as $pergunta => $resposta) {
    if (array_key_exists($resposta, $pontuacoes)) {
        $pontuacoes[$resposta]++;
    }
}

// Determinar o perfil baseado na pontuação
$perfil = '';
if ($pontuacoes['visionario'] > $pontuacoes['planejador'] && $pontuacoes['visionario'] > $pontuacoes['pratico']) {
    $perfil = 'Visionário';
} elseif ($pontuacoes['planejador'] > $pontuacoes['visionario'] && $pontuacoes['planejador'] > $pontuacoes['pratico']) {
    $perfil = 'Planejador';
} else {
    $perfil = 'Prático';
}

// Retornar os dados como JSON
echo json_encode([
    'perfil' => $perfil,
    'pontuacoes' => $pontuacoes
]);
?>
