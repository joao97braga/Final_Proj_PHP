<?php
include '../../config.php';
include '../../auth/session.php';

requireLogin();

$leitor_id = $_SESSION['leitor_id'];

// Obter histórico de empréstimos do leitor
$sql = "SELECT e.*, l.Titulo as livro_titulo, l.ISBN as livro_isbn 
        FROM Emprestimo e
        INNER JOIN Livro l ON e.Livro_ID = l.LIVRO_ID
        WHERE e.Leitor_ID = $leitor_id
        ORDER BY e.Data_Emp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Empréstimos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php include '../../includes/header.php'; ?>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Meu Histórico de Empréstimos</h3>
            </div>
            <div class="card-body">
                <?php if ($result->num_rows > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Livro</th>
                                <th>Data Empréstimo</th>
                                <th>Data Vencimento</th>
                                <th>Data Devolução</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    $status = 'Em Andamento';
                                    $status_class = 'text-primary';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row['livro_titulo'] . ' (ISBN: ' . $row['livro_isbn'] . ')'; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['Data_Emp'])); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['Data_Vencimento'])); ?></td>
                                    <td><?php echo $row['Date_Entrega'] ? date('d/m/Y', strtotime($row['Date_Entrega'])) : '-'; ?></td>
                                    <td class="<?php echo $status_class; ?>"><?php echo $status; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">Você ainda não realizou nenhum empréstimo.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>

<?php
$conn->close();
?>