<?php 
  $show_search_area = show_search_area($controller_name, $params, 'user');
?>
<div class="lists-index-ajax">
  <?php include('ajax_index_overplay.php'); ?>

  <div class="page-title m-b-20">
    <div class="row justify-content-between">
      <div class="col-md-2">
        <h1 class="page-title">
          <span class="fe fe-calendar"></span> <?=lang($controller_name)?>
        </h1>
      </div>
      <div class="col-md-4">
        <div class="d-flex">
          <a href="<?=cn("order/new_order")?>" class="ml-auto btn btn-outline-primary">
            <span class="fe fe-plus"></span>
              <?=lang("add_new")?>
          </a>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row justify-content-between">
          <div class="col-md-10"  id="btn-filter-group">
            
          </div>
          <div class="col-md-2">
            <div class="d-flex search-area">
              <?php echo $show_search_area; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  <?php 
    $this->load->view('table_blade.php'); 
  ?>
</div>
