<?= $this->extend('layouts/main_view'); ?>

<?= $this->section('content'); ?>

<div class="">
  <?php if (session()->has('success')) : ?>
    <?= view('components/modal', [
      'id' => 'payment_success_modal',
      'icon' => 'assets/images/Checked.svg',
      'title' => 'Pembayaran ' . session('service_name') . ' sebesar',
      'message' => session('success'),
      'nominal' => session('total_amount'),
    ]) ?>
  <?php endif; ?>

  <?php if (session()->has('error')) : ?>
    <?= view('components/modal', [
      'id' => 'payment_error_modal',
      'icon' => 'assets/images/Cancel.svg',
      'title' => 'Pembayaran ' . session('service_name') . ' sebesar',
      'message' => session('error'),
      'nominal' => session('total_amount'),
    ]) ?>
  <?php endif; ?>


  <?= view('components/profile_balance') ?>

  <div class="flex flex-col justify-center items-start p-5 max-w-7xl mx-auto">
    <div class="flex flex-col items-start">
      <h2 class="text-xl">Pembayaran</h2>
      <div class="flex justify-center items-center gap-2 mt-2">
        <img src="<?= esc($service['service_icon']); ?>" alt="<?= esc($service['service_name']); ?>" class="w-18 h-18 mb-2 object-cover" />
        <h3 class="text-4xl font-semibold"><?= esc($service['service_name']); ?></h3>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto p-5 pr-8">
    <form action="<?= site_url('/transaction') ?>" method="post" class="flex flex-col gap-4">
      <?= csrf_field() ?>

      <input type="hidden" name="service_code" value="<?= esc($service['service_code']) ?>">

      <!-- Input Nominal (readonly) -->
      <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
          <?= view('components/icons/credit') ?>
        </div>
        <input
          type="text"
          name="nominal"
          id="input-nominal"
          class="pl-10 pr-4 py-2 w-full border rounded focus:outline-none focus:ring-2 focus:ring-red-500"
          value="<?= number_format($service['service_tariff'], 0, ',', '.') ?>"
          readonly>
      </div>

      <!-- Tombol Submit -->
      <button id="open-confirm-modal" type="button" class="btn w-full bg-red-600 text-white rounded px-4 py-2 hover:bg-red-700">
        Bayar
      </button>
    </form>
  </div>

  <!-- Modal Konfirmasi Topup -->
  <dialog id="modal-confirm-topup" class="modal">
    <div class="modal-box text-center max-w-sm p-6 space-y-4">
      <!-- Logo -->
      <div class="flex justify-center">
        <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo" class="w-12 h-12">
      </div>

      <!-- Text -->
      <div class="space-y-2">
        <p>Beli
          <span><?= esc($service['service_name']); ?></span>
          senilai
        </p>
        <p class="text-2xl font-bold">
          <span id="confirm-nominal-text">Rp0</span><span>?</span>
        </p>
      </div>

      <!-- Action Buttons -->
      <div class="modal-action flex flex-col gap-2 mt-4">
        <button id="confirm-topup-btn" class="btn text-red-500 hover:text-red-700 w-full font-semibold">
          Ya, Lanjutkan Pembayaran
        </button>
        <form method="dialog" class="w-full">
          <button class="btn w-full">
            Batalkan
          </button>
        </form>
      </div>
    </div>
  </dialog>

</div>

<script>
  const openConfirmModalBtn = document.getElementById('open-confirm-modal');
  const confirmTopupBtn = document.getElementById('confirm-topup-btn');
  const confirmNominalText = document.getElementById('confirm-nominal-text');
  const topupForm = document.querySelector('form');
  const inputNominal = document.getElementById('input-nominal');

  function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(angka);
  }

  openConfirmModalBtn.addEventListener('click', () => {
    const nominal = parseInt(inputNominal.value.replace(/\D/g, ''), 10) || 0;
    confirmNominalText.textContent = formatRupiah(nominal);
    const modal = document.getElementById('modal-confirm-topup');
    modal.showModal();
  });

  confirmTopupBtn.addEventListener('click', () => {
    topupForm.submit();
  });
</script>

<?= $this->endSection(); ?>