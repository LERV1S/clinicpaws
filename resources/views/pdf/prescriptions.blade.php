<!DOCTYPE html>
<html>
<head>
    <title>Prescription PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .prescription-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
            position: relative;
        }
        .prescription-header {
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
            background-color: #007BFF;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .prescription-header h1 {
            font-size: 24px;
            margin: 0;
            color: #ffffff;
        }
        .prescription-header p {
            margin: 5px 0;
            font-size: 18px;
            color: #ffffff;
        }
        .prescription-details {
            margin-bottom: 20px;
        }
        .prescription-details p {
            margin: 5px 0;
        }
        .prescription-details p.date {
            text-align: right;
        }
        .footer-message {
            text-align: center;
            margin-top: 40px;
            font-style: italic;
            color: #007BFF;
        }

        /* Tabla de medicinas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        /* Estilos para la marca de agua */
        .watermark-img {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 60%;
            height: auto;
            z-index: 0;
            opacity: 0.1;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <!-- Marca de agua usando una ruta absoluta -->
    <img src="{{ public_path('images/Clinic_Paws2.png') }}" alt="Watermark" class="watermark-img">

    <div class="prescription-container">
        <!-- Header de la veterinaria -->
        <div class="prescription-header">
            <h1>ClinicPaws Veterinary</h1>
            <p>Your Pet's Prescription Details</p>
        </div>

        <!-- Detalles de la prescripción -->
        <div class="prescription-details">
            <p class="date"><strong>Date:</strong> {{ $prescription->date }}</p>
            <p><strong>Veterinarian:</strong> {{ $prescription->veterinarian->user->name }}</p>
            <p><strong>Pet Name:</strong> {{ $prescription->pet->name }}</p>
        </div>

        <!-- Tabla de medicinas -->
        <h3>Medicines</h3>
        <table>
            <thead>
                <tr>
                    <th>Medicine Name</th>
                    <th>Dosage</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescription->medicines as $medicine)
                    <tr>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->pivot->dosage }}</td>
                        <td>{{ $medicine->pivot->instructions }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Mensaje de agradecimiento -->
        <div class="footer-message">
            <p>Thank you for trusting us with {{ $prescription->pet->name }}'s care!</p>
            <p>We hope {{ $prescription->pet->name }} recovers soon. Have a great day!</p>
        </div>
    </div>
</body>
</html>
