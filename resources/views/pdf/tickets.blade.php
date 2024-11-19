<!DOCTYPE html>
<html>
<head>
    <title>Ticket PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .ticket-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
            position: relative;
            z-index: 1;
        }

        .ticket-header {
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
            background-color: #007BFF;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .ticket-header h1 {
            font-size: 24px;
            margin: 0;
            color: #ffffff;
        }

        .ticket-header p {
            margin: 5px 0;
            font-size: 18px;
            color: #ffffff;
        }

        .ticket-details, .inventory-items, .footer-message {
            margin-bottom: 20px;
        }

        .inventory-items h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #007BFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .total-price {
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
            color: #333333;
        }

        .footer-message {
            text-align: center;
            margin-top: 40px;
            font-style: italic;
            color: #007BFF;
        }

        /* Estilos para la imagen de fondo */
        .watermark-img {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 60%;
            height: auto;
            z-index: 0;
            opacity: 0.1; /* Ajusta la opacidad */
            transform: translate(-50%, -50%);
        }

    </style>
</head>
<body>

    <!-- Marca de agua usando una ruta absoluta -->
    <img src="{{ public_path('images/Clinic_Paws2.png') }}" alt="Watermark" class="watermark-img">

    <div class="ticket-container">
        <!-- Header del ticket -->
        <div class="ticket-header">
            <h1>ClinicPaws Veterinary</h1>
            <p>Thank you for trusting us with your pet's care!</p>
        </div>

        <!-- Detalles del ticket -->
        <div class="ticket-details">
            <p><strong>Client:</strong> {{ $ticket->client->user->name }}</p>
            <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
            <p><strong>Description:</strong> {{ $ticket->description }}</p>
            <p><strong>Status:</strong> {{ $ticket->status }}</p>
            <p><strong>Created at:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Items del inventario en formato tabla -->
        <div class="inventory-items">
            <h3>Inventory Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price per Item (IVA incl.)</th>
                        <th>Total (IVA incl.)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalTicketPrice = 0;
                    @endphp
                    @foreach ($ticket->inventories as $inventory)
                        @php
                            // Cálculo del IVA y del precio total con IVA
                            $itemPriceWithIVA = $inventory->price * 1.16;
                            $totalItemPrice = $itemPriceWithIVA * $inventory->pivot->quantity;
                            $totalTicketPrice += $totalItemPrice;
                        @endphp
                        <tr>
                            <td>{{ $inventory->item_name }}</td>
                            <td>{{ $inventory->pivot->quantity }}</td>
                            <td>${{ number_format($itemPriceWithIVA, 2) }}</td>
                            <td>${{ number_format($totalItemPrice, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <p class="total-price">Total (IVA incl.): ${{ number_format($totalTicketPrice, 2) }}</p>

        <!-- Mensaje de agradecimiento -->
        <div class="footer-message">
            <p>Thank you for your visit, {{ $ticket->client->user->name }}!</p>
            <p>We hope to see you again soon. Have a great day!</p>
        </div>
    </div>

</body>
</html>
