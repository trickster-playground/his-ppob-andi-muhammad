<?= $this->extend('layouts/main_view'); ?>

<?= $this->section('content'); ?>

<div class="">
  <?php if (session()->has('success') && session()->has('nominal')) : ?>
    <?= view('components/modal', [
      'id' => 'topup_success_modal',
      'icon' => 'assets/images/Checked.svg',
      'title' => 'Top Up sebesar',
      'message' => session('success'),
      'nominal' => session('nominal'),
    ]) ?>
  <?php endif; ?>
  <?php if (session()->has('error')) : ?>
    <?= view('components/modal', [
      'id' => 'topup_error_modal',
      'icon' => 'assets/images/Cancel.svg',
      'title' => 'Top Up sebesar',
      'message' => session('error'),
      'nominal' => session('nominal'),
    ]) ?>
  <?php endif; ?>

  <?= view('components/profile_balance') ?>

  <div class="flex flex-col justify-center items-start p-5 max-w-7xl mx-auto">
    <div class="flex flex-col items-start">
      <h2 class="text-xl">Silahkan masukkan</h2>
      <h3 class="text-4xl font-semibold">Nominal Top Up</h3>
    </div>
  </div>

  <div class="max-w-7xl mx-auto p-5 pr-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
    <!-- Kolom Kiri: Form -->
    <form action="<?= site_url('/topup') ?>" method="post" class="flex flex-col gap-4">
      <?= csrf_field() ?>

      <!-- Input Nominal -->
      <?= view('components/input_field', [
        'icon' => view('components/icons/credit'),
        'type' => 'text',
        'placeholder' => 'Input Nominal',
        'name' => 'nominal',
        'id' => 'input-nominal',
      ]) ?>

      <!-- Tombol Submit -->
      <button id="open-confirm-modal" type="button" class="btn w-full bg-red-600 text-white rounded px-4 py-2 hover:bg-red-700 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
        Top Up
      </button>
    </form>

    <!-- Kolom Kanan: Quick Amount Buttons -->
    <div class="grid grid-cols-3 gap-2">
      <button type="button" data-amount="10000" class="btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
        Rp10.000
      </button>
      <button type="button" data-amount="20000" class="btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
        Rp20.000
      </button>
      <button type="button" data-amount="50000" class="btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
        Rp50.000
      </button>
      <button type="button" data-amount="100000" class="btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
        Rp100.000
      </button>
      <button type="button" data-amount="250000" class="btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
        Rp250.000
      </button>
      <button type="button" data-amount="500000" class="btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
        Rp500.000
      </button>
    </div>
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
        <p>Anda yakin untuk Topup sebesar</p>
        <p class="text-2xl font-bold">
          <span id="confirm-nominal-text">Rp0</span><span>?</span>
        </p>
      </div>

      <!-- Action Buttons -->
      <div class="modal-action flex flex-col gap-2 mt-4">
        <button id="confirm-topup-btn" class="btn text-red-500 hover:text-red-700 w-full font-semibold">
          Ya, Lanjutkan Topup
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
  const quickButtons = document.querySelectorAll('.btn-quick');
  const inputNominal = document.getElementById('input-nominal');
  const openConfirmModalBtn = document.getElementById('open-confirm-modal');
  const confirmTopupBtn = document.getElementById('confirm-topup-btn');
  const confirmNominalText = document.getElementById('confirm-nominal-text');
  const topupForm = document.querySelector('form');

  function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(angka);
  }

  function validateNominal() {
    const value = parseInt(inputNominal.value.replace(/\D/g, ''), 10);
    if (!isNaN(value) && value >= 10000 && value <= 1000000) {
      openConfirmModalBtn.disabled = false;
    } else {
      openConfirmModalBtn.disabled = true;
    }
  }

  quickButtons.forEach(button => {
    button.addEventListener('click', () => {
      const amount = button.getAttribute('data-amount');
      inputNominal.value = amount;
      validateNominal();
    });
  });

  inputNominal.addEventListener('input', validateNominal);

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