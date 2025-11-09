<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste Técnico Pokémon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        .container { margin-top: 30px; }
        .pokemon-img { width: 60px; height: 60px; object-fit: contain; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Lista de Pokémons</h1>
        
        <button id="btn-abrir-modal" class="btn btn-primary mb-3 shadow-sm">
            <span class="fs-4 me-2">+</span> Inserir ID(s) de Pokémon
        </button>

        <table id="pokemonTable" class="display table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo(s)</th>
                    <th>Foto</th>
                    <th>Ação</th> 
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertModalLabel">Inserir código(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-pokemon-ids">
                    <div class="modal-body">
                        <div id="ids-container">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="btn-adicionar-linha">Adicionar nova linha</button>
                        <button type="submit" class="btn btn-success" id="btn-salvar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="main.js"></script>
</body>
</html>