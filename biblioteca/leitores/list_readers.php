<?php
include '../config.php';
include '../auth/session.php';

$sql = "SELECT * FROM Leitor ORDER BY Ultimo_nome, Primeiro_nome";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Leitores</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Lista de Leitores</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="add_reader.php" class="btn btn-primary">Adicionar Leitor</a>
                </div>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telemóvel</th>
                            <th>Data de Aniversário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['Leitor_ID']; ?></td>
                                    <td><?php echo $row['Primeiro_nome'] . ' ' . $row['Ultimo_nome']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
                                    <td><?php echo $row['Telemovel'] ?: '-'; ?></td>
                                    <td><?php echo $row['Data_Aniversario'] ? date('d/m/Y', strtotime($row['Data_Aniversario'])) : '-'; ?></td>
                                    <td>
                                        <a href="edit_reader.php?id=<?php echo $row['Leitor_ID']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                        <a href="delete_reader.php?id=<?php echo $row['Leitor_ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja apagar este leitor?');">Apagar</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Nenhum leitor encontrado</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>