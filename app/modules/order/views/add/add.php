<?php
  $filter_categories = [];
  if (!empty($items_service) && !empty($items_category)) {
    $filter_categories = filter_items_by_category($items_category, $items_service);
  }
?>

<!-- Visual Platform Selection Bar -->
<div class="platform-selector-container mb-4">
  <p class="text-muted mb-2 px-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; font-weight: 700;">Select Platform</p>
  <div class="d-flex align-items-center platform-scroll-wrapper" style="overflow-x: auto; overflow-y: hidden; white-space: nowrap; gap: 4px; padding: 8px 6px;">
    <button type="button" class="btn platform-select-btn active" data-platform="all">
      <i class="fa fa-globe"></i> <span>All Platforms</span>
    </button>
    <button type="button" class="btn platform-select-btn" data-platform="tiktok">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 4px; margin-top: -2px;"><path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/></svg> <span>TikTok</span>
    </button>
    <button type="button" class="btn platform-select-btn" data-platform="instagram">
      <i class="fa fa-instagram"></i> <span>Instagram</span>
    </button>
    <button type="button" class="btn platform-select-btn" data-platform="youtube">
      <i class="fa fa-youtube-play"></i> <span>YouTube</span>
    </button>
    <button type="button" class="btn platform-select-btn" data-platform="facebook">
      <i class="fa fa-facebook-official"></i> <span>Facebook</span>
    </button>
    <button type="button" class="btn platform-select-btn" data-platform="twitter">
      <i class="fa fa-twitter"></i> <span>Twitter</span>
    </button>
    <button type="button" class="btn platform-select-btn" data-platform="telegram">
      <i class="fa fa-paper-plane"></i> <span>Telegram</span>
    </button>
    <button type="button" class="btn platform-select-btn" data-platform="spotify">
      <i class="fa fa-spotify"></i> <span>Spotify</span>
    </button>
    <button type="button" class="btn platform-select-btn" data-platform="other">
      <i class="fa fa-ellipsis-h"></i> <span>Others</span>
    </button>
  </div>
</div>

