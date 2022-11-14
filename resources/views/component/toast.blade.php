<div style="z-index=110" aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
  <div class="toast" style="position: fixed; top: 20%; right: 50;">
    <div class="toast-header">
      <strong class="mr-auto">通知</strong>
    </div>
    <div class="toast-body">
      新增成功
    </div>
  </div>
</div>
<script>
    closeToast = function () {
        $('.toast').fadeOut('fast');
    };

    openToast = function () {
        $('.toast').fadeIn('slow');
    };

    setInterval("closeToast()","3000");
</script>