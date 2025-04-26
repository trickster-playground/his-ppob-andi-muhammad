<?= $this->extend('layouts/auth_view'); ?>

<?= $this->section('content'); ?>
<div class="flex flex-col gap-8">
  <h1 class="text-2xl font-semibold  text-center flex items-center justify-center gap-2">
    <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo" class="w-8 h-8">
    SIMS PPOB
  </h1>
  <h2 class="text-3xl font-semibold text-center">Masuk atau buat akun <br> untuk memulai</h2>

  <!-- Menampilkan pesan notifikasi sukses jika ada -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 text-green-700 p-4 mb-4 rounded-md">
      <?= session()->getFlashdata('success'); ?>
    </div>
  <?php endif; ?>
  
  <form method="post" action="/registration" class="flex flex-col gap-4 ">

    <!-- Input Email -->
    <?= view('components/input_field', [
      'icon' => view('components/icons/mail'),
      'type' => 'text',
      'placeholder' => 'masukkan email anda',
      'name' => 'email'
    ]) ?>

    <!-- Input Password -->
    <?= view('components/input_field', [
      'icon' => view('components/icons/lock'),
      'type' => 'password',
      'placeholder' => 'masukkan password anda',
      'name' => 'password'
    ]) ?>

    <button type="submit" class="btn btn-primary w-full p-3 rounded-md bg-red-500 text-white hover:bg-red-700 mt-6">Masuk</button>
  </form>

  <p class="text-center text-sm mt-2">
    Belum punya akun? Registrasi
    <a href="/register" class="text-red-600 hover:underline">di sini</a>
  </p>

</div>
<?= $this->endSection(); ?>