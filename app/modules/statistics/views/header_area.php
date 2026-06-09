<?php if ($header_area) : ?>
  <div class="row g-4 mb-4">
    <?php 
      $main_stats = array_slice($header_area, 0, 2);
      $secondary_stats = array_slice($header_area, 2);
    ?>
    
    <!-- Hero Section for Main Stats (Balance & Spent) -->
    <div class="col-12 mb-3">
      <div class="card stat-card p-4 h-100 position-relative overflow-hidden" style="background: rgba(10, 14, 23, 0.9) !important; border-color: rgba(0, 240, 255, 0.2) !important;">
        <div class="stat-card-glow position-absolute" style="width: 250px; height: 250px; opacity: 0.25;"></div>

        <div class="row align-items-center position-relative" style="z-index: 10;">
          <?php foreach ($main_stats as $key => $item): ?>
            <div class="col-md-6 mb-4 mb-md-0 <?= ($key == 0) ? 'border-right-custom' : 'pl-md-5' ?>">
               <div class="d-flex align-items-center">
                 <span class="stat-icon-wrap" style="width: 64px; height: 64px; background: rgba(0, 240, 255, 0.1);">
                   <i class="<?=$item['icon'];?>" style="font-size: 28px;"></i>
                 </span>
                 <div class="ml-4">
                    <p class="text-muted mb-0" style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;"><?=esc($item['name']);?></p>
                    <h2 class="number text-white mb-0 mt-1" style="font-size: 46px; font-weight: 800; letter-spacing: -1.5px; text-shadow: 0 0 25px rgba(0,240,255,0.25);"><?=esc($item['value']);?></h2>
                 </div>
               </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Secondary Stats -->
    <?php foreach ($secondary_stats as $key => $item): ?>
      <div class="col-sm-6 col-lg-3 item mb-3">
        <div class="card stat-card p-4 h-100 position-relative overflow-hidden">
          <div class="stat-card-glow position-absolute" style="width: 80px; height: 80px; opacity: 0.1;"></div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="stat-icon-wrap" style="width: 40px; height: 40px;">
              <i class="<?=$item['icon'];?>" style="font-size: 18px;"></i>
            </span>
          </div>
          <div class="mt-2">
            <h2 class="number text-white mb-1" style="font-size: 24px; font-weight: 700;"><?=esc($item['value']);?></h2>
            <p class="text-muted mb-0" style="font-size: 12px; font-weight: 500; text-transform: uppercase;"><?=esc($item['name']);?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    
    <style>
      @media (min-width: 768px) {
        .border-right-custom {
          border-right: 1px solid rgba(255,255,255,0.08);
        }
      }
    </style>
  </div>
<?php endif; ?>