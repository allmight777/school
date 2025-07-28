<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur lors du traitement</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #f8d7da; color: #721c24; }
        pre { background: #f5c6cb; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Une erreur est survenue :</h1>
    <p><strong>Message :</strong> {{ $message }}</p>
    <h2>Trace :</h2>
    <pre>{{ $trace }}</pre>
</body>
</html>
