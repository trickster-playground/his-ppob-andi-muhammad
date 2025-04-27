<?= $this->extend('layouts/main_view'); ?>

<?= $this->section('content'); ?>

<div>

  <?php include('components/profile_balance.php'); ?>

  <div class="flex flex-col justify-center items-start p-5 max-w-7xl mx-auto">
    <div class="flex flex-col items-start mb-4">
      <h2 class="text-2xl font-semibold">Semua Transaksi</h2>
    </div>

    <div class="w-full space-y-2">

      <?php foreach ($transactions as $index => $transaction) : ?>
        <div class="border border-gray-300 rounded-md overflow-hidden">
          <button
            type="button"
            class="w-full flex flex-col items-start p-4 bg-white text-primary-content font-semibold focus:outline-none"
            onclick="toggleCollapse('collapse-<?= $index ?>')">

            <!-- Baris atas: nominal + deskripsi -->
            <div class="w-full flex justify-between items-center mb-1">
              <div class="text-xl text-green-500 font-bold">
                + Rp<?= number_format($transaction['total_amount'], 0, ',', '.') ?>
              </div>
              <div class="text-right">
                <?= esc($transaction['description']) ?>
              </div>
            </div>

            <!-- Baris bawah: tanggal + icon -->
            <div class="w-full flex justify-between items-center text-sm text-gray-500">
              <div>
                <?= date('d F Y H:i', strtotime($transaction['created_on'])) ?> WIB
              </div>
              <svg id="icon-<?= $index ?>" class="w-4 h-4 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>

          </button>

          <!-- Isi collapsible -->
          <div id="collapse-<?= $index ?>" class="hidden px-4 py-2 bg-gray-100 text-gray-700 text-sm">
            <p><strong>Invoice Number:</strong> <?= esc($transaction['invoice_number']) ?></p>
            <p><strong>Jenis Transaksi:</strong> <?= esc($transaction['transaction_type']) ?></p>
          </div>

        </div>
      <?php endforeach; ?>

    </div>

  </div>

</div>

<script>
  function toggleCollapse(id) {
    const content = document.getElementById(id);
    const icon = document.getElementById('icon-' + id.split('-')[1]);
    if (content.classList.contains('hidden')) {
      content.classList.remove('hidden');
      icon.classList.add('rotate-180');
    } else {
      content.classList.add('hidden');
      icon.classList.remove('rotate-180');
    }
  }
</script>

<?= $this->endSection(); ?>