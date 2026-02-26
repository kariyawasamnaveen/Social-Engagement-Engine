<!-- NEW ORDER PAGE OVERHAUL -->
<?php
  $filter_categories = [];
  if (!empty($items_service) && !empty($items_category)) {
    $filter_categories = filter_items_by_category($items_category, $items_service);
  }
?>

<div class="row m-t-10">
  <div class="col-md-12">
    <div class="tabs-list mb-4">
      <ul class="nav nav-pills justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#new_order"><?=lang("single_order")?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#mass_order"><?=lang("mass_order")?></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-md-10 col-xl-10">
    <div class="tab-content">
      <div id="new_order" class="tab-pane fade in active show">
        <form class="form actionForm" action="<?=cn($controller_name . "/ajax_add_order")?>" data-redirect="<?=cn('new_order')?>" method="POST">
          <div class="row">
            <div class="col-md-7">
              <div class="card p-4">
                <div class="card-header pb-4 pt-0 px-0">
                  <h4 class="card-title text-white mb-0"><?=lang('add_new')?></h4>
                </div>
                <div class="card-body p-0">
                  <!-- Success Message -->
                  <?php $this->load->view('child/order_message_success'); ?>

                  <div class="form-group">
                    <label for=""><?= lang('Search_for_'); ?></label>
                    <select name="search_service_id" class="ajaxSearchService input-search-service form-control custom-select" placeholder="Search for...">
                      <option value=""></option>
                      <?php
                        if ($items_service) {
                          $currency_symbol = get_option('currency_symbol');

                          usort($items_service, function($a, $b) {
                            return $a['id'] - $b['id'];
                          });

                          foreach ($items_service as $key => $service) {
                            $service_rate = $currency_symbol. (double)$service['price'];
                            $service_name = sprintf('%s - %s [%s]', $service['id'], $service['name'], $service_rate);
                            $option = sprintf('<option value="%s"> %s</option>', $service['id'], $service_name);
                            echo $option;
                          }
                        } 
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label><?=lang("Category")?></label>
                    <select name="category_id" class="form-control square ajaxChangeCategory">
                      <?php if (!empty($filter_categories)):?>      
                        <?php foreach ($filter_categories as $key => $category) : ?>
                          <option value="<?=$category['id']?>"><?=$category['name']; ?></option>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <option> <?=lang("choose_a_category")?></option>
                      <?php endif;?>
                    </select>
                  </div>

                  <div class="form-group" id="result_onChange">
                    <label><?=lang("order_service")?></label>
                    <select name="service_id" class="form-control square ajaxChangeService">
                    </select>
                  </div>

                  <!-- Min/max on responsive d-md-none-->
                  <div class="row d-none">
                    <div class="col-md-4  col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("minimum_amount")?></label>
                        <input class="form-control square" name="service_min" type="text" value="" readonly>
                      </div>
                    </div>

                    <div class="col-md-4  col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("maximum_amount")?></label>
                        <input class="form-control square" name="service_max" type="text" value="" readonly>
                      </div>
                    </div>

                    <div class="col-md-4  col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("price_per_1000")?></label>
                        <input class="form-control square" name="service_price" type="text" value="" readonly>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group order-default-link">
                    <label><?=lang("Link")?></label>
                    <input class="form-control square" type="text" name="link" placeholder="https://" id="">
                  </div>

                  <div class="form-group order-default-quantity">
                    <label><?=lang("Quantity")?></label>
                    <input class="form-control square ajaxQuantity" name="quantity" type="number">
                  </div>

                  <div class="form-group order-default-speed">
                    <label><?=lang("delivery_speed")?></label>
                    <select name="speed" class="form-control square">
                      <option value="instant"><?=lang("Instant")?> (Standard)</option>
                      <option value="organic"><?=lang("Organic")?> (Safe)</option>
                      <option value="slow"><?=lang("Slow")?> (Most Organic)</option>
                    </select>
                  </div>
                  
                  <div class="form-group order-comments d-none">
                    <label for=""><?=lang("Comments")?> <?php lang('1_per_line')?></label>
                    <textarea  rows="10" name="comments" class="form-control square ajax_custom_comments"></textarea>
                  </div> 

                  <div class="form-group order-comments-custom-package d-none">
                    <label for=""><?=lang("Comments")?> <?php lang('1_per_line')?></label>
                    <textarea  rows="10" name="comments_custom_package" class="form-control square"></textarea>
                  </div>

                  <div class="form-group order-usernames d-none">
                    <label for=""><?=lang("Usernames")?></label>
                    <input type="text" class="form-control input-tags" name="usernames" value="usenameA,usenameB,usenameC,usenameD">
                  </div>

                  <div class="form-group order-usernames-custom d-none">
                    <label for=""><?=lang("Usernames")?> <?php lang('1_per_line')?></label>
                    <textarea  rows="10" name="usernames_custom" class="form-control square ajax_custom_lists"></textarea>
                  </div>

                  <div class="form-group order-hashtags d-none">
                    <label for=""><?=lang("hashtags_format_hashtag")?></label>
                    <input type="text" class="form-control input-tags" name="hashtags" value="#goodphoto,#love,#nice,#sunny">
                  </div>

                  <div class="form-group order-hashtag d-none">
                    <label for=""><?=lang("Hashtag")?> </label>
                    <input class="form-control square" type="text" name="hashtag">
                  </div>

                  <div class="form-group order-username d-none">
                    <label for=""><?=lang("Username")?></label>
                    <input class="form-control square" name="username" type="text">
                  </div>   
                  
                  <!-- Mentions Media Likers -->
                  <div class="form-group order-media d-none">
                    <label for=""><?=lang("Media_Url")?></label>
                    <input class="form-control square" name="media_url" type="link">
                  </div>

                  <!-- Subscriptions  -->
                  <?php $this->load->view('child/order_subscriptions', ['controller_name' => $controller_name]); ?>
                 
                  <!-- Dripfeeed -->
                  <?php
                      $this->load->view('child/order_dripfeed', ['controller_name' => $controller_name]);
                  ?>

                  <div class="form-group" id="result_total_charge">
                    <input type="hidden" name="total_charge" value="0.00">
                    <p class="btn btn-info total_charge mt-3"><?=lang("total_charge")?>
                      <?=get_option("currency_sumbol", '$')?><span class="charge_number">0</span>
                    </p>
                    <div class="alert alert-icon alert-danger d-none" role="alert">
                      <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i><?=lang("order_amount_exceeds_available_funds")?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="agree">
                      <span class="custom-control-label text-uppercase"><?=lang("yes_i_have_confirmed_the_order")?></span>
                    </label>
                  </div>

                  <div class="form-actions left">

                    <button type="submit" class="btn btn-primary btn-spinner-border mr-1 mb-1 btn-block btn-lg">
                      <?=lang("place_order")?>
                    </button>

                  </div>
              </div>
            </div>  

            <!-- Order Resume -->
            <?php require_once ('child/order_resume.php'); ?>
          </div>
        </form>
      </div>
      <div id="mass_order" class="tab-pane fade">
        <div class="card p-4">
          <?php $this->load->view('child/mass_order', ['controller_name' => $controller_name]); ?>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
  if (get_option('enable_attentions_orderpage')) $this->load->view('child/order_guide', []); 
