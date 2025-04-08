<?php
include '../config.php';
include '../auth/session.php';

requireLogin();

// Obter lista de livros para o select
$sql_livros = "SELECT * FROM Livro ORDER BY Titulo";
$result_livros = $conn->query($sql_livros);

// Obter lista de leitores para o select
$sql_leitores = "SELECT * FROM Leitor ORDER BY Ultimo_nome, Primeiro_nome";
$result_leitores = $conn->query($sql_leitores);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emprestimo_id = $_POST['emprestimo_id'];
    $livro_id = $_POST['livro_id'];
    $leitor_id = $_POST['leitor_id'];
    $data_emp = $_POST['data_emp'];
    $data_vencimento = $_POST['data_vencimento'];
    $date_entrega = $_POST['date_entrega'] ?: NULL;

    // Verificar se a nova atribuição de livro está disponível (se estiver mudando o livro)
    $sql_current = "SELECT Livro_ID FROM Emprestimo WHERE Emprestimo_ID = $emprestimo_id";
    $result_current = $conn->query($sql_current);
    $current_loan = $result_current->fetch_assoc();

    $can_update = true;

    if ($current_loan['Livro_ID'] != $livro_id) {
        // Verificar se o novo livro já está emprestado
        $sql_check = "SELECT * FROM Emprestimo WHERE Livro_ID = $livro_id AND Date_Entrega IS NULL AND Emprestimo_ID != $emprestimo_id";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            $error = "Este livro já está emprestado e ainda não foi devolvido.";
            $can_update = false;
        }
    }

    if ($can_update) {
        $sql = "UPDATE Emprestimo SET 
                Livro_ID = $livro_id, 
                Leitor_ID = $leitor_id, 
                Data_Emp = '$data_emp', 
                Data_Vencimento = '$data_vencimento',
                Date_Entrega = " . ($date_entrega ? "'$date_entrega'" : "NULL") . "
                WHERE Emprestimo_ID = $emprestimo_id";

        if ($conn->query($sql) === TRUE) {
            header('Location: list_loans.php');
            exit;
        } else {
            $error = "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    $emprestimo_id = $_GET['id'];
    $sql = "SELECT * FROM Emprestimo WHERE Emprestimo_ID = $emprestimo_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $emprestimo = $result->fetch_assoc();
    } else {
        header('Location: list_loans.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empréstimo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Editar Empréstimo</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="emprestimo_id" value="<?php echo $emprestimo['Emprestimo_ID']; ?>">
                    <div class="mb-3">
                        <label for="livro_id" class="form-label">Livro:</label>
                        <select class="form-control" name="livro_id" required>
                            <?php
                            // Reset the result pointer
                            $result_livros->data_seek(0);
                            while ($livro = $result_livros->fetch_assoc()):
                            ?>
                                <option value="<?php echo $livro['LIVRO_ID']; ?>" <?php echo ($livro['LIVRO_ID'] == $emprestimo['Livro_ID']) ? 'selected' : ''; ?>>
                                    <?php echo $livro['Titulo'] . ' (ISBN: ' . $livro['ISBN'] . ')'; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="leitor_id" class="form-label">Leitor:</label>
                        <select class="form-control" name="leitor_id" required>
                            <?php
                            // Reset the result pointer
                            $result_leitores->data_seek(0);
                            while ($leitor = $result_leitores->fetch_assoc()):
                            ?>
                                <option value="<?php echo $leitor['Leitor_ID']; ?>" <?php echo ($leitor['Leitor_ID'] == $emprestimo['Leitor_ID']) ? 'selected' : ''; ?>>
                                    <?php echo $leitor['Primeiro_nome'] . ' ' . $leitor['Ultimo_nome'] . ' (' . $leitor['Email'] . ')'; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="data_emp" class="form-label">Data de Empréstimo:</label>
                        <input type="date" class="form-control" name="data_emp" value="<?php echo $emprestimo['Data_Emp']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_vencimento" class="form-label">Data de Vencimento:</label>
                        <input type="date" class="form-control" name="data_vencimento" value="<?php echo $emprestimo['Data_Vencimento']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_entrega" class="form-label">Data de Entrega:</label>
                        <input type="date" class="form-control" name="date_entrega" value="<?php echo $emprestimo['Date_Entrega']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="list_loans.php" class="btn btn-secondary">Voltar</a>
                </form>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>

<?php
$conn->close();
?>