<?php
if ($items_top_best_seller):
  
  // Platform detector helper inside the view
  if (!function_exists('detect_service_platform')) {
    function detect_service_platform($name) {
      $lower = strtolower($name);
      if (strpos($lower, 'tiktok') !== false) {
        return [
          'name' => 'TikTok',
          'color' => '#FF007F',
          'bg' => 'rgba(255, 0, 127, 0.12)',
          'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#FF007F" viewBox="0 0 16 16"><path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/></svg>'
        ];
      } elseif (strpos($lower, 'instagram') !== false || strpos($lower, 'ig ') !== false || strpos($lower, 'ins ') !== false) {
        return [
          'name' => 'Instagram',
          'color' => '#8B5CF6',
          'bg' => 'rgba(139, 92, 246, 0.12)',
          'icon' => '<i class="fa fa-instagram" style="color: #8B5CF6;"></i>'
        ];
      } elseif (strpos($lower, 'youtube') !== false || strpos($lower, 'yt ') !== false) {
        return [
          'name' => 'YouTube',
          'color' => '#FF0000',
          'bg' => 'rgba(255, 0, 0, 0.12)',
          'icon' => '<i class="fa fa-youtube-play" style="color: #FF0000;"></i>'
        ];
      } elseif (strpos($lower, 'facebook') !== false || strpos($lower, 'fb ') !== false) {
        return [
          'name' => 'Facebook',
          'color' => '#1877F2',
          'bg' => 'rgba(24, 119, 242, 0.12)',
          'icon' => '<i class="fa fa-facebook-official" style="color: #1877F2;"></i>'
        ];
      } elseif (strpos($lower, 'twitter') !== false || strpos($lower, 'x ') !== false) {
        return [
          'name' => 'Twitter',
          'color' => '#00F0FF',
          'bg' => 'rgba(0, 240, 255, 0.12)',
          'icon' => '<i class="fa fa-twitter" style="color: #00F0FF;"></i>'
        ];
      }
      return [
        'name' => 'Social',
        'color' => '#00F0FF',
        'bg' => 'rgba(0, 240, 255, 0.12)',
        'icon' => '<i class="fa fa-globe" style="color: #00F0FF;"></i>'
      ];
    }
  }
?>

<div class="row justify-content-center">
  <div class="col-md-12 col-xl-12">
    <div class="card p-4" style="background: rgba(20, 20, 24, 0.4); border: 1px solid var(--border-dim); border-radius: 24px; backdrop-filter: blur(15px);">
      <div class="card-header border-bottom-0 pb-4 pt-0 px-0 d-flex justify-content-between align-items-center">
        <div>
          <h3 class="card-title text-white mb-1" style="font-size: 18px; font-weight: 700;"><?php echo lang("top_bestsellers"); ?></h3>
          <p class="text-muted mb-0" style="font-size: 13px;">Our most in-demand services currently trending</p>
        </div>
      </div>
      
      <!-- Responsive List Grid -->
      <div class="bestseller-grid row g-3">
        <?php
          foreach ($items_top_best_seller as $key => $item) {
            $platform = detect_service_platform($item['name']);
            $show_item_view = show_item_details('services', $item);
        ?>
          <div class="col-12 mb-3">
            <div class="bestseller-item p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center position-relative overflow-hidden" style="background: rgba(20, 20, 24, 0.6); border: 1px solid var(--border-dim); border-radius: 16px; transition: all 0.3s ease;">
              
              <!-- Left Side: ID & Name -->
              <div class="d-flex align-items-center mb-3 mb-md-0 col-md-7 px-0">
                <span class="badge mr-3" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-dim); border-radius: 8px; color: var(--text-muted); font-size: 11px; font-weight: 700; padding: 6px 10px; min-width: 48px; text-align: center;">
                  #<?=esc($item['id']);?>
                </span>
                
                <div>
                  <div class="d-flex align-items-center mb-1 flex-wrap">
                    <span class="d-flex align-items-center justify-content-center mr-2 px-2 py-1" style="background: <?=$platform['bg']?>; border-radius: 6px; font-size: 11px; font-weight: 700; color: <?=$platform['color']?>; gap: 4px;">
                      <?=$platform['icon']?> <?=$platform['name']?>
                    </span>
                  </div>
                  <h5 class="text-white mb-0" style="font-size: 14px; font-weight: 600; line-height: 1.4;"><?=esc($item['name']);?></h5>
                </div>
              </div>

              <!-- Right Side: Details & Action -->
              <div class="d-flex flex-row justify-content-between justify-content-md-end align-items-center col-md-5 px-0 flex-wrap" style="gap: 15px;">
                <!-- Min / Max -->
                <div class="text-left text-md-right min-max-box">
                  <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Min/Max</span>
                  <span class="text-white" style="font-size: 12px; font-weight: 600;"><?=$item['min'] . ' / ' . $item['max']?></span>
                </div>

                <!-- Price -->
                <div class="text-left text-md-right price-box">
                  <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Rate / 1k</span>
                  <span class="badge" style="background: rgba(0, 240, 255, 0.08); border: 1px solid rgba(0, 240, 255, 0.2); color: #00F0FF; font-size: 13px; font-weight: 700; border-radius: 8px; padding: 6px 12px;">
                    <?=get_option('currency_symbol', '$')?><?=(double)$item['price'];?>
                  </span>
                </div>

                <!-- Action Button -->
                <div class="action-box">
                  <a href="<?=cn('new_order')?>" class="btn btn-sm btn-outline-primary py-2 px-3 btn-pill d-flex align-items-center" style="font-size: 11px; font-weight: 700; gap: 4px;">
                    Order <i class="fe fe-arrow-right"></i>
                  </a>
                </div>
              </div>

            </div>
          </div>
        <?php } ?>
      </div>

    </div>
  </div>
</div>
<?php endif; ?>