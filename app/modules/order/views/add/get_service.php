<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <label><?=lang("service_name")?></label>
    <input class="form-control" name="service_name" type="text" value="<?=$service['name']?>" readonly>
  </div>
</div>   

<div class="col-md-4 col-sm-12 col-xs-12">
  <div class="form-group">
    <label><?=lang("minimum_amount")?></label>
    <input class="form-control" type="text" name="service_min" value="<?=$service['min']?>"  readonly>
  </div>
</div>

<div class="col-md-4 col-sm-12 col-xs-12">
  <div class="form-group">
    <label><?=lang("maximum_amount")?></label>
    <input class="form-control"  type="text" name="service_max" value="<?=$service['max']?>" readonly>
  </div>
</div>

<div class="col-md-4 col-sm-12 col-xs-12">
  <div class="form-group">
    <label><?=lang("price_per_1000")?> (<?=get_option("currency_symbol", "")?>)</label>
    <?php
      $user_price = get_user_price(session('uid'), (object)$service);
    ?>
    <input class="form-control" type="text" name="service_price_show" value="<?=show_price_format($user_price);?>" readonly>
    <input class="form-control" type="hidden" name="service_price" value="<?=$user_price;?>">
  </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <label for="userinput8"><?=lang("Description")?></label>
    <?php
      if (!empty($service['desc'])) { ?>
      <div class="card bg-dark-dim border-dim">
        <div class="p-3 text-dim" style="min-height: 150px; font-size: 13px; line-height: 1.6;">
          <?php
            $desc = html_entity_decode($service['desc'], ENT_QUOTES);
            $desc = str_replace("\n", "<br>", $desc);
            echo strip_tags($desc, "<br>");
          ?>
        </div>
      </div>
      <?php } else { ?>
      <textarea rows="10" class="form-control" name="service_desc" id="service_desc" disabled></textarea>
    <?php }?>  
    
  </div>
</div>
