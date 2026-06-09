<!DOCTYPE html>
<html lang="en">
  <?php include_once 'blocks/head.blade.php'; ?>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </head>
  <style>
      /* PREMIUM DARK NEON GLASS SYSTEM */
      :root {
          --bg-base: #030306;
          --glass-card: rgba(18, 18, 28, 0.65);
          --glass-border: rgba(255, 255, 255, 0.08);
          --neon-pink: #FF007F;
          --neon-cyan: #00F0FF;
          --neon-purple: #8B5CF6;
          --text-main: #FFFFFF;
          --text-dim: #9CA3AF;
          --text-muted: #6B7280;
      }

      body, html { 
          background-color: var(--bg-base) !important;
          color: #fff !important; 
          font-family: 'Poppins', sans-serif !important; 
          min-height: 100vh;
          overflow-x: hidden;
          margin: 0;
          padding: 0;
      }

      /* Ambient Glow Background */
      .ambient-glow {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          pointer-events: none;
          z-index: 0;
          overflow: hidden;
      }

      .glow-orb {
          position: absolute;
          border-radius: 50%;
          filter: blur(100px);
          opacity: 0.12;
      }

      .orb-1 {
          background: var(--neon-pink);
          width: 350px;
          height: 350px;
          top: -5%;
          left: -10%;
      }

      .orb-2 {
          background: var(--neon-cyan);
          width: 400px;
          height: 400px;
          bottom: -5%;
          right: -10%;
      }

      .navbar, .footer, .navbar-custom, footer { display: none !important; }
      
      .login-wrapper {
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 100vh;
          width: 100%;
          padding: 40px 20px;
          position: relative;
          z-index: 1;
      }

      #app-login-container {
          width: 100%;
          max-width: 460px; 
          background: var(--glass-card) !important;
          border: 1px solid var(--glass-border) !important;
          border-radius: 28px !important;
          padding: 50px 40px !important;
          backdrop-filter: blur(20px) !important;
          -webkit-backdrop-filter: blur(20px) !important;
          box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4) !important;
          transition: all 0.3s ease;
          text-align: center;
      }

      #app-login-container:hover {
          border-color: rgba(255, 0, 127, 0.2) !important;
          box-shadow: 0 20px 40px rgba(255, 0, 127, 0.05) !important;
      }
      
      .header-logo {
          display: flex; 
          align-items: center; 
          justify-content: center; 
          margin-bottom: 30px;
          gap: 10px;
      }

      .header-logo h1 { 
          font-family: 'Outfit', sans-serif;
          font-size: 24px; 
          font-weight: 800; 
          letter-spacing: 1px; 
          margin: 0; 
          background: linear-gradient(45deg, var(--neon-cyan), var(--neon-pink));
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
      }

      .header-logo i {
          font-size: 24px;
          color: var(--neon-cyan);
          filter: drop-shadow(0 0 5px var(--neon-cyan));
      }

      .login-card-description {
          font-size: 18px;
          font-weight: 700;
          color: #fff;
          margin-bottom: 12px;
          line-height: 1.4;
      }

      .success-icon {
          font-size: 56px;
          color: #22C55E;
          margin-bottom: 24px;
          filter: drop-shadow(0 0 10px rgba(34, 197, 94, 0.4));
      }

      .info-text {
          font-size: 14px;
          color: var(--text-dim);
          line-height: 1.6;
          margin-bottom: 30px;
      }

      .app-btn-submit {
          display: inline-block;
          text-align: center;
          text-decoration: none;
          width: 100%; 
          background: linear-gradient(135deg, var(--neon-pink) 0%, var(--neon-purple) 100%) !important; 
          color: #fff !important; 
          border: none !important; 
          border-radius: 14px !important;
          padding: 16px !important; 
          font-size: 15px !important; 
          font-weight: 700 !important; 
          cursor: pointer; 
          transition: all 0.3s ease;
          box-shadow: 0 8px 25px rgba(255, 0, 127, 0.3) !important; 
          letter-spacing: 0.5px; 
          text-transform: uppercase;
      }

      .app-btn-submit:hover {
          transform: translateY(-2px);
          box-shadow: 0 12px 30px rgba(255, 0, 127, 0.5) !important;
      }

      .app-btn-submit:active { 
          transform: scale(0.98); 
      }

      /* Staggered Animations */
      @keyframes fadeUp {
          from { opacity: 0; transform: translateY(15px); }
          to { opacity: 1; transform: translateY(0); }
      }
      .animate-item { opacity: 0; animation: fadeUp 0.6s ease forwards; }
      .delay-1 { animation-delay: 0.1s; }
      .delay-2 { animation-delay: 0.2s; }
      .delay-3 { animation-delay: 0.3s; }
      .delay-4 { animation-delay: 0.4s; }
  </style>

  <body>
    <!-- Ambient Glow Background Orbs -->
    <div class="ambient-glow">
        <div class="glow-orb orb-1"></div>
        <div class="glow-orb orb-2"></div>
    </div>

    <div class="login-wrapper">
        <div id="app-login-container" class="animate-item delay-1">
            
            <div class="header-logo animate-item delay-2">
                <img src="<?=BASE?>assets/images/logo.png" style="height: 35px; width: 35px; vertical-align: middle; margin-right: 10px;">
                <h1>HelpA Social Matrix</h1>
            </div>

            <div class="success-icon animate-item delay-3">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <p class="login-card-description animate-item delay-3"><?=lang("congratulations_your_registration_is_now_complete")?></p>
            <p class="info-text animate-item delay-3"><?=lang('congratulations_desc')?></p>

            <a class="app-btn-submit animate-item delay-4" href="<?=cn('auth/login')?>"><?=lang("get_start_now")?></a>
            
        </div>
    </div>

  </body>
  <?php include_once 'blocks/script.blade.php'; ?>
</html>
