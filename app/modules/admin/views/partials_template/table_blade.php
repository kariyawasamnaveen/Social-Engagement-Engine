<style> 
  .table-responsive td,
  .table-responsive td a {
    white-space: normal !important;
    word-break: break-word !important;
    overflow-wrap: break-word !important;
    max-width: 300px;
  }
  .table-responsive .dropdown-menu > a {
    white-space: nowrap !important;
  }
</style>

<div class="row mt-3">
  <div class="col-12">
    <div class="card p-4" style="background: rgba(20, 20, 24, 0.4); border: 1px solid var(--border-dim); border-radius: 24px; backdrop-filter: blur(15px);">
        <div class="card-header border-bottom-0 pb-4 pt-0 px-0 d-flex justify-content-between align-items-center">
            <h3 class="card-title text-white mb-0" style="font-size: 16px; font-weight: 700;"><?=lang("Lists")?></h3>
        </div>
        
        <div class="table-responsive" style="border-radius: 14px; overflow: hidden; border: 1px solid var(--border-dim); background: rgba(10, 10, 12, 0.2);">
            <table class="<?= get_table_class(); ?> mb-0" style="background: transparent;">
                <?php echo $table_thead_html; ?>
                <tbody id="table-body">
                    <!-- Loaded dynamically via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
  </div>
  
  <div class="col-12 mt-3" id="pagination">
    <!-- Loaded dynamically via AJAX -->
  </div>
</div>
