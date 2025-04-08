<?php
include '../config.php';
include '../auth/session.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leitor_id = $_POST['leitor_id'];
    $primeiro_nome = $_POST['primeiro_nome'];
    $ultimo_nome = $_POST['ultimo_nome'];
    $data_aniversario = $_POST['data_aniversario'] ?: NULL;
    $morada = $_POST['morada'];
    $telemovel = $_POST['telemovel'];
    $email = $_POST['email'];

    $sql = "UPDATE Leitor SET 
            Primeiro_nome = '$primeiro_nome', 
            Ultimo_nome = '$ultimo_nome', 
            Data_Aniversario = " . ($data_aniversario ? "'$data_aniversario'" : "NULL") . ",
            Morada = '$morada',
            Telemovel = '$telemovel',
            Email = '$email'
            WHERE Leitor_ID = $leitor_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: list_readers.php');
        exit;
    } else {
        $error = "Erro: " . $sql . "<br>" . $conn->error;
    }
} else {
    $leitor_id = $_GET['id'];
    $sql = "SELECT * FROM Leitor WHERE Leitor_ID = $leitor_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $leitor = $result->fetch_assoc();
    } else {
        header('Location: list_readers.php');
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Leitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Editar Leitor</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="leitor_id" value="<?php echo $leitor['Leitor_ID']; ?>">
                    <div class="mb-3">
                        <label for="primeiro_nome" class="form-label">Primeiro Nome:</label>
                        <input type="text" class="form-control" name="primeiro_nome" value="<?php echo $leitor['Primeiro_nome']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ultimo_nome" class="form-label">Último Nome:</label>
                        <input type="text" class="form-control" name="ultimo_nome" value="<?php echo $leitor['Ultimo_nome']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_aniversario" class="form-label">Data de Aniversário:</label>
                        <input type="date" class="form-control" name="data_aniversario" value="<?php echo $leitor['Data_Aniversario']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="morada" class="form-label">Morada:</label>
                        <input type="text" class="form-control" name="morada" value="<?php echo $leitor['Morada']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telemovel" class="form-label">Telemóvel:</label>
                        <input type="text" class="form-control" name="telemovel" value="<?php echo $leitor['Telemovel']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $leitor['Email']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="list_readers.php" class="btn btn-secondary">Voltar</a>
                </form>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>