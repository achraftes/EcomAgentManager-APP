<!DOCTYPE html>
<html>
<head>
    <title>Leads Assigned</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333333;
        }
        .lead-card {
            background-color: #f9f9f9;
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .lead-card h2 {
            font-size: 20px;
            color: #333333;
        }
        .lead-card p {
            color: #666666;
            margin: 5px 0;
        }
        .lead-card .status {
            font-size: 14px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello, {{ $agentName }}</h1>
        <h2>You have been assigned the following leads:</h2>
        <br>
        @if($leads->isEmpty())
            <p style="text-align: center; color: #888888;">No leads with comments for today.</p>
        @else
            @foreach($leads as $lead)
                <div class="lead-card">
                    <h2>Order id: {{ $lead->order_id }}</h2>
                    <p>Client: {{ $lead->client }}</p>
                    <p>Phone: {{ $lead->phone }}</p>
                    <p>City: {{ $lead->city }}</p>
                    <p>Address: {{ $lead->address }}</p>
                    <p class="status">Status: {{ $lead->status }}</p>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
