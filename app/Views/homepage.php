<?= $this->extend('layouts/main_view'); ?>

<?= $this->section('content'); ?>
<div>
  <?= view('components/alert') ?>

  <?= view('components/profile_balance') ?>

  <!-- Services -->
  <div class="mt-6 max-w-7xl mx-auto p-4">
    <h1 class="text-lg font-semibold mb-4">Layanan Kami</h1>
    <div class="grid grid-cols-12 gap-2">
      <?php foreach ($services as $service): ?>
        <a href="<?= site_url('transaction/payment/' . $service['service_code']) ?>" class="flex flex-col items-center col-span-1 hover:bg-gray-100 p-2 rounded-md transition">
          <img src="<?= esc($service['service_icon']); ?>" alt="<?= esc($service['service_name']); ?>" class="w-18 h-18 mb-2 object-cover" />
          <span class="text-center text-sm"><?= esc($service['service_name']); ?></span>
        </a>
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