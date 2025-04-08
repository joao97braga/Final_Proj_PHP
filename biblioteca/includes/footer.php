<footer class="bg-dark text-white py-3 mt-5">
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
    
    <script src="<?php echo str_replace('/includes', '', dirname($_SERVER['PHP_SELF'])); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo str_replace('/includes', '', dirname($_SERVER['PHP_SELF'])); ?>/js/script.js"></script>
</body>
</html>