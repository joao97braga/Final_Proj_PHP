<?php
include '../config.php';
include '../auth/session.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $primeiro_nome = $_POST['primeiro_nome'];
    $ultimo_nome = $_POST['ultimo_nome'];
    $data_aniversario = $_POST['data_aniversario'] ?: NULL;
    $morada = $_POST['morada'];
    $telemovel = $_POST['telemovel'];
    $email = $_POST['email'];
    
    $sql = "INSERT INTO Leitor (Primeiro_nome, Ultimo_nome, Data_Aniversario, Morada, Telemovel, Email) 
            VALUES ('$primeiro_nome', '$ultimo_nome', " . ($data_aniversario ? "'$data_aniversario'" : "NULL") . ", 
            '$morada', '$telemovel', '$email')";

    if ($conn->query($sql) === TRUE) {
        header('Location: list_readers.php');
        exit;
    } else {
        $error = "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Leitor</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Adicionar Leitor</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="primeiro_nome" class="form-label">Primeiro Nome:</label>
                        <input type="text" class="form-control" name="primeiro_nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="ultimo_nome" class="form-label">Último Nome:</label>
                        <input type="text" class="form-control" name="ultimo_nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_aniversario" class="form-label">Data de Aniversário:</label>
                        <input type="date" class="form-control" name="data_aniversario">
                    </div>
                    <div class="mb-3">
                        <label for="morada" class="form-label">Morada:</label>
                        <input type="text" class="form-control" name="morada">
                    </div>
                    <div class="mb-3">
                        <label for="telemovel" class="form-label">Telemóvel:</label>
                        <input type="text" class="form-control" name="telemovel">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                    <a href="list_readers.php" class="btn btn-secondary">Voltar</a>
                </form>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>