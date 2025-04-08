<?php
include '../config.php';
include '../auth/session.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$sql = "SELECT e.*, l.Titulo as livro_titulo, l.ISBN as livro_isbn, 
         le.Primeiro_nome as leitor_primeiro_nome, le.Ultimo_nome as leitor_ultimo_nome 
         FROM Emprestimo e
         INNER JOIN Livro l ON e.Livro_ID = l.LIVRO_ID
         INNER JOIN Leitor le ON e.Leitor_ID = le.Leitor_ID";

if ($filter == 'active') {
    $sql .= " WHERE e.Date_Entrega IS NULL";
} elseif ($filter == 'returned') {
    $sql .= " WHERE e.Date_Entrega IS NOT NULL";
} elseif ($filter == 'late') {
    $sql .= " WHERE e.Date_Entrega IS NULL AND e.Data_Vencimento < CURDATE()";
}

$sql .= " ORDER BY e.Data_Emp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empréstimos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Lista de Empréstimos</h3>
                <div class="mt-2">
                    <a href="?filter=all" class="btn btn-sm <?php echo $filter == 'all' ? 'btn-primary' : 'btn-outline-primary'; ?>">Todos</a>
                    <a href="?filter=active" class="btn btn-sm <?php echo $filter == 'active' ? 'btn-primary' : 'btn-outline-primary'; ?>">Ativos</a>
                    <a href="?filter=returned" class="btn btn-sm <?php echo $filter == 'returned' ? 'btn-primary' : 'btn-outline-primary'; ?>">Devolvidos</a>
                    <a href="?filter=late" class="btn btn-sm <?php echo $filter == 'late' ? 'btn-primary' : 'btn-outline-primary'; ?>">Em Atraso</a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="add_loan.php" class="btn btn-primary">Adicionar Empréstimo</a>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Livro</th>
                            <th>Leitor</th>
                            <th>Data Empréstimo</th>
                            <th>Data Vencimento</th>
                            <th>Data Entrega</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php
                                $status = '';
                                $status_class = '';

                                if ($row['Date_Entrega']) {
                                    $status = 'Devolvido';
                                    $status_class = 'text-success';
                                } elseif (strtotime($row['Data_Vencimento']) < time()) {
                                    $status = 'Em Atraso';
                                    $status_class = 'text-danger';
                                } else {
                                    $status = 'Ativo';
                                    $status_class = 'text-primary';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row['Emprestimo_ID']; ?></td>
                                    <td><?php echo $row['livro_titulo'] . ' (ISBN: ' . $row['livro_isbn'] . ')'; ?></td>
                                    <td><?php echo $row['leitor_primeiro_nome'] . ' ' . $row['leitor_ultimo_nome']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['Data_Emp'])); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['Data_Vencimento'])); ?></td>
                                    <td><?php echo $row['Date_Entrega'] ? date('d/m/Y', strtotime($row['Date_Entrega'])) : '-'; ?></td>
                                    <td class="<?php echo $status_class; ?>"><?php echo $status; ?></td>
                                    <td>
                                        <a href="edit_loan.php?id=<?php echo $row['Emprestimo_ID']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                        <?php if (!$row['Date_Entrega']): ?>
                                            <a href="return_loan.php?id=<?php echo $row['Emprestimo_ID']; ?>" class="btn btn-sm btn-success">Devolver</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Nenhum empréstimo encontrado</td>
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