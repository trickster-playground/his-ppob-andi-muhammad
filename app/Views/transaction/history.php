<?= $this->extend('layouts/main_view'); ?>

<?= $this->section('content'); ?>

<div class="page-transaction">

  <?= view('components/profile_balance') ?>

  <div class="flex flex-col justify-center items-start p-5 max-w-7xl mx-auto ">
    <div class="flex flex-col items-start mb-4">
      <h2 class="text-2xl font-semibold">Semua Transaksi</h2>
    </div>

    <div id="transaction-list" class="w-full space-y-2 ">

      <?php foreach ($transactions as $index => $transaction) : ?>
        <div class="border border-gray-300 rounded-md overflow-hidden">
          <button
            type="button"
            class="w-full flex flex-col items-start p-4 bg-white text-primary-content font-semibold focus:outline-none"
            onclick="toggleCollapse('collapse-<?= esc($transaction['invoice_number']) ?>', 'icon-<?= esc($transaction['invoice_number']) ?>')">

            <!-- Baris atas: nominal + deskripsi -->
            <div class="w-full flex justify-between items-center mb-1">
              <div class="<?= $transaction['transaction_type'] === 'PAYMENT' ? 'text-red-500' : 'text-green-500' ?> text-xl font-bold">
                <?= $transaction['transaction_type'] === 'PAYMENT' ? '-' : '+' ?> Rp <?= number_format($transaction['total_amount'], 0, ',', '.') ?>
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
              <svg id="icon-<?= esc($transaction['invoice_number']) ?>" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down transform transition-transform duration-300">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M6 9l6 6l6 -6" />
              </svg>
            </div>

          </button>

          <!-- Isi collapsible -->
          <div id="collapse-<?= esc($transaction['invoice_number']) ?>" class="hidden px-4 py-2 bg-gray-100 text-gray-700 text-sm">
            <p><strong>Invoice Number:</strong> <?= esc($transaction['invoice_number']) ?></p>
            <p><strong>Jenis Transaksi:</strong> <?= esc($transaction['transaction_type']) ?></p>
          </div>

        </div>
      <?php endforeach; ?>

    </div>

    <!-- Load More Button -->
    <button id="load-more-button" class="w-full py-2 bg-red-500 hover:bg-red-700 text-white font-semibold mt-4 rounded-md focus:outline-none" onclick="loadMoreTransactions()">
      Show More
    </button>

  </div>

</div>

<script>
  let offset = <?= $offset ?>;
  const limit = 5;

  function loadMoreTransactions() {
    const loadMoreButton = document.getElementById('load-more-button');
    loadMoreButton.disabled = true;
    loadMoreButton.textContent = 'Loading...';

    fetch('/transaction/loadMoreTransactions?offset=' + offset + '&limit=' + limit)
      .then(response => response.json())
      .then(data => {
        if (data.transactions.length > 0) {
          const transactionList = document.getElementById('transaction-list');
          data.transactions.forEach(transaction => {
            const transactionItem = document.createElement('div');

            const formattedAmount = new Intl.NumberFormat('id-ID', {
              style: 'currency',
              currency: 'IDR',
              minimumFractionDigits: 0,
            }).format(transaction.total_amount);

            transactionItem.classList.add('border', 'border-gray-300', 'rounded-md', 'overflow-hidden');
            transactionItem.innerHTML = `
            <button type="button" class="w-full flex flex-col items-start p-4 bg-white text-primary-content font-semibold focus:outline-none" onclick="toggleCollapse('collapse-${transaction.invoice_number}', 'icon-${transaction.invoice_number}')">
              <div class="w-full flex justify-between items-center mb-1">
                <div class="text-xl ${transaction.transaction_type === 'PAYMENT' ? 'text-red-500' : 'text-green-500'} font-bold">
                    ${transaction.transaction_type === 'PAYMENT' ? '-' : '+'} ${formattedAmount}
                </div>
                <div class="text-right">
                  ${transaction.description}
                </div>
              </div>
              <div class="w-full flex justify-between items-center text-sm text-gray-500">
               <div>${formatDate(transaction.created_on)} WIB</div>
                <svg id="icon-${transaction.invoice_number}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down transform transition-transform duration-300">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M6 9l6 6l6 -6" />
                </svg>
              </div>
            </button>
            <div id="collapse-${transaction.invoice_number}" class="hidden px-4 py-2 bg-gray-100 text-gray-700 text-sm">
              <p><strong>Invoice Number:</strong> ${transaction.invoice_number}</p>
              <p><strong>Jenis Transaksi:</strong> ${transaction.transaction_type}</p>
            </div>
          `;
            transactionList.appendChild(transactionItem);
          });

          // Update offset
          offset = data.offset;

          // Enable the button after loading
          loadMoreButton.disabled = false;
          loadMoreButton.textContent = 'Show More';
        } else {
          loadMoreButton.textContent = 'No more transactions';
          loadMoreButton.disabled = true;
        }
      })
      .catch(error => {
        console.error('Error loading transactions:', error);

        // Enable the button and set the text back to "Load More"
        loadMoreButton.disabled = false;
        loadMoreButton.textContent = 'Error! Show more';
      });
  }

  function formatDate(dateString) {
    const formattedDate = new Date(dateString);
    const day = formattedDate.getDate().toString().padStart(2, '0');
    const month = formattedDate.toLocaleString('id-ID', {
      month: 'long'
    });
    const year = formattedDate.getFullYear();
    const hours = formattedDate.getHours().toString().padStart(2, '0');
    const minutes = formattedDate.getMinutes().toString().padStart(2, '0');
    return `${day} ${month} ${year} ${hours}:${minutes}`;
  }

  function toggleCollapse(idCollapse, idIcon) {
    const content = document.getElementById(idCollapse);
    const icon = document.getElementById(idIcon);
    if (content.classList.contains('hidden')) {
      content.classList.remove('hidden');
      icon.classList.add('rotate-90');
    } else {
      content.classList.add('hidden');
      icon.classList.remove('rotate-90');
    }
  }
</script>

<?= $this->endSection(); ?>