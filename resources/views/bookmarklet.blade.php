<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyVault - Select Credential</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 15px 20px;
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header h5 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .site-badge {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            margin-top: 5px;
        }

        .content {
            padding: 20px;
            max-height: calc(100vh - 100px);
            overflow-y: auto;
        }

        .credential-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .credential-card:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .credential-username {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .credential-site {
            font-size: 13px;
            color: #666;
        }

        .btn-fill {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-fill:hover {
            background: #5568d3;
        }

        .btn-copy {
            font-size: 12px;
        }

        .toast-copy {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #333;
            color: #fff;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
            z-index: 999999;
        }
    </style>
</head>

<body>

    <div class="header">
        <h5>
            <i class="fa fa-key" style="color:#667eea;"></i>
            MyVault Password Manager
        </h5>

        @if ($site)
            <div>
                <span class="site-badge">
                    <i class="fa fa-globe"></i> {{ $site }}
                </span>
            </div>
        @endif
    </div>

    <div class="content">

        @if ($items->count() > 0)
            @foreach ($items as $item)
                <div class="credential-card"
                    onclick="fillCredentials('{{ addslashes($item->username) }}','{{ addslashes($item->password) }}')">

                    <div class="credential-username">
                        <i class="fa fa-user"></i> {{ $item->username }}
                    </div>

                    <div class="credential-site">
                        {{ $item->sitename }}
                    </div>

                    <div class="d-flex gap-2 mt-3">

                        <!-- Autofill (same as before) -->
                        <button class="btn btn-fill"
                            onclick="event.stopPropagation(); fillCredentials('{{ addslashes($item->username) }}','{{ addslashes($item->password) }}')">
                            <i class="fa fa-arrow-right"></i> Fill
                        </button>

                        <!-- Copy Username -->
                        <button class="btn btn-outline-secondary btn-copy"
                            onclick="event.stopPropagation(); copyText('{{ addslashes($item->username) }}','Username')">
                            <i class="fa fa-copy"></i> Username
                        </button>

                        <!-- Copy Password -->
                        <button class="btn btn-outline-secondary btn-copy"
                            onclick="event.stopPropagation(); copyText('{{ addslashes($item->password) }}','Password')">
                            <i class="fa fa-copy"></i> Password
                        </button>

                    </div>

                </div>
            @endforeach
        @else
            <div class="text-center bg-white p-5 rounded">
                <div class="no-results">
                    <i class="fa fa-inbox fa-4x" style="color: #667eea;"></i>
                    <p>No saved credentials for <strong>{{ $site }}</strong></p>
                    <a href="{{ route('front.socialmedia') }}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Credential
                    </a>
                </div>
            </div>
        @endif

    </div>

    <script>
        function fillCredentials(username, password) {
            if (window.opener && !window.opener.closed) {
                window.opener.postMessage({
                    type: 'MYVAULT_FILL',
                    username: username,
                    password: password
                }, '*');

                showToast('Autofill triggered');
                setTimeout(() => window.close(), 1500);
            } else {
                alert('Parent window not found');
            }
        }

        function copyText(text, label) {
            navigator.clipboard.writeText(text).then(() => {
                showToast(label + ' copied');
            });
        }

        function showToast(msg) {
            const toast = document.createElement('div');
            toast.className = 'toast-copy';
            toast.innerText = msg;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        }
    </script>

</body>

</html>
