<?php
$icons = [
  'success' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>',
  'error' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>',
  'warning' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856C18.07 18.376 18 17.699 18 17a6 6 0 10-12 0c0 .699-.07 1.376-.208 2z" />
                  </svg>',
];

$alertClasses = [
  'success' => 'alert-success',
  'error'    => 'alert-error',
  'warning'  => 'alert-warning',
];
?>

<?php foreach (['success', 'error', 'warning'] as $type): ?>
  <?php $message = session()->getFlashdata($type); ?>
  <?php if ($message): ?>
    <div class="fixed ml-2 top-4 left-1/2 -translate-x-1/2 z-50 w-auto mx-auto px-4">
      <div id="alert-<?= $type ?>" role="alert" class="bg-blue-500 text-white p-4 rounded-md shadow-lg flex items-center gap-2">
        <?= $icons[$type] ?? '' ?>
        <span><?= esc($message) ?></span>
      </div>
    </div>




    <script>
      setTimeout(() => {
        const alert = document.getElementById('alert-<?= $type ?>');
        if (alert) {
          alert.style.opacity = '0';
          setTimeout(() => alert.remove(), 500);
        }
      }, 3000);
    </script>
  <?php endif; ?>
<?php endforeach; ?>