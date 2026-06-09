<?php
    $option = get_value($payment_params, 'option');
    $min_amount = get_value($payment_params, 'min');
    $max_amount = get_value($payment_params, 'max');
    $type = get_value($payment_params, 'type');
    $take_fee_from_user = get_value($payment_params, 'take_fee_from_user');
?>

<div class="add-funds-form-content">
    <form class="form actionForm" action="<?=cn($module."/process")?>" data-redirect="<?=cn($module)?>" method="POST">
        <div class="form-group">
            <div class="text-center mb-4">
                <img src="<?=BASE?>assets/images/payments/payhere.png" alt="PayHere" style="max-height: 50px;">
                <p class="text-muted mt-2"><small><?=lang('you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account')?></small></p>
            </div>
            
            <label class="form-label"><?=lang('Amount')?> (<?=get_option("currency_code", "LKR")?>)</label>
            <input type="number" class="form-control" name="amount" value="<?=$min_amount?>" step="0.01" min="<?=$min_amount?>">
            <input type="hidden" name="payment_id" value="<?=$payment_id?>">
            <input type="hidden" name="payment_method" value="payhere">
        </div>

        <div class="form-group">
            <p class="text-muted mb-2">Note:</p>
            <ul class="text-muted small pl-3">
                <li>Minimal payment: <strong><?=$min_amount?></strong></li>
                <?php if ($max_amount > 0): ?>
                <li>Maximal payment: <strong><?=$max_amount?></strong></li>
                <?php endif; ?>
            </ul>
            
            <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" class="custom-control-input" id="payhere_agree" name="agree" value="1" checked>
                <label class="custom-control-label text-uppercase" for="payhere_agree"><strong><?=lang('yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback')?></strong></label>
            </div>
        </div>

        <div class="form-actions mt-4 text-center">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <button type="submit" class="btn btn-primary btn-submit btn-lg px-5">Pay Now</button>
        </div>
    </form>
</div>
