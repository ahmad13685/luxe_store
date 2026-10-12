<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') | Luxe Store</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Main Stylesheet (same one the rest of the site uses) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Auth pages only (extracted from the original login.php inline styles) -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

    <!-- ===== THEME TOGGLE ===== -->
    <button class="theme-toggle-auth" id="themeToggle" title="Toggle dark mode">
        <i class="bi bi-moon-stars"></i>
    </button>

    @yield('content')

    <script>
        // Same dark/light mode logic as the rest of the site (localStorage key: luxe-theme)
        const root = document.documentElement;
        const themeBtn = document.getElementById('themeToggle');

        function setTheme(t) {
            root.setAttribute('data-theme', t);
            localStorage.setItem('luxe-theme', t);
            themeBtn.innerHTML = t === 'dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon-stars"></i>';
        }

        setTheme(localStorage.getItem('luxe-theme') || 'light');

        themeBtn.addEventListener('click', function () {
            const current = root.getAttribute('data-theme');
            setTheme(current === 'dark' ? 'light' : 'dark');
        });

        // Password show/hide toggle - works for every .password-toggle on the page
        document.querySelectorAll('.password-toggle .toggle-eye').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = btn.previousElementSibling;
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                btn.innerHTML = isPassword ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
            });
        });
    </script>

    @yield('scripts')

</body>
</html>
