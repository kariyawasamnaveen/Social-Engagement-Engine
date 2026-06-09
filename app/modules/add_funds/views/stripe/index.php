
<style>
  .StripeElement {
    box-sizing: border-box;
    width: 100%;
    height: 44px;
    padding: 12px 15px;
    background-color: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    -webkit-transition: all 150ms ease;
    transition: all 150ms ease;
  }

  .StripeElement--focus {
    border-color: rgba(255, 255, 255, 0.3);
    background-color: rgba(255, 255, 255, 0.05);
  }

  .StripeElement--invalid {
    border-color: #ff5252;
  }

  .StripeElement--webkit-autofill {
    background-color: transparent !important;
  }
</style>

<style>
  .creditCardForm .form-control {
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .creditCardForm .form-group .transparent {
    opacity: 0.1;
  }
</style>
<script src="https://js.stripe.com/v3/"></script>
<?php
  $option           = get_value($payment_params, 'option');
  $min_amount       = get_value($payment_params, 'min');
  $max_amount       = get_value($payment_params, 'max');
  $type             = get_value($payment_params, 'type');
  $tnx_fee          = get_value($option, 'tnx_fee');
  $currency_code    = get_option("currency_code",'USD');
  $currency_symbol  = get_option("currency_symbol",'$');
?>

<div class="add-funds-form-content">
  <form class="form actionAddFundsStripeCheckoutForm" action="#" method="post" id="payment-form">
    <div class="form-group">
      <div class="text-center mb-4">
        <img src="<?=BASE?>assets/images/payments/stripe.png" alt="Stripe icon" style="max-height: 50px;">
        <p class="text-muted mt-2"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Stripe')?></small></p>
      </div>

      <label class="form-label"><?=lang('Amount')?> (<?=get_option("currency_code", "USD")?>)</label>
      <input type="number" class="form-control" name="amount" value="<?=$min_amount?>" step="0.01" min="<?=$min_amount?>">
    </div>

    <div class="form-group mt-3">
      <label class="form-label">Credit or debit card</label>
      <div id="card-element" class="mt-2"></div>
      <div id="card-errors" role="alert" class="text-danger mt-2 small"></div>
    </div>
    
    <div class="form-group text-center mb-4" id="credit_cards">
      <img src="<?php echo BASE; ?>assets/images/payments/visa.jpg" id="visa" style="height:25px; border-radius:3px; margin: 0 5px; opacity:0.8;">
      <img src="<?php echo BASE; ?>assets/images/payments/mastercard.jpg" id="mastercard" style="height:25px; border-radius:3px; margin: 0 5px; opacity:0.8;">
      <img src="<?php echo BASE; ?>assets/images/payments/amex.jpg" id="amex" style="height:25px; border-radius:3px; margin: 0 5px; opacity:0.8;">
    </div>

    <div class="form-group">
      <p class="text-muted mb-2">Note:</p>
      <ul class="text-muted small pl-3">
        <?php if ($tnx_fee > 0) { ?>
        <li><?=lang("transaction_fee")?>: <strong><?php echo $tnx_fee; ?>%</strong></li>
        <?php } ?>
        <li>Minimal payment: <strong><?=$min_amount?></strong></li>
        <?php if ($max_amount > 0): ?>
        <li>Maximal payment: <strong><?=$max_amount?></strong></li>
        <?php endif; ?>
      </ul>
      
      <div class="custom-control custom-checkbox mt-3">
        <input type="checkbox" class="custom-control-input" id="stripe_agree" name="agree" value="1" checked>
        <label class="custom-control-label text-uppercase" for="stripe_agree"><strong><?=lang('yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback')?></strong></label>
      </div>
    </div>

    <div class="form-actions mt-4 text-center">
      <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
      <input type="hidden" name="payment_method" value="<?php echo $type; ?>">
      <button type="submit" class="btn btn-primary btn-submit btn-lg px-5">Pay Now</button>
    </div>
  </form>
</div>


<script type="text/javascript">
setTimeout(function(){
  var publicKey = '<?php echo get_value($option, 'public_key'); ?>';
  if (!publicKey || publicKey.trim() === '') {
      var cardElement = document.getElementById('card-element');
      if (cardElement) {
          cardElement.innerHTML = '<div class="alert alert-info text-white" style="background: rgba(0, 240, 255, 0.08); border: 1px solid var(--accent-blue); padding: 15px; border-radius: 12px; font-size: 13px;"><i class="fa-solid fa-circle-info mr-2" style="color: var(--accent-blue);"></i><strong>Sandbox Simulation Mode:</strong> No keys configured. Submitting will simulate a sandbox payment.</div>';
      }
      var form = document.getElementById('payment-form');
      form.addEventListener('submit', function(event) {
          event.preventDefault();
          var _that = $(this);
          stripeTokenHandler({id: 'tok_sandbox_mock'}, _that);
      });
      return;
  }

  // Create a Stripe client
  var stripe = Stripe(publicKey);

  // Create an instance of Elements
  var elements = stripe.elements();

  // Custom styling can be passed to options when creating an Element.
  // (Note that this demo uses a wider set of styles than the guide below.)
  var style = {
      base: {
      color: '#ffffff',
      lineHeight: '18px',
      fontFamily: '"Outfit", "Inter", Helvetica, sans-serif',
      fontSmoothing: 'antialiased',
      fontSize: '15px',
      '::placeholder': {
        color: 'rgba(255, 255, 255, 0.4)'
      }
      },
      invalid: {
        color: '#ff5252',
        iconColor: '#ff5252'
      }
  };

  // Create an instance of the card Element
  var card = elements.create('card', {hidePostalCode: true, style: style});

  // Add an instance of the card Element into the `card-element` <div>
  card.mount('#card-element');

  // Handle real-time validation errors from the card Element.
  card.addEventListener('change', function(event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
  });

  // Handle form submission
  var form = document.getElementById('payment-form');
  form.addEventListener('submit', function(event) {
      event.preventDefault();
      var _that = $(this);
      
      stripe.createToken(card).then(function(result) {
        if (result.error) {
        // Inform the user if there was an error
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server
            stripeTokenHandler(result.token, _that);
        }
      });
  });
}, 1000);

function stripeTokenHandler(stripe_token, _that) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', stripe_token.id);
  form.appendChild(hiddenInput);

  // var hiddenToken = document.createElement('input');
  // hiddenToken.setAttribute('type', 'hidden');
  // hiddenToken.setAttribute('name', 'token');
  // hiddenToken.setAttribute('value', token);
  // form.appendChild(hiddenToken);

  // Submit the form
  pageOverlay.show();
  event.preventDefault();
  var  _action   = PATH + 'add_funds/process',
    _form   = _that.closest('form'),
    _data   = _form.serialize(),
    _data   = _data + '&' + $.param({token:token});
  $.post(_action, _data, function(_result){
    console.log(_data);
    setTimeout(function(){
      pageOverlay.hide();
    },1500)
    if (is_json(_result)) {
      _result = JSON.parse(_result);
      setTimeout(function(){
        notify(_result.message, _result.status);
      },1500)
    }else{
      setTimeout(function(){
        $(".actionAddFundsStripeCheckoutForm").html(_result);
      }, 1500)
    }
  })
  return false;
}
</script>
