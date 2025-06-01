<!DOCTYPE html>
<html>
<head>
    <title>System Requirements Check</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; }
        .check { margin: 0.5rem 0; }
        .pass { color: green; }
        .fail { color: red; }
    </style>
</head>
<body>
    <h1>✅ System Requirements Check</h1>

    @foreach ($checks as $label => $status)
        <div class="check">
            @if ($status)
                <span class="pass">✅ {{ $label }}</span>
            @else
                <span class="fail">❌ {{ $label }}</span>
            @endif
        </div>
    @endforeach

    <hr>
    <p>Make sure all requirements are green before continuing.</p>
</body>
</html>
