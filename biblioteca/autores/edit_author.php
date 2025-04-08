<?php
include '../config.php';
include '../auth/session.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $autor_id = $_POST['autor_id'];
    $primeiro_nome = $_POST['primeiro_nome'];
    $ultimo_nome = $_POST['ultimo_nome'];
    $data_aniversario = $_POST['data_aniversario'] ?: NULL;

    $sql = "UPDATE Autor SET 
            Primeiro_Nome = '$primeiro_nome', 
            Ultimo_Nome = '$ultimo_nome', 
            Data_Aniversario = " . ($data_aniversario ? "'$data_aniversario'" : "NULL") . "
            WHERE Autor_ID = $autor_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: list_authors.php');
        exit;
    } else {
        $error = "Erro: " . $sql . "<br>" . $conn->error;
    }
} else {
    $autor_id = $_GET['id'];
    $sql = "SELECT * FROM Autor WHERE Autor_ID = $autor_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $autor = $result->fetch_assoc();
    } else {
        header('Location: list_authors.php');
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Autor</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Editar Autor</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <input type="hidden" name="autor_id" value="<?php echo $autor['Autor_ID']; ?>">
                    <div class="mb-3">
                        <label for="primeiro_nome" class="form-label">Primeiro Nome:</label>
                        <input type="text" class="form-control" name="primeiro_nome" value="<?php echo $autor['Primeiro_Nome']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ultimo_nome" class="form-label">Último Nome:</label>
                        <input type="text" class="form-control" name="ultimo_nome" value="<?php echo $autor['Ultimo_Nome']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_aniversario" class="form-label">Data de Aniversário:</label>
                        <input type="date" class="form-control" name="data_aniversario" value="<?php echo $autor['Data_Aniversario']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="list_authors.php" class="btn btn-secondary">Voltar</a>
                </form>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>