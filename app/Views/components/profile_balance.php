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
        <h2 class="text-xl ">Selamat Datang,</h2>
        <h3 class="text-4xl font-semibold "><?= session()->get('first_name') ?? 'Nama Depan'; ?> <?= session()->get('last_name') ?? 'Nama Belakang'; ?></h3>
      </div>
    </div>

    <?php include('icons/eye.php'); ?>

    <!-- Banner Saldo -->
    <div class="flex-none w-3/5 relative">
      <img src="<?= base_url('assets/images/Background Saldo.png'); ?>" alt="Banner" class="w-full h-auto rounded-lg" />

      <!-- Informasi -->
      <div class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-start p-6 text-white">
        <div class="text-lg font-semibold">Saldo Anda</div>
        <div id="balance-amount" class="text-2xl font-bold mt-2">
          Rp. **********
        </div>

        <button id="toggle-balance" class="flex items-center gap-2 mt-6 text-sm bg-white text-black px-3 py-1 rounded-full shadow">
          <span id="toggle-text">Lihat Saldo</span>
          <span id="eye-icon">
            <?= $eyeOffIcon; ?>
          </span>
        </button>
      </div>
    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const balanceAmount = document.getElementById('balance-amount');
      const toggleButton = document.getElementById('toggle-balance');
      const toggleText = document.getElementById('toggle-text');
      const eyeIcon = document.getElementById('eye-icon');

      let isHidden = true;

      toggleButton.addEventListener('click', () => {
        isHidden = !isHidden;

        if (isHidden) {
          balanceAmount.textContent = 'Rp. **********';
          toggleText.textContent = 'Lihat Saldo';
          eyeIcon.innerHTML = '<?= $eyeOffIcon; ?>';
        } else {
          balanceAmount.textContent = 'Rp. <?= number_format($balance, 0, ',', '.') ?>';
          toggleText.textContent = 'Tutup Saldo';
          eyeIcon.innerHTML = '<?= $eyeIcon; ?>';
        }
      });
    });
  </script>