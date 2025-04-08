<?php
include '../../config.php';
include '../../auth/session.php';

requireLogin();

$livro_id = $_GET['livro'] ?? 0;
$leitor_id = $_SESSION['leitor_id'];
$success = false;
$error = null;

// Verificar se o livro existe
$sql_livro = "SELECT * FROM Livro WHERE LIVRO_ID = $livro_id";
$result_livro = $conn->query($sql_livro);

if ($result_livro->num_rows == 0) {
    $error = "Livro não encontrado.";
} else {
    $livro = $result_livro->fetch_assoc();

    // Verificar se o livro já está emprestado
    $sql_check = "SELECT * FROM Emprestimo WHERE Livro_ID = $livro_id AND Date_Entrega IS NULL";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $error = "Este livro já está emprestado e ainda não foi devolvido.";
    } else {
        // Verificar se o usuário já tem muitos empréstimos ativos (limite de 5, por exemplo)
        $sql_count = "SELECT COUNT(*) as total FROM Emprestimo WHERE Leitor_ID = $leitor_id AND Date_Entrega IS NULL";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();

        if ($row_count['total'] >= 5) {
            $error = "Você já atingiu o limite máximo de empréstimos ativos (5).";
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Processar a solicitação de empréstimo
            $data_hoje = date('Y-m-d');
            $data_vencimento = date('Y-m-d', strtotime('+15 days')); // 15 dias para devolução

            $sql_insert = "INSERT INTO Emprestimo (Livro_ID, Leitor_ID, Data_Emp, Data_Vencimento) 
                          VALUES ($livro_id, $leitor_id, '$data_hoje', '$data_vencimento')";

            if ($conn->query($sql_insert) === TRUE) {
                $success = true;
            } else {
                $error = "Erro ao processar o empréstimo: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Empréstimo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Solicitar Empréstimo</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                <h4>Empréstimo realizado com sucesso!</h4>
                                <p>O livro "<?php echo $livro['Titulo']; ?>" foi emprestado para você.</p>
                                <p>Data de devolução: <?php echo date('d/m/Y', strtotime('+15 days')); ?></p>
                                <div class="mt-3">
                                    <a href="../livros.php" class="btn btn-primary">Voltar para Catálogo</a>
                                    <a href="historico.php" class="btn btn-secondary">Ver Meus Empréstimos</a>
                                </div>
                            </div>
                        <?php elseif ($error): ?>
                            <div class="alert alert-danger">
                                <h4>Não foi possível realizar o empréstimo</h4>
                                <p><?php echo $error; ?></p>
                                <div class="mt-3">
                                    <a href="../livros.php" class="btn btn-primary">Voltar para Catálogo</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Detalhes do Livro</h4>
                                    <p><strong>Título:</strong> <?php echo $livro['Titulo']; ?></p>
                                    <p><strong>ISBN:</strong> <?php echo $livro['ISBN']; ?></p>
                                    <p><strong>Gênero:</strong> <?php echo $livro['Genero'] ?: 'Não especificado'; ?></p>
                                    <p><strong>Ano:</strong> <?php echo $livro['Ano_Publicacao'] ?: 'Não especificado'; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h4>Termos do Empréstimo</h4>
                                    <p><strong>Data de Empréstimo:</strong> <?php echo date('d/m/Y'); ?></p>
                                    <p><strong>Data de Devolução:</strong> <?php echo date('d/m/Y', strtotime('+15 days')); ?></p>
                                    <p><strong>Leitor:</strong> <?php echo $_SESSION['nome']; ?></p>
                                </div>
                            </div>

                            <form method="POST" action="" class="mt-4">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="concordo" name="concordo" required>
                                    <label class="form-check-label" for="concordo">
                                        Concordo com os termos de empréstimo e me comprometo a devolver o livro até a data estipulada.
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Confirmar Empréstimo</button>
                                <a href="../livros.php" class="btn btn-secondary">Cancelar</a>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>

<?php
$conn->close();
?>