<div class="row m-t-10">
  <div class="col-md-12 mb-4">
    <div class="tabs-list d-flex justify-content-start" style="border-bottom: 1px solid var(--border-dim); padding-bottom: 1px;">
      <ul class="nav nav-tabs border-0" style="gap: 15px;">
        <li class="nav-item">
          <a class="nav-link active py-2 px-3" data-toggle="tab" href="#new_order" style="border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; border: none; color: var(--text-muted); background: transparent; transition: all 0.3s;"><?=lang("single_order")?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link py-2 px-3" data-toggle="tab" href="#mass_order" style="border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; border: none; color: var(--text-muted); background: transparent; transition: all 0.3s;"><?=lang("mass_order")?></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="tab-content">
  <!-- Single Order Tab -->
  <div id="new_order" class="tab-pane fade in active show">
    <form class="form actionForm" action="<?=cn($controller_name . "/ajax_add_order")?>" data-redirect="<?=cn('new_order')?>" method="POST">
      <div class="row g-4">
        
        <!-- Left Column: Form Fields -->
        <div class="col-lg-7 mb-4">
          <div class="custom-card-box p-4 position-relative" style="background: rgba(20, 20, 24, 0.5) !important; border: 2px solid rgba(255, 0, 127, 0.6) !important; box-shadow: 0 0 25px rgba(255, 0, 127, 0.3), inset 0 0 15px rgba(255, 0, 127, 0.1) !important; border-radius: 24px !important; backdrop-filter: blur(20px) !important; overflow: visible !important;">
            
            <div class="border-bottom-0 pb-4 pt-0 px-0">
              <h4 class="text-white mb-0" style="font-size: 18px; font-weight: 700;"><?=lang('add_new')?></h4>
            </div>
            
            <div class="p-0">
              <!-- Success Message Banner -->
              <?php $this->load->view('child/order_message_success'); ?>

              <!-- Search Service Field -->
              <div class="form-group mb-4">
                <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?= lang('Search_for_'); ?></label>
                <select name="search_service_id" class="ajaxSearchService input-search-service form-control custom-select" placeholder="Type to search service...">
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
                        echo sprintf('<option value="%s">%s</option>', $service['id'], $service_name);
                      }
                    } 
                  ?>
                </select>
              </div>

              <!-- Category Field -->
              <div class="form-group mb-4">
                <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang("Category")?></label>
                <select name="category_id" class="form-control square ajaxChangeCategory" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;">
                  <?php if (!empty($filter_categories)):?>      
                    <?php foreach ($filter_categories as $key => $category) : ?>
                      <option value="<?=$category['id']?>"><?=$category['name']; ?></option>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <option value=""> <?=lang("choose_a_category")?></option>
                  <?php endif;?>
                </select>
              </div>

              <!-- Service Field -->
              <div class="form-group mb-4" id="result_onChange">
                <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang("order_service")?></label>
                <select name="service_id" class="form-control square ajaxChangeService" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;">
                </select>
              </div>

              <!-- Hidden Responsive Min/Max values -->
              <div class="row d-none">
                <div class="col-4">
                  <input class="form-control square" name="service_min" type="text" readonly>
                </div>
                <div class="col-4">
                  <input class="form-control square" name="service_max" type="text" readonly>
                </div>
                <div class="col-4">
                  <input class="form-control square" name="service_price" type="text" readonly>
                </div>
              </div>

              <!-- Order Link Field -->
              <div class="form-group mb-4 order-default-link">
                <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang("Link")?></label>
                <input class="form-control square" type="text" name="link" placeholder="https://" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
              </div>

              <!-- Quantity Field -->
              <div class="form-group mb-4 order-default-quantity">
                <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang("Quantity")?></label>
                <input class="form-control square ajaxQuantity" name="quantity" type="number" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
              </div>

              <!-- Delivery Speed Field -->
              <div class="form-group mb-4 order-default-speed">
                <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang("delivery_speed")?></label>
                <select name="speed" class="form-control square" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;">
                  <option value="instant"><?=lang("Instant")?> (Standard)</option>
                  <option value="organic"><?=lang("Organic")?> (Safe)</option>
                  <option value="slow"><?=lang("Slow")?> (Most Organic)</option>
                </select>
              </div>

              <!-- Dynamic form fields based on service (comments, lists, tags etc.) -->
              <div class="form-group mb-4 order-comments d-none">
                <label class="text-white mb-2"><?=lang("Comments")?> <?php lang('1_per_line')?></label>
                <textarea rows="6" name="comments" class="form-control square ajax_custom_comments" style="border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;"></textarea>
              </div> 

              <div class="form-group mb-4 order-comments-custom-package d-none">
                <label class="text-white mb-2"><?=lang("Comments")?> <?php lang('1_per_line')?></label>
                <textarea rows="6" name="comments_custom_package" class="form-control square" style="border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;"></textarea>
              </div>

              <div class="form-group mb-4 order-usernames d-none">
                <label class="text-white mb-2"><?=lang("Usernames")?></label>
                <input type="text" class="form-control input-tags" name="usernames" value="usenameA,usenameB,usenameC,usenameD">
              </div>

              <div class="form-group mb-4 order-usernames-custom d-none">
                <label class="text-white mb-2"><?=lang("Usernames")?> <?php lang('1_per_line')?></label>
                <textarea rows="6" name="usernames_custom" class="form-control square ajax_custom_lists" style="border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;"></textarea>
              </div>

              <div class="form-group mb-4 order-hashtags d-none">
                <label class="text-white mb-2"><?=lang("hashtags_format_hashtag")?></label>
                <input type="text" class="form-control input-tags" name="hashtags" value="#goodphoto,#love,#nice,#sunny">
              </div>

              <div class="form-group mb-4 order-hashtag d-none">
                <label class="text-white mb-2"><?=lang("Hashtag")?> </label>
                <input class="form-control square" type="text" name="hashtag" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;">
              </div>

              <div class="form-group mb-4 order-username d-none">
                <label class="text-white mb-2"><?=lang("Username")?></label>
                <input class="form-control square" name="username" type="text" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;">
              </div>   
              
              <div class="form-group mb-4 order-media d-none">
                <label class="text-white mb-2"><?=lang("Media_Url")?></label>
                <input class="form-control square" name="media_url" type="link" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;">
              </div>

              <!-- Dripfeed / Subscriptions Views -->
              <?php $this->load->view('child/order_subscriptions', ['controller_name' => $controller_name]); ?>
              <?php $this->load->view('child/order_dripfeed', ['controller_name' => $controller_name]); ?>

              <!-- Total Charge Preview Card -->
              <div class="form-group mb-4" id="result_total_charge">
                <input type="hidden" name="total_charge" value="0.00">
                <div class="total-charge-box p-3 d-flex justify-content-between align-items-center mb-3" style="background: rgba(0, 240, 255, 0.05); border: 1px solid rgba(0, 240, 255, 0.2); border-radius: 14px;">
                  <span class="text-muted" style="font-size: 13px; font-weight: 600;"><?=lang("total_charge")?></span>
                  <span class="charge-display-pill font-weight-bold" style="color: #00F0FF; font-size: 18px;">
                    <?=get_option("currency_symbol", '$')?><span class="charge_number">0.00</span>
                  </span>
                </div>
                <div class="alert alert-icon alert-danger d-none p-3" role="alert" style="border-radius: 12px;">
                  <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i><?=lang("order_amount_exceeds_available_funds")?>
                </div>
              </div>

              <!-- Confirmed order checkbox -->
              <div class="form-group mb-4">
                <label class="custom-control custom-checkbox d-flex align-items-center" style="cursor: pointer; gap: 8px;">
                  <input type="checkbox" class="custom-control-input" name="agree" style="width: 18px; height: 18px; cursor: pointer;">
                  <span class="custom-control-label text-white" style="font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;"><?=lang("yes_i_have_confirmed_the_order")?></span>
                </label>
              </div>

              <!-- Actions -->
              <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-spinner-border btn-block btn-lg py-3" style="font-size: 15px; font-weight: 700; border-radius: 14px; box-shadow: 0 8px 25px rgba(0, 240, 255, 0.2);">
                  <?=lang("place_order")?>
                </button>
              </div>
            </div>
          </div>
        </div>  

        <!-- Right Column: Order Resume -->
        <?php require_once ('child/order_resume.php'); ?>
      </div>
    </form>
  </div>

  <!-- Mass Order Tab -->
  <div id="mass_order" class="tab-pane fade">
    <div class="card p-4" style="background: rgba(20, 20, 24, 0.4); border: 1px solid var(--border-dim); border-radius: 24px; backdrop-filter: blur(15px);">
      <?php $this->load->view('child/mass_order', ['controller_name' => $controller_name]); ?>
    </div>
  </div>
