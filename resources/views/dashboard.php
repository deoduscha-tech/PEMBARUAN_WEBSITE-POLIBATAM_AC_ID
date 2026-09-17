<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat P2M Polibatam</title>
    <link rel="icon" type="image/png" sizes="32x32" href="https://p2m.polibatam.ac.id/wp-content/uploads/2020/01/cropped-Logo-Polibatam-3-32x32.png">
    <link rel="apple-touch-icon" href="https://p2m.polibatam.ac.id/wp-content/uploads/2020/01/cropped-Logo-Polibatam-3-32x32.png">
    <style>
        /* =========================================================
           Theme variables and shared base styles
        ========================================================= */
        :root {
            --navy-dark: #0d244a;
            --navy: #0e2d5d;
            --navy-soft: #1d4c81;
            --blue: #1c73d9;
            --blue-soft: #dff4ff;
            --gold: #f4bd3b;
            --page-bg: #dfe3e8;
            --panel-bg: #f4f4f4;
            --text: #1d2430;
            --muted: #5c6777;
            --line: #dfe5ec;
            --white: #ffffff;
            --shadow: 0 10px 25px rgba(12, 24, 54, 0.08);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--page-bg);
            color: var(--text);
            line-height: 1.5;
        }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; display: block; }

        .page {
            width: 100%;
            margin: 0 auto;
            background: transparent;
        }

        .top-date,
        .hero-wrap,
        .nav-bar,
        .footer,
        .page-shell {
            width: 100%;
            max-width: none;
        }

        .top-date {
            background: #081d35;
            color: #dfeafc;
            font-size: 15px;
            font-weight: 700;
            padding: 9px 0 8px;
            letter-spacing: 0.01em;
            line-height: 1.4;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .top-date-row {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
        }

        .top-date-text {
            letter-spacing: 0.01em;
        }

        .top-date-time {
            background: #1c73d9;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            padding: 3px 9px;
            letter-spacing: 0.02em;
            border-radius: 3px;
        }

        .page-inner {
            max-width: 1240px;
            margin: 0 auto;
            width: calc(100% - 22px);
        }

        .hero-wrap {
            position: relative;
            background: linear-gradient(180deg, rgba(15, 32, 58, 0.56), rgba(15, 32, 58, 0.42)),
                url('https://p2m.polibatam.ac.id/wp-content/themes/newsup/images/head-back.jpg') center/cover no-repeat;
            min-height: 138px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-top: 1px solid rgba(255,255,255,0.12);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
        }

        .hero-wrap::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 4px;
            background: linear-gradient(90deg, #1c73d9, #2d9aff);
            z-index: 2;
        }

        .branding-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 16px;
            padding: 12px 0;
            min-height: 110px;
        }

        .site-logo {
            width: 68px;
            height: 68px;
            border-radius: 12px;
            background: linear-gradient(180deg, #ffffff, #dfefff) url('https://p2m.polibatam.ac.id/wp-content/uploads/2020/01/cropped-Logo-Polibatam-3-32x32.png') center center no-repeat;
            background-size: contain;
            box-shadow: 0 8px 24px rgba(0,0,0,0.18);
            border: 3px solid rgba(255,255,255,0.6);
            flex-shrink: 0;
            transform: rotate(-5deg);
        }

        .site-logo::before {
            content: "";
        }

        .site-branding-text {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            text-align: left;
        }

        .hero-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(transparent 0, transparent 96%, rgba(255,255,255,0.12) 100%),
                linear-gradient(90deg, transparent 0, transparent 96%, rgba(255,255,255,0.12) 100%);
            background-size: 30px 30px;
            opacity: 0.5;
        }

        .hero-title {
            position: relative;
            z-index: 1;
            color: rgba(255,255,255,0.98);
            font-size: clamp(2rem, 2.4vw, 2.4rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            text-shadow: 0 4px 18px rgba(0,0,0,0.25);
            margin: 0;
            line-height: 1.08;
        }

        .nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(180deg, #1a4d88, #0d2e5d);
            padding: 0 10px 0 0;
            min-height: 50px;
            gap: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            box-shadow: inset 0 -1px 0 rgba(255,255,255,0.05);
        }

        .nav-main {
            display: flex;
            align-items: center;
            gap: 0;
            flex-wrap: wrap;
            width: 100%;
        }

        .nav-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            background: rgba(255,255,255,0.12);
            border-right: 1px solid rgba(255,255,255,0.1);
            color: white;
            font-size: 1.2rem;
            margin-right: 8px;
        }

        .nav-item {
            padding: 16px 11px 15px;
            color: rgba(255,255,255,0.88);
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            font-size: 0.7rem;
            border-bottom: 3px solid transparent;
            line-height: 1.2;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.05);
            color: white;
        }

        .nav-item.active {
            background: rgba(26, 153, 255, 0.18);
            border-bottom-color: var(--gold);
            color: white;
        }

        /* =========================================================
           Navigation and ticker styles
        ========================================================= */
        .nav-item .caret {
            display: inline-block;
            margin-left: 4px;
            font-size: 0.7rem;
            opacity: 0.85;
            vertical-align: middle;
        }

        .nav-search {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            color: white;
            font-size: 1.05rem;
            border-left: 1px solid rgba(255,255,255,0.15);
            margin-left: 8px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .nav-search:hover {
            background: rgba(255,255,255,0.08);
        }

        .site-search-panel {
            width: 100%;
            background: linear-gradient(180deg, #f5f9ff, #edf4ff);
            border-bottom: 1px solid rgba(13, 45, 94, 0.08);
            padding: 10px 0 12px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.7);
        }

        .site-search-inner {
            width: min(1240px, calc(100% - 22px));
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            border: 1px solid rgba(13, 45, 94, 0.12);
            border-radius: 999px;
            padding: 8px 12px 8px 18px;
            box-shadow: 0 8px 18px rgba(13, 45, 94, 0.08);
        }

        #global-search-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 9px 0;
            color: #132c54;
            font-size: 0.98rem;
            outline: none;
        }

        #global-search-input::placeholder {
            color: #71819a;
        }

        .site-search-close {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 50%;
            background: #eaf1ff;
            color: #133b70;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
        }

        .mg-latest-news-sec {
            background: #f7f9fc;
            border-top: 1px solid rgba(15, 33, 61, 0.08);
            border-bottom: 1px solid rgba(15, 33, 61, 0.08);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
        }

        .mg-latest-news {
            display: flex;
            align-items: center;
            width: 100%;
            min-height: 52px;
            overflow: hidden;
        }

        .bn_title {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 180px;
            background: linear-gradient(180deg, #1e7be8, #0e5ebf);
            color: white;
            height: 52px;
            padding: 0 20px;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: none;
            font-size: 1.02rem;
            box-shadow: inset 0 -1px 0 rgba(0,0,0,0.08);
            flex-shrink: 0;
        }

        .bn_title .title {
            margin: 0;
            font-size: 1rem;
            font-weight: 800;
            color: white;
            line-height: 1;
        }

        .bn_title .ticker-badge {
            position: relative;
            z-index: 1;
            font-size: 1rem;
            padding: 0;
            background: transparent;
            box-shadow: none;
            gap: 11px;
        }

        .bn_title .ticker-badge::after {
            content: none;
        }

        .bn_title .ticker-icon {
            width: 24px;
            height: 24px;
            border-radius: 7px;
            font-size: 1rem;
            background: linear-gradient(180deg, #cdefff, #4fb3f7);
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.6), 0 0 14px rgba(120, 206, 255, 0.9);
        }

        .ticker {
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, #edf5ff, #ebf2ff);
            border: none;
            padding: 0;
            color: #102b52;
            font-weight: 700;
            font-size: 0.95rem;
            margin-top: 0;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
            flex: 1;
            height: 52px;
            display: flex;
            align-items: center;
        }

        .ticker-track {
            display: flex;
            align-items: center;
            height: 100%;
            gap: 0;
            white-space: nowrap;
            width: max-content;
            animation: ticker-scroll 60s linear infinite;
            will-change: transform;
        }

        .ticker-group {
            display: flex;
            align-items: center;
            flex: 0 0 auto;
            height: 100%;
        }

        .ticker:hover .ticker-track {
            animation-play-state: paused;
        }

        .ticker-item {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            height: 100%;
            padding: 0 26px;
            color: #0d4aa6;
            font-weight: 700;
            font-size: 0.95rem;
            line-height: 1;
            white-space: nowrap;
            text-decoration: none;
            position: relative;
        }

        .ticker-dot {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #1c73d9;
            flex-shrink: 0;
            box-shadow: 0 0 0 3px rgba(28, 115, 217, 0.16);
        }

        .ticker-item:hover {
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .ticker-item:not(:last-child)::after {
            content: "\2022";
            position: absolute;
            right: -3px;
            color: #9aa7b6;
            font-size: 1.1rem;
            text-decoration: none;
        }

        .ticker-track > .ticker-group:first-child .ticker-item:first-child {
            padding-left: 26px;
        }

        @keyframes ticker-scroll {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-50%);
            }
        }

        .ticker-badge {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(180deg, #1d7ae6, #0d5fc8);
            color: white;
            padding: 10px 16px 10px 12px;
            border-radius: 9px 9px 9px 9px;
            font-weight: 800;
            font-size: 0.92rem;
            letter-spacing: 0.01em;
            flex-shrink: 0;
            overflow: visible;
            box-shadow: inset 0 -1px 0 rgba(0,0,0,0.1), 0 4px 18px rgba(29, 122, 230, 0.35);
        }

        .ticker-badge::after {
            content: "";
            position: absolute;
            inset: -6px;
            border-radius: 12px;
            background: rgba(45, 154, 255, 0.12);
            z-index: -1;
            animation: pulse-ring 1.6s ease-out infinite;
        }

        .ticker-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 6px;
            background: linear-gradient(180deg, #9ce6ff, #38a6f3);
            color: #f7fbff;
            font-size: 0.9rem;
            line-height: 1;
            font-weight: 900;
            animation: bolt-flash 1.15s ease-in-out infinite;
            transform-origin: center;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.45), 0 0 12px rgba(87, 181, 255, 0.75);
            text-shadow: 0 0 10px rgba(255,255,255,0.7);
        }


        @keyframes bolt-flash {
            0%, 100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.45), 0 0 12px rgba(87, 181, 255, 0.75);
            }
            15% {
                transform: scale(1.22) rotate(12deg);
                opacity: 1;
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.5), 0 0 18px rgba(120, 206, 255, 0.9);
            }
            35% {
                transform: scale(0.92) rotate(-10deg);
                opacity: 0.9;
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.45), 0 0 8px rgba(87, 181, 255, 0.7);
            }
            60% {
                transform: scale(1.18) rotate(8deg);
                opacity: 1;
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.55), 0 0 18px rgba(120, 206, 255, 1);
            }
            80% {
                transform: scale(1.08) rotate(3deg);
                opacity: 1;
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.96);
                opacity: 0;
            }
            30% {
                opacity: 0.7;
            }
            100% {
                transform: scale(1.18);
                opacity: 0;
            }
        }

        .content-shell {
            background: #f0f2f6;
            padding: 18px 0 0;
        }

        /* =========================================================
           Content grid and article layouts
        ========================================================= */
        .content-shell .page-inner,
        .main-grid {
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
        }

        .main-grid {
            display: grid;
            grid-template-columns: minmax(0, 2.1fr) minmax(300px, 0.92fr);
            gap: 20px;
            align-items: start;
            padding: 18px 0 18px;
        }

        .mg-fea-area {
            padding: 0;
            background: #eceef2;
        }

        /* =========================================================
           Hero / feature slider styles
        ========================================================= */
        .feature-slider {
            position: relative;
            overflow: hidden;
            min-height: 420px;
            height: 100%;
            background: linear-gradient(120deg, #eff3f7 0%, #f6f6f6 38%, #eaeaea 100%);
            border: 1px solid rgba(12, 37, 70, 0.08);
            box-shadow: 0 10px 24px rgba(12, 24, 54, 0.08);
        }

        .feature-slider::before,
        .feature-slider::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .feature-slider::before {
            background: linear-gradient(135deg, rgba(30, 124, 215, 0.95) 0 28%, rgba(30, 124, 215, 0.15) 28% 29%, transparent 29% 100%);
            clip-path: polygon(0 0, 32% 0, 58% 100%, 0 100%);
        }

        .feature-slider::after {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.92) 0 58%, transparent 58% 100%);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 42% 100%);
        }

        .feature-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            visibility: hidden;
            transform: translateX(8%) scale(0.985);
            transition: opacity 0.6s ease, transform 0.6s ease, visibility 0.6s ease;
            pointer-events: none;
            z-index: 0;
        }

        .feature-slide.active {
            opacity: 1;
            visibility: visible;
            transform: translateX(0) scale(1);
            pointer-events: auto;
            z-index: 1;
        }

        .feature-slide .feature-image {
            position: relative;
            width: 100%;
            height: 100%;
            background-color: #edf3fb;
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow: hidden;
        }

        .feature-slide .feature-image::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(5, 32, 62, 0.18) 0 40%, transparent 40% 100%),
                linear-gradient(180deg, rgba(7, 29, 54, 0.08), rgba(7, 29, 54, 0.25));
        }

        .feature-slide .feature-image::after {
            content: "";
            position: absolute;
            right: -50px;
            top: -60px;
            width: 62%;
            height: 120%;
            background: rgba(255, 255, 255, 0.14);
            transform: rotate(18deg);
            filter: blur(1px);
        }

        .feature-slide .feature-content {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            padding: 22px 30px 18px 36px;
            color: #fff;
            background: transparent;
            max-width: 74%;
        }

        .feature-slide .feature-category {
            display: inline-block;
            background: linear-gradient(180deg, #1d85e7, #1167c2);
            color: #fff;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 12px;
            box-shadow: 0 8px 18px rgba(17, 92, 167, 0.25);
        }

        .feature-slide .feature-title {
            margin: 0 0 12px;
            font-size: clamp(2rem, 3vw, 4.1rem);
            line-height: 0.96;
            color: #fff;
            font-weight: 900;
            letter-spacing: -0.06em;
            max-width: 820px;
            text-transform: uppercase;
            text-shadow: 0 2px 14px rgba(4, 20, 41, 0.24);
        }

        .feature-slide .feature-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.96);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .feature-slide .feature-meta .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: rgba(255,255,255,0.9);
            display: inline-block;
        }

        .feature-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            border: 1px solid rgba(13, 45, 94, 0.12);
            border-radius: 50%;
            background: rgba(255,255,255,0.85);
            color: #0d2d5e;
            font-size: 2rem;
            line-height: 1;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(12, 24, 54, 0.16);
            z-index: 2;
        }

        .feature-nav.prev {
            left: 18px;
        }

        .feature-nav.next {
            right: 18px;
        }

        .fea-grid {
            display: grid;
            grid-template-columns: minmax(0, 2.1fr) minmax(300px, 0.9fr);
            gap: 18px;
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
            padding: 18px 0 0;
        }

        .feature-panel {
            background: #fff;
            border: 1px solid var(--line);
            box-shadow: 0 8px 20px rgba(12, 24, 54, 0.06);
            padding: 0;
            overflow: hidden;
            min-height: 0;
        }

        .feature-hero {
            background: linear-gradient(180deg, #f5f7fa 0%, #edf1f5 100%);
            min-height: 0;
            position: relative;
            padding: 0;
            display: flex;
            align-items: stretch;
            border: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 6px 18px rgba(6, 28, 63, 0.08);
        }

        .feature-hero::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 72px;
            background: #0c2f5f;
            z-index: 0;
        }

        .feature-hero-inner {
            position: relative;
            z-index: 1;
            display: flex;
            width: 100%;
            min-height: 100%;
        }

        .feature-visual {
            position: relative;
            flex: 0 0 47%;
            background: linear-gradient(135deg, #d9f4ff 0%, #cfe8ff 30%, #b9e8ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px 18px 18px 86px;
        }

        .feature-visual::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(11, 35, 72, 0.08), rgba(255,255,255,0));
        }

        .visual-block {
            position: relative;
            width: 100%;
            min-height: 100%;
            display: flex;
            align-items: stretch;
            justify-content: center;
        }

        .visual-canvas {
            position: relative;
            width: 100%;
            min-height: 260px;
            background: linear-gradient(135deg, #0d2d5e, #1c5eb5 45%, #38b5ef 100%);
            overflow: hidden;
            box-shadow: inset 0 0 0 12px rgba(255,255,255,0.08);
        }

        .visual-canvas::before,
        .visual-canvas::after {
            content: "";
            position: absolute;
            border-radius: 50%;
        }

        .visual-canvas::before {
            width: 180px;
            height: 180px;
            background: rgba(255,255,255,0.08);
            right: 8%;
            top: 12%;
        }

        .visual-canvas::after {
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.14);
            left: 8%;
            bottom: 14%;
        }

        .mini-logo {
            position: absolute;
            left: 50%;
            top: 48%;
            transform: translate(-50%, -50%);
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255,255,255,0.94);
            display: grid;
            place-items: center;
            font-size: 2.7rem;
            font-weight: 900;
            color: #0d2d5e;
            box-shadow: 0 12px 24px rgba(0,0,0,0.18);
        }

        .mini-logo::before {
            content: "P";
        }

        .visual-badge {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 18px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.28);
            color: white;
            padding: 6px 12px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border-radius: 20px;
        }

        .feature-copy {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 22px 24px 18px 28px;
            background: linear-gradient(180deg, #f7f9fb, #edf3fa);
        }

        .feature-title {
            position: relative;
            z-index: 1;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-weight: 900;
            line-height: 0.8;
            color: var(--navy-dark);
            letter-spacing: -0.08em;
            text-transform: uppercase;
        }

        .feature-title .line {
            display: block;
            font-size: clamp(2.2rem, 2.7vw, 4rem);
        }

        .feature-title .line-gold {
            color: #f3af2d;
        }

        .feature-title .line-blue {
            color: #0b4ca3;
        }

        .feature-title .line-dark {
            color: #0a2d5d;
        }

        .feature-subtitle {
            margin-top: 12px;
            font-size: clamp(1.08rem, 1.45vw, 1.7rem);
            font-weight: 900;
            color: #0d2f5f;
            line-height: 1.08;
            letter-spacing: -0.04em;
            max-width: 600px;
        }

        .feature-meta {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-weight: 700;
            margin-top: 16px;
            font-size: 0.88rem;
        }

        .feature-meta .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--navy-dark);
        }

        .side-stack {
            background: #fff;
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            padding: 12px 12px 8px;
            min-height: 0;
            width: 100%;
            align-self: start;
        }

        .top-right-area,
        .col-md-4.top-right-area {
            display: block;
            align-self: start;
        }

        .top-right-area #exTab2 {
            background: #fff;
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            padding: 0;
            width: 100%;
            overflow: hidden;
        }

        .tabs,
        .nav-tabs {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            margin: 0;
            list-style: none;
            background: #f4f5f7;
            border-bottom: 1px solid var(--line);
            padding: 0;
        }

        .tabs li,
        .nav-tabs .nav-item {
            display: block;
            min-width: 0;
        }

        .tab,
        .nav-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(180deg, #f8fafc, #edf2f8);
            border: 0;
            border-right: 1px solid rgba(13, 46, 87, 0.08);
            color: #1a2d43;
            font-weight: 800;
            font-size: 0.82rem;
            padding: 13px 10px 12px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            text-transform: none;
            letter-spacing: 0.02em;
            position: relative;
            min-height: 48px;
            transition: all 0.2s ease;
        }

        .nav-tabs .nav-item:last-child .nav-link {
            border-right: none;
        }

        .tab:hover,
        .nav-link:hover {
            background: linear-gradient(180deg, #ffffff, #edf4ff);
            color: #123d6d;
        }

        .tab.active,
        .nav-link.active {
            background: linear-gradient(180deg, #ffffff, #f4f9ff);
            box-shadow: inset 0 -3px 0 #0d5ec9;
            color: #0d2f5f;
        }

        .tab-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 14px;
            height: 14px;
            color: #6d7a8b;
            flex-shrink: 0;
            transition: color 0.2s ease;
        }

        .tab-icon svg {
            width: 100%;
            height: 100%;
            display: block;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.9;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .nav-link.active .tab-icon {
            color: #0d5ec9;
        }

        .navigation.pagination {
            display: flex;
            justify-content: center;
            width: 100%;
            margin: 22px 0 6px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-numbers {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 10px;
            background: #fff;
            border: 1px solid var(--line);
            color: #0d2f5f;
            font-weight: 700;
            font-size: 0.92rem;
            border-radius: 4px;
        }

        .page-numbers.current {
            background: #1c73d9;
            border-color: #1c73d9;
            color: #fff;
        }

        .page-numbers.dots {
            border-color: transparent;
            background: transparent;
        }

        .screen-reader-text {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0 0 0 0);
            white-space: nowrap;
        }

        .side-list-wrap {
            display: grid;
            gap: 12px;
        }

        .side-item {
            display: grid;
            grid-template-columns: 92px 1fr;
            gap: 12px;
            align-items: center;
            background: linear-gradient(180deg, #f7f9fc, #eef5fb);
            border: 1px solid var(--line);
            padding: 9px;
            min-height: 104px;
            box-shadow: inset 0 0 0 1px rgba(17, 59, 116, 0.02);
        }

        .side-thumb {
            background: linear-gradient(135deg, #8cd7ff, #d7f0ff);
            border-radius: 8px;
            min-height: 72px;
            display: grid;
            place-items: center;
            font-weight: 800;
            color: var(--navy-dark);
            font-size: 0.8rem;
            box-shadow: inset 0 0 0 1px rgba(10, 45, 93, 0.12);
        }

        .side-item strong {
            display: inline-block;
            font-size: 0.67rem;
            text-transform: uppercase;
            color: var(--blue);
            background: rgba(28, 115, 217, 0.08);
            padding: 4px 6px;
            border-radius: 5px;
            margin-bottom: 8px;
        }

        .side-item h4 {
            margin: 0;
            font-size: 0.97rem;
            line-height: 1.33;
            color: var(--text);
        }

        .you-missed {
            background: #f3f5f7;
            border-top: 1px solid var(--line);
            padding: 18px 0 28px;
            margin-top: 8px;
        }

        .missed-section .mg-sec-title {
            margin-bottom: 18px;
        }

        /* "You missed" uses the Bootstrap row/col markup; undo the generic
           .row width so it lines up with .missed-inner instead of nesting. */
        .missed-section .row {
            width: 100%;
            margin: 0;
            padding: 0;
            row-gap: 0;
        }

        .missed-section .row > .col-md-12 {
            flex-basis: 100%;
            max-width: 100%;
            margin-bottom: 0;
        }

        /* 4 cards on one row — must beat the generic .col-sm-6 50% basis. */
        .missed-section .row > .col-lg-3,
        .missed-section .row > .col-sm-6 {
            display: flex;
            flex: 0 0 calc(25% - 13.5px);
            max-width: calc(25% - 13.5px);
        }

        .missed-section .mg-blog-post-3.minh.back-img {
            width: 100%;
            min-height: 210px;
            height: 210px;
            overflow: hidden;
            border-radius: 2px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
        }

        .missed-section .mg-blog-inner {
            overflow: hidden;
            max-width: 100%;
            box-sizing: border-box;
            margin-top: auto;
        }

        .missed-section .mg-blog-inner h4.title,
        .missed-section .mg-blog-inner h4.title a {
            margin: 6px 0 8px;
            font-size: 0.92rem;
            line-height: 1.35;
            font-weight: 700;
            color: #fff;
            word-break: break-word;
            overflow-wrap: anywhere;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .missed-section .mg-blog-inner .mg-blog-category {
            display: block;
            margin-bottom: 4px;
        }

        .missed-section .mg-blog-inner .mg-blog-category a {
            white-space: nowrap;
            font-size: 0.62rem;
        }

        .missed-section .mg-blog-inner .mg-blog-meta {
            display: block;
            font-size: 0.72rem;
            opacity: 0.92;
        }

        @media (max-width: 1100px) {
            .missed-section .row > .col-lg-3,
            .missed-section .row > .col-sm-6 {
                flex: 0 0 calc(50% - 9px);
                max-width: calc(50% - 9px);
            }
        }

        .missed-inner {
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
        }

        .mg-sec-title {
            margin-bottom: 18px;
        }

        .mg-sec-title h4 {
            margin: 0;
            display: inline-block;
            background: #1c73d9;
            color: white;
            padding: 12px 18px;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: none;
            border-radius: 0;
        }

        .mg-sec-title {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            border-bottom: 2px solid var(--line);
            margin-bottom: 18px;
        }

        .section-label {
            background: var(--blue);
            color: white;
            display: inline-flex;
            align-items: center;
            padding: 12px 16px;
            font-weight: 800;
            font-size: 0.95rem;
            border-radius: 6px 6px 0 0;
        }

        .missed-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            padding-top: 10px;
        }

        .missed-card {
            background: linear-gradient(135deg, rgba(130, 208, 255, 0.8), rgba(22, 127, 210, 0.75));
            border: 1px solid var(--line);
            min-height: 190px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 18px;
            color: white;
            box-shadow: var(--shadow);
        }

        .missed-card:nth-child(2) {
            background: linear-gradient(135deg, rgba(179, 223, 255, 0.8), rgba(31, 115, 190, 0.8));
        }

        .missed-card:nth-child(3) {
            background: linear-gradient(135deg, rgba(145, 220, 255, 0.8), rgba(37, 99, 218, 0.75));
        }

        .missed-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.06), rgba(10,20,40,0.32));
        }

        .missed-card > * {
            position: relative;
            z-index: 1;
        }

        .missed-tag {
            display: inline-block;
            background: rgba(10, 33, 60, 0.14);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            padding: 5px 8px;
            border-radius: 5px;
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            width: fit-content;
            margin-bottom: 8px;
        }

        .missed-card h4 {
            margin: 0;
            font-size: 1.05rem;
            line-height: 1.35;
            color: white;
            max-width: 420px;
        }

        .missed-date {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            margin-top: 10px;
            opacity: 0.9;
        }

        .footer {
            position: relative;
            background: linear-gradient(180deg, rgba(10, 19, 42, 1), rgba(8, 15, 34, 1));
            color: white;
            min-height: 180px;
            margin-top: 20px;
            padding: 0 12px 0;
            overflow: hidden;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding-top: 40px;
            padding-bottom: 18px;
            position: relative;
        }

        .footer-title {
            font-size: clamp(2.4rem, 3.1vw, 3.5rem);
            font-weight: 800;
            letter-spacing: -0.06em;
            margin: 0 0 34px;
            color: rgba(255,255,255,0.96);
            line-height: 1.1;
        }

        .footer-inner::before {
            content: "";
            display: block;
            width: 100%;
            border-top: 1px solid rgba(255,255,255,0.14);
            margin-bottom: 18px;
        }

        .footer-bottom {
            text-align: center;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.74);
            line-height: 1.5;
            padding-bottom: 18px;
        }

        .footer-back-to-top {
            position: absolute;
            right: 32px;
            bottom: 14px;
            width: 42px;
            height: 42px;
            border-radius: 6px;
            background: linear-gradient(180deg, #1b6ee8, #0d4ca8);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(29, 108, 220, 0.45);
            font-size: 1.4rem;
            font-weight: 700;
            text-decoration: none;
        }

        .page-shell {
            background: #efefef;
        }

        .article-layout {
            background: #efefef;
            padding: 0 0 10px;
        }

        .article-head {
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
            padding: 24px 0 16px;
            font-size: clamp(2.3rem, 4vw, 4rem);
            font-weight: 900;
            letter-spacing: -0.06em;
            line-height: 1.1;
            color: #101926;
            text-transform: uppercase;
        }

        .article-body {
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
            background: #f3f3f3;
            border: 1px solid var(--line);
            min-height: 180px;
            padding: 14px 0 6px;
        }

        .placeholder-box {
            min-height: 120px;
            background: rgba(255,255,255,0.25);
            border: 1px solid var(--line);
        }

        .story-row {
            display: grid;
            grid-template-columns: 310px 1fr;
            gap: 20px;
            align-items: center;
            padding: 18px 18px 12px;
            border-bottom: 1px solid rgba(16, 25, 38, 0.08);
        }

        .story-row:last-child {
            border-bottom: none;
        }

        .story-thumb {
            min-height: 220px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.1);
            background: linear-gradient(135deg, #d7f0ff, #b4e2ff);
        }

        .story-mini-logo {
            font-size: clamp(1.8rem, 3vw, 3rem);
            font-weight: 900;
            letter-spacing: -0.05em;
            color: var(--navy-dark);
            text-transform: none;
            line-height: 0.9;
        }

        .blue-thumb {
            background: linear-gradient(135deg, #a7e7ff, #7ecdff);
        }

        .dark-thumb {
            background: linear-gradient(180deg, #0a1a2d, #0c2d5b);
        }

        .dark-thumb .story-mini-logo {
            color: #f3f8ff;
            font-size: clamp(1.2rem, 2vw, 2.2rem);
            text-transform: uppercase;
            text-align: center;
        }

        .event-thumb {
            background: linear-gradient(135deg, #dfeeff, #cde9ff);
        }

        .story-copy h3 {
            margin: 0 0 10px;
            color: #0e294f;
            font-size: clamp(1.3rem, 2.1vw, 2.3rem);
            line-height: 1.2;
            font-weight: 800;
        }

        .story-copy p {
            margin: 0 0 12px;
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .read-more {
            display: inline-block;
            background: #2bb673;
            color: #fff;
            border-radius: 6px;
            padding: 10px 18px;
            font-weight: 700;
            text-transform: none;
            box-shadow: 0 8px 18px rgba(43,182,115,0.2);
        }

        .box-archive {
            background: #f7f7f7;
            padding: 0;
        }

        .year-menu {
            display: grid;
            grid-template-columns: 1fr;
            background: #f8f8f8;
            border: 1px solid var(--line);
        }

        .year {
            display: flex;
            align-items: center;
            min-height: 64px;
            padding: 0 18px;
            color: #1c2940;
            font-weight: 700;
            border-bottom: 1px solid var(--line);
            background: rgba(17, 30, 52, 0.04);
        }

        .year.active {
            background: #111d2d;
            color: white;
        }

        .year:last-child {
            border-bottom: none;
        }

        .publication-shell {
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            gap: 0;
            border: 1px solid var(--line);
            background: #f3f3f3;
            margin-top: 0;
        }

        .publication-side {
            background: #1c2430;
            color: white;
            min-height: 420px;
        }

        .publication-side .year {
            background: transparent;
            color: rgba(255,255,255,0.9);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 0 18px;
            font-size: 0.78rem;
            letter-spacing: 0.03em;
        }

        .publication-side .year.active {
            background: #1f7ae0;
            color: white;
        }

        .publication-content {
            background: #efefef;
            padding: 26px 30px 18px;
            min-height: 420px;
        }

        .publication-content h3 {
            margin: 0 0 18px;
            font-size: clamp(1.8rem, 2.5vw, 2.4rem);
            text-align: center;
            color: #0b1d35;
            font-weight: 900;
        }

        .publication-list {
            margin: 0;
            padding-left: 26px;
            color: #1b2430;
            font-size: 0.96rem;
            line-height: 1.65;
        }

        .publication-list li {
            margin-bottom: 8px;
        }

        .publication-list strong {
            color: #111827;
        }

        .publication-list a {
            color: #0d4aa6;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .publication-list ol {
            margin-top: 8px;
            padding-left: 22px;
        }

        .publication-list ol li {
            margin-bottom: 8px;
        }

        .year-2024-article {
            background: #efefef;
            border: 1px solid var(--line);
            padding: 0;
            margin-top: 0;
        }

        .year-2024-article .article-head {
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
            padding: 30px 0 10px;
            font-size: clamp(2rem, 4vw, 4rem);
            font-weight: 900;
            letter-spacing: -0.05em;
        }

        .year-2024-box {
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            background: #f4f4f4;
            border: 1px solid var(--line);
            min-height: 380px;
        }

        .year-2024-menu {
            background: #1d2432;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .year-2024-menu .year-item {
            min-height: 66px;
            display: flex;
            align-items: center;
            padding: 0 18px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.8);
        }

        .year-2024-menu .year-item.active {
            background: #1c73d9;
            color: white;
        }

        .year-2024-content {
            background: #efefef;
            padding: 26px 28px 12px;
        }

        .year-2024-content h2 {
            margin: 0 0 18px;
            font-size: clamp(1.7rem, 3vw, 2.3rem);
            color: #0d203a;
            line-height: 1.2;
            font-weight: 900;
        }

        .year-2024-content h3 {
            margin: 10px 0 8px;
            font-size: 1.05rem;
            color: #0d203a;
        }

        .year-2024-content p,
        .year-2024-content li {
            color: #1a2433;
            font-size: 1rem;
            line-height: 1.75;
        }

        .year-2024-content ul {
            margin: 0 0 18px 18px;
            padding-left: 16px;
        }

        .year-2024-content ol {
            margin: 0 0 18px 20px;
            padding-left: 14px;
        }

        .year-2024-content strong {
            color: #0c1d30;
        }

        .stat-row {
            width: min(1280px, calc(100% - 26px));
            margin: 20px auto 0;
            padding: 12px 0 0;
            color: var(--text);
            font-size: 1.12rem;
            font-weight: 700;
        }

        .mini-icon {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: var(--blue);
            transform: rotate(45deg);
            margin-right: 8px;
        }

        /* --- Minimal grid shim: the markup uses Bootstrap column classes
           but no Bootstrap stylesheet is loaded, so the home layout
           collapsed to a single full-width column. These rules restore
           the intended two-column home layout and the 4-up "You missed"
           grid without altering the markup. --- */
        .container-fluid {
            width: 100%;
            padding: 0;
            margin: 0 auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
            padding: 18px 0;
            gap: 18px;
            align-items: flex-start;
        }

        .col-md-8,
        .col-md-4,
        .col-md-6,
        .col-md-12,
        .col-lg-3,
        .col-sm-6 {
            min-width: 0;
            flex: 0 0 auto;
        }

        .col-md-12 {
            flex-basis: 100%;
        }

        .col-md-8 {
            flex-basis: calc(66.6667% - 9px);
        }

        .col-md-4 {
            flex-basis: calc(33.3333% - 9px);
        }

        .col-md-6 {
            flex-basis: calc(50% - 9px);
        }

        .col-lg-3 {
            flex-basis: calc(25% - 13.5px);
        }

        .col-sm-6 {
            flex-basis: calc(50% - 13.5px);
        }

        .mg-fea-area .row,
        #content .row {
            align-items: stretch;
        }

        /* Match the featured card to the sidebar height so no empty gap is
           left below it, while keeping the cover image un-zoomed. */
        .mg-fea-area .row > .col-md-8,
        .mg-fea-area .row > .top-right-area {
            align-self: stretch;
        }

        .mg-fea-area .homemain,
        .mg-fea-area .homemain .item,
        .mg-fea-area .mg-blog-post.lg.back-img {
            height: 100%;
        }

        .mg-fea-area .mg-blog-post.lg.back-img {
            min-height: 480px;
            background-size: cover;
            background-position: center top;
            display: flex;
            align-items: flex-end;
        }

        /* Cap the sidebar so the 4 thumbnails fill the featured card's
           height instead of overflowing it. */
        .mg-fea-area .top-right-area #exTab2 {
            height: 100%;
        }

        .mg-fea-area .tab-content,
        .mg-fea-area .tab-content .tab-pane,
        .mg-fea-area .mg-posts-sec,
        .mg-fea-area .mg-posts-sec-inner {
            height: 100%;
        }

        .mg-fea-area .small-list-post {
            height: auto;
        }

        .mg-fea-area .small-list-post .small-post {
            min-height: 0;
            overflow: hidden;
        }

        .mg-fea-area .small-list-post .small-post .title {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .mg-fea-area .top-right-area #exTab2 {
            display: flex;
            flex-direction: column;
        }

        .mg-fea-area .small-list-post {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mg-fea-area .small-list-post .small-post {
            margin-bottom: 0;
        }

        /* Cover blocks shared by the home page: the featured card, the
           article thumbnails and the "You missed" cards. */
        .mg-blog-post.lg,
        .mg-post-thumb.back-img.md,
        .mg-blog-post-3.minh.back-img {
            min-height: 260px;
            background-size: cover;
            background-position: center;
            position: relative;
            border: 1px solid var(--line);
        }

        .mg-blog-post-3.minh.back-img {
            min-height: 190px;
            display: flex;
            align-items: flex-end;
        }

        /* Home article cards: image left, copy right — as on the live site.
           The generic .col-md-6 basis (50%) plus wrap=false keeps the two
           halves on one line instead of stacking them. */
        .article-post {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: stretch;
        }

        .article-post .post-thumb-col {
            flex: 0 0 300px;
            max-width: 300px;
            padding-right: 18px;
            align-self: stretch;
            display: flex;
            flex-direction: column;
        }

        .article-post .mg-post-thumb.back-img.md {
            flex: 1 1 auto;
            min-height: 200px;
            background-size: cover;
            background-position: center;
            border: 1px solid var(--line);
            position: relative;
        }

        .article-post .mg-sec-top-post {
            flex: 1 1 0 !important;
            max-width: none !important;
            min-width: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (max-width: 720px) {
            .article-post {
                flex-wrap: wrap;
            }
        }

        .article-post .entry-title {
            margin: 8px 0 10px;
            font-size: clamp(1.15rem, 1.7vw, 1.5rem);
            line-height: 1.28;
            color: #0e294f;
            font-weight: 800;
        }

        .article-post .entry-title a {
            color: inherit;
        }

        .article-post .mg-content p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .article-post .mg-blog-meta {
            color: #6b7787;
        }

        @media (max-width: 720px) {
            .article-post .post-thumb-col {
                flex-basis: 100%;
                max-width: 100%;
                padding-right: 0;
            }
        }

        .mg-blog-post.lg article.bottom {
            position: relative;
            z-index: 1;
            background: linear-gradient(180deg, rgba(8, 22, 44, 0) 0%, rgba(8, 22, 44, 0.55) 38%, rgba(8, 22, 44, 0.92) 100%);
            color: #fff;
            padding: 60px 22px 18px;
            width: 100%;
        }

        .mg-blog-post.lg article.bottom .title,
        .mg-blog-post.lg article.bottom .title a {
            margin: 8px 0 10px;
            font-size: clamp(1.3rem, 2.1vw, 2rem);
            line-height: 1.22;
            font-weight: 800;
            color: #fff;
        }

        .mg-blog-post.lg article.bottom .mg-blog-meta {
            margin-top: 4px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.9);
        }

        .mg-blog-inner {
            position: relative;
            z-index: 1;
            background: linear-gradient(180deg, rgba(8, 22, 44, 0) 0%, rgba(8, 22, 44, 0.6) 40%, rgba(8, 22, 44, 0.94) 100%);
            color: #fff;
            padding: 50px 14px 14px;
            width: 100%;
        }

        .mg-blog-inner .title a {
            color: #fff;
        }

        .mg-blog-meta,
        .mg-blog-category {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .newsup-categories.category-color-1 {
            background: var(--blue);
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.68rem;
            letter-spacing: 0.06em;
        }

        .mg-posts-modul-2 .small-post,
        .small-post {
            display: grid;
            grid-template-columns: 92px 1fr;
            gap: 10px;
            align-items: center;
            background: #f7f9fc;
            border: 1px solid var(--line);
            padding: 8px;
            margin-bottom: 12px;
        }

        .small-post .img-small-post img {
            width: 100%;
            height: 60px;
            object-fit: cover;
            border: 1px solid var(--line);
        }

        .small-post .title {
            margin: 6px 0 0;
            font-size: 0.9rem;
            line-height: 1.35;
        }

        .article-post,
        .mg-posts-sec-post {
            background: #f7f9fc;
            border: 1px solid var(--line);
            padding: 16px;
            margin-bottom: 18px;
            box-shadow: var(--shadow);
            align-items: center;
        }

        .mg-posts-sec-post .entry-title {
            margin: 10px 0;
            font-size: clamp(1.15rem, 1.6vw, 1.5rem);
            line-height: 1.3;
            color: #0e294f;
        }

        .mg-posts-sec-post .mg-content p {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        @media (max-width: 900px) {
            .main-grid,
            .missed-grid,
            .tabs {
                grid-template-columns: 1fr;
            }

            .col-md-8,
            .col-md-4,
            .col-md-6,
            .col-lg-3,
            .col-sm-6 {
                flex-basis: 100%;
            }

            .row {
                gap: 14px;
                padding: 14px 0;
            }
            .nav-bar {
                flex-wrap: wrap;
                justify-content: center;
                padding: 8px 10px;
            }
            .nav-main {
                justify-content: center;
            }
            .nav-item {
                padding: 10px 8px;
            }
            .ticker {
                font-size: 0.82rem;
                padding: 10px 12px;
            }
            .feature-title {
                font-size: 2rem;
            }
        }

        /* --- Minimal grid shim: the markup uses Bootstrap column classes
           but no Bootstrap stylesheet is loaded, so the home layout
           collapsed to a single full-width column. These rules restore
           the intended two-column home layout and the 4-up "You missed"
           grid without altering the markup. --- */
        .container-fluid {
            width: 100%;
            padding: 0;
            margin: 0 auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
            padding: 18px 0;
            gap: 18px;
            align-items: flex-start;
        }

        .col-md-8,
        .col-md-4,
        .col-md-6,
        .col-md-12,
        .col-lg-3,
        .col-sm-6 {
            min-width: 0;
            flex: 0 0 auto;
        }

        .col-md-12 {
            flex-basis: 100%;
        }

        .col-md-8 {
            flex-basis: calc(66.6667% - 9px);
        }

        .col-md-4 {
            flex-basis: calc(33.3333% - 9px);
        }

        .col-md-6 {
            flex-basis: calc(50% - 9px);
        }

        .col-lg-3 {
            flex-basis: calc(25% - 13.5px);
        }

        .col-sm-6 {
            flex-basis: calc(50% - 13.5px);
        }

        .mg-fea-area .row,
        #content .row {
            align-items: stretch;
        }

        /* Match the featured card to the sidebar height so no empty gap is
           left below it, while keeping the cover image un-zoomed. */
        .mg-fea-area .row > .col-md-8,
        .mg-fea-area .row > .top-right-area {
            align-self: stretch;
        }

        .mg-fea-area .homemain,
        .mg-fea-area .homemain .item,
        .mg-fea-area .mg-blog-post.lg.back-img {
            height: 100%;
        }

        .mg-fea-area .mg-blog-post.lg.back-img {
            min-height: 480px;
            background-size: cover;
            background-position: center top;
            display: flex;
            align-items: flex-end;
        }

        /* Cap the sidebar so the 4 thumbnails fill the featured card's
           height instead of overflowing it. */
        .mg-fea-area .top-right-area #exTab2 {
            height: 100%;
        }

        .mg-fea-area .tab-content,
        .mg-fea-area .tab-content .tab-pane,
        .mg-fea-area .mg-posts-sec,
        .mg-fea-area .mg-posts-sec-inner {
            height: 100%;
        }

        .mg-fea-area .small-list-post {
            height: auto;
        }

        .mg-fea-area .small-list-post .small-post {
            min-height: 0;
            overflow: hidden;
        }

        .mg-fea-area .small-list-post .small-post .title {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .mg-fea-area .top-right-area #exTab2 {
            display: flex;
            flex-direction: column;
        }

        .mg-fea-area .small-list-post {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mg-fea-area .small-list-post .small-post {
            margin-bottom: 0;
        }

        .mg-blog-post.lg,
        .mg-post-thumb.back-img.md,
        .mg-blog-post-3.minh.back-img {
            min-height: 260px;
            background-size: cover;
            background-position: center;
            position: relative;
            border: 1px solid var(--line);
        }

        .mg-blog-post-3.minh.back-img {
            min-height: 190px;
            display: flex;
            align-items: flex-end;
        }

        /* Home article cards: image left, copy right — as on the live site.
           The generic .col-md-6 basis (50%) plus wrap=false keeps the two
           halves on one line instead of stacking them. */
        .article-post {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: stretch;
        }

        .article-post .post-thumb-col {
            flex: 0 0 300px;
            max-width: 300px;
            padding-right: 18px;
            align-self: stretch;
            display: flex;
            flex-direction: column;
        }

        .article-post .mg-post-thumb.back-img.md {
            flex: 1 1 auto;
            min-height: 200px;
            background-size: cover;
            background-position: center;
            border: 1px solid var(--line);
            position: relative;
        }

        .article-post .mg-sec-top-post {
            flex: 1 1 0 !important;
            max-width: none !important;
            min-width: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (max-width: 720px) {
            .article-post {
                flex-wrap: wrap;
            }
        }

        .article-post .entry-title {
            margin: 8px 0 10px;
            font-size: clamp(1.15rem, 1.7vw, 1.5rem);
            line-height: 1.28;
            color: #0e294f;
            font-weight: 800;
        }

        .article-post .entry-title a {
            color: inherit;
        }

        .article-post .mg-content p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .article-post .mg-blog-meta {
            color: #6b7787;
        }

        @media (max-width: 720px) {
            .article-post .post-thumb-col {
                flex-basis: 100%;
                max-width: 100%;
                padding-right: 0;
            }
        }

        .mg-blog-post.lg article.bottom {
            position: relative;
            z-index: 1;
            background: linear-gradient(180deg, rgba(8, 22, 44, 0) 0%, rgba(8, 22, 44, 0.55) 38%, rgba(8, 22, 44, 0.92) 100%);
            color: #fff;
            padding: 60px 22px 18px;
            width: 100%;
        }

        .mg-blog-post.lg article.bottom .title,
        .mg-blog-post.lg article.bottom .title a {
            margin: 8px 0 10px;
            font-size: clamp(1.3rem, 2.1vw, 2rem);
            line-height: 1.22;
            font-weight: 800;
            color: #fff;
        }

        .mg-blog-post.lg article.bottom .mg-blog-meta {
            margin-top: 4px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.9);
        }

        .mg-blog-inner {
            position: relative;
            z-index: 1;
            background: linear-gradient(180deg, rgba(8, 22, 44, 0) 0%, rgba(8, 22, 44, 0.6) 40%, rgba(8, 22, 44, 0.94) 100%);
            color: #fff;
            padding: 50px 14px 14px;
            width: 100%;
        }

        .mg-blog-inner .title a {
            color: #fff;
        }

        .mg-blog-meta,
        .mg-blog-category {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .newsup-categories.category-color-1 {
            background: var(--blue);
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.68rem;
            letter-spacing: 0.06em;
        }

        .mg-posts-modul-2 .small-post,
        .small-post {
            display: grid;
            grid-template-columns: 92px 1fr;
            gap: 10px;
            align-items: center;
            background: #f7f9fc;
            border: 1px solid var(--line);
            padding: 8px;
            margin-bottom: 12px;
        }

        .small-post .img-small-post img {
            width: 100%;
            height: 60px;
            object-fit: cover;
            border: 1px solid var(--line);
        }

        .small-post .title {
            margin: 6px 0 0;
            font-size: 0.9rem;
            line-height: 1.35;
        }

        .article-post,
        .mg-posts-sec-post {
            background: #f7f9fc;
            border: 1px solid var(--line);
            padding: 16px;
            margin-bottom: 18px;
            box-shadow: var(--shadow);
            align-items: center;
        }

        .mg-posts-sec-post .entry-title {
            margin: 10px 0;
            font-size: clamp(1.15rem, 1.6vw, 1.5rem);
            line-height: 1.3;
            color: #0e294f;
        }

        .mg-posts-sec-post .mg-content p {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        @media (max-width: 900px) {
            .main-grid,
            .missed-grid,
            .tabs {
                grid-template-columns: 1fr;
            }

            .col-md-8,
            .col-md-4,
            .col-md-6,
            .col-lg-3,
            .col-sm-6 {
                flex-basis: 100%;
            }

            .row {
                gap: 14px;
                padding: 14px 0;
            }
            .nav-bar {
                flex-wrap: wrap;
                justify-content: center;
                padding: 8px 10px;
            }
            .nav-main {
                justify-content: center;
            }
        }

        .container-fluid {
            width: 100%;
            padding: 0;
            margin: 0 auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            width: min(1280px, calc(100% - 26px));
            margin: 0 auto;
            padding: 18px 0;
            gap: 18px;
            align-items: flex-start;
        }

        .col-md-8,
        .col-md-4,
        .col-md-6,
        .col-md-12,
        .col-lg-3,
        .col-sm-6 {
            min-width: 0;
            flex: 0 0 auto;
        }

        .col-md-12 {
            flex-basis: 100%;
        }

        .col-md-8 {
            flex-basis: calc(66.6667% - 9px);
        }

        .col-md-4 {
            flex-basis: calc(33.3333% - 9px);
        }

        .col-md-6 {
            flex-basis: calc(50% - 9px);
        }

        .col-lg-3 {
            flex-basis: calc(25% - 13.5px);
        }

        .col-sm-6 {
            flex-basis: calc(50% - 13.5px);
        }

        .mg-fea-area .row,
        #content .row {
            align-items: stretch;
        }

        /* Match the featured card to the sidebar height so no empty gap is
           left below it, while keeping the cover image un-zoomed. */
        .mg-fea-area .row > .col-md-8,
        .mg-fea-area .row > .top-right-area {
            align-self: stretch;
        }

        .mg-fea-area .homemain,
        .mg-fea-area .homemain .item,
        .mg-fea-area .mg-blog-post.lg.back-img {
            height: 100%;
        }

        .mg-fea-area .mg-blog-post.lg.back-img {
            min-height: 480px;
            background-size: cover;
            background-position: center top;
            display: flex;
            align-items: flex-end;
        }

        /* Cap the sidebar so the 4 thumbnails fill the featured card's
           height instead of overflowing it. */
        .mg-fea-area .top-right-area #exTab2 {
            height: 100%;
        }

        .mg-fea-area .tab-content,
        .mg-fea-area .tab-content .tab-pane,
        .mg-fea-area .mg-posts-sec,
        .mg-fea-area .mg-posts-sec-inner {
            height: 100%;
        }

        .mg-fea-area .small-list-post {
            height: auto;
        }

        .mg-fea-area .small-list-post .small-post {
            min-height: 0;
            overflow: hidden;
        }

        .mg-fea-area .small-list-post .small-post .title {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .mg-fea-area .top-right-area #exTab2 {
            display: flex;
            flex-direction: column;
        }

        .mg-fea-area .small-list-post {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mg-fea-area .small-list-post .small-post {
            margin-bottom: 0;
        }

        /* Cover blocks shared by the home page: the featured card, the
           article thumbnails and the "You missed" cards. */
        .mg-blog-post.lg,
        .mg-post-thumb.back-img.md,
        .mg-blog-post-3.minh.back-img {
            min-height: 260px;
            background-size: cover;
            background-position: center;
            position: relative;
            border: 1px solid var(--line);
        }

        .mg-blog-post-3.minh.back-img {
            min-height: 190px;
            display: flex;
            align-items: flex-end;
        }

        /* Home article cards: image left, copy right — as on the live site.
           The generic .col-md-6 basis (50%) plus wrap=false keeps the two
           halves on one line instead of stacking them. */
        .article-post {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: stretch;
        }

        .article-post .post-thumb-col {
            flex: 0 0 300px;
            max-width: 300px;
            padding-right: 18px;
            align-self: stretch;
            display: flex;
            flex-direction: column;
        }

        .article-post .mg-post-thumb.back-img.md {
            flex: 1 1 auto;
            min-height: 200px;
            background-size: cover;
            background-position: center;
            border: 1px solid var(--line);
            position: relative;
        }

        .article-post .mg-sec-top-post {
            flex: 1 1 0 !important;
            max-width: none !important;
            min-width: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (max-width: 720px) {
            .article-post {
                flex-wrap: wrap;
            }
        }

        .article-post .entry-title {
            margin: 8px 0 10px;
            font-size: clamp(1.15rem, 1.7vw, 1.5rem);
            line-height: 1.28;
            color: #0e294f;
            font-weight: 800;
        }

        .article-post .entry-title a {
            color: inherit;
        }

        .article-post .mg-content p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .article-post .mg-blog-meta {
            color: #6b7787;
        }

        @media (max-width: 720px) {
            .article-post .post-thumb-col {
                flex-basis: 100%;
                max-width: 100%;
                padding-right: 0;
            }
        }

        .mg-blog-post.lg article.bottom {
            position: relative;
            z-index: 1;
            background: linear-gradient(180deg, rgba(8, 22, 44, 0) 0%, rgba(8, 22, 44, 0.55) 38%, rgba(8, 22, 44, 0.92) 100%);
            color: #fff;
            padding: 60px 22px 18px;
            width: 100%;
        }

        .mg-blog-post.lg article.bottom .title,
        .mg-blog-post.lg article.bottom .title a {
            margin: 8px 0 10px;
            font-size: clamp(1.3rem, 2.1vw, 2rem);
            line-height: 1.22;
            font-weight: 800;
            color: #fff;
        }

        .mg-blog-post.lg article.bottom .mg-blog-meta {
            margin-top: 4px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.9);
        }

        .mg-blog-inner {
            position: relative;
            z-index: 1;
            background: linear-gradient(180deg, rgba(8, 22, 44, 0) 0%, rgba(8, 22, 44, 0.6) 40%, rgba(8, 22, 44, 0.94) 100%);
            color: #fff;
            padding: 50px 14px 14px;
            width: 100%;
        }

        .mg-blog-inner .title a {
            color: #fff;
        }

        .mg-blog-meta,
        .mg-blog-category {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .newsup-categories.category-color-1 {
            background: var(--blue);
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.68rem;
            letter-spacing: 0.06em;
        }

        .mg-posts-modul-2 .small-post,
        .small-post {
            display: grid;
            grid-template-columns: 92px 1fr;
            gap: 10px;
            align-items: center;
            background: #f7f9fc;
            border: 1px solid var(--line);
            padding: 8px;
            margin-bottom: 12px;
        }

        .small-post .img-small-post img {
            width: 100%;
            height: 60px;
            object-fit: cover;
            border: 1px solid var(--line);
        }

        .small-post .title {
            margin: 6px 0 0;
            font-size: 0.9rem;
            line-height: 1.35;
        }

        .article-post,
        .mg-posts-sec-post {
            background: #f7f9fc;
            border: 1px solid var(--line);
            padding: 16px;
            margin-bottom: 18px;
            box-shadow: var(--shadow);
            align-items: center;
        }

        .mg-posts-sec-post .entry-title {
            margin: 10px 0;
            font-size: clamp(1.15rem, 1.6vw, 1.5rem);
            line-height: 1.3;
            color: #0e294f;
        }

        .mg-posts-sec-post .mg-content p {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        @media (max-width: 900px) {
            .main-grid,
            .missed-grid,
            .tabs {
                grid-template-columns: 1fr;
            }

            .col-md-8,
            .col-md-4,
            .col-md-6,
            .col-lg-3,
            .col-sm-6 {
                flex-basis: 100%;
            }

            .row {
                gap: 14px;
                padding: 14px 0;
            }
        }
    </style>
</head>
<body>
    <?php
        $navItems = [
            ['label' => 'PROFIL', 'href' => '/profil', 'active' => ($page ?? 'home') === 'profil'],
            ['label' => 'INFORMASI', 'href' => '/informasi', 'active' => ($page ?? 'home') === 'penelitian'],
            ['label' => 'PUBLIKASI', 'href' => '/publikasi', 'active' => ($page ?? 'home') === 'publikasi' || ($page ?? 'home') === 'tahun2024'],
            ['label' => 'HKI', 'href' => '#', 'active' => false, 'hasDropdown' => true],
            ['label' => 'SINTA', 'href' => 'https://sinta.kemdiktisaintek.go.id/affiliations/profile/564', 'active' => false, 'external' => true],
            ['label' => 'JURNAL', 'href' => 'https://jurnal.polibatam.ac.id/', 'active' => false, 'external' => true],
            ['label' => 'STATISTIK', 'href' => '#', 'active' => false],
            ['label' => 'POLIBATAM UNIVERSITY BERDAMPAK', 'href' => '#', 'active' => false],
        ];

        $tickerItems = [
            'Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026',
            'Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026',
            'P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)',
            'Pengumuman Penerima Pendanaan Program Penelitian dan Pengabdian kepada Masyarakat (BIMA), Program Inovasi Seni Nusantara (BIMA), Program Hilirisasi Riset Prioritas (HILIRISET), dan Program SEMESTA Tahun Anggaran 2026',
            'Pembentukan dan Pengangkatan Ketua Pusat Kajian (PK) dan Center Of Excellence (CoE) Politeknik Negeri Batam Tahun 2026',
        ];

        $sidebarPosts = [
            ['title' => 'Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026', 'img' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2023/06/Pengumuman-Penerima-Bantuan-Dana-Penelitian-dan-Pengabdian-Masyarakat-Usulan-Baru-bagi-Perguruan-Tinggi-Pengelola-Program-Studi-Pendidikan-Tinggi-Vokasi-Tahun-Anggaran-2023-2-300x169.png'],
            ['title' => 'Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026', 'img' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/BUKU-PANDUAN-300x212.jpg'],
            ['title' => 'P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)', 'img' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/111-1-300x200.png'],
            ['title' => 'Pengumuman Penerima Pendanaan Program Penelitian dan Pengabdian kepada Masyarakat (BIMA), Program Inovasi Seni Nusantara (BIMA), Program Hilirisasi Riset Prioritas (HILIRISET), dan Program SEMESTA Tahun Anggaran 2026', 'img' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/1-300x212.jpg'],
        ];

        $latestPosts = $sidebarPosts;
        $popularPosts = array_reverse($sidebarPosts);
        $trendingPosts = [
            $sidebarPosts[3],
            $sidebarPosts[0],
            $sidebarPosts[2],
            $sidebarPosts[1],
        ];

        $featuredSlides = [
            [
                'title' => 'Pengumuman Penerima Pendanaan Program Penelitian dan Pengabdian kepada Masyarakat',
                'date' => 'April 10, 2026',
                'author' => 'P3M',
                'category' => 'Informasi',
                'image' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/1.jpg',
            ],
            [
                'title' => 'Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026',
                'date' => 'April 29, 2026',
                'author' => 'P3M',
                'category' => 'Informasi',
                'image' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/BUKU-PANDUAN.jpg',
            ],
            [
                'title' => 'P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)',
                'date' => 'April 20, 2026',
                'author' => 'P3M',
                'category' => 'Informasi',
                'image' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/111-1.png',
            ],
        ];

        $missedCards = [
            ['tag' => 'Informasi', 'title' => 'Pengumuman Hasil Seleksi Penelitian dan Pengabdian...', 'date' => 'June 15, 2026'],
            ['tag' => 'Informasi', 'title' => 'Buku Panduan Penelitian dan Pengabdian kepada Masyarakat...', 'date' => 'April 29, 2026'],
            ['tag' => 'Informasi', 'title' => 'P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi...', 'date' => 'April 20, 2026'],
        ];
    ?>
    <div class="page-shell" data-page="<?php echo e($page ?? 'home'); ?>">
        <?php echo view('partials.site-header', ['page' => $page ?? 'home']); ?>

        <?php if (($page ?? 'home') === 'home') : ?>
            <section class="mg-latest-news-sec">
                <div class="page-inner">
                    <div class="mg-latest-news">
                        <div class="bn_title">
                            <span class="ticker-badge"><span class="ticker-icon" aria-hidden="true">&#9889;</span>Latest Post</span>
                        </div>
                        <div class="page ticker" aria-label="Latest post ticker">
                            <div class="ticker-track">
                                <div class="ticker-group">
                                    <?php foreach ($tickerItems as $item) : ?>
                                        <a class="ticker-item" href="#"><span class="ticker-dot" aria-hidden="true"></span><?php echo $item; ?></a>
                                    <?php endforeach; ?>
                                </div>
                                <div class="ticker-group" aria-hidden="true">
                                    <?php foreach ($tickerItems as $item) : ?>
                                        <a class="ticker-item" href="#" tabindex="-1"><span class="ticker-dot" aria-hidden="true"></span><?php echo $item; ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mg-fea-area">
                <div class="overlay">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="homemain" class="homemain">
                                    <div class="feature-slider" aria-label="Featured stories carousel">
                                        <?php foreach ($featuredSlides as $index => $slide) : ?>
                                            <article class="feature-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                                                <div class="feature-image" style="background-image: url('<?php echo $slide['image']; ?>');">
                                                    <button class="feature-nav prev" type="button" aria-label="Previous slide">&#8249;</button>
                                                    <button class="feature-nav next" type="button" aria-label="Next slide">&#8250;</button>
                                                    <div class="feature-content">
                                                        <span class="feature-category"><?php echo $slide['category']; ?></span>
                                                        <h4 class="feature-title"><?php echo $slide['title']; ?></h4>
                                                        <div class="feature-meta">
                                                            <span><?php echo strtoupper(date('F d, Y', strtotime($slide['date']))); ?></span>
                                                            <span class="dot" aria-hidden="true"></span>
                                                            <span><?php echo $slide['author']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 top-right-area">
                                <div id="exTab2">
                                    <ul class="nav nav-tabs tabs">
                                        <li class="nav-item">
                                            <a class="nav-link tab active" href="#tan-main-banner-latest-trending-popular-recent" data-tab="latest">
                                                <span class="tab-icon" aria-hidden="true">
                                                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"></circle><path d="M12 7v5l3 2"></path></svg>
                                                </span>
                                                <span>Latest</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link tab" href="#tan-main-banner-latest-trending-popular-recent" data-tab="popular">
                                                <span class="tab-icon" aria-hidden="true">
                                                    <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.2"></circle><path d="M5 18c1.6-2.6 4-3.9 7-3.9s5.4 1.3 7 3.9"></path></svg>
                                                </span>
                                                <span>Popular</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link tab" href="#tan-main-banner-latest-trending-popular-recent" data-tab="trending">
                                                <span class="tab-icon" aria-hidden="true">
                                                    <svg viewBox="0 0 24 24"><path d="M4 16l7-7 4 4 7-7"></path><path d="M18 6h2v2"></path></svg>
                                                </span>
                                                <span>Trending</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tan-main-banner-latest-trending-popular-recent" class="tab-pane active fade show" data-panel="latest">
                                            <div class="mg-posts-sec mg-posts-modul-2">
                                                <div class="mg-posts-sec-inner row">
                                                    <div class="small-list-post col-lg-12">
                                                        <?php foreach ($latestPosts as $post) : ?>
                                                            <div class="small-post">
                                                                <div class="img-small-post"><a href="#"><img src="<?php echo $post['img']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>"></a></div>
                                                                <div class="small-post-content">
                                                                    <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                                                    <div class="title_small_post"><h5 class="title"><a href="#"><?php echo $post['title']; ?></a></h5></div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" data-panel="popular" hidden>
                                            <div class="mg-posts-sec mg-posts-modul-2">
                                                <div class="mg-posts-sec-inner row">
                                                    <div class="small-list-post col-lg-12">
                                                        <?php foreach ($popularPosts as $post) : ?>
                                                            <div class="small-post">
                                                                <div class="img-small-post"><a href="#"><img src="<?php echo $post['img']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>"></a></div>
                                                                <div class="small-post-content">
                                                                    <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                                                    <div class="title_small_post"><h5 class="title"><a href="#"><?php echo $post['title']; ?></a></h5></div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" data-panel="trending" hidden>
                                            <div class="mg-posts-sec mg-posts-modul-2">
                                                <div class="mg-posts-sec-inner row">
                                                    <div class="small-list-post col-lg-12">
                                                        <?php foreach ($trendingPosts as $post) : ?>
                                                            <div class="small-post">
                                                                <div class="img-small-post"><a href="#"><img src="<?php echo $post['img']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>"></a></div>
                                                                <div class="small-post-content">
                                                                    <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                                                    <div class="title_small_post"><h5 class="title"><a href="#"><?php echo $post['title']; ?></a></h5></div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div id="content" class="container-fluid home">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mg-posts-sec mg-posts-modul-6">
                            <div class="mg-posts-sec-inner">
                                <article class="d-md-flex article-post mg-posts-sec-post align-items-center post">
                                    <div class="col-12 col-md-6 post-thumb-col">
                                        <div class="mg-post-thumb back-img md" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2023/06/Pengumuman-Penerima-Bantuan-Dana-Penelitian-dan-Pengabdian-Masyarakat-Usulan-Baru-bagi-Perguruan-Tinggi-Pengelola-Program-Studi-Pendidikan-Tinggi-Vokasi-Tahun-Anggaran-2023-2.png');">
                                            <span class="post-form"><i class="fas fa-camera"></i></span>
                                            <a class="link-div" href="#"></a>
                                        </div>
                                    </div>
                                    <div class="mg-sec-top-post py-3 col">
                                        <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                        <h4 class="entry-title title"><a href="#">Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026</a></h4>
                                        <div class="mg-blog-meta">
                                            <span class="mg-blog-date"><i class="fas fa-clock"></i> June 15, 2026</span>
                                            <a class="auth" href="#"><i class="fas fa-user-circle"></i> P3M</a>
                                        </div>
                                        <div class="mg-content"><p>Pusat Penelitian dan Pengabdian Masyarakat (P3M) Politeknik Negeri Batam mengumumkan daftar penerima pendanaan Penelitian dan Pengabdian kepada Masyarakat TA 2026 Politeknik Negeri Batam.</p></div>
                                    </div>
                                </article>

                                <article class="d-md-flex article-post mg-posts-sec-post align-items-center post">
                                    <div class="col-12 col-md-6 post-thumb-col">
                                        <div class="mg-post-thumb back-img md" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/BUKU-PANDUAN.jpg');">
                                            <span class="post-form"><i class="fas fa-camera"></i></span>
                                            <a class="link-div" href="#"></a>
                                        </div>
                                    </div>
                                    <div class="mg-sec-top-post py-3 col">
                                        <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                        <h4 class="entry-title title"><a href="#">Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026</a></h4>
                                        <div class="mg-blog-meta">
                                            <span class="mg-blog-date"><i class="fas fa-clock"></i> April 29, 2026</span>
                                            <a class="auth" href="#"><i class="fas fa-user-circle"></i> P3M</a>
                                        </div>
                                        <div class="mg-content"><p>Pada pengusulan penelitian dan Pengabdian kepada Masyarakat tahun 2026, Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam meluncurkan buku panduan pengusulan penelitian...</p></div>
                                    </div>
                                </article>

                                <article class="d-md-flex article-post mg-posts-sec-post align-items-center post">
                                    <div class="col-12 col-md-6 post-thumb-col">
                                        <div class="mg-post-thumb back-img md" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/111-1.png');">
                                            <span class="post-form"><i class="fas fa-camera"></i></span>
                                            <a class="link-div" href="#"></a>
                                        </div>
                                    </div>
                                    <div class="mg-sec-top-post py-3 col">
                                        <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                        <h4 class="entry-title title"><a href="#">P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)</a></h4>
                                        <div class="mg-blog-meta">
                                            <span class="mg-blog-date"><i class="fas fa-clock"></i> April 20, 2026</span>
                                            <a class="auth" href="#"><i class="fas fa-user-circle"></i> P3M</a>
                                        </div>
                                        <div class="mg-content"><p>Batam, 16 April 2026 — Politeknik Negeri Batam melalui kegiatan Expert Talk Series #1 sukses menyelenggarakan webinar bertajuk “Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)” ...</p></div>
                                    </div>
                                </article>

                                <article class="d-md-flex article-post mg-posts-sec-post align-items-center post">
                                    <div class="col-12 col-md-6 post-thumb-col">
                                        <div class="mg-post-thumb back-img md" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2023/06/Pengumuman-Penerima-Bantuan-Dana-Penelitian-dan-Pengabdian-Masyarakat-Usulan-Baru-bagi-Perguruan-Tinggi-Pengelola-Program-Studi-Pendidikan-Tinggi-Vokasi-Tahun-Anggaran-2023-2.png');">
                                            <span class="post-form"><i class="fas fa-camera"></i></span>
                                            <a class="link-div" href="#"></a>
                                        </div>
                                    </div>
                                    <div class="mg-sec-top-post py-3 col">
                                        <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                        <h4 class="entry-title title"><a href="#">Pengumuman Penerima Pendanaan Program Penelitian dan Pengabdian kepada Masyarakat (BIMA), Program Inovasi Seni Nusantara (BIMA), Program Hilirisasi Riset Prioritas (HILIRISET), dan Program SEMESTA Tahun Anggaran 2026</a></h4>
                                        <div class="mg-blog-meta">
                                            <span class="mg-blog-date"><i class="fas fa-clock"></i> April 10, 2026</span>
                                            <a class="auth" href="#"><i class="fas fa-user-circle"></i> P3M</a>
                                        </div>
                                        <div class="mg-content"><p>Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam mengumkan penerima pendanaan Program Penelitian dan Pengabdian kepada Masyarakat (BIMA), Program Inovasi Seni Nusantara (BIMA), Program Hilirisasi Riset Prioritas (HILIRISET), dan Program SEMESTA Tahun Anggaran 2026.</p></div>
                                    </div>
                                </article>

                                <article class="d-md-flex article-post mg-posts-sec-post align-items-center post">
                                    <div class="col-12 col-md-6 post-thumb-col">
                                        <div class="mg-post-thumb back-img md" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/1.jpg');">
                                            <span class="post-form"><i class="fas fa-camera"></i></span>
                                            <a class="link-div" href="#"></a>
                                        </div>
                                    </div>
                                    <div class="mg-sec-top-post py-3 col">
                                        <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                        <h4 class="entry-title title"><a href="#">Pembentukan dan Pengangkatan Ketua Pusat Kajian (PK) dan Center Of Excellence (CoE) Politeknik Negeri Batam Tahun 2026</a></h4>
                                        <div class="mg-blog-meta">
                                            <span class="mg-blog-date"><i class="fas fa-clock"></i> February 12, 2026</span>
                                            <a class="auth" href="#"><i class="fas fa-user-circle"></i> P3M</a>
                                        </div>
                                        <div class="mg-content"><p>Politeknik Negeri Batam menetapkan Pembentukan dan Pengangkatan Ketua Pusat Kajian (PK) serta Center Of Excellence (CoE) Politeknik Negeri Batam Tahun 2026 sebagai upaya penguatan ekosistem penelitian dan pengabdian kepada masyarakat.</p></div>
                                    </div>
                                </article>

                                <div class="col-md-12 text-center d-flex justify-content-center">
                                    <nav class="navigation pagination" aria-label="Posts pagination">
                                        <h2 class="screen-reader-text">Posts pagination</h2>
                                        <div class="nav-links">
                                            <span aria-current="page" class="page-numbers current">1</span>
                                            <a class="page-numbers" href="#">2</a>
                                            <span class="page-numbers dots">…</span>
                                            <a class="page-numbers" href="#">27</a>
                                            <a class="next page-numbers" href="#">›</a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid missed-section mg-posts-sec-inner">
                <div class="missed-inner">
                    <div class="row">
                        <div class="col-md-12" style="flex-basis:100%;max-width:100%;">
                            <div class="mg-sec-title"><h4>You missed</h4></div>
                        </div>
                        <div class="col-lg-3 col-sm-6 pulse animated">
                            <div class="mg-blog-post-3 minh back-img mb-lg-0" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2023/06/Pengumuman-Penerima-Bantuan-Dana-Penelitian-dan-Pengabdian-Masyarakat-Usulan-Baru-bagi-Perguruan-Tinggi-Pengelola-Program-Studi-Pendidikan-Tinggi-Vokasi-Tahun-Anggaran-2023-2.png');">
                                <a class="link-div" href="#"></a>
                                <div class="mg-blog-inner">
                                    <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                    <h4 class="title"><a href="#">Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026</a></h4>
                                    <div class="mg-blog-meta"><span class="mg-blog-date"><i class="fas fa-clock"></i> June 15, 2026</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 pulse animated">
                            <div class="mg-blog-post-3 minh back-img mb-lg-0" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/BUKU-PANDUAN.jpg');">
                                <a class="link-div" href="#"></a>
                                <div class="mg-blog-inner">
                                    <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                    <h4 class="title"><a href="#">Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026</a></h4>
                                    <div class="mg-blog-meta"><span class="mg-blog-date"><i class="fas fa-clock"></i> April 29, 2026</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 pulse animated">
                            <div class="mg-blog-post-3 minh back-img mb-lg-0" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/111-1.png');">
                                <a class="link-div" href="#"></a>
                                <div class="mg-blog-inner">
                                    <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                    <h4 class="title"><a href="#">P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)</a></h4>
                                    <div class="mg-blog-meta"><span class="mg-blog-date"><i class="fas fa-clock"></i> April 20, 2026</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 pulse animated">
                            <div class="mg-blog-post-3 minh back-img mb-lg-0" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/1.jpg');">
                                <a class="link-div" href="#"></a>
                                <div class="mg-blog-inner">
                                    <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                    <h4 class="title"><a href="#">Pengumuman Penerima Pendanaan Program Penelitian dan Pengabdian kepada Masyarakat (BIMA), Program Inovasi Seni Nusantara (BIMA), Program Hilirisasi Riset Prioritas (HILIRISET), dan Program SEMESTA Tahun Anggaran 2026</a></h4>
                                    <div class="mg-blog-meta"><span class="mg-blog-date"><i class="fas fa-clock"></i> April 10, 2026</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif (($page ?? 'home') === 'profil') : ?>
            <div class="page article-layout">
                <div class="article-head">PROFIL</div>
                <div class="article-body">
                    <div class="placeholder-box"></div>
                </div>
                <div class="page stat-row"><i class="mini-icon"></i> Jumlah Pengunjung: 17,874</div>
                <div class="page you-missed" style="margin-top: 18px;">
                    <div class="section-label">You missed</div>
                    <div class="missed-grid">
                        <?php foreach ($missedCards as $card) : ?>
                            <div class="missed-card">
                                <span class="missed-tag"><?php echo $card['tag']; ?></span>
                                <h4><?php echo $card['title']; ?></h4>
                                <div class="missed-date"><?php echo $card['date']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php elseif (($page ?? 'home') === 'informasi' || ($page ?? 'home') === 'penelitian') : ?>
            <div class="page article-layout">
                <div class="article-head">INFORMASI</div>
                <div class="article-body large-box">
                    <div class="story-row">
                        <div class="story-thumb blue-thumb">
                            <div class="story-mini-logo">simP3M</div>
                        </div>
                        <div class="story-copy">
                            <h3>Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026</h3>
                            <p>Pusat Penelitian dan Pengabdian Masyarakat (P3M) Politeknik Negeri Batam mengumumkan daftar penerima pendanaan Penelitian dan Pengabdian kepada Masyarakat TA 2026 ...</p>
                            <a class="read-more" href="#">Baca Selengkapnya</a>
                        </div>
                    </div>
                    <div class="story-row">
                        <div class="story-thumb blue-thumb dark-thumb">
                            <div class="story-mini-logo large-title">BUKU PANDUAN<br> PENELITIAN &amp; PENGABDIAN</div>
                        </div>
                        <div class="story-copy">
                            <h3>Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026</h3>
                            <p>Pada pengusulan penelitian dan pengabdian kepada masyarakat tahun 2026, Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam meluncurkan buku ...</p>
                            <a class="read-more" href="#">Baca Selengkapnya</a>
                        </div>
                    </div>
                    <div class="story-row">
                        <div class="story-thumb event-thumb">
                            <div class="story-mini-logo">Q1</div>
                        </div>
                        <div class="story-copy">
                            <h3>P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)</h3>
                            <p>Batam, 16 April 2026 — Politeknik Negeri Batam melalui kegiatan Expert Talk Series #1 sukses menyelenggarakan webinar bertajuk ...</p>
                            <a class="read-more" href="#">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="page stat-row"><i class="mini-icon"></i> Jumlah Pengunjung: 6,589</div>
            </div>
        <?php elseif (($page ?? 'home') === 'hki') : ?>
            <div class="page article-layout">
                <div class="article-head">HKI</div>
                <div class="article-body large-box">
                    <div class="story-row">
                        <div class="story-thumb blue-thumb">
                            <div class="story-mini-logo">HKI</div>
                        </div>
                        <div class="story-copy">
                            <h3>Hak Kekayaan Intelektual</h3>
                            <p>Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam aktif mendorong pengembangan inovasi, karya ilmiah, dan produk teknologi yang memiliki nilai komersial serta manfaat bagi masyarakat.</p>
                            <p>Berbagai karya inovatif dari dosen dan mahasiswa didaftarkan sebagai HKI untuk melindungi, meningkatkan nilai ekonomi, serta memperkuat ekosistem riset dan inovasi perguruan tinggi.</p>
                            <a class="read-more" href="https://p2m.polibatam.ac.id/?page_id=4735" target="_blank" rel="noopener noreferrer">Lihat Detail HKI</a>
                        </div>
                    </div>

                    <div class="story-row">
                        <div class="story-thumb blue-thumb dark-thumb">
                            <div class="story-mini-logo large-title">INTELLECTUAL<br>PROPERTY</div>
                        </div>
                        <div class="story-copy">
                            <h3>Prioritas Pengembangan HKI</h3>
                            <p>Beberapa fokus utama pengembangan HKI meliputi teknologi tepat guna, perangkat lunak, desain produk, inovasi pendidikan, serta solusi berbasis kebutuhan industri dan masyarakat.</p>
                            <ul>
                                <li>Perlindungan inovasi produk dan teknologi</li>
                                <li>Pengembangan karya riset yang aplikatif</li>
                                <li>Dukungan komersialisasi hasil penelitian</li>
                                <li>Kolaborasi dengan industri dan mitra strategis</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="page stat-row"><i class="mini-icon"></i> Jumlah Pengunjung: 4,342</div>
            </div>
        <?php elseif (($page ?? 'home') === 'statistik') : ?>
            <div class="page article-layout">
                <div class="article-head">STATISTIK</div>
                <div class="article-body large-box">
                    <div class="story-row">
                        <div class="story-thumb blue-thumb">
                            <div class="story-mini-logo">P2M</div>
                        </div>
                        <div class="story-copy">
                            <h3>Statistik Pusat Penelitian dan Pengabdian Masyarakat</h3>
                            <p>Pusat P2M Polibatam terus memperkuat aktivitas riset, publikasi, dan pengabdian dengan fokus pada inovasi, kolaborasi, serta dampak nyata bagi masyarakat dan industri.</p>
                            <ul>
                                <li>Riset dan inovasi terarah sesuai kebutuhan industri</li>
                                <li>Kolaborasi lintas disiplin dan mitra strategis</li>
                                <li>Publikasi ilmiah dan penguatan karya akademik</li>
                                <li>Pengabdian masyarakat berbasis solusi teknologi</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="page stat-row"><i class="mini-icon"></i> Jumlah Pengunjung: 12,480</div>
            </div>
        <?php elseif (($page ?? 'home') === 'berdampak') : ?>
            <div class="page article-layout">
                <div class="article-head">POLIBATAM UNIVERSITY BERDAMPAK</div>
                <div class="article-body large-box">
                    <div class="story-row">
                        <div class="story-thumb blue-thumb dark-thumb">
                            <div class="story-mini-logo large-title">IMPACT</div>
                        </div>
                        <div class="story-copy">
                            <h3>Membangun dampak nyata untuk masyarakat dan industri</h3>
                            <p>Polibatam University Berdampak merupakan komitmen untuk membawa kontribusi nyata melalui riset, inovasi, pengabdian, dan penerapan teknologi yang berdampak pada kualitas hidup, daya saing industri, serta kesejahteraan masyarakat.</p>
                            <p>Melalui pendekatan kolaboratif, Polibatam mendorong terciptanya solusi yang bermanfaat secara luas, terukur, dan berkelanjutan.</p>
                            <a class="read-more" href="#">Pelajari lebih lanjut</a>
                        </div>
                    </div>
                </div>
                <div class="page stat-row"><i class="mini-icon"></i> Dampak Program: Tingkatkan sinergi riset, industri, dan masyarakat</div>
            </div>
        <?php elseif (($page ?? 'home') === 'publikasi' || ($page ?? 'home') === 'tahun2025' || ($page ?? 'home') === 'tahun2026') : ?>
            <div class="page article-layout">
                <div class="article-head">TAHUN 2025</div>
                <div class="publication-shell">
                    <div class="publication-side">
                        <a class="year" href="/tahun-2026">TAHUN 2026</a>
                        <a class="year active" href="/tahun-2025">TAHUN 2025</a>
                        <a class="year" href="/tahun-2024">TAHUN 2024</a>
                        <a class="year" href="#">TAHUN SEBELUMNYA</a>
                    </div>
                    <div class="publication-content">
                        <h3>LUARAN PUBLIKASI</h3>
                        <ol class="publication-list">
                            <li><strong>A. Jurnal Internasional Berputasi</strong>
                                <ol>
                                    <li><strong>Muhammad Zainuddin Lubis</strong>, Andrean V.H. Simanjuntak, Nelly F. Riama, Gumilang R. Pasma, Angga Dwinovantyo, Agus Saleh Atmadipoera, Kutubuddin Ansari, Punyawi Jamjareegulgarn – <a href="https://www.sciencedirect.com/science/article/pii/S1687428524001043" target="_blank" rel="noopener noreferrer">Numerical simulation of hydrodynamics and measurement in the Northwest Banda Sea</a>. Terbit pada Egyptian Journal of Aquatic Research. (Q1)</li>
                                    <li><strong>Cahya Miranto</strong>, <strong>Ardiman Firmanda</strong>, Hestiasari Rante, Sritrusta Sukaridhoto, Muhammad Agus Zainuddin, Haolia Rahman – <a href="https://beei.org/index.php/EEI/article/view/9532" target="_blank" rel="noopener noreferrer">Performance analysis of 3D assets in virtual reality simulations for climate change: a case study in sustainable energy systems</a>. Terbit pada Bulletin of Electrical Engineering and Informatics. (Q1)</li>
                                    <li><strong>Widodo</strong>, Suhardjono, M. Khoirul Effendi – <a href="https://www.sciencedirect.com/science/article/pii/S2215016125003917" target="_blank" rel="noopener noreferrer">The impact of CDIO implementation on retrofitting CNC based universal turn drill in vocational education</a>. Terbit pada Methodsx. (Q1)</li>
                                    <li><strong>Muhammad Zainuddin Lubis</strong>, <strong>Muhammad Ghazali</strong>, Andrean V.H. Simanjuntak, Nelly F. Riama, Gumilang R. Pasma, Asep Priatna, Husnul Kausarian, Made Wedanta Suryadarma, Sri Pujiyati, Fredrich Simanungkalit, Batara, Kutubuddin Ansari, Punyawi Jamjareegulgarn – <a href="https://www.sciencedirect.com/science/article/pii/S1110982325000067" target="_blank" rel="noopener noreferrer">Decadal and seasonal oceanographic trends influenced by climate changes in the Gulf of Thailand</a>. Terbit pada Egyptian Journal of Remote Sensing and Space Science. (Q1)</li>
                                    <li><strong>Wenang Anurogo</strong>, Agave Putra Avedo Tarigan, Debby Seftyarizki, Wikan Jaya Prihantarto, Junhee Woo, Leon dos Santos Catarino, Amarpreet Singh Arora, Emilien Gohaud, Birte Meller, Thorsten Schuetze – <a href="https://www.mdpi.com/2073-445X/14/8/1656" target="_blank" rel="noopener noreferrer">Cellular Automata–Artificial Neural Network Approach to Dynamically Model Past and Future Surface Temperature Changes: A Case of a Rapidly Urbanizing Island Area</a>, Indonesia. Terbit pada Land. (Q1)</li>
                                    <li><strong>Muhammad Zaenuddin</strong> – <a href="https://www.researchgate.net/publication/394853206_How_to_Achieve_the_Integration_From_the_Dualism_of_Institutional_Conflicts_Lesson_Learned_From_Batam_Indonesia" target="_blank" rel="noopener noreferrer">How to Achieve the Integration From the Dualism of Institutional Conflicts? Lesson Learned From Batam, Indonesia</a>. Terbit pada Sage Open. (Q1)</li>
                                    <li><strong>Riska Analia</strong>, Anne Forster, Sheng-Quan Xie, Zhiqiang Zhang – <a href="https://www.mdpi.com/1424-8220/25/12/3836" target="_blank" rel="noopener noreferrer">Privacy-Preserving Approach for Early Detection of Long-Lie Incidents: A Pilot Study with Healthy Subjects</a>. Terbit pada Sensors. (Q1)</li>
                                    <li>Fadhila Yonata, <strong>Suwarno</strong>, Fahri Haswani, Ahmad Syairofi, Alfina Fadilatul Mabruroh – <a href="https://www.researchgate.net/publication/392835528_Demystifying_Gender-Value-Laden_English_Materials_Used_for_Indonesian_Senior_High_Schools_Multimodal_Analysis_and_Teachers'_Voices" target="_blank" rel="noopener noreferrer">Demystifying Gender-Value-Laden English Materials Used for Indonesian Senior High Schools: Multimodal Analysis and Teachers’ Voices</a>. Terbit pada Sexuality Gender and Policy. (Q1)</li>
                                    <li><strong>Muhammad Zainuddin Lubis</strong>, Edriyan Situmorang, Andrean V.H. Simanjuntak, Nelly F. Riama, Gumilang R. Pasma, Angga Dwinovantyo, Husnul Kausarian, Nyoman Metta N. Natih, Batara, Kutubuddin Ansari, Punyawi Jamjareegulgarn – <a href="https://www.sciencedirect.com/science/article/pii/S1687428525000044" target="_blank" rel="noopener noreferrer">Indonesian Throughflow, spatial–temporal variability, and its relationship to ENSO events in the Lombok Strait</a>. Terbit pada Egyptian Journal of Aquatic Research. (Q1)</li>
                                    <li>Prabowo Budhy Santoso, Haryo Dwito Armono, Raja Oloan Saut Gurning, <strong>Danang Cahyagi</strong> – <a href="https://www.mdpi.com/2071-1050/17/13/5773" target="_blank" rel="noopener noreferrer">Beyond River Port Logistics: Maximizing Land-Constrained Container Terminal Capacity with Agile and Lean Operation</a>. Terbit pada Sustainability Switzerland. (Q1)</li>
                                    <li>Ratna Andhika Mahaputri, Emi Emilia, Eri Kurniawan, <strong>Suwarno</strong> – <a href="https://www.tandfonline.com/doi/full/10.1080/14708477.2024.2307596" target="_blank" rel="noopener noreferrer">Instagram for learning interculturally: a blueprint in a global Englishes era</a>. Terbit pada Language and Intercultural Communication. (Q1)</li>
                                    <li><strong>Muhammad Zainuddin Lubis</strong>, Syarief Hidayat, Song Hu – <a href="https://www.mdpi.com/2077-1312/13/10/1974" target="_blank" rel="noopener noreferrer">Indonesian Throughflow in the Halmahera Sea: A Review</a>. Terbit pada Journal of Marine Science and Engineering. (Q2)</li>
                                    <li><strong>Muhammad Zainuddin Lubis</strong>, Budi Purwanto, Dyan Primana Sobaruddin, Dian Adrianto – <a href="https://www.researchgate.net/publication/390525867_Satellite-derived_Spatio-temporal_Dynamics_of_Sea_Surface_Temperature_in_the_Indonesian_and_Halmahera_Seas_During_ENSO_Events" target="_blank" rel="noopener noreferrer">Satellite-derived Spatio-temporal Dynamics of Sea Surface Temperature in the Indonesian and Halmahera Seas During ENSO Events</a>. Terbit pada Evergreen. (Q2)</li>
                                    <li>Imam Marzuki, Djarot Hindarto, <strong>Afdhol Dzikri</strong>, Fardani Annisa Damastuti, Yunifa Miftachul Arif, Reza Fuad Rachmadi, Mochamad Hariadi – <a href="https://etasr.com/index.php/ETASR/article/view/11055" target="_blank" rel="noopener noreferrer">Hierarchical Clustering-Based Geospatial Analysis for a Personalized Tourism Destination Recommender System</a>. Terbit pada Engineering Technology and Applied Science Research. (Q2)</li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="page stat-row"><i class="mini-icon"></i> Jumlah Pengunjung: 269</div>
                <div class="page you-missed" style="margin-top: 18px;">
                    <div class="section-label">You missed</div>
                    <div class="missed-grid">
                        <div class="missed-card"><span class="missed-tag">Informasi</span><h4>Pengumuman Hasil Seleksi Penelitian dan Pengabdian...</h4><div class="missed-date">June 15, 2026</div></div>
                        <div class="missed-card"><span class="missed-tag">Informasi</span><h4>Buku Panduan Penelitian dan Pengabdian kepada Masyarakat...</h4><div class="missed-date">April 29, 2026</div></div>
                        <div class="missed-card"><span class="missed-tag">Informasi</span><h4>P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi...</h4><div class="missed-date">April 20, 2026</div></div>
                    </div>
                </div>
            </div>
        <?php elseif (($page ?? 'home') === 'tahun2024') : ?>
            <div class="year-2024-article">
                <div class="article-head">Tahun 2024</div>
                <div class="year-2024-box">
                    <div class="year-2024-menu">
                        <a class="year-item" href="/tahun-2026">TAHUN 2026</a>
                        <a class="year-item" href="/tahun-2025">TAHUN 2025</a>
                        <a class="year-item active" href="/tahun-2024">TAHUN 2024</a>
                        <a class="year-item" href="#">TAHUN SEBELUMNYA</a>
                    </div>
                    <div class="year-2024-content">
                        <h2>PENGUATAN BUDAYA RISET DOSEN POLITEKNIK NEGERI BATAM</h2>

                        <h3><strong>A.</strong> <strong>Penelitian Kerjasama</strong></h3>
                        <ol>
                            <li><strong>Alena Uperiati</strong> – Membangun Animasi yang dapat Digunakan sebagai Media Pemanfaatan untuk Pengenalan Eco Enzim</li>
                            <li><strong>Aditya Gautama Darmoyono</strong> – Modul Mikrokontroler dengan Standar Industri untuk Penguat Lambda Sensor</li>
                            <li><strong>Mega Gemala</strong> – Rancangan dan Implementasi Alat Pengolahan Limbah Coolant Laboratorium Jurusan Teknik Mesin Politeknik Negeri Batam</li>
                            <li><strong>Mega Mayasari</strong> – User Perceptions of Cloud-Based Small Business Accounting Software: (Uji coba Aplikasi Keuangan Berbasis Cloud dalam lingkup UMKM di Kota Batam dan Pengembangan Aplikasi BANTU UMKM)</li>
                            <li><strong>Hendawan Soebhakt</strong> – Pengembangan Sistem Navigasi Automated Guided Vehicle (AGV) Menggunakan RFID Tag Function Set dan Magnetic Track</li>
                            <li><strong>Sandi Prasetyaningsih</strong> – Pengembangan Citra Maskot Si Mudi</li>
                            <li><strong>Senanjung Prayoga</strong> – Pengembangan Sistem Monitoring Automated Guided Vehicle (AGV) Berbasis web</li>
                            <li><strong>Dwi Amalia Purnamasar</strong> – Video Promosi Aplikasi Guide Me: Aplikasi Tour Guide sebagai rekomendasi destinasi wisata di Batam</li>
                            <li><strong>Miratul Khusna Mufida</strong> – Parkwell: A Data-Driven Smart Parking System Powered by IoT and Big Data Analytics for Sustainable Urban Mobility.</li>
                            <li><strong>Ir. Metta Santiputri</strong> – Aplikasi Pengukuran Ketercapaian Target Mutu Sesuai Standar Pengelolaan Mutu Internal (SPMI) Polibatam</li>
                            <li><strong>Swono Sibagariang</strong> – Model Klasifikasi Calon Mahasiswa Baru Untuk Rekomendasi Program Studi Menggunakan Recurrent Neural Network</li>
                            <li><strong>Nelmiawati</strong> – Automating Security Testing Reports and Management: An Information System for Efficient Penetration Testing Management</li>
                            <li><strong>Ir. Benny Haddli Irawan</strong> – Kajian Proses Pembuatan Suku Cadang Molding pada Industri Elektronik PT. IPEX</li>
                            <li><strong>Ari Wibowo</strong> – Desain dan Fabrikasi Prototipe Electrochlorination Skid Frame untuk Industri Offshore di Batam</li>
                            <li><strong>Rahman Hakim</strong> – Desain dan Fabrikasi Prototype Mold untuk Produk Spesimen Uji Kekerasan Material Plastik</li>
                            <li><strong>Ahmad Hamim Thohari</strong> – Pengembangan Lanjutan Aplikasi Pengukuran Ketercapaian Tujuan Pembelajaran</li>
                            <li><strong>Afriyanti Hasanah</strong> – Perancangan Start Up Layanan Penyedia Jasa Aplikasi Perpajakan (PJAP) Polibatam</li>
                            <li><strong>Mutia Ulfah</strong> – Konflik Israel – Palestina; Dampaknya Terhadap Boikot Produk Franchise Asing Dan UMKM Lokal Di Batam Dari Perspektif Perilaku Konsumen</li>
                            <li><strong>Naufal Abdurrahman Prasetyo</strong> – Perancangan Kapal Ambulans Duck Amphibious Untuk Perairan Terbatas Pada Tahap Conseptual Design</li>
                            <li><strong>Nadia Fathurrahmi Lawita</strong> – Polibatam Stock Rising: Media Kreatif Literasi Keuangan Pasar Modal Bagi Generasi Muda Melek Investasi</li>
                        </ol>

                        <h3><strong>Pengabdian Kepada Masyarakat</strong></h3>
                        <p><strong>Pengabdian Pemberdayaan Masyarakat</strong></p>
                        <ol>
                            <li><strong>Muhammad Naufal Airlangga Diputra</strong> – Workshop pengenalan K3L untuk siswa SMA/SMK</li>
                            <li><strong>Alfonsa Dian Sumarna</strong> – Pendampingan Pengelolaan dan Pengenalan Manajemen Keuangan Rumah Tangga Bagi Kelompok Pengajian Kampung Tua Belian Kota Batam</li>
                            <li><strong>Sartikha</strong> – Edukasi Pengelolaan Sampah Sisa Makanan (Organik) untuk Pemuda Kota Batam</li>
                            <li><strong>Anis Rahmi</strong> – Video Pembuatan NPWP untuk Tenaga Kerja Asing PT. Infineon Technologies Batam</li>
                            <li><strong>Mutia Ulfah</strong> – Penguatan Kapasitas UMKM Kuliner di Kota Batam melalui Pendampingan Perancangan Model Bisnis Lean Canvas dan Pembuatan NIB sebagai Strategi Pertumbuhan Berkelanjutan</li>
                            <li><strong>Ahmadi Irmansyah Lubis</strong> – Pengembangan dan Implementasi Sistem Informasi Organisasi Pada Pimpinan Cabang Muhammadiyah Kecamatan Batam Kota</li>
                            <li><strong>Adlian Jefiza</strong> – Pelatihan Arm Robot bagi Siswa SMK di Pulau Bintan</li>
                            <li><strong>Widya Rika Puspita</strong> – Jam Dinding Digital Sholat (Digital Prayer Clock)</li>
                            <li><strong>Ir. Kamarudin</strong> – Sistem Monitoring Kualitas Air Akuaponik Guna Mengurangi Resiko Gagal Panen pada Petani Desa Sri Bintan Berbasis IoT Dalam Rangka Mewujudkan Desa Lumbung Pangan</li>
                            <li><strong>Illa Aryen</strong> – Monitoring Kondisi Kolam Bioflok untuk Membantu Peternak Ikan Nila di Batam</li>
                            <li><strong>Eka Mutia Lubis</strong> – Perancangan Bangun GreenHouse Akuaponik Guna Mengurangi Resiko Gagal Panen pada Petani Desa Sri Bintan Berbasis IoT Dalam Rangka Mewujudkan Desa Lumbung Pangan</li>
                            <li><strong>Aditya Gautama Darmoyono</strong> – Digitalisasi sistem monitoring budidaya ikan air tawar untuk mewujudkan sistem perikanan yang modern menuju Desa Sri Bintan sebagai lumbung perikanan</li>
                            <li><strong>Roza Puspita</strong> – Welder Up-skilling untuk Siswa SMK Pengelasan Batam Dalam Persiapan Sertifikasi Internasional CSWIP</li>
                            <li><strong>Fitriyanti Nakul</strong> – Peningkatan Kualitas Pelayanan Pengaturan Lalu Lintas Kota melalui Penggunaan Perangkat Traffic Light Baton yang diproduksi dengan Teknologi Perakitan Komponen Elektronik (SMT)</li>
                            <li><strong>Maidel Fani</strong> – Penerapan SOC di Sekolah Menengah Kejuruan Negeri (SMKN)1 Singkep sebagai Solusi untuk Mengatasi Ancaman Digital Serangan Siber</li>
                            <li><strong>Yusiran</strong> – Pengembangan Teknologi Alat Celup Batik Dalam Upaya Optimasi Hasil Produksi Pada Pengrajin Batik Cindur Kota Batam</li>
                            <li><strong>Nurul Laili Arifin</strong> – Tungku Pengering Sebagai Solusi Peningkatan Taraf Hidup Masyarakat</li>
                            <li><strong>Febrina Wulandar</strong> – Program Pendampingan UMKM Pada Kelompok Usaha Ibu Rumah Tangga dan Anak di RW 005, Kelurahan Mangsang, Kecamatan Sungai Beduk, Kota Batam</li>
                            <li><strong>Ryan Satria Wijaya</strong> – Pelatihan Robotika berbasis STEM untuk SMA/SMK di kota Batam</li>
                            <li><strong>Hana Mutialif Maulidiah</strong> – Pemanfaatan Tenaga Surya sebagai Penggerak Kincir Air pada Kolam Budidaya Ikan Air Tawar</li>
                            <li><strong>M. Jaka Wimbang Wicaksono</strong> – Modernisasi Sistem Pemantauan Lahan Berbasis AI Untuk Mewujudkan Pertanian Maju, Mandiri Dan Modern Di Desa Sri Bintan</li>
                            <li><strong>Mu’thiana Gusnam</strong> – Penerapan Sistem Hidroponik Deep Flow Technique Di Perumahan Griya Batu Aji Asri Berbasis Panel Surya</li>
                            <li><strong>Prasaja Wikanta</strong> – Wireless Score Board Display untuk Pertandingan Olahraga Voli</li>
                            <li><strong>Danang Cahyagi</strong> – Pelatihan Penggunaan Software AutoCAD kepada siswa/i SMK Kota Batam Tahun 2024</li>
                            <li><strong>Ir.Jhon Hericson Purba</strong> – Pelatihan PLC untuk Siswa dan guru SMK di Pulau Bintan</li>
                            <li><strong>Muhammad Arifin</strong> – Wireless Score Board untuk Sarana Rekreasi Olahraga di Desa Sri Bintan</li>
                            <li><strong>Siskha Handayani</strong> – Pengembangan Media Microlearning berbasis mobile di Sekolah Menengah Atas Islam Terpadu (SMAIT) Ulil Albab Batam</li>
                            <li><strong>Nur Fitria Pujo Leksonowati</strong> – Implementasi Rotary Biokomposter dalam Pengolahan Limbah Organik Pertanian Kelompok Tani Harapan Sukses Kec. Sekupang</li>
                            <li><strong>Riri Zelmiyanti</strong> – Pendampingan Pelaporan Keuangan dan Pelaporan Pajak UMKM Kota Batam Melalui Program Business Development Services (BDS)</li>
                            <li><strong>Rahmat Hidayat</strong> – Pendampingan pembuatan modul ajar berbasis Digital bagi Guru SMP di Kota Batam</li>
                        </ol>

                        <p><strong>Pengabdian Kerjasama</strong></p>
                        <ol>
                            <li><strong>Winanda Wahana Warga Dalam</strong> – Pengenalan Investasi Melalui Simulasi Permainan Pasar Modal Sebagai Salah Satu Media Praktek Investasi untuk Tahap Awal Gen-Z Melalui Siswa/Siswi Sekolah Menengah Kejuruan Akuntansi SMK MHS Batam</li>
                            <li><strong>Ayu Puspitasari</strong> – Edukasi Penggunaan Warehouse Manajemen System (WMS) dalam Pengelolaan Pergudangan bagi Siswa SMK Negeri 1 Tanjungpinang</li>
                            <li><strong>Adhitomo Wirawan</strong> – Pelatihan Bantuan Dasar Hidup pada Bayi dan Anak kepada Komunitas Batam Babywearers</li>
                        </ol>
                        <p><strong>Jumlah Pengunjung: 2,723</strong></p>
                    </div>
                </div>
                <div class="page stat-row"><i class="mini-icon"></i> Jumlah Pengunjung: 2,723</div>
                <div class="page you-missed" style="margin-top: 18px;">
                    <div class="section-label">You missed</div>
                    <div class="missed-grid">
                        <div class="missed-card"><span class="missed-tag">Informasi</span><h4>Pengumuman Hasil Seleksi Penelitian dan Pengabdian...</h4><div class="missed-date">June 15, 2026</div></div>
                        <div class="missed-card"><span class="missed-tag">Informasi</span><h4>Buku Panduan Penelitian dan Pengabdian kepada Masyarakat...</h4><div class="missed-date">April 29, 2026</div></div>
                        <div class="missed-card"><span class="missed-tag">Informasi</span><h4>P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi...</h4><div class="missed-date">April 20, 2026</div></div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="page article-layout">
                <div class="article-head">PUBLIKASI</div>
                <div class="article-body box-archive">
                    <div class="year-menu">
                        <div class="year active">TAHUN 2026</div>
                        <div class="year">TAHUN 2025</div>
                        <div class="year">TAHUN 2024</div>
                        <div class="year">TAHUN SEBELUMNYA</div>
                    </div>
                </div>
                <div class="page stat-row"><i class="mini-icon"></i> Jumlah Pengunjung: 6,589</div>
            </div>
        <?php endif; ?>

        <footer class="footer">
            <div class="footer-inner page">
                <h2 class="footer-title">Pusat P2M Polibatam</h2>
                <div class="footer-bottom">Proudly powered by WordPress | Theme: Newsup by Themeansar.</div>
                <a class="footer-back-to-top" href="#" aria-label="Back to top">↑</a>
            </div>
        </footer>
    </div>

    <script>
        /* =========================================================
           Page interactions (vanilla JS)
        ========================================================= */
        var WP_Statistics_Tracker_Object = {
            "requestUrl": "https://p2m.polibatam.ac.id/index.php?rest_route=/wp-statistics/v2",
            "ajaxUrl": "https://p2m.polibatam.ac.id/wp-admin/admin-ajax.php",
            "hitParams": {
                "wp_statistics_hit": 1,
                "source_type": "home",
                "source_id": 0,
                "search_query": "",
                "signature": "cc8a7f860ed6b5bdd054bd8254368363",
                "endpoint": "hit"
            },
            "option": {
                "dntEnabled": "",
                "bypassAdBlockers": "",
                "consentIntegration": {
                    "name": null,
                    "status": []
                },
                "isPreview": false,
                "userOnline": false,
                "isWpConsentApiActive": false
            },
            "isLegacyEventLoaded": "",
            "customEventAjaxUrl": "https://p2m.polibatam.ac.id/wp-admin/admin-ajax.php?action=wp_statistics_custom_event&nonce=e606510d6d",
            "onlineParams": {
                "wp_statistics_hit": 1,
                "source_type": "home",
                "source_id": 0,
                "search_query": "",
                "signature": "cc8a7f860ed6b5bdd054bd8254368363",
                "action": "wp_statistics_online_check"
            },
            "jsCheckTime": "60000"
        };

        (function () {
            function initDateTime() {
                var topDateText = document.getElementById('top-date-text');
                var topDateTime = document.getElementById('top-date-time');

                if (!topDateText || !topDateTime) return;

                function updateDateTime() {
                    var now = new Date();
                    topDateText.textContent = now.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    topDateTime.textContent = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    });
                }

                updateDateTime();
                setInterval(updateDateTime, 1000);
            }

            function initSearchToggle() {
                var searchButton = document.querySelector('.nav-search');
                var searchPanel = document.getElementById('search-panel');
                var searchInput = document.getElementById('global-search-input');
                var searchClose = document.querySelector('.site-search-close');

                if (!searchButton || !searchPanel || !searchInput) return;

                function closeSearch() {
                    searchPanel.setAttribute('hidden', 'hidden');
                    searchButton.setAttribute('aria-expanded', 'false');
                }

                function openSearch() {
                    searchPanel.removeAttribute('hidden');
                    searchButton.setAttribute('aria-expanded', 'true');
                    setTimeout(function () {
                        searchInput.focus();
                    }, 40);
                }

                searchButton.addEventListener('click', function () {
                    if (searchPanel.hasAttribute('hidden')) {
                        openSearch();
                    } else {
                        closeSearch();
                    }
                });

                searchButton.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        if (searchPanel.hasAttribute('hidden')) {
                            openSearch();
                        } else {
                            closeSearch();
                        }
                    }
                });

                if (searchClose) {
                    searchClose.addEventListener('click', closeSearch);
                }

                searchInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeSearch();
                    }
                });
            }

            function initTabs() {
                var tabLinks = document.querySelectorAll('.nav-link.tab');
                var tabPanes = document.querySelectorAll('.tab-pane');

                if (!tabLinks.length || !tabPanes.length) return;

                tabLinks.forEach(function (tabLink) {
                    tabLink.addEventListener('click', function (event) {
                        event.preventDefault();
                        var targetTab = tabLink.getAttribute('data-tab');

                        tabLinks.forEach(function (link) {
                            link.classList.toggle('active', link === tabLink);
                        });

                        tabPanes.forEach(function (pane) {
                            var isActive = pane.getAttribute('data-panel') === targetTab;
                            pane.classList.toggle('active', isActive);
                            pane.classList.toggle('show', isActive);
                            pane.hidden = !isActive;
                        });
                    });
                });
            }

            function initBackToTop() {
                var backToTop = document.querySelector('.footer-back-to-top');

                if (!backToTop) return;

                backToTop.addEventListener('click', function (event) {
                    event.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            function initSlider() {
                var slider = document.querySelector('.feature-slider');
                if (!slider) return;

                var slides = Array.prototype.slice.call(slider.querySelectorAll('.feature-slide'));
                if (!slides.length) return;

                var currentIndex = 0;
                var timer = null;

                function showSlide(index) {
                    currentIndex = (index + slides.length) % slides.length;
                    slides.forEach(function (slide, slideIndex) {
                        var isActive = slideIndex === currentIndex;
                        slide.classList.toggle('active', isActive);
                        slide.style.transform = isActive ? 'translateX(0) scale(1)' : 'translateX(8%) scale(0.985)';
                    });
                }

                function goNext() {
                    showSlide(currentIndex + 1);
                }

                function goPrev() {
                    showSlide(currentIndex - 1);
                }

                function startAutoplay() {
                    if (timer) {
                        clearInterval(timer);
                    }
                    timer = setInterval(goNext, 5000);
                }

                slider.querySelectorAll('.feature-nav').forEach(function (button) {
                    button.addEventListener('click', function () {
                        if (button.classList.contains('prev')) {
                            goPrev();
                        } else {
                            goNext();
                        }
                        startAutoplay();
                    });
                });

                slider.addEventListener('mouseenter', function () {
                    if (timer) {
                        clearInterval(timer);
                        timer = null;
                    }
                });

                slider.addEventListener('mouseleave', startAutoplay);
                showSlide(0);
                startAutoplay();
            }

            initDateTime();
            initSearchToggle();
            initTabs();
            initBackToTop();
            initSlider();
        })();
    </script>
</body>
</html>
