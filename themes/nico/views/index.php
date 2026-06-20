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
    <meta name="description" content="<?=get_option('website_desc', "HelpA Global Service - #1 SMM Reseller Panel. Best SMM Panel for Resellers. Also well known for TOP SMM Panel and Cheap SMM Panel for all kind of Social Media Marketing Services.")?>">
    <meta name="keywords" content="<?=get_option('website_keywords', "smm panel, HelpA Global Service, smm reseller panel, smm provider panel, reseller panel, instagram panel, resellerpanel, social media reseller panel, smmpanel, panelsmm")?>">
    <title><?=get_option('website_title', "HelpA Global Service - Premium TikTok & Instagram Growth")?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=get_option('website_favicon', BASE."assets/images/favicon.png")?>">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS Reset & Variables (Matching Sign In theme) */
        :root {
            --neon-pink: #FF007F;
            --neon-cyan: #00F0FF;
            --neon-purple: #8B5CF6;
            --bg-base: #0a040d;
            --glass-card: rgba(15, 20, 35, 0.45);
            --glass-border: rgba(255, 255, 255, 0.06);
            --text-main: #FFFFFF;
            --text-dim: #a0a0a0;
            --text-muted: #6B7280;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
        }

        body {
            background: radial-gradient(ellipse at top right, #db1a68 0%, #0a040d 45%, #000000 100%) !important;
            color: var(--text-main) !important;
            font-family: 'Poppins', sans-serif !important;
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
            filter: blur(140px);
            opacity: 0.12;
            animation: drift 25s infinite alternate ease-in-out;
        }

        .blob-1 {
            background: var(--neon-pink);
            width: 500px;
            height: 500px;
            top: 5%;
            left: -10%;
        }

        .blob-2 {
            background: var(--neon-cyan);
            width: 600px;
            height: 600px;
            top: 45%;
            right: -10%;
            animation-delay: -5s;
        }

        .blob-3 {
            background: var(--neon-purple);
            width: 450px;
            height: 450px;
            bottom: 10%;
            left: 20%;
            animation-delay: -10s;
        }

        @keyframes drift {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(60px, -60px) scale(1.15); }
            100% { transform: translate(-60px, 60px) scale(0.9); }
        }

        /* Navigation Header */
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
            text-decoration: none;
            gap: 12px;
        }

        .logo img {
            max-height: 65px;
            filter: drop-shadow(0 0 10px rgba(0, 240, 255, 0.35));
            transition: all 0.3s;
        }

        .logo img:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 0 15px rgba(255, 0, 127, 0.5));
        }

        .logo-text {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .logo-highlight {
            background: linear-gradient(135deg, var(--neon-cyan) 0%, var(--neon-purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 35px;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-dim);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s, text-shadow 0.3s;
        }

        .nav-links a:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(0, 240, 255, 0.5);
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
            padding: 12px 28px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.5px;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.12);
            transform: translateY(-1px);
        }

        .btn-neon {
            background: linear-gradient(90deg, var(--neon-pink), var(--neon-purple));
            border: none;
            border-radius: 40px;
            padding: 12px 30px;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(255, 0, 127, 0.35);
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-family: 'Outfit', sans-serif;
        }

        .btn-neon:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 0, 127, 0.6), 0 0 15px rgba(0, 240, 255, 0.3);
        }

        /* Hero Section */
        .hero {
            position: relative;
            padding: 180px 8% 80px 8%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            z-index: 1;
        }

        /* ADVANCED COMPOSITE BADGE (From login) */
        .composite-badge {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.6));
            animation: floatBadge 5s ease-in-out infinite;
        }

        @keyframes floatBadge {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .badge-seal {
            transform: translate(4px, -2px);
            width: 48px;
            height: 48px;
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
            font-size: 16px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
        }

        .badge-textbox {
            background: linear-gradient(90deg, rgba(82, 210, 233, 0.25) 0%, rgba(10, 20, 30, 0.8) 100%);
            border: 1px solid #52d2e9;
            border-left: none;
            border-radius: 0 8px 8px 0;
            padding: 6px 18px 6px 24px;
            margin-left: -20px;
            z-index: 1;
            color: #d1f4ff;
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            box-shadow: inset 0 0 15px rgba(82, 210, 233, 0.1);
            text-transform: uppercase;
        }

        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 68px;
            font-weight: 900;
            line-height: 1.05;
            max-width: 950px;
            margin-bottom: 28px;
            letter-spacing: -2.5px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, var(--neon-pink) 0%, var(--neon-cyan) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 40px rgba(255, 0, 127, 0.15);
        }

        .hero p {
            color: var(--text-dim);
            font-size: 18px;
            max-width: 700px;
            line-height: 1.6;
            margin-bottom: 45px;
        }

        /* Hand-drawn red underlines (From login) */
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

        /* Hero Graphics & Live Order Console */
        .hero-graphics {
            position: relative;
            width: 100%;
            max-width: 900px;
            margin-top: 55px;
            z-index: 2;
        }

        .glass-dashboard-mockup {
            background: var(--glass-card);
            border: 2px solid #52d2e9;
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            box-shadow: 0 30px 60px rgba(0,0,0,0.6), inset 0 0 20px rgba(82, 210, 233, 0.08);
            display: flex;
            flex-direction: column;
            gap: 25px;
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
            gap: 7px;
        }

        .dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
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
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: all 0.3s;
        }

        .mockup-card:hover {
            border-color: rgba(0, 240, 255, 0.4);
            transform: translateY(-2px);
        }

        .mockup-card i {
            font-size: 24px;
            color: var(--neon-cyan);
        }

        .mockup-card .num {
            font-size: 30px;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
        }

        .mockup-card .lbl {
            font-size: 12px;
            color: var(--text-dim);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Simulated Console / Log Stream */
        .terminal-console {
            background: rgba(3, 3, 6, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 18px 24px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #52d2e9;
            height: 140px;
            overflow-y: hidden;
            display: flex;
            flex-direction: column;
            gap: 6px;
            box-shadow: inset 0 0 15px rgba(0,0,0,0.8);
            position: relative;
            white-space: pre-wrap;
            word-wrap: break-word;
            word-break: break-all;
        }

        .terminal-console::before {
            content: 'LIVE TRANSACTION STREAM';
            position: absolute;
            top: 5px;
            right: 15px;
            font-size: 9px;
            color: var(--text-muted);
            letter-spacing: 1px;
            font-weight: 700;
        }

        .log-line {
            line-height: 1.4;
            opacity: 0.9;
            animation: logFadeIn 0.3s ease-out forwards;
        }

        @keyframes logFadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 0.9; transform: translateY(0); }
        }

        .log-line .timestamp { color: var(--text-muted); margin-right: 10px; }
        .log-line .success { color: #27C93F; font-weight: 700; }
        .log-line .info { color: #F54EA2; }

        /* Floating Badges */
        .floating-badge {
            position: absolute;
            background: rgba(15, 15, 27, 0.9);
            border: 1px solid var(--glass-border);
            padding: 14px 22px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            z-index: 10;
            transition: all 0.3s;
        }

        .floating-badge:hover {
            transform: scale(1.05);
        }

        .fb-1 {
            top: -25px;
            left: -45px;
            border-color: var(--neon-pink);
            animation: bounce-slow 4s infinite ease-in-out;
        }

        .fb-2 {
            bottom: 30px;
            right: -55px;
            border-color: var(--neon-cyan);
            animation: bounce-slow 4s infinite ease-in-out 2s;
        }

        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
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
            gap: 25px;
            width: 100%;
        }

        .stat-box {
            background: var(--glass-card);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .stat-box:hover {
            border-color: rgba(255, 0, 127, 0.3);
            box-shadow: 0 12px 35px rgba(255, 0, 127, 0.08);
            transform: translateY(-5px);
        }

        .stat-box h3 {
            font-size: 44px;
            font-weight: 800;
            margin-bottom: 8px;
            font-family: 'Outfit', sans-serif;
            letter-spacing: -1px;
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
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Interactive Calculator Section */
        .calculator-section {
            padding: 100px 8% 60px 8%;
            z-index: 2;
            position: relative;
        }

        .calculator-container {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 50px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .calculator-info h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 46px;
            font-weight: 900;
            margin-bottom: 20px;
            line-height: 1.1;
        }

        .calculator-info p {
            color: var(--text-dim);
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .info-pill-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-pill-item {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--glass-border);
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 14px;
        }

        .info-pill-item i {
            color: var(--neon-cyan);
            font-size: 18px;
        }

        .glass-calculator-card {
            background: var(--glass-card);
            border: 2px solid rgba(255, 255, 255, 0.07);
            border-radius: 24px;
            padding: 35px;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .calc-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .calc-group label {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
            color: var(--text-dim);
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .calc-select {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(0, 240, 255, 0.4);
            border-radius: 8px;
            padding: 14px 18px;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2300F0FF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-position: right 18px center;
            background-repeat: no-repeat;
            background-size: 16px;
            transition: all 0.3s;
        }

        .calc-select:hover {
            border-color: var(--neon-pink);
            box-shadow: 0 0 10px rgba(255, 0, 127, 0.2);
        }

        .slider-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .calc-slider {
            flex-grow: 1;
            appearance: none;
            height: 6px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.1);
            outline: none;
            cursor: pointer;
        }

        .calc-slider::-webkit-slider-thumb {
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--neon-pink);
            border: 2px solid #fff;
            box-shadow: 0 0 10px rgba(255,0,127,0.8);
            transition: transform 0.2s;
        }

        .calc-slider::-webkit-slider-thumb:hover {
            transform: scale(1.2);
        }

        .calc-num-input {
            width: 100px;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(0, 240, 255, 0.4);
            border-radius: 8px;
            padding: 10px 12px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            outline: none;
        }

        .total-display-box {
            background: rgba(0, 0, 0, 0.2);
            border: 1px dashed var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .total-left h4 {
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            color: var(--text-dim);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .total-left span {
            font-size: 11px;
            color: #27C93F;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .total-price {
            font-family: 'Outfit', sans-serif;
            font-size: 34px;
            font-weight: 900;
            color: var(--neon-cyan);
            text-shadow: 0 0 15px rgba(0,240,255,0.4);
        }

        /* Services Preview Section */
        .services-preview {
            padding: 80px 8%;
            z-index: 2;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 46px;
            font-weight: 900;
            margin-bottom: 18px;
            letter-spacing: -1px;
        }

        .section-header p {
            color: var(--text-dim);
            font-size: 16px;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .service-card {
            background: var(--glass-card);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px 30px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .service-card:hover {
            border-color: rgba(0, 240, 255, 0.4);
            box-shadow: 0 15px 35px rgba(0, 240, 255, 0.08);
            transform: translateY(-6px);
        }

        .service-card.pink:hover {
            border-color: rgba(255, 0, 127, 0.4);
            box-shadow: 0 15px 35px rgba(255, 0, 127, 0.08);
        }

        .service-card.purple:hover {
            border-color: rgba(139, 92, 246, 0.4);
            box-shadow: 0 15px 35px rgba(139, 92, 246, 0.08);
        }

        .s-icon {
            width: 62px;
            height: 62px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 25px;
            color: var(--neon-cyan);
            transition: all 0.3s;
        }

        .service-card:hover .s-icon {
            background: var(--neon-cyan);
            color: #000;
            box-shadow: 0 0 15px var(--neon-cyan);
            transform: scale(1.05);
        }

        .service-card.pink .s-icon {
            color: var(--neon-pink);
        }

        .service-card.pink:hover .s-icon {
            background: var(--neon-pink);
            color: #fff;
            box-shadow: 0 0 15px var(--neon-pink);
            transform: scale(1.05);
        }

        .service-card.purple .s-icon {
            color: var(--neon-purple);
        }

        .service-card.purple:hover .s-icon {
            background: var(--neon-purple);
            color: #fff;
            box-shadow: 0 0 15px var(--neon-purple);
            transform: scale(1.05);
        }

        .service-card h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
            font-family: 'Outfit', sans-serif;
            letter-spacing: -0.5px;
        }

        .service-card p {
            color: var(--text-dim);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
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
            font-family: 'Outfit', sans-serif;
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
            gap: 25px;
        }

        .step-card {
            background: var(--glass-card);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px 30px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            position: relative;
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .step-card:hover {
            border-color: rgba(139, 92, 246, 0.4);
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(139, 92, 246, 0.08);
        }

        .step-num {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 50px;
            font-weight: 800;
            color: rgba(255,255,255,0.03);
            line-height: 1;
            font-family: 'Outfit', sans-serif;
            transition: color 0.3s;
        }

        .step-card:hover .step-num {
            color: rgba(139, 92, 246, 0.12);
        }

        .step-card h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #fff;
            font-family: 'Outfit', sans-serif;
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
            max-width: 850px;
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
            font-family: 'Outfit', sans-serif;
        }

        .faq-icon {
            font-size: 14px;
            color: var(--text-dim);
            transition: transform 0.3s, color 0.3s;
        }

        .faq-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease-out, padding 0.35s;
            padding: 0 24px;
            color: var(--text-dim);
            font-size: 14px;
            line-height: 1.6;
        }

        .faq-item.active {
            border-color: rgba(0, 240, 255, 0.3);
            box-shadow: 0 5px 20px rgba(0,240,255,0.03);
        }

        .faq-item.active .faq-icon {
            transform: rotate(45deg);
            color: var(--neon-pink);
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
            background: linear-gradient(135deg, rgba(255, 0, 127, 0.08) 0%, rgba(0, 240, 255, 0.08) 100%);
            border: 2px solid rgba(0, 240, 255, 0.2);
            border-radius: 35px;
            padding: 85px 40px;
            max-width: 1050px;
            margin: 0 auto;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 25px;
        }

        .cta-container h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 50px;
            font-weight: 900;
            max-width: 800px;
            line-height: 1.1;
        }

        .cta-container p {
            color: var(--text-dim);
            font-size: 16px;
            max-width: 550px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--glass-border);
            background: #020204;
            padding: 70px 8% 40px 8%;
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

        .footer-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            gap: 12px;
            margin-bottom: 10px;
        }

        .footer-logo img {
            max-height: 60px;
            filter: drop-shadow(0 0 10px rgba(0, 240, 255, 0.2));
        }

        .footer-info p {
            color: var(--text-dim);
            font-size: 14px;
            line-height: 1.6;
            max-width: 340px;
        }

        .footer-links h5 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 22px;
            color: #fff;
            font-family: 'Outfit', sans-serif;
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
            background: rgba(255,255,255,0.02);
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
            box-shadow: 0 0 12px rgba(0, 240, 255, 0.45);
            transform: translateY(-2px);
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
            .hero h1 { font-size: 52px; }
            .calculator-container { grid-template-columns: 1fr; gap: 40px; }
            .stats-grid, .services-grid, .steps-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            header { padding: 12px 4%; }
            .logo img { max-height: 40px; }
            .btn-glass { padding: 8px 18px; font-size: 12px; }
            .btn-neon { padding: 8px 20px; font-size: 12px; }
            .nav-links { display: none; }
            
            .hero { padding: 150px 6% 60px 6%; }
            .hero h1 { font-size: 36px; letter-spacing: -1.5px; line-height: 1.15; }
            .hero p { font-size: 14px; margin-bottom: 30px; }
            
            .mockup-grid { grid-template-columns: 1fr; gap: 12px; }
            .terminal-console { font-size: 11px; padding: 12px 18px; height: 120px; }
            .floating-badge { display: none; }
            
            .stat-box { padding: 22px 15px; }
            .stat-box h3 { font-size: 36px; }
            
            .calculator-info h2 { font-size: 32px; }
            .glass-calculator-card { padding: 25px; }
            
            .services-preview { padding: 60px 6%; }
            .section-header h2 { font-size: 34px; }
            
            .how-works { padding: 60px 6%; }
            .faq-section { padding: 60px 6%; }
            .cta-bottom { padding: 80px 6%; }
            .cta-container { padding: 50px 24px; }
            .cta-container h2 { font-size: 32px; }
            
            .stats-grid, .services-grid, .steps-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; gap: 30px; }
            .footer-bottom { flex-direction: column; gap: 15px; text-align: center; }
        }

        @media (max-width: 576px) {
            .hero .nav-btn-wrapper {
                flex-direction: column;
                width: 100%;
                gap: 12px;
                margin: 0 auto;
            }
            .hero .nav-btn-wrapper a {
                width: 100%;
                text-align: center;
                box-sizing: border-box;
            }
            .composite-badge {
                transform: scale(0.85);
                margin-bottom: 20px;
            }
        }

        @media (max-width: 480px) {
            header { padding: 10px 3%; }
            .logo img { max-height: 32px; }
            .nav-btn-wrapper { gap: 8px; }
            .btn-glass { padding: 6px 12px; font-size: 11px; }
            .btn-neon { padding: 6px 14px; font-size: 11px; }
            
            .hero h1 { font-size: 28px; }
            .slider-wrapper { flex-direction: column; align-items: stretch; gap: 10px; }
            .calc-num-input { width: 100%; }
            .total-display-box { flex-direction: column; text-align: center; gap: 10px; }
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
            <img src="<?=BASE?>assets/images/logo.png" alt="HelpA Logo">
            <span class="logo-text">HelpA <span class="logo-highlight">Global Service</span></span>
        </a>
        <ul class="nav-links">
            <li><a href="#features">Features</a></li>
            <li><a href="#calculator">Calculator</a></li>
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
        <div class="composite-badge">
            <div class="badge-seal"><i class="fa-solid fa-crown"></i></div>
            <div class="badge-textbox">Premium Growth Infrastructure</div>
        </div>
        
        <h1>Automated Growth Infrastructure for the <br><span><span class="red-underline long">Modern Social Media Age</span></span></h1>
        <p>Experience direct wholesale rates, instant API distribution nodes, and autonomous anti-drop monitors. Boost your social authority fully automatically.</p>
        
        <div class="nav-btn-wrapper">
            <?php if(!get_option('disable_signup_page')){ ?>
            <a href="<?=cn('auth/signup')?>" class="btn-neon" style="padding: 16px 36px; font-size: 15px;">Start Growing Now</a>
            <?php } ?>
            <a href="#calculator" class="btn-glass" style="padding: 16px 36px; font-size: 15px;">Calculate Estimate</a>
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
                    <div style="font-size: 11px; color: #52d2e9; font-weight: 700; letter-spacing: 0.5px;">AUTONOMOUS MATRIX CONTROLLER V2.5</div>
                </div>
                <div class="mockup-grid">
                    <div class="mockup-card">
                        <i class="fa-brands fa-tiktok"></i>
                        <div class="num">724K</div>
                        <div class="lbl">Views Routed</div>
                    </div>
                    <div class="mockup-card" style="border-color: rgba(255, 0, 127, 0.2);">
                        <i class="fa-brands fa-instagram" style="color: var(--neon-pink);"></i>
                        <div class="num">98.4K</div>
                        <div class="lbl">Likes Dispatched</div>
                    </div>
                    <div class="mockup-card">
                        <i class="fa-solid fa-network-wired" style="color: var(--neon-purple);"></i>
                        <div class="num">0.08s</div>
                        <div class="lbl">Avg Link Latency</div>
                    </div>
                </div>
                <!-- Simulated Live Transaction Terminal -->
                <div class="terminal-console" id="live-console">
                    <!-- Log lines will be appended here dynamically by JS -->
                </div>
            </div>
            
            <!-- Floating Badges -->
            <div class="floating-badge fb-1">
                <i class="fa-solid fa-shield-halved" style="color: var(--neon-pink); font-size: 20px;"></i>
                <div>
                    <h5 style="font-size: 13px; font-weight: 700;">Secure Node</h5>
                    <p style="font-size: 11px; color: var(--text-dim);">100% Risk Free</p>
                </div>
            </div>
            <div class="floating-badge fb-2">
                <i class="fa-solid fa-bolt" style="color: var(--neon-cyan); font-size: 20px;"></i>
                <div>
                    <h5 style="font-size: 13px; font-weight: 700;">Instant Route</h5>
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
                <p>Transactions Completed</p>
            </div>
            <div class="stat-box pink">
                <h3>0.14s</h3>
                <p>Average Startup Speed</p>
            </div>
            <div class="stat-box purple">
                <h3>99.9%</h3>
                <p>Refill Verification Success</p>
            </div>
            <div class="stat-box">
                <h3>24/7</h3>
                <p>Fully Autonomous Node</p>
            </div>
        </div>
    </section>

    <!-- Service Cost Calculator Section -->
    <section class="calculator-section" id="calculator">
        <div class="calculator-container">
            <div class="calculator-info">
                <h2>Direct Provider Prices. <br><span class="red-underline short">No Middlemen.</span></h2>
                <p>We bypass third-party resellers. Our infrastructure communicates directly with primary social distribution pools, guaranteeing the absolute lowest global prices for premium high-retention growth.</p>
                <div class="info-pill-list">
                    <div class="info-pill-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Calculate exact estimates in real-time before registering</span>
                    </div>
                    <div class="info-pill-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Zero hidden fees or transaction surcharges</span>
                    </div>
                    <div class="info-pill-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Automatic 30-day refills integrated on all standard packages</span>
                    </div>
                </div>
            </div>
            
            <!-- Dynamic Widget -->
            <div class="glass-calculator-card">
                <div class="calc-group">
                    <label for="calc-platform">1. Select Platform</label>
                    <select class="calc-select" id="calc-platform" onchange="updateServicesDropdown()">
                        <option value="tiktok">TikTok Network</option>
                        <option value="instagram">Instagram Network</option>
                        <option value="youtube">YouTube Network</option>
                    </select>
                </div>
                
                <div class="calc-group">
                    <label for="calc-service">2. Select Service Type</label>
                    <select class="calc-select" id="calc-service" onchange="calculatePrice()">
                        <!-- Dynamic options loaded via JS -->
                    </select>
                </div>
                
                <div class="calc-group">
                    <label>3. Order Quantity</label>
                    <div class="slider-wrapper">
                        <input type="range" class="calc-slider" id="calc-slider" min="500" max="50000" step="500" value="5000" oninput="syncSliderToInput()">
                        <input type="number" class="calc-num-input" id="calc-num-input" min="500" max="50000" step="500" value="5000" oninput="syncInputToSlider()">
                    </div>
                </div>
                
                <div class="total-display-box">
                    <div class="total-left">
                        <h4>Estimated Total</h4>
                        <span><i class="fa-solid fa-bolt"></i> Starts in < 2 mins</span>
                    </div>
                    <div class="total-price" id="calc-total">$0.75</div>
                </div>
                
                <?php if(!get_option('disable_signup_page')){ ?>
                <a href="<?=cn('auth/signup')?>" class="btn-neon" style="text-align: center; font-size: 14px; padding: 16px;">Deploy Growth Order</a>
                <?php } else { ?>
                <a href="<?=cn('auth/login')?>" class="btn-neon" style="text-align: center; font-size: 14px; padding: 16px;">Log In to Deploy</a>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Services Preview Section -->
    <section class="services-preview" id="services">
        <div class="section-header">
            <h2>Our High-Velocity Nodes</h2>
            <p>Curated viral acceleration tools engineered specifically for modern social media platforms.</p>
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
                    Starting from <span>$0.70 / 1K</span>
                </div>
            </div>
            <!-- Service Card 3 -->
            <div class="service-card purple">
                <div class="s-icon">
                    <i class="fa-solid fa-circle-play"></i>
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
                <p>Create a secure creator account on our portal using our signup form.</p>
            </div>
            <div class="step-card">
                <div class="step-num">02</div>
                <h4>Add Balance</h4>
                <p>Load funds safely using our secure card and cryptocurrency checkout channels.</p>
            </div>
            <div class="step-card">
                <div class="step-num">03</div>
                <h4>Choose Package</h4>
                <p>Select targeted engagement options for TikTok, Instagram or YouTube.</p>
            </div>
            <div class="step-card">
                <div class="step-num">04</div>
                <h4>Receive Boost</h4>
                <p>Watch your engagement stats explode with instant delivery startup.</p>
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
                    Yes, our distribution methods are fully compliant with search and platform limits. We distribute engagement safely without putting your profile or channel at risk.
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
                    <img src="<?=BASE?>assets/images/logo.png" alt="HelpA Logo">
                    <span class="logo-text" style="font-size: 22px;">HelpA <span class="logo-highlight">Global Service</span></span>
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
                    <li><a href="#calculator">Calculator</a></li>
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
            <div>&copy; <?=date('Y')?> HelpA Global Service. All Rights Reserved.</div>
            <div style="font-size: 11px;">Powered by SmartPanel Architecture.</div>
        </div>
    </footer>

    <!-- Scripts for Calculator and simulated logs -->
    <script>
        // 1. FAQ Accordion Script
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

        // 2. Simulated Live Order Stream Console
        const logConsole = document.getElementById('live-console');
        const simulatedLogs = [
            { type: 'success', text: 'Success! 1,200 Instagram Likes dispatched.' },
            { type: 'info', text: 'Routing order #39281 to JAP Node-C.' },
            { type: 'success', text: 'Success! 10,000 TikTok Views dispatched in 0.07s.' },
            { type: 'info', text: 'Verifying anti-drop integrity for profile link: @creator_brand.' },
            { type: 'success', text: 'Refill verification complete: Status: Stable [No drop detected].' },
            { type: 'info', text: 'Dispatching YouTube subscribers routing request.' },
            { type: 'success', text: 'Success! 200 YouTube subscribers routed successfully.' },
            { type: 'info', text: 'Analyzing API channel latency: Average 0.08s.' },
            { type: 'success', text: 'Success! 5,000 Instagram followers routed to high-retention pool.' }
        ];

        function getTimestamp() {
            const now = new Date();
            return `[${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}:${now.getSeconds().toString().padStart(2, '0')}]`;
        }

        function addLogLine() {
            const log = simulatedLogs[Math.floor(Math.random() * simulatedLogs.length)];
            const line = document.createElement('div');
            line.className = 'log-line';
            
            const tsSpan = document.createElement('span');
            tsSpan.className = 'timestamp';
            tsSpan.textContent = getTimestamp();
            
            const msgSpan = document.createElement('span');
            msgSpan.className = log.type;
            msgSpan.textContent = log.text;
            
            line.appendChild(tsSpan);
            line.appendChild(msgSpan);
            
            logConsole.appendChild(line);
            
            // Keep only latest 6 lines
            while (logConsole.children.length > 5) {
                logConsole.removeChild(logConsole.firstChild);
            }
            
            // Auto scroll (though not needed if capped at 5)
            logConsole.scrollTop = logConsole.scrollHeight;
        }

        // Initialize with 4 lines
        for(let i=0; i<4; i++) {
            setTimeout(addLogLine, i * 800);
        }
        // Loop continuously
        setInterval(addLogLine, 3500);

        // 3. Service Price Calculator Script
        const servicesData = {
            tiktok: [
                { id: 'views', name: 'Premium High-Retention Views', rate: 0.15 },
                { id: 'likes', name: 'High-Retention Likes', rate: 0.80 },
                { id: 'followers', name: 'Real-Looking Profile Followers', rate: 1.20 }
            ],
            instagram: [
                { id: 'likes', name: 'Instant Real-Post Likes', rate: 0.70 },
                { id: 'followers', name: 'Premium Stable Followers', rate: 1.10 },
                { id: 'views', name: 'HQ Video/Reels Views', rate: 0.10 }
            ],
            youtube: [
                { id: 'views', name: 'Organic-Drip Video Views', rate: 1.50 },
                { id: 'likes', name: 'High-Retention Video Likes', rate: 1.80 },
                { id: 'subs', name: 'Stable Channel Subscribers', rate: 4.50 }
            ]
        };

        const platformSelect = document.getElementById('calc-platform');
        const serviceSelect = document.getElementById('calc-service');
        const sliderInput = document.getElementById('calc-slider');
        const numInput = document.getElementById('calc-num-input');
        const totalDisplay = document.getElementById('calc-total');

        function updateServicesDropdown() {
            const platform = platformSelect.value;
            const services = servicesData[platform];
            serviceSelect.innerHTML = '';
            services.forEach(srv => {
                const opt = document.createElement('option');
                opt.value = srv.rate;
                opt.textContent = `${srv.name} ($${srv.rate.toFixed(2)}/1K)`;
                serviceSelect.appendChild(opt);
            });
            calculatePrice();
        }

        function calculatePrice() {
            const rate = parseFloat(serviceSelect.value) || 0;
            const qty = parseInt(numInput.value) || 0;
            const total = (qty / 1000) * rate;
            totalDisplay.textContent = `$${total.toFixed(2)}`;
        }

        function syncSliderToInput() {
            numInput.value = sliderInput.value;
            calculatePrice();
        }

        function syncInputToSlider() {
            let val = parseInt(numInput.value);
            if (isNaN(val)) val = 500;
            if (val < 500) val = 500;
            if (val > 50000) val = 50000;
            sliderInput.value = val;
            numInput.value = val;
            calculatePrice();
        }

        // Initialize Calculator
        updateServicesDropdown();
    </script>
</body>
</html>