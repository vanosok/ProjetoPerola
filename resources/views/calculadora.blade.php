<!-- calculadora.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
</head>
<body>
    <form action="/calcular" method="POST">
        @csrf <!-- Adiciona um token CSRF para segurança -->
        <label for="valor">Digite um valor:</label><br>
        <input type="text" id="valor" name="valor"><br><br>
        <button type="submit">Calcular</button>
    </form>
</body>
</html>
