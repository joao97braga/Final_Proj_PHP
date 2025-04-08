<?php
include '../../config.php';
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['leitor_id'])) {
    header('Location: ../../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM Leitor WHERE Email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Em um cenário real, você usaria password_verify() com senhas hasheadas
        // Esta é uma versão simplificada
        if ($password == $row['Password']) { // Assumindo que existe um campo Password na tabela Leitor
            $_SESSION['leitor_id'] = $row['Leitor_ID'];
            $_SESSION['nome'] = $row['Primeiro_nome'] . ' ' . $row['Ultimo_nome'];
            $_SESSION['email'] = $row['Email'];
            
            header('Location: ../../index.php');
            exit;
        } else {
            $error = "Password incorreta!";
        }
    } else {
        $error = "Email não encontrado!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Biblioteca</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        
                        <div class="mt-3">
                            <p>Não tem uma conta? <a href="register.php">Registre-se aqui</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../../includes/footer.php'; ?>
</body>
</html>