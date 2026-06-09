<?php
    // If the user is already logged in, redirect them directly to the app dashboard
    if (session('uid')) {
        header("Location: " . cn('statistics'));
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?=get_option('website_title', "HelpA Social Matrix - Premium TikTok & Instagram Growth")?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=get_option('website_favicon', BASE."assets/images/favicon.png")?>">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS Reset & Variable Tokens */
        :root {
            --bg-base: #030306;
            --glass-card: rgba(15, 15, 27, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
            --neon-pink: #FF007F;
            --neon-cyan: #00F0FF;
            --neon-blue: #0072FF;
            --neon-purple: #8B5CF6;
            --text-main: #FFFFFF;
            --text-dim: #9CA3AF;
            --text-muted: #6B7280;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-main);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Ambient Glow Blobs */
        .ambient-glow-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .glow-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.15;
            animation: drift 25s infinite alternate ease-in-out;
        }

        .blob-1 {
            background: var(--neon-pink);
            width: 500px;
            height: 500px;
            top: -10%;
            left: -10%;
        }

        .blob-2 {
            background: var(--neon-cyan);
            width: 600px;
            height: 600px;
            bottom: 20%;
            right: -10%;
            animation-delay: -5s;
        }

        .blob-3 {
            background: var(--neon-purple);
            width: 400px;
            height: 400px;
            top: 40%;
            left: 50%;
            animation-delay: -10s;
        }

        @keyframes drift {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(50px, -50px) scale(1.1); }
            100% { transform: translate(-50px, 50px) scale(0.9); }
        }

        /* Navbar */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 8%;
            z-index: 100;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 24px;
            color: #fff;
            letter-spacing: 1px;
        }

        .logo span {
            background: linear-gradient(45deg, var(--neon-cyan), var(--neon-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo img {
            max-height: 38px;
            filter: drop-shadow(0 0 8px rgba(0, 240, 255, 0.4));
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-dim);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #fff;
        }

        .nav-btn-wrapper {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            padding: 12px 24px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }

        .btn-neon {
            background: linear-gradient(135deg, var(--neon-pink), var(--neon-purple));
            border: none;
            border-radius: 40px;
            padding: 12px 28px;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 0, 127, 0.3);
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-neon:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 0, 127, 0.5);
        }

        /* Hero Section */
        .hero {
            position: relative;
            padding: 180px 8% 100px 8%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            z-index: 1;
        }

        .badge-viral {
            background: rgba(0, 240, 255, 0.1);
            border: 1px solid rgba(0, 240, 255, 0.3);
            color: var(--neon-cyan);
            border-radius: 40px;
            padding: 6px 16px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 24px;
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.1);
        }

        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 64px;
            font-weight: 800;
            line-height: 1.1;
            max-width: 900px;
            margin-bottom: 24px;
            letter-spacing: -1px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, var(--neon-pink) 0%, var(--neon-cyan) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 40px rgba(255, 0, 127, 0.1);
        }

        .hero p {
            color: var(--text-dim);
            font-size: 18px;
            max-width: 650px;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        /* Floating elements in hero */
        .hero-graphics {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin-top: 50px;
        }

        .glass-dashboard-mockup {
            background: var(--glass-card);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: left;
            position: relative;
        }

        .mockup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--glass-border);
            padding-bottom: 15px;
        }

        .dots {
            display: flex;
            gap: 6px;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
        }

        .dot.red { background: #FF5F56; }
        .dot.yellow { background: #FFBD2E; }
        .dot.green { background: #27C93F; }

        .mockup-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .mockup-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mockup-card i {
            font-size: 24px;
            color: var(--neon-cyan);
        }

        .mockup-card .num {
            font-size: 28px;
            font-weight: 700;
        }

        .mockup-card .lbl {
            font-size: 12px;
            color: var(--text-dim);
        }

        /* Floating Badge Icons */
        .floating-badge {
            position: absolute;
            background: rgba(15, 15, 27, 0.8);
            border: 1px solid var(--glass-border);
            padding: 12px 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 10;
        }

        .fb-1 {
            top: -20px;
            left: -40px;
            border-color: var(--neon-pink);
            animation: bounce-slow 4s infinite ease-in-out;
        }

        .fb-2 {
            bottom: 40px;
            right: -50px;
            border-color: var(--neon-cyan);
            animation: bounce-slow 4s infinite ease-in-out 2s;
        }

        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Stats Section */
        .stats-section {
            padding: 60px 8%;
            z-index: 2;
            position: relative;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            width: 100%;
        }

        .stat-box {
            background: var(--glass-card);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 30px;
            text-align: center;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.3s;
        }

        .stat-box:hover {
            border-color: rgba(255, 0, 127, 0.3);
            box-shadow: 0 10px 30px rgba(255, 0, 127, 0.05);
            transform: translateY(-5px);
        }

        .stat-box h3 {
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 8px;
            background: linear-gradient(45deg, #fff, var(--text-dim));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-box.cyan h3 {
            background: linear-gradient(45deg, #fff, var(--neon-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-box.pink h3 {
            background: linear-gradient(45deg, #fff, var(--neon-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-box.purple h3 {
            background: linear-gradient(45deg, #fff, var(--neon-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-box p {
            color: var(--text-dim);
            font-size: 14px;
            font-weight: 500;
        }

        /* Services Preview Section */
        .services-preview {
            padding: 100px 8%;
            z-index: 2;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 44px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .section-header p {
            color: var(--text-dim);
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .service-card {
            background: var(--glass-card);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px 30px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .service-card:hover {
            border-color: rgba(0, 240, 255, 0.3);
            box-shadow: 0 15px 35px rgba(0, 240, 255, 0.05);
            transform: translateY(-5px);
        }

        .s-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 24px;
            color: var(--neon-cyan);
            transition: all 0.3s;
        }

        .service-card:hover .s-icon {
            background: var(--neon-cyan);
            color: #000;
            box-shadow: 0 0 15px var(--neon-cyan);
        }

        .service-card.pink:hover .s-icon {
            background: var(--neon-pink);
            color: #fff;
            box-shadow: 0 0 15px var(--neon-pink);
        }

        .service-card.pink .s-icon {
            color: var(--neon-pink);
        }

        .service-card.purple:hover .s-icon {
            background: var(--neon-purple);
            color: #fff;
            box-shadow: 0 0 15px var(--neon-purple);
        }

        .service-card.purple .s-icon {
            color: var(--neon-purple);
        }

        .service-card h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .service-card p {
            color: var(--text-dim);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
            flex-grow: 1;
        }

        .service-price {
            font-size: 13px;
            color: var(--text-muted);
            border-top: 1px solid var(--glass-border);
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .service-price span {
            color: #fff;
            font-weight: 700;
            font-size: 16px;
        }

        /* How it works */
        .how-works {
            padding: 80px 8%;
            z-index: 2;
            position: relative;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .step-card {
            background: var(--glass-card);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px 30px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            position: relative;
            transition: all 0.3s;
        }

        .step-card:hover {
            border-color: rgba(139, 92, 246, 0.3);
            transform: translateY(-5px);
        }

        .step-num {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 48px;
            font-weight: 800;
            color: rgba(255,255,255,0.03);
            line-height: 1;
            font-family: 'Outfit', sans-serif;
            transition: color 0.3s;
        }

        .step-card:hover .step-num {
            color: rgba(139, 92, 246, 0.1);
        }

        .step-card h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #fff;
        }

        .step-card p {
            color: var(--text-dim);
            font-size: 13px;
            line-height: 1.6;
        }

        /* FAQ Section */
        .faq-section {
            padding: 100px 8%;
            z-index: 2;
            position: relative;
        }

        .faq-container {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .faq-item {
            background: var(--glass-card);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.3s;
        }

        .faq-header {
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .faq-header h5 {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
        }

        .faq-icon {
            font-size: 14px;
            color: var(--text-dim);
            transition: transform 0.3s;
        }

        .faq-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s;
            padding: 0 24px;
            color: var(--text-dim);
            font-size: 14px;
            line-height: 1.6;
        }

        .faq-item.active {
            border-color: rgba(255, 255, 255, 0.15);
        }

        .faq-item.active .faq-icon {
            transform: rotate(45deg);
            color: #fff;
        }

        .faq-item.active .faq-body {
            max-height: 200px;
            padding-bottom: 24px;
        }

        /* CTA Bottom Section */
        .cta-bottom {
            padding: 120px 8%;
            z-index: 2;
            position: relative;
            text-align: center;
        }

        .cta-container {
            background: linear-gradient(135deg, rgba(255, 0, 127, 0.05) 0%, rgba(0, 240, 255, 0.05) 100%);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            padding: 80px 40px;
            max-width: 1000px;
            margin: 0 auto;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 24px;
        }

        .cta-container h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 48px;
            font-weight: 800;
            max-width: 700px;
        }

        .cta-container p {
            color: var(--text-dim);
            font-size: 16px;
            max-width: 500px;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--glass-border);
            background: #020204;
            padding: 60px 8% 40px 8%;
            position: relative;
            z-index: 2;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 50px;
            margin-bottom: 60px;
        }

        .footer-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .footer-info p {
            color: var(--text-dim);
            font-size: 14px;
            line-height: 1.6;
            max-width: 320px;
        }

        .footer-links h5 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            color: #fff;
        }

        .footer-links ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-links a {
            color: var(--text-dim);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #fff;
        }

        .social-icons {
            display: flex;
            gap: 16px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dim);
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            color: #fff;
            border-color: var(--neon-cyan);
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.3);
            transform: scale(1.05);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(255,255,255,0.05);
            padding-top: 30px;
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero h1 { font-size: 48px; }
            .stats-grid, .services-grid, .steps-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            header { padding: 15px 5%; }
            .nav-links { display: none; }
            .hero h1 { font-size: 38px; }
            .hero p { font-size: 15px; }
            .stats-grid, .services-grid, .steps-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; gap: 30px; }
            .footer-bottom { flex-direction: column; gap: 15px; text-align: center; }
            .floating-badge { display: none; }
        }
    </style>
</head>
<body>

    <!-- Drifting Ambient Glow Blobs -->
    <div class="ambient-glow-wrapper">
        <div class="glow-blob blob-1"></div>
        <div class="glow-blob blob-2"></div>
        <div class="glow-blob blob-3"></div>
    </div>

    <!-- Navigation Header -->
    <header>
        <a href="<?=cn()?>" class="logo">
            <img src="<?=BASE?>assets/images/logo.png" alt="Website Logo" style="max-height: 70px; vertical-align: middle; margin-right: 10px;">
        </a>
        <ul class="nav-links">
            <li><a href="#features">Features</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#how-it-works">How It Works</a></li>
            <li><a href="#faq">FAQ</a></li>
        </ul>
        <div class="nav-btn-wrapper">
            <a href="<?=cn('auth/login')?>" class="btn-glass">Log In</a>
            <?php if(!get_option('disable_signup_page')){ ?>
            <a href="<?=cn('auth/signup')?>" class="btn-neon">Sign Up</a>
            <?php } ?>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="badge-viral">
            <i class="fa-solid fa-fire mr-2"></i> Instant Viral Boost
        </div>
        <h1>Powering the Next Generation of <span>Creator Brands</span></h1>
        <p>The premium automated SMM hub for TikTok & Instagram growth. Instant delivery, high retention, and fully autonomous viral acceleration.</p>
        
        <div class="nav-btn-wrapper">
            <?php if(!get_option('disable_signup_page')){ ?>
            <a href="<?=cn('auth/signup')?>" class="btn-neon" style="padding: 16px 36px; font-size: 15px;">Start Growing Now</a>
            <?php } ?>
            <a href="#services" class="btn-glass" style="padding: 16px 36px; font-size: 15px;">View Services</a>
        </div>

        <div class="hero-graphics" id="features">
            <!-- Glassmorphic Mockup -->
            <div class="glass-dashboard-mockup">
                <div class="mockup-header">
                    <div class="dots">
                        <div class="dot red"></div>
                        <div class="dot yellow"></div>
                        <div class="dot green"></div>
                    </div>
                    <div style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Autonomous SMM Controller v2.4</div>
                </div>
                <div class="mockup-grid">
                    <div class="mockup-card">
                        <i class="fa-brands fa-tiktok"></i>
                        <div class="num">724K</div>
                        <div class="lbl">Views Delivered</div>
                    </div>
                    <div class="mockup-card" style="border-color: rgba(255, 0, 127, 0.2);">
                        <i class="fa-brands fa-instagram" style="color: var(--neon-pink);"></i>
                        <div class="num">98.4K</div>
                        <div class="lbl">Likes Dispatched</div>
                    </div>
                    <div class="mockup-card">
                        <i class="fa-solid fa-chart-line" style="color: var(--neon-purple);"></i>
                        <div class="num">0.12s</div>
                        <div class="lbl">Avg Response Time</div>
                    </div>
                </div>
            </div>
            <!-- Floating Badges -->
            <div class="floating-badge fb-1">
                <i class="fa-solid fa-shield-halved" style="color: var(--neon-pink); font-size: 20px;"></i>
                <div>
                    <h5 style="font-size: 13px; font-weight: 700;">Secure Portal</h5>
                    <p style="font-size: 11px; color: var(--text-dim);">100% Risk Free</p>
                </div>
            </div>
            <div class="floating-badge fb-2">
                <i class="fa-solid fa-bolt" style="color: var(--neon-cyan); font-size: 20px;"></i>
                <div>
                    <h5 style="font-size: 13px; font-weight: 700;">Instant Launch</h5>
                    <p style="font-size: 11px; color: var(--text-dim);">Automated Queues</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-box cyan">
                <h3>12.8M</h3>
                <p>Total Orders Dispatched</p>
            </div>
            <div class="stat-box pink">
                <h3>0.14s</h3>
                <p>Average Startup Speed</p>
            </div>
            <div class="stat-box purple">
                <h3>99.9%</h3>
                <p>Refill Delivery Success</p>
            </div>
            <div class="stat-box">
                <h3>24/7</h3>
                <p>Autonomous Support</p>
            </div>
        </div>
    </section>

    <!-- Services Preview Section -->
    <section class="services-preview" id="services">
        <div class="section-header">
            <h2>Our High-Velocity Services</h2>
            <p>Curated viral acceleration tools engineered specifically for modern TikTok and Instagram content creators.</p>
        </div>
        <div class="services-grid">
            <!-- Service Card 1 -->
            <div class="service-card">
                <div class="s-icon">
                    <i class="fa-brands fa-tiktok"></i>
                </div>
                <h4>TikTok Followers</h4>
                <p>Boost your TikTok authority with premium, active profile followers. Includes full refill guarantee and organic-looking gradual drip-feed.</p>
                <div class="service-price">
                    Starting from <span>$1.20 / 1K</span>
                </div>
            </div>
            <!-- Service Card 2 -->
            <div class="service-card pink">
                <div class="s-icon">
                    <i class="fa-brands fa-instagram"></i>
                </div>
                <h4>Instagram Likes</h4>
                <p>Get instant visual proof on your IG posts or reels. Instantly queued and fully optimized for discovery page placement.</p>
                <div class="service-price">
                    Starting from <span>$0.80 / 1K</span>
                </div>
            </div>
            <!-- Service Card 3 -->
            <div class="service-card purple">
                <div class="s-icon">
                    <i class="fa-solid fa-play"></i>
                </div>
                <h4>TikTok Views</h4>
                <p>Explode your video retention statistics. Our high-retention views signal the TikTok algorithm to trigger the For You Page.</p>
                <div class="service-price">
                    Starting from <span>$0.15 / 1K</span>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="how-works" id="how-it-works">
        <div class="section-header">
            <h2>Launch in 4 Simple Steps</h2>
            <p>Connect with our SMM infrastructure and dispatch your orders in minutes.</p>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">01</div>
                <h4>Register Free</h4>
                <p>Create a secure creator account on our portal using signup form.</p>
            </div>
            <div class="step-card">
                <div class="step-num">02</div>
                <h4>Add Balance</h4>
                <p>Load funds safely using our variety of secure checkout options.</p>
            </div>
            <div class="step-card">
                <div class="step-num">03</div>
                <h4>Choose Package</h4>
                <p>Select targeted engagement options for TikTok or Instagram.</p>
            </div>
            <div class="step-card">
                <div class="step-num">04</div>
                <h4>Receive Boost</h4>
                <p>Watch your engagement skyrocket with instant delivery startup.</p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section" id="faq">
        <div class="section-header">
            <h2>Frequently Answered Queries</h2>
            <p>Everything you need to know about our viral distribution platform.</p>
        </div>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-header">
                    <h5>Are these services safe for my TikTok/Instagram accounts?</h5>
                    <i class="fa-solid fa-plus faq-icon"></i>
                </div>
                <div class="faq-body">
                    Yes, our distribution methods are fully compliant with search and platform limits. We distribute engagement safely without putting your profile at risk.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-header">
                    <h5>How fast does delivery begin?</h5>
                    <i class="fa-solid fa-plus faq-icon"></i>
                </div>
                <div class="faq-body">
                    Orders are processed instantaneously. The typical startup speed is under 2 minutes, and views/likes will propagate on your link immediately.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-header">
                    <h5>What is the refill policy?</h5>
                    <i class="fa-solid fa-plus faq-icon"></i>
                </div>
                <div class="faq-body">
                    Most of our premium services include a 30-day automated refill warranty. If your engagement fluctuates, our system automatically tops it up.
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Bottom Section -->
    <section class="cta-bottom">
        <div class="cta-container">
            <h2>Ready to Explode Your Social Footprint?</h2>
            <p>Join thousands of content creators, influencers, and digital brands using our viral engine daily.</p>
            <?php if(!get_option('disable_signup_page')){ ?>
            <a href="<?=cn('auth/signup')?>" class="btn-neon" style="padding: 18px 40px; font-size: 16px;">Create Account</a>
            <?php } else { ?>
            <a href="<?=cn('auth/login')?>" class="btn-neon" style="padding: 18px 40px; font-size: 16px;">Launch Portal</a>
            <?php } ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-info">
                <a href="<?=cn()?>" class="footer-logo">
                    <img src="<?=BASE?>assets/images/logo.png" alt="Website Logo" style="max-height: 70px; vertical-align: middle; margin-right: 10px;">
                </a>
                <p>Automated, secure, and instantaneous growth infrastructure engineered for the social media age.</p>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h5>Platform</h5>
                <ul>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#how-it-works">How It Works</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h5>Legal</h5>
                <ul>
                    <li><a href="<?=cn('terms')?>">Terms of Service</a></li>
                    <li><a href="<?=cn('terms')?>">Privacy Policy</a></li>
                    <li><a href="<?=cn('faq')?>">Support Hub</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div>&copy; <?=date('Y')?> HelpA Social Matrix. All Rights Reserved.</div>
            <div style="font-size: 11px;">Powered by SmartPanel Architecture.</div>
        </div>
    </footer>

    <!-- FAQ Accordion Script -->
    <script>
        document.querySelectorAll('.faq-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const isActive = item.classList.contains('active');
                
                // Close other items
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
                
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>