<!-- resources/views/tickets/pdf.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Ticket PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        .ticket-header h1 {
            font-size: 24px;
            color: #4CAF50;
            margin: 0;
        }
        .ticket-details {
            margin-bottom: 30px;
        }
        .ticket-details p {
            margin: 8px 0;
            font-size: 16px;
            color: #333;
        }
        .ticket-details p strong {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="ticket-header">
            <h1>Ticket #{{ $ticket->id }}</h1>
        </div>

        <div class="ticket-details">
            <p><strong>Client:</strong> {{ $ticket->client->user->name }}</p>
            <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
            <p><strong>Description:</strong> {{ $ticket->description }}</p>
            <p><strong>Status:</strong> {{ $ticket->status }}</p>
            <p><strong>Created at:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
