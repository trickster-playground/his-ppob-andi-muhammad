<dialog id="<?= esc($id) ?>" class="modal">
  <div class="modal-box text-center max-w-sm">
    <div class="flex justify-center mb-4">
      <img src="<?= base_url($icon) ?>" alt="Icon" class="w-12 h-12">
    </div>
    <h3 class="text-lg "><?= esc($title) ?></h3>

    <?php if (!empty($nominal)) : ?>
      <p class="text-3xl font-bold mb-2">Rp<?= number_format($nominal, 0, ',', '.') ?></p>
    <?php endif; ?>

    <p class="mb-4"><?= esc($message) ?></p>

    <div class="modal-action justify-center">
      <a href="/homepage" class="btn text-lg text-red-500 hover:text-red-700 font-bold">
        Kembali ke Beranda
      </a>
    </div>
  </div>
</dialog>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('<?= esc($id) ?>');
    if (modal) {
      modal.showModal();
    }
  });
</script>