?>


<script>
  $(function(){
    $('.datepicker').datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
      startDate: truncateDate(new Date())
    });
    $(".datepicker").datepicker().datepicker("setDate", new Date());

    function truncateDate(date) {
      return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

    $('.input-tags').selectize({
        delimiter: ',',
        persist: false,
        create: function (input) {
            return {
              value: input,
              text: input
            }
        }
    });
  });
</script>

<!-- category filter -->
<?php
  $excluded_keywords = array_keys(app_config('social_media'));
  unset($excluded_keywords[array_search('everything', $excluded_keywords)]);
  unset($excluded_keywords[array_search('other', $excluded_keywords)]);
?>
<script>
  const categories = <?php echo json_encode($filter_categories, JSON_UNESCAPED_UNICODE); ?>;
  const excludedKeywords = <?php echo json_encode(array_values($excluded_keywords)); ?>;
  const app_currency_symbol = "<?php echo get_option("currency_sumbol", '$'); ?>";
  const services_list = <?php echo json_encode($items_service, JSON_UNESCAPED_UNICODE); ?>;
  const lang = {
    hours: "<?=lang('hours')?>",
    minutes: "<?=lang('minutes')?>",
    seconds: "<?=lang('seconds')?>",
    notEnoughData: "<?=lang('Not_enough_data')?>"
  };

  
</script>
