<?= $this->extend('layouts/main_view'); ?>

<?= $this->section('content'); ?>
<div>
  <?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 text-green-700 p-4 mb-4 rounded-md">
      <?= session()->getFlashdata('success'); ?>
    </div>
  <?php endif; ?>

  <div class="flex items-center justify-between px-2 mb-6 max-w-7xl mx-auto">
    <div class="flex flex-col items-start p-3 max-w-4xl">
      <!-- Foto Profil -->
      <div class="flex justify-center mb-4">
        <img
          src="<?= base_url('assets/images/Profile Photo.png'); ?>"
          alt="Foto Profil"
          class="w-25 h-25 rounded-full object-cover border-2 border-primary" />
      </div>

      <!-- Informasi pengguna -->
      <div class=" flex flex-col items-start">
        <!-- Pesan Selamat Datang -->
        <h2 class="text-xl ">Selamat Datang,</h2>
        <h3 class="text-4xl font-semibold "><?= session()->get('first_name') ?? 'Nama Depan'; ?> <?= session()->get('last_name') ?? 'Nama Belakang'; ?></h3>
      </div>
    </div>


    <!-- Banner Saldo  -->
    <div class="flex-none w-3/5 ">
      <img
        src="<?= base_url('assets/images/Background Saldo.png'); ?>"
        alt="Banner"
        class="w-full h-auto rounded-lg" />
    </div>
  </div>

  <!-- Services -->
  <div class="mt-10 max-w-7xl mx-auto">
    <h1 class="text-lg font-semibold mb-4">Layanan Kami</h1>
    <div class="grid grid-cols-12 gap-2">
      <?php foreach ($services as $service): ?>
        <div class="flex flex-col items-center col-span-1">
          <img src="<?= esc($service['service_icon']); ?>" alt="<?= esc($service['service_name']); ?>" class="w-18 h-18 mb-2 object-cover" />
          <span class="text-center text-sm"><?= esc($service['service_name']); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Slider Banner -->
  <div class="mt-8 p-2 ml-2">
    <div class="flex items-start max-w-7xl mx-auto px-2">
      <h1 class="text-lg font-semibold">Temukan Promo Menarik</h1>
    </div>

    <div class="mt-4 overflow-x-hidden mx-auto ml-80">
      <div class="flex space-x-4 w-max">
        <?php foreach ($banners as $banner): ?>
          <div class="w-80 flex-shrink-0">
            <img src="<?= esc($banner['banner_image']); ?>" alt="<?= esc($banner['banner_name']); ?>" class="w-full h-auto object-cover rounded-md" />
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

</div>



<?= $this->endSection(); ?>