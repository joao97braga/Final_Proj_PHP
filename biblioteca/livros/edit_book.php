<?php
include '../config.php';
include '../auth/session.php';

requireLogin();

// Get author list for association
$sql_autores = "SELECT * FROM Autor ORDER BY Ultimo_Nome, Primeiro_Nome";
$result_autores = $conn->query($sql_autores);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $livro_id = $_POST['livro_id'];
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $isbn = $_POST['isbn'];
    
    // Validate ISBN format
    if (!preg_match('/^[0-9-]{10,17}$/', $isbn)) {
        $error = "ISBN inválido. Por favor, verifique o formato.";
    } else {
        $sql = "UPDATE Livro SET 
                Titulo = '$titulo', 
                Genero = '$genero', 
                Ano_Publicacao = " . ($ano_publicacao ? "$ano_publicacao" : "NULL") . ", 
                ISBN = '$isbn' 
                WHERE LIVRO_ID = $livro_id";

        if ($conn->query($sql) === TRUE) {
            // Handle author associations if submitted
            if (isset($_POST['autores'])) {
                // First remove all existing associations
                $sql_delete = "DELETE FROM Livro_Autor WHERE Livro_ID = $livro_id";
                $conn->query($sql_delete);
                
                // Then add the new ones
                foreach ($_POST['autores'] as $autor_id) {
                    $sql_insert = "INSERT INTO Livro_Autor (Livro_ID, Autor_ID) VALUES ($livro_id, $autor_id)";
                    $conn->query($sql_insert);
                }
            }
            
            $_SESSION['success'] = "Livro atualizado com sucesso!";
            header('Location: list_books.php');
            exit;
        } else {
            $error = "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    $livro_id = $_GET['id'];
    $sql = "SELECT * FROM Livro WHERE LIVRO_ID = $livro_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $livro = $result->fetch_assoc();
        
        // Get this book's authors
        $sql_book_authors = "SELECT Autor_ID FROM Livro_Autor WHERE Livro_ID = $livro_id";
        $result_book_authors = $conn->query($sql_book_authors);
        
        $selected_authors = [];
        while ($row = $result_book_authors->fetch_assoc()) {
            $selected_authors[] = $row['Autor_ID'];
        }
    } else {
        header('Location: list_books.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Editar Livro</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <input type="hidden" name="livro_id" value="<?php echo $livro['LIVRO_ID']; ?>">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $livro['Titulo']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">Gênero:</label>
                        <input type="text" class="form-control" id="genero" name="genero" value="<?php echo $livro['Genero']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="ano_publicacao" class="form-label">Ano de Publicação:</label>
                        <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao" value="<?php echo $livro['Ano_Publicacao']; ?>" min="1000" max="<?php echo date('Y'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN:</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo $livro['ISBN']; ?>" required>
                        <div class="form-text">Formato: ISBN-10 ou ISBN-13 (ex: 978-3-16-148410-0)</div>
                    </div>
                    <div class="mb-3">
                        <label for="autores" class="form-label">Autores:</label>
                        <select class="form-select" id="autores" name="autores[]" multiple>
                            <?php 
                            // Reset result pointer
                            $result_autores->data_seek(0);
                            while ($autor = $result_autores->fetch_assoc()): 
                            ?>
                                <option value="<?php echo $autor['Autor_ID']; ?>" <?php echo in_array($autor['Autor_ID'], $selected_authors) ? 'selected' : ''; ?>>
                                    <?php echo $autor['Primeiro_Nome'] . ' ' . $autor['Ultimo_Nome']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <div class="form-text">Pressione Ctrl para selecionar múltiplos autores</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Atualizar Livro</button>
                        <a href="list_books.php" class="btn btn-secondary">Voltar para Lista</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>