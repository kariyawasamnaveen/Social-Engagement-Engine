<div class="page-header d-flex align-items-center justify-content-between mb-4">
  <div class="d-flex align-items-center">
    <a href="<?=cn('statistics')?>" class="btn btn-dark btn-pill p-2 mr-3" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
        <i class="fe fe-arrow-left"></i>
    </a>
    <h1 class="page-title mb-0" style="font-size: 20px; font-weight: 700;">
        <?=lang('Your_account')?>
    </h1>
  </div>
  <a href="<?=cn("auth/logout")?>" class="btn btn-outline-danger btn-pill px-4">
    <i class="fe fe-log-out mr-2"></i><?=lang('Logout')?>
  </a>
</div>
<?php
  $item_user_timezone = esc($item['last_name'] ?? 'Asia/Ho_Chi_Minh');
  $item_login_type = esc($item['last_name'] ?? '');
  $item_more_infor = esc($item['more_information'] ?? []);
?>
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?=lang("basic_information")?></h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body">
        <form class="form actionForm" action="<?=cn($module."/ajax_update")?>" data-redirect="<?=cn($module)?>" method="POST">
          <div class="form-body">
            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang("first_name")?></label>
                  <input class="form-control square" name="first_name" type="text" value="<?=esc($item['first_name'] ?? '')?>">
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="userinput5"><?=lang("last_name")?></label>
                    <input class="form-control square" name="last_name" type="text" value="<?=esc($item['last_name'] ?? '')?>">
                  </div>
              </div> 

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang('Email')?></label>
                  <input class="form-control square" name="email" type="email" value="<?=esc($item['email'] ?? '')?>" readonly>
                </div>
              </div>
              

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang('Timezone')?></label>
                  <select  name="timezone" class="form-control square">
                    <?php $time_zones = tz_list();
                      if (!empty($time_zones)) {
                        foreach ($time_zones as $key => $time_zone) {
                    ?>
                    <option value="<?=$time_zone['zone']?>" <?= ($item_user_timezone== $time_zone["zone"]) ? 'selected': ''?>><?=$time_zone['time']?></option>
                    <?php }}?>
                  </select>
                </div>
              </div>
              
              <?php if ($item_login_type != 'google_login') : ?>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="projectinput5"><?=lang('Password')?></label>
                    <input class="form-control square" name="password" type="password">
                    <small class="text-muted"><?=lang("note_if_you_dont_want_to_change_password_then_leave_these_password_fields_empty")?></small>
                  </div>
                </div> 

                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="projectinput5"><?=lang('Confirm_password')?></label>
                    <input class="form-control square" name="re_password" type="password">
                  </div>
                </div>
              <?php endif; ?>
              <div class="col-md-12 col-sm-12 col-xs-12 form-actions">
                <div class="p-l-10">
                  <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1"><?=lang('Save')?></button>
                </div>
              </div>
            </div>
          </div>
          <div class="">
          </div>
        </form>
      </div>
    </div>
  </div> 

  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?=lang("more_informations")?></h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body">
        <form class="form actionForm" action="<?=cn($module."/ajax_update_more_infors")?>" data-redirect="<?=cn($module)?>" method="POST">
          <div class="form-body">
            <div class="row">
              <?php
                if ($item_more_infor) {
                  $website    = get_value($item['more_information'], "website");
                  $phone      = get_value($item['more_information'], "phone");
                  $skype_id   = get_value($item['more_information'], "skype_id");
                  $what_asap  = get_value($item['more_information'], "what_asap");
                  $address    = get_value($item['more_information'], "address");
                }
              ?>  
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="userinput5"><?=lang('Website')?></label>
                  <input class="form-control square" name="website" type="text" value="<?= $website?>">
                </div>
              </div> 

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang('Phone')?></label>
                  <input class="form-control square" name="phone" type="text" value="<?= $phone?>">
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang('Skype_id')?></label>
                  <input class="form-control square"  name="skype_id"  type="text" value="<?= $skype_id?>">
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang("whatsapp_number")?></label>
                  <input class="form-control square"  name="what_asap"  type="text" value="<?= $what_asap ?>">
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang('Address')?></label>
                  <input class="form-control square" name="address" type="text" value="<?=(!empty($address))? $address: ''?>">
                  <small class="text-muted"><?=lang("note_if_you_dont_want_add_more_information_then_leave_these_informations_fields_empty")?></small>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12 form-actions left">
                <div class="p-l-10">
                  <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1"><?=lang("Save")?></button>
                </div>
              </div>
            </div>
          </div>
          <div class="">
          </div>
        </form>
      </div>
    </div>
  </div>  

  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?=lang('your_api_key')?></h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body">
        <form class="form actionForm" action="<?=cn($module . "/ajax_update_api")?>" method="POST">
          <div class="form-group" id="result_notification">
            <label> <?=lang('Key')?></label>
            <div class="input-group">
              <input type="text" name="api_key" class="form-control square" value="<?= hide_api_key(esc($item['api_key'] ?? ''))?>">
            </div>
            
          </div>
          <div class="">
            <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1"><?=lang("Generate_new")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-12 mt-4 mb-5 text-center">
    <a href="<?=cn("auth/logout")?>" class="btn btn-danger btn-block btn-lg btn-pill py-3" style="font-weight: 700; box-shadow: 0 10px 20px -5px rgba(220, 38, 38, 0.2);">
        <i class="fe fe-log-out mr-2"></i> <?=lang('Logout')?>
    </a>
    <p class="text-muted mt-3" style="font-size: 13px;">Version 1.0.0 | Signed in as <?=esc($item['email'] ?? '')?></p>
  </div>

</div>

