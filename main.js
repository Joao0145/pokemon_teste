$(document).ready(function() {
    
    // 1. Inicializa a DataTable (10 registros por página)
    var pokemonTable = $('#pokemonTable').DataTable({
        "paging": true,
        "pageLength": 10, 
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json"
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "types" },
            { 
                "data": "image_url",
                "render": function(data, type, row) {
                    if (data) {
                        return '<img src="' + data + '" class="pokemon-img" alt="' + row.name + '">';
                    }
                    return 'N/A';
                },
                "orderable": false 
            },
            // Opção de exclusão da linha da tabela [cite: 23]
            {
                "data": null,
                "defaultContent": '<button class="btn btn-danger btn-sm btn-excluir">Excluir</button>',
                "orderable": false
            }
        ]
    });

    let codeCount = 1;
    
    // Função auxiliar para o formulário
    function addInputField(count) {
        return `
            <div class="input-group mb-3" data-id-count="${count}">
                <span class="input-group-text">Código ${count}</span>
                <input type="text" class="form-control pokemon-id" name="id[]" placeholder="ID do Pokémon (ex: 25)" required>
                ${count > 1 ? '<button class="btn btn-outline-danger btn-remover-linha" type="button">X</button>' : ''}
            </div>
        `;
    }
    
    // Lógica do Modal e Botões
    $('#btn-abrir-modal').on('click', function() {
        $('#ids-container').html(addInputField(1));
        codeCount = 1;
        $('#insertModal').modal('show');
    });

    $('#btn-adicionar-linha').on('click', function() {
        codeCount++;
        $('#ids-container').append(addInputField(codeCount));
    });

    $('#ids-container').on('click', '.btn-remover-linha', function() {
        $(this).closest('.input-group').remove();
    });

    // 3. Submissão do Formulário via AJAX (Comunicação assíncrona [cite: 21])
    $('#form-pokemon-ids').on('submit', function(e) {
        e.preventDefault();
        
        let pokemonIDs = [];
        $('.pokemon-id').each(function() {
            let val = $(this).val().trim();
            if (val) {
                pokemonIDs.push(val);
            }
        });

        if (pokemonIDs.length === 0) {
            alert('Por favor, insira pelo menos um ID de Pokémon.');
            return;
        }
        
        $('#insertModal').modal('hide');
        $('#btn-salvar').prop('disabled', true).text('Processando...');
        
        // Requisição AJAX
        $.ajax({
            url: 'controller.php', 
            method: 'POST',
            data: { ids: pokemonIDs }, 
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    // Atualiza a tabela dinamicamente [cite: 26, 27]
                    pokemonTable.rows.add(response.data).draw(false); 
                    alert('Sucesso! ' + response.data.length + ' Pokémon(s) adicionados.');
                } else {
                    alert('Nenhum Pokémon válido encontrado. ' + (response.message || 'Verifique o ID.'));
                }
            },
            error: function(xhr, status, error) {
                console.error("Erro na requisição AJAX:", error);
                alert('Erro de comunicação com o servidor PHP. Verifique o console (F12) para detalhes.');
            },
            complete: function() {
                $('#btn-salvar').prop('disabled', false).text('Salvar');
            }
        });
    });

    // 4. Lógica de exclusão de linha
    $('#pokemonTable tbody').on('click', '.btn-excluir', function () {
        if(confirm("Tem certeza que deseja remover este Pokémon da lista?")) {
            pokemonTable.row($(this).parents('tr')).remove().draw();
        }
    });
});