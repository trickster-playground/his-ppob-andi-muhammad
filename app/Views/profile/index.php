<?= $this->extend('layouts/main_view'); ?>

<?= $this->section('content'); ?>

<div class="flex items-center justify-center">
  <?= view('components/alert') ?>
  <div class="p-8 w-full max-w-4xl">
    <!-- Foto Profil -->
    <div class="flex justify-center items-center mb-4 relative w-40 h-40 mx-auto rounded-full hover:border-2 hover:border-gray-400 transition">
      <img
        id="profileImagePreview"
        src="<?= esc($profileImage); ?>"
        alt="Foto Profil"
        class="w-[160px] h-[160px] rounded-full object-cover" />

      <!-- Tombol Icon Pena -->
      <label for="profileImageInput" class="absolute bottom-4 right-6 translate-x-1/4 translate-y-1/4 rounded-full p-2 border bg-gray-100 border-gray-200 shadow hover:bg-gray-200 transition">
        <?= view('components/icons/pen') ?>
      </label>

      <!-- Form Upload File -->
      <form action="<?= base_url('/profile/image'); ?>" method="post" enctype="multipart/form-data">
        <input type="file" id="profileImageInput" name="file" class="hidden" onchange="this.form.submit()" />
      </form>
    </div>



    <!-- Nama User -->
    <h2 class="text-2xl font-semibold mb-6 text-center" id="profileName">
      <?= esc(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')); ?>
    </h2>

    <!-- Form Input -->
    <form id="profileForm" action="<?= base_url('/profile/update'); ?>" method="post" class="space-y-4">
      <!-- Input Email -->
      <div class="w-full flex flex-col gap-2">
        <label for="email" class="font-semibold">Email</label>
        <?= view('components/input_field', [
          'icon' => view('components/icons/mail'),
          'type' => 'text',
          'placeholder' => 'masukkan email anda',
          'name' => 'email',
          'id' => 'email',
          'value' => $profile['email'] ?? '',
          'attributes' => 'readonly',
        ]) ?>
        <?php if (session('errors') && isset(session('errors')['email'])): ?>
          <div class="text-sm text-red-500"><?= esc(session('errors')['email']) ?></div>
        <?php endif; ?>
      </div>

      <!-- Input First Name -->
      <div class="w-full flex flex-col gap-2">
        <label for="first_name" class="font-semibold">Nama Depan</label>
        <?= view('components/input_field', [
          'icon' => view('components/icons/user'),
          'type' => 'text',
          'placeholder' => 'nama depan',
          'name' => 'first_name',
          'id' => 'first_name',
          'value' => $profile['first_name'] ?? '',
          'attributes' => 'readonly',
        ]) ?>
        <?php if (session('errors') && isset(session('errors')['first_name'])): ?>
          <div class="text-sm text-red-500"><?= esc(session('errors')['first_name']) ?></div>
        <?php endif; ?>
      </div>

      <!-- Input Last Name -->
      <div class="w-full flex flex-col gap-2">
        <label for="last_name" class="font-semibold">Nama Belakang</label>
        <?= view('components/input_field', [
          'icon' => view('components/icons/user'),
          'type' => 'text',
          'placeholder' => 'nama belakang',
          'name' => 'last_name',
          'id' => 'last_name',
          'value' => $profile['last_name'] ?? '',
          'attributes' => 'readonly',
        ]) ?>
        <?php if (session('errors') && isset(session('errors')['last_name'])): ?>
          <div class="text-sm text-red-500"><?= esc(session('errors')['last_name']) ?></div>
        <?php endif; ?>
      </div>

      <!-- Tombol -->
      <div id="buttonGroup" class="flex flex-col gap-2 mt-6">
        <button type="button" id="editButton" class="btn btn-primary w-full p-3 rounded-md bg-red-600 text-white hover:bg-red-700" onclick="enableEdit()">Edit Profile</button>
      </div>
    </form>

    <!-- Logout -->
    <form action="<?= base_url('/logout'); ?>" method="get">
      <button type="submit" class="btn btn-outline w-full p-3 rounded-md border border-red-300 hover:bg-red-300 text-red-500 mt-6">Logout</button>
    </form>

  </div>
</div>

<script>
  function enableEdit() {
    document.getElementById('email').removeAttribute('readonly');
    document.getElementById('first_name').removeAttribute('readonly');
    document.getElementById('last_name').removeAttribute('readonly');

    document.getElementById('buttonGroup').innerHTML = `
    <div class="flex gap-2">
      <button type="submit" class="btn btn-primary flex-1 p-3 rounded-md bg-green-600 text-white hover:bg-green-700">Simpan</button>
      <button type="button" class="btn btn-secondary flex-1 p-3 rounded-md bg-red-600 text-white hover:bg-red-700" onclick="cancelEdit()">Batalkan</button>
    </div>
  `;
  }

  function cancelEdit() {
    document.getElementById('email').setAttribute('readonly', true);
    document.getElementById('first_name').setAttribute('readonly', true);
    document.getElementById('last_name').setAttribute('readonly', true);

    document.getElementById('profileForm').reset();

    document.getElementById('buttonGroup').innerHTML = `
    <button type="button" id="editButton" class="btn btn-primary w-full p-3 rounded-md bg-red-600 text-white hover:bg-red-700" onclick="enableEdit()">Edit Profile</button>
  `;
  }
</script>

<?= $this->endSection(); ?>