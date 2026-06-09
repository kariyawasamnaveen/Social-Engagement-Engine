<!DOCTYPE html>
<html lang="en">
  <?php 
    include_once 'blocks/head.blade.php';
    $form_url        = cn("auth/ajax_forgot_password");
    $form_attributes = [
      'id'            => 'signUpForm', 
      'data-focus'    => 'false', 
      'class'         => 'actionFormWithoutToast', 
      'data-redirect' => cn('auth/login'), 
      'method'        => "POST"  
    ];
  ?>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </head>
  <style>
      /* EXACT IMAGE MATCH SYSTEM */
      :root {
          --neon-pink: #FF007F;
          --neon-cyan: #00F0FF;
          --neon-purple: #8B5CF6;
      }

      body, html { 
          background: radial-gradient(ellipse at top left, #db1a68 0%, #0a040d 30%, #000000 100%) !important;
          color: #fff !important; 
          font-family: 'Poppins', sans-serif !important; 
          min-height: 100vh;
          overflow: hidden;
          margin: 0;
          padding: 0;
          display: flex;
          align-items: center;
          justify-content: center;
      }

      .navbar, .footer, .navbar-custom, footer { display: none !important; }

      /* OUTER GLOWING CONTAINER */
      .app-wrapper {
          width: 96vw;
          height: 93vh;
          max-width: 1900px;
          border-radius: 15px;
          border: 2px solid #52d2e9 !important;
          background: #0d0415;
          display: flex;
          overflow: hidden;
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
          position: relative;
      }

      /* LEFT PANEL: Cosmic (70%) */
      .cosmic-panel {
          flex: 7;
          position: relative;
          background: radial-gradient(circle at center, #1a0b2e 0%, #05020a 100%);
          display: flex;
          align-items: center;
          justify-content: space-evenly;
          padding: 50px;
          border-right: 1px solid rgba(255,255,255,0.05);
      }

      .cosmic-overlay {
          position: absolute;
          top: 0; left: 0; width: 100%; height: 100%;
          background-image: url("<?=BASE?>assets/images/bg-wave.png");
          background-size: cover;
          background-repeat: no-repeat;
          background-position: bottom left;
          opacity: 1;
          filter: brightness(0.6);
          z-index: 0;
      }

            /* ADVANCED COMPOSITE BADGE */
      .composite-badge {
          position: absolute;
          top: 50px;
          left: 50px;
          display: flex;
          align-items: center;
          z-index: 10;
          filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.6));
      }
      .badge-seal {
          transform: translate(4px, -2px);
          width: 56px;
          height: 56px;
          display: flex;
          align-items: center;
          justify-content: center;
          z-index: 2;
          position: relative;
          background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M50 2 L58 10 L69 6 L74 16 L85 16 L88 27 L98 32 L94 42 L99 50 L94 58 L98 68 L88 73 L85 84 L74 84 L69 94 L58 90 L50 98 L42 90 L31 94 L26 84 L15 84 L12 73 L2 68 L6 58 L1 50 L6 42 L2 32 L12 27 L15 16 L26 16 L31 6 L42 10 Z' fill='%231b2631' stroke='%234c6270' stroke-width='3'/%3E%3Ccircle cx='50' cy='50' r='34' fill='url(%23grad)' stroke='%2352d2e9' stroke-width='2'/%3E%3Cdefs%3E%3CradialGradient id='grad' cx='50%25' cy='50%25' r='50%25'%3E%3Cstop offset='0%25' stop-color='%2352d2e9' stop-opacity='0.4'/%3E%3Cstop offset='100%25' stop-color='%230b131c' stop-opacity='0.9'/%3E%3C/radialGradient%3E%3C/defs%3E%3C/svg%3E");
          background-size: cover;
      }
      .badge-seal i {
          color: #52d2e9;
          font-size: 20px;
          filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
      }
      .badge-textbox {
          background: linear-gradient(90deg, rgba(82, 210, 233, 0.25) 0%, rgba(10, 20, 30, 0.8) 100%);
          border: 1px solid #52d2e9;
          border-left: none;
          border-radius: 0 8px 8px 0;
          padding: 8px 20px 8px 30px;
          margin-left: -20px;
          z-index: 1;
          color: #d1f4ff;
          font-family: 'Outfit', sans-serif;
          font-size: 14px;
          font-weight: 700;
          letter-spacing: 1px;
          box-shadow: inset 0 0 15px rgba(82, 210, 233, 0.1);
      }

      /* FORM BOX */
      .glass-form-box {
          position: relative;
          z-index: 5;
          width: 480px;
          max-height: 80vh;
          background: rgba(15, 20, 35, 0.15);
          border: 1px solid rgba(255, 255, 255, 0.05);
          border-radius: 15px;
          backdrop-filter: blur(4px);
          -webkit-backdrop-filter: blur(4px);
          padding: 0 0 20px 0;
          box-shadow: 0 25px 50px rgba(0,0,0,0.5);
          display: flex;
          flex-direction: column;
      }

      .form-tabs {
          display: flex;
          border-top: 2px solid transparent;
          border-left: 2px solid transparent;
          border-right: 2px solid transparent;
          background: linear-gradient(rgba(15, 20, 35, 0.7), rgba(15, 20, 35, 0.7)) padding-box,
                      linear-gradient(90deg, #00f0ff, #ff3399) border-box;
          border-bottom: 1px solid rgba(255,255,255,0.05);
          margin-bottom: 25px;
          border-top-left-radius: 15px;
          border-top-right-radius: 15px;
          overflow: hidden;
          flex-shrink: 0;
      }
      .form-tab {
          flex: 1;
          text-align: center;
          padding: 20px 0;
          font-family: 'Outfit', sans-serif;
          font-weight: 600;
          font-size: 18px;
          color: rgba(255,255,255,0.5);
          cursor: pointer;
          position: relative;
          background: rgba(0,0,0,0.2);
          transition: 0.3s;
      }
      .form-tab.active {
          color: #fff;
          background: transparent;
      }
      .form-tab.active::after {
          content: '';
          position: absolute;
          bottom: -1px; left: 10%; width: 80%; height: 3px;
          background: linear-gradient(90deg, var(--neon-pink), transparent);
      }

      .form-inner {
          padding: 0 30px;
          overflow-y: auto;
      }
      .form-inner::-webkit-scrollbar { width: 4px; }
      .form-inner::-webkit-scrollbar-thumb { background: rgba(0, 240, 255, 0.3); border-radius: 4px; }

      .app-input-group { margin-bottom: 15px; }
      .app-input-group label {
          display: block;
          font-family: 'Outfit', sans-serif;
          letter-spacing: 0.5px;
          font-size: 10px;
          color: #a0a0a0;
          margin-bottom: 6px;
          font-weight: 600;
      }
      
      .app-input-group input,
      .app-input-group select {
          width: 100%;
          background: rgba(0, 0, 0, 0.2) !important;
          border: 1px solid rgba(0, 240, 255, 0.6) !important;
          border-radius: 8px !important;
          padding: 12px 16px !important;
          color: #c4e1f0 !important;
          font-size: 13px !important;
          outline: none;
          transition: 0.3s;
          appearance: none;
      }
      .app-input-group select {
          background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2300F0FF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") !important;
          background-position: right 16px center !important;
          background-repeat: no-repeat !important;
          background-size: 16px !important;
          padding-right: 40px !important;
      }

      .custom-checkbox-wrapper {
          display: flex;
          align-items: center;
          margin-bottom: 15px;
          padding-left: 5px;
      }
      .custom-checkbox-wrapper input[type="checkbox"] {
          width: 14px;
          height: 14px;
          margin-right: 10px;
          accent-color: var(--neon-pink);
          cursor: pointer;
      }
      .custom-checkbox-wrapper label {
          font-size: 14px;
          color: #a0a0a0;
          cursor: pointer;
          margin: 0;
      }
      .custom-checkbox-wrapper a {
          color: #52d2e9;
          text-decoration: none;
      }

      .social-login {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 12px;
          margin-bottom: 20px;
          font-size: 14px;
          color: #a0a0a0;
      }
      .social-btn {
          width: 32px;
          height: 32px;
          border-radius: 6px;
          border: 1px solid rgba(255,255,255,0.2);
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          font-size: 18px;
          color: #a0a0a0;
      }
      .social-btn:hover { color: #fff; border-color: #fff; }
      
      .social-btn.google { border: 2px solid #52d2e9 !important; border-radius: 12px; }
      .social-btn.google i { background: conic-gradient(from -45deg, #ea4335 110deg, #4285f4 90deg 180deg, #34a853 180deg 270deg, #fbbc05 270deg) 73% 55%/150% 150% no-repeat; -webkit-background-clip: text; color: transparent; -webkit-text-fill-color: transparent; }
      .social-btn.linkedin { border: 2px solid #ff3399 !important; border-radius: 12px; color: #52d2e9 !important; }

      .app-btn-submit {
          width: 100%;
          background: linear-gradient(90deg, #FF007F, #D946EF) !important;
          color: #fff !important;
          border: none !important;
          border-radius: 8px !important;
          padding: 16px !important;
          font-family: 'Outfit', sans-serif !important;
          font-size: 14px !important;
          font-weight: 700 !important;
          cursor: pointer;
          transition: 0.3s;
          margin-top: 5px;
      }
      .app-btn-submit:hover {
          transform: translateY(-2px);
          box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4) !important;
      }

      /* LOGO */
      .massive-logo {
          height: 550px;
          margin-left: 0px;
          width: auto;
          position: relative;
          z-index: 5;
          animation: floatLogo 6s ease-in-out infinite;
      }
      @keyframes floatLogo {
          0% { transform: translate(40px, 0px) scale(1.1); }
          50% { transform: translate(40px, -15px) scale(1.1); }
          100% { transform: translate(40px, 0px) scale(1.1); }
      }

      /* RIGHT PANEL: Typography (30%) */
      .typography-panel {
          flex: 3;
          background-color: #000000;
          background: radial-gradient(80% 80% at 100% 0%, rgba(240, 69, 121, 0.35) 0%, rgba(0, 0, 0, 1) 100%);
          display: flex;
          flex-direction: column;
          justify-content: center;
          padding: 80px 60px;
          position: relative;
          z-index: 5;
      }

      .stacked-title {
          font-family: 'Outfit', sans-serif;
          font-size: 100px;
          font-weight: 900;
          line-height: 0.95;
          margin: 0 0 40px 0;
          letter-spacing: -2px;
          background: linear-gradient(to bottom, #F54EA2 0%, #D24CB3 50%, #9E55EB 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          filter: drop-shadow(0px 0px 8px rgba(210, 76, 179, 0.4));
      }

      .typography-subtitle {
          
          color: rgba(82, 210, 233, 0.8) !important;
          font-family: 'Outfit', sans-serif;
          font-size: 28px;
          line-height: 1.6;
          font-weight: 400;
          
      }

      /* Hand-drawn red underlines */
      .red-underline {
          position: relative;
          display: inline-block;
      }
      .red-underline.short::after {
          content: '';
          position: absolute;
          bottom: -6px;
          left: -2%;
          width: 104%;
          height: 7px;
          background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 15' preserveAspectRatio='none'%3E%3Cpath d='M2 10 Q 25 6, 50 9 T 98 8' stroke='%23ff3399' stroke-width='4' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
          background-size: 100% 100%;
          background-repeat: no-repeat;
      }
      .red-underline.long::after {
          content: '';
          position: absolute;
          bottom: -6px;
          left: -2%;
          width: 104%;
          height: 7px;
          background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 15' preserveAspectRatio='none'%3E%3Cpath d='M2 9 Q 30 12, 60 7 T 98 10' stroke='%23ff3399' stroke-width='3' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
          background-size: 100% 100%;
          background-repeat: no-repeat;
      }
      
      .alert-message-reponse {
          font-weight: 600 !important;
          font-size: 12px !important;
          margin-top: 15px;
          text-align: center;
      }
      .forgot-text {
          font-size: 14px;
          color: #a0a0a0;
          text-decoration: none;
          display: block;
          text-align: center;
          margin: 15px auto 0;
          width: max-content;
          border-bottom: 2px solid #ff3399;
          padding-bottom: 3px;
          transition: 0.3s;
      }

      /* MOBILE RESPONSIVE */
      @media (max-width: 1200px) {
          .stacked-title { font-size: 50px; }
          .massive-logo { height: 280px; }
          .glass-form-box { width: 320px; }
      }
      @media (max-width: 991px) {
          .app-wrapper { flex-direction: column; height: 100vh; width: 100vw; border-radius: 0; border: none; overflow-y: auto; }
          .cosmic-panel { flex-direction: column; padding: 100px 20px 40px 20px; min-height: 80vh; }
          .typography-panel { padding: 40px 20px; align-items: center; text-align: center; }
          .badge-container { top: 20px; left: 20px; }
          .massive-logo { height: 200px; margin: 40px 0; }
          .glass-form-box { width: 100%; max-width: 500px; }
          body, html { display: block; overflow-y: auto; }
      }
  </style>

  <body>
    <div class="app-wrapper">
        
        <!-- LEFT PANEL: Cosmic & Form & Logo -->
        <div class="cosmic-panel">
            <div class="cosmic-overlay"></div>
            
                        <div class="composite-badge">
                <div class="badge-seal"><i class="fa-solid fa-crown"></i></div>
                <div class="badge-textbox">PREMIUM GROWTH INFRASTRUCTURE</div>
            </div>
            
            <!-- FORM -->
            <div class="glass-form-box">
                <div class="form-tabs">
                    <div class="form-tab"><?=lang("forgot_password")?></div>
                </div>

                <div class="form-inner">
                    
                    <p class="info-text"><?=lang("enter_your_registration_email_address_to_receive_password_reset_instructions")?></p>

                    <?php echo form_open($form_url, $form_attributes); ?>
                        
                        <div class="app-input-group">
                            <label>EMAIL ADDRESS</label>
                            <input type="email" name="email" id="email" placeholder="Enter your email address" required>
                        </div>
                        
                        <?php if (get_option('enable_goolge_recapcha') &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") : ?>
                        <div class="form-group" style="margin-top: 15px;">
                            <div class="g-recaptcha" data-sitekey="<?=get_option('google_capcha_site_key')?>"></div>
                        </div>
                        <?php endif; ?>

                        <div class="form-group text-center">
                            <div id="alert-message" class="alert-message-reponse text-danger" style="margin-top:10px;"></div>
                        </div>
                        
                        <button class="app-btn-submit btn-submit" type="submit"><?=lang("Submit")?></button>
                    <?php echo form_close(); ?>
                    
                    <div class="forgot-text">
                        <?=lang("already_have_account")?> <a href="<?=cn('auth/login')?>"><?=lang("Login")?></a><br><br>
                        <a href="<?=cn();?>" style="font-size: 11px; opacity: 0.6;"><i class="fa-solid fa-arrow-left"></i> <?=lang('back_to_home');?></a>
                    </div>
                </div>
            </div>

            <!-- LOGO -->
            <img src="<?=BASE?>assets/images/logo.png" class="massive-logo" alt="Logo">
            
        </div>
        
        <!-- RIGHT PANEL: Typography -->
        <div class="typography-panel">
            <h1 class="stacked-title">
                HelpA<br>
                Social<br>
                Matrix
            </h1>
            
                        <p class="typography-subtitle">
                Automated, <span class="red-underline short">secure,</span> and<br>
                instantaneous growth infrastructure<br>
                for the <span class="red-underline long">modern social media age.</span>
            </p>
        </div>

    </div>
  </body>
  <?php include_once 'blocks/script.blade.php'; ?>
</html>
