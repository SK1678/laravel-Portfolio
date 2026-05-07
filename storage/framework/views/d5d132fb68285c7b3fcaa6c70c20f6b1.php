<?php echo $__env->make('admin.include.adminHeader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!-- MAIN CONTENT -->
<main id="content" class="content py-10" style="padding-bottom: 0px !important;">
  <div class="container-fluid">
    <?php echo $__env->yieldContent('content'); ?>

    <div class="row " style="background:lavender; margin-top: 20px;">
      <div class="col-12">
        <footer class="text-center py-2 mt-3 mb-2 text-secondary ">
          <p class="mb-0">Copyright © 2026 Lavender CMS. Developed by <a href="mailto:sarkarmeher1999@gmail.com"
              target="_blank" class="text-primary">Meher Kanti Sarkar</a> </p>
        </footer>
      </div>
    </div>
  </div>
</main>
<?php echo $__env->make('admin.include.adminFooter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/layouts/admin.blade.php ENDPATH**/ ?>