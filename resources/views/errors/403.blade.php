<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso Denegado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #d4f1f4; /* Fondo azul pastel */
        }

        .button-container {
            position: absolute;
            top: 312px; /* Distancia del botón con respecto a la parte superior */
            display: flex;
            justify-content: center;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            background-color: #42a5f5; /* Azul similar a los tonos de la imagen */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #ffca28; /* Cambia el color de hover a un tono amarillo/naranja que combine con los detalles de la imagen */
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="{{ url('/dashboard') }}">
            <button>Regresar</button>
        </a>
    </div>
    <img src="{{ asset('images/403-error.webp') }}" alt="403 Forbidden">
</body>
</html>
