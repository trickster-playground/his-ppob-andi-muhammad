<?php
$eyeIcon = '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>';

$eyeOffIcon = '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>';
?>

<?php $inputId = 'input_' . esc($name ?? uniqid()); ?>
<div class="relative w-full">
  <?php if (!empty($icon)): ?>
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
      <?= $icon ?>
    </div>
  <?php endif; ?>

  <input
    id="<?= $inputId ?>"
    type="<?= esc($type ?? 'text') ?>"
    name="<?= esc($name ?? '') ?>"
    placeholder="<?= esc($placeholder ?? '') ?>"
    value="<?= esc($value ?? '') ?>"
    class="w-full border border-gray-300 rounded-md p-3 <?= (!empty($icon) ? 'pl-12' : 'pl-4') ?> focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300" />

  <?php if (($type ?? '') === 'password'): ?>
    <button
      type="button"
      onclick="togglePassword('<?= $inputId ?>', this)"
      class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition">
      <span class="toggle-eye">
        <?= $eyeIcon ?>
      </span>
    </button>
  <?php elseif (!empty($kbd)): ?>
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center space-x-1">
      <?php foreach ($kbd as $key): ?>
        <kbd class="kbd kbd-xl"><?= esc($key) ?></kbd>
      <?php endforeach; ?>
    </div>
  <?php elseif (!empty($badge)): ?>
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
      <span class="badge badge-neutral badge-xl"><?= esc($badge) ?></span>
    </div>
  <?php endif; ?>
</div>

<script>
  function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const eyeWrapper = btn.querySelector('.toggle-eye');

    const eyeSVG = `<?= addslashes($eyeIcon) ?>`;
    const eyeOffSVG = `<?= addslashes($eyeOffIcon) ?>`;

    if (input.type === 'password') {
      input.type = 'text';
      eyeWrapper.innerHTML = eyeOffSVG;
    } else {
      input.type = 'password';
      eyeWrapper.innerHTML = eyeSVG;
    }
  }
</script>