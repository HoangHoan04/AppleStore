<script>
<?php if(isset($_SESSION['message']))
  {
  ?>
alertify.set('notifier', 'position', 'top-right');
alertify.success('<?= $_SESSION['message'] ?>');
<?php 
  unset($_SESSION['message']);
  }
  ?>
</script>