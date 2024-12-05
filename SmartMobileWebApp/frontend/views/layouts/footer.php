<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartMobile</title>
</head>
<body>

<footer class="custom-footer">
    <div class="footer-container">
        <!-- Logo -->
        <div class="footer-section">
            <h2 class="footer-logo">SmartMobile</h2>
        </div>

        <!-- Coluna "Owners" -->
        <div class="footer-section">
            <h3>Owners</h3>
            <ul class="footer-list">
                <li>Pedro Latado</li>
                <li>Pedro Gaspar</li>
                <li>Guilherme Abreu</li>
            </ul>
        </div>

        <!-- Links úteis -->
        <div class="footer-section">
            <h3>Links Úteis</h3>
            <ul class="footer-list">
                <li><a href="<?= \yii\helpers\Url::to(['site/about']) ?>">Sobre nós</a></li>
            </ul>
        </div>
    </div>
</footer>

</body>
</html>
