<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $basePath; ?>/css/style.css">
</head>
<body>
<div class="content-wrapper">
    <header class="bg-dark text-white py-3">
        <div class="container">
            <img src="<?php echo $basePath; ?>/images/BookLibLogo.jpeg" alt="Logo da Biblioteca">
        </div>
    </header>