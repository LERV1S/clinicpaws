<!DOCTYPE html>
<html>
<head>
    <title>Invoice PDF</title>
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

        .invoice-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
            position: relative;
            z-index: 1;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
            background-color: #007BFF;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .invoice-header h1 {
            font-size: 24px;
            margin: 0;
            color: #ffffff;
        }

        .invoice-header p {
            margin: 5px 0;
            font-size: 18px;
            color: #ffffff;
        }

        .invoice-details, .inventory-items, .footer-message {
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

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
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

    <div class="invoice-container">
        <!-- Header de la factura -->
        <div class="invoice-header">
            <h1>ClinicPaws Veterinary Invoice</h1>
            <p>Thank you for your trust in our services!</p>
        </div>

        <!-- Detalles del emisor y receptor -->
        <div class="invoice-details">
            <p><strong>Invoice Number:</strong> {{ $invoice->id }}</p>
            <p><strong>Invoice Series:</strong> A-{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Issue Date:</strong> {{ $invoice->created_at->format('d/m/Y') }}</p>
            <p><strong>Payment Date:</strong> {{ $invoice->updated_at->format('d/m/Y') }}</p>
            
            <p class="section-title">Issuer Information</p>
            <p><strong>Company:</strong> ClinicPaws Veterinary</p>
            <p><strong>NIF:</strong> ABC123456</p>
            <p><strong>Address:</strong> 123 Veterinary St, Animal City</p>

            <p class="section-title">Client Information</p>
            <p><strong>Name:</strong> {{ $invoice->client->user->name }}</p>
            <p><strong>Email:</strong> {{ $invoice->client->user->email }}</p>
        </div>

        <!-- Items del inventario en formato tabla -->
        <div class="inventory-items">
            <h3>Inventory Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price per Item</th>
                        <th>IVA (16%)</th>
                        <th>Total (with IVA)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $baseImponible = 0;
                        $ivaTotal = 0;
                    @endphp
                    @foreach ($invoice->inventories as $inventory)
                        @php
                            $precioSinIva = $inventory->price;
                            $cantidad = $inventory->pivot->quantity;
                            $totalItemPrice = $precioSinIva * $cantidad;
                            $ivaItem = $totalItemPrice * 0.16;  // Calculo del 16% de IVA
                            $baseImponible += $totalItemPrice;
                            $ivaTotal += $ivaItem;
                        @endphp
                        <tr>
                            <td>{{ $inventory->item_name }}</td>
                            <td>{{ $cantidad }}</td>
                            <td>${{ number_format($precioSinIva, 2) }}</td>
                            <td>${{ number_format($ivaItem, 2) }}</td>
                            <td>${{ number_format($totalItemPrice + $ivaItem, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totales -->
        <p class="total-price">Base Imponible: ${{ number_format($baseImponible, 2) }}</p>
        <p class="total-price">IVA Total (16%): ${{ number_format($ivaTotal, 2) }}</p>
        <p class="total-price">Total a Pagar: ${{ number_format($baseImponible + $ivaTotal, 2) }}</p>

        <!-- Mensaje de agradecimiento -->
        <div class="footer-message">
            <p>Thank you for your visit, {{ $invoice->client->user->name }}!</p>
            <p>We hope to see you again soon. Have a great day!</p>
        </div>
    </div>

</body>
</html>
