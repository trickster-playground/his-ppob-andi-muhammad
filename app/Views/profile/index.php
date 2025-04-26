<?= $this->extend('layouts/main_view'); ?>

<?= $this->section('content'); ?>
<div class="flex items-center justify-center ">
  <div class="p-8 w-full max-w-4xl">
    <!-- Foto Profil -->
    <div class="flex justify-center mb-4">
      <img
        src="<?= base_url('assets/images/Profile Photo.png'); ?>"
        alt="Foto Profil"
        class="w-40 h-40 rounded-full object-cover" />
    </div>

    <!-- Nama User -->
    <h2 class="text-2xl font-semibold mb-6 text-center">
      <?= esc(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')); ?>
    </h2>

    <!-- Form Input -->
    <form action="#" method="post" class="space-y-4">
      <!-- Input Email -->
      <div class="w-full flex flex-col gap-2">
        <label for="email" class="font-semibold">Email</label>
        <?= view('components/input_field', [
          'icon' => view('components/icons/mail'),
          'type' => 'text',
          'placeholder' => 'masukkan email anda',
          'name' => 'email',
          'value' => $profile['email'] ?? '',
        ]) ?>
      </div>

      <!-- Input First Name -->
      <div class="w-full flex flex-col gap-2">
        <label for="first_name" class="font-semibold">Nama Depan</label>
        <?= view('components/input_field', [
          'icon' => view('components/icons/user'),
          'type' => 'text',
          'placeholder' => 'nama depan',
          'name' => 'first_name',
          'value' => $profile['first_name'] ?? '',
        ]) ?>
      </div>

      <!-- Input Last Name -->
      <div class="w-full flex flex-col gap-2">
        <label for="last_name" class="font-semibold">Nama Belakang</label>
        <?= view('components/input_field', [
          'icon' => view('components/icons/user'),
          'type' => 'text',
          'placeholder' => 'nama belakang',
          'name' => 'last_name',
          'value' => $profile['last_name'] ?? '',
        ]) ?>
      </div>
    </form>

    <button class="btn btn-primary w-full p-3 rounded-md bg-red-600 text-white hover:bg-red-700 mt-6">Edit Profile</button>
    
    <form action="<?= base_url('/logout'); ?>" method="get">
      <button type="submit" class="btn btn-outline w-full p-3 rounded-md border border-red-300 hover:bg-red-300 text-red-500 mt-6">Logout</button>
    </form>

  </div>


</div>
<?= $this->endSection(); ?>