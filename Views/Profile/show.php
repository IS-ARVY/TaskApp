<?= $this->extend("layouts/default") ?>

<?= $this->Section("title ") ?>Profile<?= $this->endSection() ?>

<?= $this->section("content") ?>

<h1 class="title">Profile</h1>

<?php if ($user->profile_image): ?>

    <img src="<?= site_url('/profile/image') ?>" width="200" height="200" alt="profile image">

    <a href="<?= site_url('/profileimage/delete') ?>">Delete profile image</a>

<?php else: ?>

<img src="<?= site_url('/images/default.jpg') ?>" width="200" heigth="200" alt="profile image">

<?php endif; ?>

<dl>
    <dt>Name</dt>
    <dd><?= esc($user->name) ?></dd>

    <dt>Email</dt>
    <dd><?= esc($user->email) ?></dd>
</dl>

<a href="<?= site_url("/profile/edit") ?>">Edit</a>

<a href="<?= site_url("/profile/editpassword") ?>">Change password</a>

<a href="<?= site_url("/profileimage/edit") ?>">Change profile image</a>

<?= $this->endSection() ?>