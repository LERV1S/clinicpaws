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
            background-color: #f4f4f4;
        }
        .ticket-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
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
        .ticket-details p, .inventory-items p, .footer-message p {
            margin: 5px 0;
        }
        .inventory-items h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #007BFF;
        }
        .inventory-items ul {
            list-style-type: none;
            padding-left: 0;
        }
        .inventory-items li {
            margin-bottom: 10px;
            color: #555555;
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
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- Header de la veterinaria -->
        <div class="ticket-header">
            <h1>ClinicPaws Veterinary</h1>
            <p>Thank you for trusting us with your pet's care!</p>
        </div>

        <!-- Detalles del cliente y ticket -->
        <div class="ticket-details">
            <p><strong>Client:</strong> {{ $ticket->client->user->name }}</p>
            <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
            <p><strong>Description:</strong> {{ $ticket->description }}</p>
            <p><strong>Status:</strong> {{ $ticket->status }}</p>
            <p><strong>Created at:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Items de inventario -->
        <div class="inventory-items">
            <h3>Inventory Items</h3>
            <ul>
                @foreach ($ticket->inventories as $inventory)
                    @php
                        $totalItemPrice = $inventory->price * $inventory->pivot->quantity;
                    @endphp
                    <li>{{ $inventory->item_name }} - Quantity: {{ $inventory->pivot->quantity }} - Price per item: ${{ number_format($inventory->price, 2) }} - Total: ${{ number_format($totalItemPrice, 2) }}</li>
                @endforeach
            </ul>

            @php
                $totalTicketPrice = $ticket->inventories->sum(function ($inventory) {
                    return $inventory->price * $inventory->pivot->quantity;
                });
            @endphp
            <p class="total-price">Total: ${{ number_format($totalTicketPrice, 2) }}</p>
        </div>

        <!-- Mensaje de agradecimiento -->
        <div class="footer-message">
            <p>Thank you for your visit, {{ $ticket->client->user->name }}!</p>
            <p>We hope to see you again soon. Have a great day!</p>
        </div>
    </div>
</body>
</html>
