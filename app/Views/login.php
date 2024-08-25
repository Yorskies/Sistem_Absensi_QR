<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQISSA - LOGIN</title>
    <link rel="shortcut icon" href="/assets/images/logo/logo2.png" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/logo/logo2.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px; /* Sesuaikan jarak antara logo dan form */
        }

        .logo {
            max-width: 100%;
            height: auto;
            max-height: 300px; /* Atur ukuran maksimum logo */
            width: auto; /* Menjaga proporsi gambar */
        }

        footer {
            background-color: #007bff; /* Ganti dengan warna yang sesuai */
            color: #fff;
            text-align: center;
        }
    </style>
</head>

<body>
    <section class="content vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6 logo-container">
                    <img src="/assets/images/logo/logo.png" class="img-fluid logo" alt="logo">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <h2 class="text-center mb-4 text-primary">AQISSA</h2>

                    <!-- Alert notifikasi -->
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i> <?= session()->getFlashdata('pesan'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>

                    <form method="post" action="/logindulu">
                        <?= csrf_field() ?>
                        <!-- Username input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Nama Pengguna">
                            <label class="form-label" for="username">Nama Pengguna</label>
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="password" name="pss" class="form-control form-control-lg" placeholder="Sandi">
                            <label class="form-label" for="pss">Sandi</label>
                        </div>

                        <div class="d-flex justify-content-around align-items-center mb-4">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                <label class="form-check-label" for="rememberMe"> Ingat saya </label>
                            </div>
                            <a href="#!">Lupa sandi?</a>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
            © 2024 SMK SWASTA AWAL KARYA PEMBANGUNAN GALANG. All rights reserved.
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
</body>

</html>
