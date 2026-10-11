<!DOCTYPE html>
<html>
<head>
    <title>Login | PS Rental</title>

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

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

<script>
    document.getElementById("loginForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const usernameInput = document.getElementById("username").value.trim();
        const lowerUsername = usernameInput.toLowerCase();

        // Tentukan role otomatis berdasarkan username
        let role = "kasir";
        if (lowerUsername === "superadmin" || lowerUsername === "admin") {
            role = "superadmin";
        }

        // Simpan ke localStorage agar dibaca oleh dashboard
        localStorage.setItem("role", role);
        localStorage.setItem("username", usernameInput);

        // Arahkan langsung ke dashboard
        window.location.href = "/dashboard";
    });
</script>

</body>
</html>