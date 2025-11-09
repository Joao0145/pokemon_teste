<?php
// Define que a resposta será JSON, necessário para o AJAX
header('Content-Type: application/json');

$response = ['success' => false, 'data' => [], 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids'])) {
    $pokemon_ids = $_POST['ids'];
    $data_to_return = [];

    $valid_ids = array_filter($pokemon_ids, function($id) {
        return is_numeric($id) && $id > 0;
    });

    if (empty($valid_ids)) {
        $response['message'] = 'Nenhum ID válido foi fornecido.';
        echo json_encode($response);
        exit;
    }

    // Loop para buscar cada Pokémon [cite: 25]
    foreach ($valid_ids as $id) {
        $api_url = "https://pokeapi.co/api/v2/pokemon/{$id}";

        // --- CORREÇÃO: Usando file_get_contents para evitar problemas de cURL desabilitado ---
        // O '@' serve para suprimir erros que seriam exibidos na tela
        $json_response = @file_get_contents($api_url); 

        // Se a busca falhar ou o Pokémon não existir
        if ($json_response === FALSE) {
            $data_to_return[] = [
                'id' => $id,
                'name' => 'ID Não Encontrado',
                'types' => 'Erro na API',
                'image_url' => ''
            ];
            continue;
        }

        $pokemon_data = json_decode($json_response, true);

        // Extração e Formatação dos Tipos [cite: 32]
        $types_array = [];
        if (isset($pokemon_data['types'])) {
            foreach ($pokemon_data['types'] as $type_info) {
                $types_array[] = ucfirst($type_info['type']['name']);
            }
        }
        $types_string = implode(', ', $types_array); 

        // Estrutura de dados FINAL (ID, Nome, Tipos, Imagem [cite: 30, 31, 32, 33])
        $data_to_return[] = [
            'id' => $pokemon_data['id'] ?? $id,
            'name' => ucfirst($pokemon_data['name']) ?? 'Desconhecido',
            'types' => $types_string,
            'image_url' => $pokemon_data['sprites']['front_default'] ?? ''
        ];
    }

    $response['success'] = true;
    $response['data'] = $data_to_return;
} else {
    $response['message'] = 'Requisição inválida ou dados ausentes.';
}

echo json_encode($response);
?>