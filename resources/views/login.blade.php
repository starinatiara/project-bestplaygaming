<!DOCTYPE html>
<html>
<head>
    <title>Login | Best Play Gaming</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-md-5">

            <div class="card shadow border-0">
                <div class="card-body p-5">

                    <h2 class="text-center text-primary">
                        PS Rental
                    </h2>

                    <p class="text-center text-muted">
                        Sistem Informasi Rental PlayStation
                    </p>

                    <form id="loginForm">

                        <div class="mb-3">
                            <label class="form-label">
                                Username
                            </label>

                            <input 
                                type="text"
                                name="username"
                                id="username"
                                class="form-control"
                                placeholder="Masukkan username"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Password
                            </label>

                            <input 
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                            >
                        </div>

                        <button 
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Login
                        </button>

                        <!-- PESAN ERROR LOGIN (TEKS TANPA KOTAK) -->
                        <div
                            id="loginError"
                            class="text-danger small mt-2 text-center"
                            role="alert"
                            style="display: none;"
                        ></div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

<script>
    const loginError = document.getElementById("loginError");

    function showLoginError(message) {
        loginError.textContent = message;
        loginError.style.display = "block";
    }

    function hideLoginError() {
        loginError.style.display = "none";
    }

    // Sembunyikan error saat user mengetik lagi
    document.getElementById("username").addEventListener("input", hideLoginError);
    document.getElementById("password").addEventListener("input", hideLoginError);

    document.getElementById("loginForm").addEventListener("submit", async function (e) {
        e.preventDefault();

        hideLoginError();

        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value;
        const tombol = this.querySelector("button[type=submit]");
        tombol.disabled = true;

        try {
            const response = await fetch("/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ username: username, password: password })
            });

            const data = await response.json();

            if (!response.ok) {
                showLoginError(data.message || "Login gagal.");
                tombol.disabled = false;
                return;
            }

            // Halaman lain masih membaca role dan username dari localStorage
            localStorage.setItem("role", data.role);
            localStorage.setItem("username", data.username);

            window.location.href = data.redirect;
        } catch (err) {
            showLoginError("Tidak dapat terhubung ke server.");
            tombol.disabled = false;
        }
    });
</script>

</body>
</html>