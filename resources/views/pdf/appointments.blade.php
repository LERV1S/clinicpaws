<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>Appointment Details</h1>

    <table>
        <tr>
            <th>Pet Name</th>
            <td>{{ $appointment->pet->name }}</td>
        </tr>
        <tr>
            <th>Veterinarian</th>
            <td>{{ $appointment->veterinarian->user->name }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $appointment->appointment_date }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $appointment->status }}</td>
        </tr>
        <tr>
            <th>Notes</th>
            <td>{{ $appointment->notes }}</td>
        </tr>
    </table>

</body>
</html>
