<?php
  $item_user_timezone = esc($item['timezone'] ?? 'Asia/Ho_Chi_Minh');
  $item_login_type = esc($item['login_type'] ?? '');
  $item_more_infor = !empty($item['more_information']) ? json_decode($item['more_information'], true) : [];
?>

<div class="profile-page-wrapper">
  <!-- Profile Page Header Banner -->
  <div class="page-header d-flex flex-column flex-sm-row align-items-center justify-content-between mb-4 p-4" style="background: rgba(20, 20, 24, 0.4); border: 1px solid var(--border-dim); border-radius: 24px; backdrop-filter: blur(15px); gap: 15px;">
    <div class="d-flex align-items-center flex-column flex-sm-row text-center text-sm-left" style="gap: 15px;">
      <div class="profile-avatar-wrap" style="position: relative; width: 64px; height: 64px; border-radius: 50%; padding: 3px; background: linear-gradient(135deg, var(--accent-pink) 0%, var(--accent-purple) 100%);">
        <div style="width: 100%; height: 100%; border-radius: 50%; background: #131315; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px solid #131315;">
          <img src="<?=BASE?>assets/images/user-avatar.png" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      </div>
      <div>
        <h1 class="page-title text-white mb-1" style="font-size: 20px; font-weight: 700;">
          <?=esc($item['first_name'] ?? '')?> <?=esc($item['last_name'] ?? '')?>
        </h1>
        <p class="text-muted mb-0" style="font-size: 13px;"><?=esc($item['email'] ?? '')?></p>
      </div>
    </div>
    
    <div class="d-flex align-items-center" style="gap: 10px;">
      <a href="<?=cn('statistics')?>" class="btn btn-dark btn-pill p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
        <i class="fe fe-arrow-left"></i>
      </a>
      <a href="<?=cn("auth/logout")?>" class="btn btn-outline-danger btn-pill px-4 py-2" style="font-size: 13px; font-weight: 700;">
        <i class="fe fe-log-out mr-2"></i><?=lang('Logout')?>
      </a>
    </div>
  </div>

  <div class="row g-4">
    <!-- Basic Information Card -->
    <div class="col-md-6 mb-4">
      <div class="card p-4 h-100" style="background: rgba(20, 20, 24, 0.4); border: 1px solid var(--border-dim); border-radius: 24px; backdrop-filter: blur(15px);">
        <div class="card-header border-bottom-0 pb-4 pt-0 px-0">
          <h3 class="card-title text-white mb-0" style="font-size: 16px; font-weight: 700;"><?=lang("basic_information")?></h3>
        </div>
        <div class="card-body p-0">
          <form class="form actionForm" action="<?=cn($module."/ajax_update")?>" data-redirect="<?=cn($module)?>" method="POST">
            <div class="form-body">
              <div class="row g-3">
                <div class="col-sm-6 mb-3">
                  <div class="form-group mb-0">
                    <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang("first_name")?></label>
                    <input class="form-control square" name="first_name" type="text" value="<?=esc($item['first_name'] ?? '')?>" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
                  </div>
                </div>

                <div class="col-sm-6 mb-3">
                  <div class="form-group mb-0">
                    <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang("last_name")?></label>
                    <input class="form-control square" name="last_name" type="text" value="<?=esc($item['last_name'] ?? '')?>" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
                  </div>
                </div> 

                <div class="col-12 mb-3">
                  <div class="form-group mb-0">
                    <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang('Email')?></label>
                    <input class="form-control square" name="email" type="email" value="<?=esc($item['email'] ?? '')?>" readonly style="height: 48px; border-radius: 12px; background: rgba(18, 18, 20, 0.5); border: 1px solid var(--border-dim); color: #888; padding: 10px 16px; cursor: not-allowed; opacity: 0.7;">
                  </div>
                </div>

                <div class="col-12 mb-4">
                  <div class="form-group mb-0">
                    <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang('Timezone')?></label>
                    <select name="timezone" class="form-control square" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff;">
                      <?php $time_zones = tz_list();
                        if (!empty($time_zones)) {
                          foreach ($time_zones as $key => $time_zone) {
                      ?>
                      <option value="<?=$time_zone['zone']?>" <?= ($item_user_timezone == $time_zone["zone"]) ? 'selected': ''?>><?=$time_zone['time']?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>

                <?php if ($item_login_type != 'google_login') : ?>
                  <div class="col-sm-6 mb-3">
                    <div class="form-group mb-0">
                      <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang('Password')?></label>
                      <input class="form-control square" name="password" type="password" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
                    </div>
                  </div> 

                  <div class="col-sm-6 mb-3">
                    <div class="form-group mb-0">
                      <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang('Confirm_password')?></label>
                      <input class="form-control square" name="re_password" type="password" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
                    </div>
                  </div>
                <?php endif; ?>
                
                <div class="col-12 mt-2">
                  <button type="submit" class="btn btn-primary btn-block py-3" style="font-size: 14px; font-weight: 700; border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 0, 127, 0.15);"><?=lang('Save')?></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div> 

    <!-- More Information Card -->
    <div class="col-md-6 mb-4">
      <div class="card p-4 h-100" style="background: rgba(20, 20, 24, 0.4); border: 1px solid var(--border-dim); border-radius: 24px; backdrop-filter: blur(15px);">
        <div class="card-header border-bottom-0 pb-4 pt-0 px-0">
          <h3 class="card-title text-white mb-0" style="font-size: 16px; font-weight: 700;"><?=lang("more_informations")?></h3>
        </div>
        <div class="card-body p-0">
          <form class="form actionForm" action="<?=cn($module."/ajax_update_more_infors")?>" data-redirect="<?=cn($module)?>" method="POST">
            <div class="form-body">
              <div class="row g-3">
                <?php
                  $website    = get_value($item_more_infor, "website");
                  $phone      = get_value($item_more_infor, "phone");
                  $skype_id   = get_value($item_more_infor, "skype_id");
                  $what_asap  = get_value($item_more_infor, "what_asap");
                  $address    = get_value($item_more_infor, "address");
                ?>  
                <div class="col-sm-6 mb-3">
                  <div class="form-group mb-0">
                    <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang('Website')?></label>
                    <input class="form-control square" name="website" type="text" value="<?=esc($website)?>" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
                  </div>
                </div> 

                <div class="col-sm-6 mb-3">
                  <div class="form-group mb-0">
                    <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang('Phone')?></label>
                    <input class="form-control square" name="phone" type="text" value="<?=esc($phone)?>" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
                  </div>
                </div>

                <div class="col-sm-6 mb-3">
                  <div class="form-group mb-0">
                    <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang('Skype_id')?></label>
                    <input class="form-control square" name="skype_id" type="text" value="<?=esc($skype_id)?>" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
                  </div>
                </div>

                <div class="col-sm-6 mb-3">
                  <div class="form-group mb-0">
                    <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang("whatsapp_number")?></label>
                    <input class="form-control square" name="what_asap" type="text" value="<?=esc($what_asap)?>" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
                  </div>
                </div>

                <div class="col-12 mb-4">
                  <div class="form-group mb-0">
                    <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang('Address')?></label>
                    <input class="form-control square" name="address" type="text" value="<?=esc($address)?>" style="height: 48px; border-radius: 12px; background: #131315; border: 1px solid var(--border-dim); color: #fff; padding: 10px 16px;">
                  </div>
                </div>
                
                <div class="col-12 mt-2">
                  <button type="submit" class="btn btn-primary btn-block py-3" style="font-size: 14px; font-weight: 700; border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 0, 127, 0.15);"><?=lang("Save")?></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>  

    <!-- API Settings Card -->
    <div class="col-12 mb-5">
      <div class="card p-4" style="background: rgba(20, 20, 24, 0.4); border: 1px solid var(--border-dim); border-radius: 24px; backdrop-filter: blur(15px);">
        <div class="card-header border-bottom-0 pb-4 pt-0 px-0">
          <h3 class="card-title text-white mb-0" style="font-size: 16px; font-weight: 700;"><?=lang('your_api_key')?></h3>
        </div>
        <div class="card-body p-0">
          <form class="form actionForm" action="<?=cn($module . "/ajax_update_api")?>" method="POST">
            <div class="row align-items-end g-3">
              <div class="col-md-9 mb-3">
                <div class="form-group mb-0" id="result_notification">
                  <label class="text-white mb-2" style="font-size: 13px; font-weight: 600;"><?=lang('Key')?></label>
                  <input type="text" name="api_key" class="form-control square font-weight-bold" value="<?= hide_api_key(esc($item['api_key'] ?? ''))?>" readonly style="height: 48px; border-radius: 12px; background: rgba(18, 18, 20, 0.5); border: 1px solid var(--border-dim); color: #00F0FF; padding: 10px 16px; letter-spacing: 1px;">
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <button type="submit" class="btn btn-outline-primary btn-block py-3" style="font-size: 14px; font-weight: 700; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 240, 255, 0.05); margin-top: 0 !important;">
                  <?=lang("Generate_new")?>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
