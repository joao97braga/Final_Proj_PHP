<?php
include '../../config.php';
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['leitor_id'])) {
    header('Location: ../../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $primeiro_nome = $_POST['primeiro_nome'];
    $ultimo_nome = $_POST['ultimo_nome'];
    $data_aniversario = $_POST['data_aniversario'] ?: NULL;
    $morada = $_POST['morada'];
    $telemovel = $_POST['telemovel'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Em um cenário real, isso seria hasheado com password_hash()
    
    // Verificar se o email já existe
    $sql_check = "SELECT * FROM Leitor WHERE Email = '$email'";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        $error = "Este email já está em uso. Por favor, escolha outro.";
    } else {
        // Incluir a senha na inserção (em um cenário real, use password_hash())
        $sql = "INSERT INTO Leitor (Primeiro_nome, Ultimo_nome, Data_Aniversario, Morada, Telemovel, Email, Password) 
                VALUES ('$primeiro_nome', '$ultimo_nome', " . ($data_aniversario ? "'$data_aniversario'" : "NULL") . ", 
                '$morada', '$telemovel', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Obter o ID do leitor recém-criado
            $leitor_id = $conn->insert_id;
            
            // Fazer login automático
            $_SESSION['leitor_id'] = $leitor_id;
            $_SESSION['nome'] = $primeiro_nome . ' ' . $ultimo_nome;
            $_SESSION['email'] = $email;
            
            header('Location: ../../index.php');
            exit;
        } else {
            $error = "Erro ao registrar: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro - Biblioteca</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
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
                        <h3>Criar Conta</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="primeiro_nome" class="form-label">Primeiro Nome:</label>
                                    <input type="text" class="form-control" name="primeiro_nome" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ultimo_nome" class="form-label">Último Nome:</label>
                                    <input type="text" class="form-control" name="ultimo_nome" required>
                                </div>
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
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </form>
                        
                        <div class="mt-3">
                            <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../../includes/footer.php'; ?>
</body>
</html>