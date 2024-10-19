<?= $this->extend("layouts/default") ?>

<?= $this->Section("title ") ?>Password Reset<?= $this->endSection() ?>

<?= $this->section("content") ?>

<h1>Password Reset</h1>

<p>Password reset successful</p>

<p><a href="<?= site_url("/login") ?>">Login</a></p>


<?= $this->endSection() ?>