<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Vendors Style-->
	<link rel="stylesheet" href="<?= base_url() ?>assets/template/main/css/vendors_css.css">

<!-- Style-->
<link rel="stylesheet" href="<?= base_url() ?>assets/template/main/css/style.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/template/main/css/skin_color.css">
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <?php if (session()->getFlashdata('gagal')) : ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('gagal') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('sukses')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('sukses') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register_action') ?>" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required class="form-control">
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required class="form-control">
            </div>
            <div class="form-group">
                <label for="npk">Npk:</label>
                <input type="text" id="npk" name="npk" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p>Already have an account? <a href="<?= base_url('/') ?>">Login here</a>.</p>
    </div>
</body>
</html>
