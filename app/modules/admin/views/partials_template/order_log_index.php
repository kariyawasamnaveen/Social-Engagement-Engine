<?php 
  $show_search_area = show_search_area($controller_name, $params, 'user');
?>
<div class="lists-index-ajax">
  <?php include('ajax_index_overplay.php'); ?>

  <div class="page-title mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
      <!-- Title & Add New Button -->
      <div class="d-flex align-items-center justify-content-between w-100">
        <div class="d-flex align-items-center">
          <span class="d-flex align-items-center justify-content-center mr-3" style="width: 44px; height: 44px; background: rgba(0, 240, 255, 0.08); border: 1px solid rgba(0, 240, 255, 0.2); border-radius: 12px; color: #00F0FF; box-shadow: 0 4px 15px rgba(0, 240, 255, 0.1);">
            <i class="fe fe-calendar" style="font-size: 20px;"></i>
          </span>
          <h1 class="page-title mb-0" style="font-size: 22px; font-weight: 700; color: #fff;">
            <?=lang($controller_name)?>
          </h1>
        </div>
        <a href="<?=cn("order/new_order")?>" class="btn btn-outline-primary btn-pill px-4 py-2 d-flex align-items-center" style="font-size: 13px; font-weight: 700; gap: 6px; box-shadow: 0 4px 15px rgba(0, 240, 255, 0.05);">
          <i class="fe fe-plus" style="font-size: 14px;"></i>
          <span><?=lang("add_new")?></span>
        </a>
      </div>
    </div>
    
    <!-- Filters & Search Bar Row -->
    <div class="row mt-4 align-items-center justify-content-between g-3">
      <div class="col-md-9" id="btn-filter-group">
        <!-- Loaded dynamically via AJAX -->
      </div>
      <div class="col-md-3">
        <div class="d-flex search-area justify-content-md-end w-100">
          <?php echo $show_search_area; ?>
        </div>
      </div>
    </div>
  </div>
 
  <!-- Orders List Table Card wrapper -->
  <?php $this->load->view('table_blade.php'); ?>
</div>