</div>

<!-- Order Guide -->
<?php if (get_option('enable_attentions_orderpage')) $this->load->view('child/order_guide', []); ?>

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

    if ($.fn.selectize) {
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
    }
  });

  // Dynamic social platform category filter
  $(document).ready(function() {
    var originalCategoryOptions = [];
    
    // Store original options
    $('select[name="category_id"] option').each(function() {
      originalCategoryOptions.push({
        value: $(this).val(),
        text: $(this).text(),
        html: $(this).prop('outerHTML')
      });
    });

    $(document).on('click', '.platform-select-btn', function(e) {
      e.preventDefault();
      var platform = $(this).data('platform').toLowerCase();
      
      $('.platform-select-btn').removeClass('active');
      $(this).addClass('active');

      var select = $('select[name="category_id"]');
      select.empty();

      var matched = false;
      originalCategoryOptions.forEach(function(opt) {
        var text = opt.text.toLowerCase();
        var isMatch = false;

        if (platform === 'all') {
          isMatch = true;
        } else if (platform === 'instagram') {
          isMatch = (text.indexOf('instagram') > -1 || text.indexOf('ig ') > -1 || text.indexOf('ins ') > -1);
        } else if (platform === 'tiktok') {
          isMatch = (text.indexOf('tiktok') > -1 || text.indexOf('tik tok') > -1);
        } else if (platform === 'youtube') {
          isMatch = (text.indexOf('youtube') > -1 || text.indexOf('yt ') > -1);
        } else if (platform === 'facebook') {
          isMatch = (text.indexOf('facebook') > -1 || text.indexOf('fb ') > -1);
        } else if (platform === 'twitter') {
          isMatch = (text.indexOf('twitter') > -1 || text.indexOf('x ') > -1 || text.indexOf('tw ') > -1);
        } else if (platform === 'telegram') {
          isMatch = (text.indexOf('telegram') > -1 || text.indexOf('tg ') > -1);
        } else if (platform === 'spotify') {
          isMatch = (text.indexOf('spotify') > -1 || text.indexOf('sp ') > -1);
        } else if (platform === 'other') {
          var mainList = ['instagram', 'ig ', 'tiktok', 'youtube', 'yt ', 'facebook', 'fb ', 'twitter', 'x ', 'telegram', 'spotify'];
          var hasMain = false;
          mainList.forEach(function(m) {
            if (text.indexOf(m) > -1) hasMain = true;
          });
          isMatch = !hasMain;
        }

        if (isMatch) {
          select.append(opt.html);
          matched = true;
        }
      });

      if (!matched) {
        select.append('<option value="">Choose a category</option>');
      }

      // Trigger change callback in SmartPanel JS to reload services list
      select.trigger('change');
    });
  });
</script>

<!-- Category filter static params for client.js -->
<?php
  $excluded_keywords = array_keys(app_config('social_media'));
  unset($excluded_keywords[array_search('everything', $excluded_keywords)]);
  unset($excluded_keywords[array_search('other', $excluded_keywords)]);
?>
<script>
  const categories = <?php echo json_encode($filter_categories, JSON_UNESCAPED_UNICODE); ?>;
  const excludedKeywords = <?php echo json_encode(array_values($excluded_keywords)); ?>;
  const app_currency_symbol = "<?php echo get_option("currency_symbol", '$'); ?>";
  const services_list = <?php echo json_encode($items_service, JSON_UNESCAPED_UNICODE); ?>;
  const lang = {
    hours: "<?=lang('hours')?>",
    minutes: "<?=lang('minutes')?>",
    seconds: "<?=lang('seconds')?>",
    notEnoughData: "<?=lang('Not_enough_data')?>"
  };
</script>
