<!DOCTYPE html>
<html>

<head>
    <title>Vault</title>
    <style>
        body {
            font-family: Arial;
            padding: 10px;
        }

        .item {
            border: 1px solid #ddd;
            padding: 8px;
            margin-bottom: 6px;
        }

        button {
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h3>🔐 Saved logins for {{ $site }}</h3>

    @forelse($items as $item)
        <div class="item">
            <strong>{{ $item['username'] }}</strong><br>

            <button
                onclick="fill(
                '{{ $item['username'] }}',
                '{{ $item['password'] }}'
            )">
                Fill
            </button>
        </div>
    @empty
        <p>No saved passwords</p>
    @endforelse

    <script>
        function fill(username, password) {
            const doc = window.opener.document;

            const userField =
                doc.querySelector("input[type='email'], input[name='username'], input[type='text']");
            const passField = doc.querySelector("input[type='password']");

            if (userField) userField.value = username;
            if (passField) passField.value = password;

            window.close();
        }
    </script>

</body>

</html>
