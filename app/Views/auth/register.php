<?= $this->extend('layouts/auth_view'); ?>

<?= $this->section('content'); ?>
<div class="flex flex-col gap-8">
  <h1 class="text-2xl font-semibold text-center flex items-center justify-center gap-2">
    <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo" class="w-8 h-8">
    SIMS PPOB
  </h1>
  <h2 class="text-3xl font-semibold text-center">Lengkapi data untuk <br> membuat akun</h2>

  <form method="post" action="/registration" class="flex flex-col gap-4 ">

    <!-- Input Email -->
    <?= view('components/input_field', [
      'icon' => view('components/icons/mail'),
      'type' => 'text',
      'placeholder' => 'masukkan email anda',
      'name' => 'email',
      'value' => old('email') // Mengembalikan nilai yang telah diinput sebelumnya
    ]) ?>
    <!-- Menampilkan error untuk email -->
    <?php if (session('errors') && isset(session('errors')['email'])): ?>
      <div class="text-sm text-red-500"><?= esc(session('errors')['email']) ?></div>
    <?php endif; ?>

    <!-- Input First Name -->
    <?= view('components/input_field', [
      'icon' => view('components/icons/user'),
      'type' => 'text',
      'placeholder' => 'nama depan',
      'name' => 'first_name',
      'value' => old('first_name') // Mengembalikan nilai yang telah diinput sebelumnya
    ]) ?>
    <!-- Menampilkan error untuk first_name -->
    <?php if (session('errors') && isset(session('errors')['first_name'])): ?>
      <div class="text-sm text-red-500"><?= esc(session('errors')['first_name']) ?></div>
    <?php endif; ?>

    <!-- Input Last Name -->
    <?= view('components/input_field', [
      'icon' => view('components/icons/user'),
      'type' => 'text',
      'placeholder' => 'nama belakang',
      'name' => 'last_name',
      'value' => old('last_name') // Mengembalikan nilai yang telah diinput sebelumnya
    ]) ?>
    <!-- Menampilkan error untuk last_name -->
    <?php if (session('errors') && isset(session('errors')['last_name'])): ?>
      <div class="text-sm text-red-500"><?= esc(session('errors')['last_name']) ?></div>
    <?php endif; ?>

    <!-- Input Password -->
    <?= view('components/input_field', [
      'icon' => view('components/icons/lock'),
      'type' => 'password',
      'placeholder' => 'buat password',
      'name' => 'password'
    ]) ?>
    <!-- Menampilkan error untuk password -->
    <?php if (session('errors') && isset(session('errors')['password'])): ?>
      <div class="text-sm text-red-500"><?= esc(session('errors')['password']) ?></div>
    <?php endif; ?>

    <!-- Konfirmasi Password -->
    <?= view('components/input_field', [
      'icon' => view('components/icons/lock'),
      'type' => 'password',
      'placeholder' => 'konfirmasi password',
      'name' => 'confirm_password'
    ]) ?>
    <!-- Menampilkan error untuk confirm_password -->
    <?php if (session('errors') && isset(session('errors')['confirm_password'])): ?>
      <div class="text-sm text-red-500"><?= esc(session('errors')['confirm_password']) ?></div>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary w-full p-3 rounded-md bg-red-500 text-white hover:bg-red-700 mt-6">Registrasi</button>
  </form>

  <p class="text-center text-sm mt-2">
    Sudah punya akun? Login
    <a href="/" class="text-red-600 hover:underline">di sini</a>
  </p>

</div>
<?= $this->endSection(); ?>