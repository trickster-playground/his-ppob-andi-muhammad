<?= $this->extend('layouts/main_view'); ?>

<?= $this->section('content'); ?>
<div class="">
  <?= view('components/alert') ?>

  <?php
  include('components/profile_balance.php');
  ?>

  <div class="flex flex-col justify-center items-start p-5 max-w-7xl mx-auto">
    <div class=" flex flex-col items-start">
      <h2 class="text-xl ">Silahkan masukkan</h2>
      <h3 class="text-4xl font-semibold ">Nominal Top Up</h3>
    </div>
  </div>

  <div class="flex flex-col gap-4 max-w-7xl mx-auto p-5 pr-8">
    <!-- Baris 1 -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
      <!-- Input Nominal -->
      <div class="flex-1">
        <?= view('components/input_field', [
          'icon' => view('components/icons/credit'),
          'type' => 'text',
          'placeholder' => 'Input Nominal',
          'name' => 'nominal', // << tambahkan ini
          'id' => 'input-nominal', // << tambahkan ini
        ]) ?>
      </div>
      <!-- Tombol quick select -->
      <div class="flex flex-1 gap-2">
        <button type="button" data-amount="10000" class="flex-1 btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
          Rp10.000
        </button>
        <button type="button" data-amount="20000" class="flex-1 btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
          Rp20.000
        </button>
        <button type="button" data-amount="50000" class="flex-1 btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
          Rp50.000
        </button>
      </div>
    </div>

    <!-- Baris 2 -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
      <!-- Tombol Submit -->
      <button id="submit-nominal" class="flex-1 max-w-[610px] bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">
        Submit
      </button>
      <!-- Tombol quick select -->
      <div class="flex flex-1 gap-2">
        <button type="button" data-amount="100000" class="flex-1 btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
          Rp100.000
        </button>
        <button type="button" data-amount="250000" class="flex-1 btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
          Rp250.000
        </button>
        <button type="button" data-amount="500000" class="flex-1 btn-quick bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
          Rp500.000
        </button>
      </div>
    </div>
  </div>

</div>

<script>
  // Ambil semua tombol quick select dan input field
  const quickButtons = document.querySelectorAll('.btn-quick');
  const inputNominal = document.getElementById('input-nominal');

  quickButtons.forEach(button => {
    button.addEventListener('click', () => {
      // Ambil nilai dari atribut data-amount tombol yang diklik
      const amount = button.getAttribute('data-amount');
      // Isi nilai ke input field
      inputNominal.value = amount;
    });
  });
</script>

<?= $this->endSection(); ?>