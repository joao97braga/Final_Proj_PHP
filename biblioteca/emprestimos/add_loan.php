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
    $livro_id = $_POST['livro_id'];
    $leitor_id = $_POST['leitor_id'];
    $data_emp = $_POST['data_emp'];
    $data_vencimento = $_POST['data_vencimento'];
    
    // Verificar se o livro já está emprestado
    $sql_check = "SELECT * FROM Emprestimo WHERE Livro_ID = $livro_id AND Date_Entrega IS NULL";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        $error = "Este livro já está emprestado e ainda não foi devolvido.";
    } else {
        $sql = "INSERT INTO Emprestimo (Livro_ID, Leitor_ID, Data_Emp, Data_Vencimento) 
                VALUES ($livro_id, $leitor_id, '$data_emp', '$data_vencimento')";

        if ($conn->query($sql) === TRUE) {
            header('Location: list_loans.php');
            exit;
        } else {
            $error = "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Empréstimo</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Adicionar Empréstimo</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="livro_id" class="form-label">Livro:</label>
                        <select class="form-control" name="livro_id" required>
                            <option value="">Selecione um livro</option>
                            <?php while ($livro = $result_livros->fetch_assoc()): ?>
                                <option value="<?php echo $livro['LIVRO_ID']; ?>"><?php echo $livro['Titulo'] . ' (ISBN: ' . $livro['ISBN'] . ')'; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="leitor_id" class="form-label">Leitor:</label>
                        <select class="form-control" name="leitor_id" required>
                            <option value="">Selecione um leitor</option>
                            <?php while ($leitor = $result_leitores->fetch_assoc()): ?>
                                <option value="<?php echo $leitor['Leitor_ID']; ?>"><?php echo $leitor['Primeiro_nome'] . ' ' . $leitor['Ultimo_nome'] . ' (' . $leitor['Email'] . ')'; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="data_emp" class="form-label">Data de Empréstimo:</label>
                        <input type="date" class="form-control" name="data_emp" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_vencimento" class="form-label">Data de Vencimento:</label>
                        <input type="date" class="form-control" name="data_vencimento" value="<?php echo date('Y-m-d', strtotime('+15 days')); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
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