</div> <!-- Close the content-wrapper div -->
    <footer class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Biblioteca</h5>
                    <p>Sistema de Gestão de Biblioteca</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>&copy; <?php echo date('Y'); ?> Biblioteca. Todos os direitos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php
    // Calculate the base path for CSS and JS files
    $current_path = $_SERVER['PHP_SELF'];
    $path_parts = explode('/', $current_path);
    $depth = count(array_intersect($path_parts, ['includes', 'livros', 'autores', 'leitores', 'emprestimos', 'frontoffice', 'auth']));
    $basePath = '';
    
    // Build the correct path based on the current directory depth
    for ($i = 0; $i < $depth; $i++) {
        $basePath .= '../';
    }
    $basePath = rtrim($basePath, '/');
    
    // If we're at the root level
    if ($basePath === '') {
        $basePath = '.';
    }
    ?>
    <script src="<?php echo $basePath; ?>/js/script.js"></script>
</body>
</html>