<!-- Chart Area -->
<div class="charts mb-5">
  <div class="card p-4 stat-card">
    <div class="card-header border-bottom-0 pb-4 pt-0 px-0 d-flex justify-content-between align-items-center">
      <div>
        <h3 class="card-title text-white mb-1" style="font-size: 18px; font-weight: 700;"><?=lang("recent_orders")?></h3>
        <p class="text-muted mb-0" style="font-size: 13px;">Analytics of your social engagement logs</p>
      </div>
    </div>
    
    <div class="row g-4">
      <div class="col-sm-12 col-md-8 mb-3">
        <div class="p-4 h-100 stat-card">
          <div id="orders_chart_spline" style="height: 20rem;"></div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 mb-3">
        <div class="p-4 h-100 stat-card">
          <div id="orders_chart_pie" style="height: 20rem;"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Orders Logs Summary Cards -->
<?php if ($chart_and_orders_area): ?>
  <div class="row g-4 mb-4">
    <?php foreach ($chart_and_orders_area['orders_statistics'] as $key => $item): 
      // Determine status-specific neon colors
      $glow_color = '#8B5CF6'; // Default purple
      $icon_color = '#8B5CF6';
      if (strpos(strtolower($item['name']), 'completed') !== false) {
        $glow_color = '#00FF87';
        $icon_color = '#00FF87';
      } elseif (strpos(strtolower($item['name']), 'processing') !== false || strpos(strtolower($item['name']), 'progress') !== false) {
        $glow_color = '#00F0FF';
        $icon_color = '#00F0FF';
      } elseif (strpos(strtolower($item['name']), 'canceled') !== false || strpos(strtolower($item['name']), 'cancelled') !== false || strpos(strtolower($item['name']), 'error') !== false) {
        $glow_color = '#FF007F';
        $icon_color = '#FF007F';
      }
    ?>
      <div class="col-sm-6 col-lg-3 item mb-3">
        <div class="card stat-card p-4 h-100 position-relative overflow-hidden" style="background: rgba(20, 20, 24, 0.6); border: 1px solid var(--border-dim); border-radius: 20px; backdrop-filter: blur(15px); transition: all 0.3s ease;">
          <div class="stat-card-glow position-absolute" style="top: -50px; right: -50px; width: 120px; height: 120px; border-radius: 50%; filter: blur(40px); opacity: 0.12; background: <?=$glow_color?>;"></div>
          
          <div class="d-flex align-items-center mb-3">
            <span class="stat-icon-wrap" style="width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-dim); color: <?=$icon_color?>; box-shadow: 0 4px 12px <?=rgba_glow($glow_color, 0.15)?>;">
              <i class="<?=$item['icon'];?>" style="font-size: 18px;"></i>
            </span>
          </div>

          <div class="mt-2">
            <h3 class="number text-white mb-1" style="font-size: 26px; font-weight: 800; letter-spacing: -0.5px;"><?=esc($item['value']);?></h3>
            <p class="text-muted mb-0" style="font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;"><?=esc($item['name']);?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php
// Helper function to convert hex to rgba for glow styling
function rgba_glow($hex, $alpha) {
  $hex = str_replace('#', '', $hex);
  if(strlen($hex) == 3) {
    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
  } else {
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));
  }
  return "rgba($r, $g, $b, $alpha)";
}
?>
