
<!DOCTYPE html>
<html>
<head><title>Lista de Pessoas</title></head>
<body>
    <h1>Pessoas</h1>
    <ul>
        <?php foreach ($pessoas as $pessoa): ?>
            <li><?= $pessoa['nome'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
