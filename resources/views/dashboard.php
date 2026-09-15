<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat P2M Polibatam</title>
    <style>
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
            font-size: 12px;
            font-weight: 700;
            padding: 10px 18px 9px;
            letter-spacing: 0.02em;
            line-height: 1.4;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .page-inner {
            max-width: 1280px;
            margin: 0 auto;
            width: calc(100% - 26px);
        }

        .hero-wrap {
            position: relative;
            background: linear-gradient(180deg, rgba(15, 32, 58, 0.56), rgba(15, 32, 58, 0.42)),
                url('https://p2m.polibatam.ac.id/wp-content/themes/newsup/images/head-back.jpg') center/cover no-repeat;
            min-height: 170px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-top: 1px solid rgba(255,255,255,0.12);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
        }

        .branding-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            padding: 14px 0;
        }

        .site-logo {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255,255,255,0.98);
            color: var(--navy-dark);
            display: grid;
            place-items: center;
            font-size: 2.3rem;
            font-weight: 900;
            box-shadow: 0 8px 24px rgba(0,0,0,0.18);
            border: 4px solid rgba(16, 52, 110, 0.5);
            flex-shrink: 0;
        }

        .site-logo::before {
            content: "P";
        }

        .site-branding-text {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
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
            font-size: clamp(2.2rem, 3vw, 3.2rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            text-shadow: 0 4px 18px rgba(0,0,0,0.25);
            margin: 0;
        }

        .nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(180deg, #1a4d88, #0d2e5d);
            padding: 0 18px 0 10px;
            min-height: 58px;
            gap: 10px;
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
            padding: 18px 12px 16px;
            color: rgba(255,255,255,0.88);
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            font-size: 0.72rem;
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

        .nav-search {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: white;
            border-left: 1px solid rgba(255,255,255,0.15);
            padding-left: 10px;
            margin-left: 8px;
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
            min-width: 170px;
            background: linear-gradient(180deg, #1e7be8, #0e5ebf);
            color: white;
            height: 52px;
            padding: 0 18px;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: none;
            font-size: 1.02rem;
            box-shadow: inset 0 -1px 0 rgba(0,0,0,0.08);
        }

        .bn_title .title {
            margin: 0;
            font-size: 1rem;
            font-weight: 800;
            color: white;
            line-height: 1;
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
        }

        .ticker-track {
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
            width: 100%;
            min-width: 100%;
            padding: 10px 18px 10px 22px;
            overflow: hidden;
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

        .ticker span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #122d52;
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
            box-shadow: var(--shadow);
            padding: 0;
            overflow: hidden;
            min-height: 470px;
        }

        .feature-hero {
            background: linear-gradient(180deg, #f5f7fa 0%, #edf1f5 100%);
            min-height: 470px;
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
            padding: 28px 24px 18px 28px;
            background: #f3f5f7;
        }

        .feature-title {
            position: relative;
            z-index: 1;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-weight: 900;
            line-height: 0.82;
            color: var(--navy-dark);
            letter-spacing: -0.08em;
        }

        .feature-title .line {
            display: block;
            font-size: clamp(2.8rem, 4vw, 5.8rem);
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
            min-height: 470px;
        }

        .tabs {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 12px;
            background: #f4f7fa;
            border: 1px solid var(--line);
            padding: 6px;
        }

        .tab {
            background: transparent;
            border: 0;
            color: #2d4058;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 12px 8px;
            text-align: center;
            cursor: pointer;
        }

        .tab.active {
            background: #fff;
            border-bottom: 2px solid #0d5ec9;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
            color: #0d2f5f;
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
            background: #f7f9fc;
            border: 1px solid var(--line);
            padding: 10px;
            min-height: 108px;
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
            border-radius: 6px 6px 0 0;
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
            background: linear-gradient(180deg, #0f1f3d, #0b1d35);
            color: white;
            min-height: 220px;
            margin-top: 20px;
            padding: 28px 12px 18px;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-title {
            font-size: clamp(2rem, 4vw, 4rem);
            font-weight: 800;
            letter-spacing: -0.05em;
            margin: 0 0 20px;
            color: rgba(255,255,255,0.95);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.12);
            text-align: center;
            padding-top: 18px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.7);
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

        @media (max-width: 900px) {
            .main-grid,
            .missed-grid,
            .tabs {
                grid-template-columns: 1fr;
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
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="page top-date">
            <div class="page-inner">September 14, 2026 &nbsp; 9:23 PM</div>
        </div>

        <div class="page hero-wrap">
            <div class="page-inner branding-inner">
                <div class="site-logo" aria-hidden="true"></div>
                <div class="site-branding-text">
                    <h1 class="hero-title">Pusat P2M Polibatam</h1>
                </div>
            </div>
        </div>

        <div class="page nav-bar">
            <div class="nav-main">
                <a class="nav-home <?php echo (($page ?? 'home') === 'home' ? 'active' : ''); ?>" href="/">⌂</a>
                <a class="nav-item <?php echo (($page ?? 'home') === 'profil' ? 'active' : ''); ?>" href="/profil">PROFIL</a>
                <a class="nav-item <?php echo (($page ?? 'home') === 'penelitian' ? 'active' : ''); ?>" href="/informasi">INFORMASI</a>
                <a class="nav-item <?php echo (($page ?? 'home') === 'publikasi' || ($page ?? 'home') === 'tahun2024' ? 'active' : ''); ?>" href="/publikasi">PUBLIKASI</a>
                <a class="nav-item" href="#">HKI</a>
                <a class="nav-item" href="https://sinta.kemdiktisaintek.go.id/affiliations/profile/564" target="_blank" rel="noopener noreferrer">SINTA</a>
                <a class="nav-item" href="https://jurnal.polibatam.ac.id/" target="_blank" rel="noopener noreferrer">JURNAL</a>
                <a class="nav-item" href="#">STATISTIK</a>
                <a class="nav-item" href="#">POLIBATAM UNIVERSITY BERDAMPAK</a>
            </div>
            <div class="nav-search">⌕</div>
        </div>

        <?php if (($page ?? 'home') === 'home') : ?>
            <section class="mg-latest-news-sec">
                <div class="page-inner">
                    <div class="mg-latest-news">
                        <div class="bn_title">
                            <h2 class="title">Latest Post</h2>
                        </div>
                        <div class="page ticker" aria-label="Latest post ticker">
                            <div class="ticker-track">
                                <span class="ticker-badge"><span class="ticker-icon">⚡</span> Latest Post</span>
                                <span>Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026</span>
                                <span>•</span>
                                <span>Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026</span>
                                <span>•</span>
                                <span>P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)</span>
                                <span>•</span>
                                <span>Pengumuman Penerima Pendanaan Program Penelitian dan Pengabdian kepada Masyarakat (BIMA), Program Inovasi Seni Nusantara (BIMA), Program Hilirisasi Riset Prioritas (HILIRISET), dan Program SEMESTA Tahun Anggaran 2026</span>
                                <span>•</span>
                                <span>Pembentukan dan Pengangkatan Ketua Pusat Kajian (PK) dan Center Of Excellence (CoE) Politeknik Negeri Batam Tahun 2026</span>
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
                                    <div class="item">
                                        <div class="mg-blog-post lg back-img" style="background-image: url('https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/BUKU-PANDUAN.jpg');">
                                            <a class="link-div" href="#"></a>
                                            <article class="bottom">
                                                <span class="post-form"><i class="fas fa-camera"></i></span>
                                                <div class="mg-blog-category">
                                                    <a class="newsup-categories category-color-1" href="#">INFORMASI</a>
                                                </div>
                                                <h4 class="title">
                                                    <a href="#">Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026</a>
                                                </h4>
                                                <div class="mg-blog-meta">
                                                    <span class="mg-blog-date"><i class="fas fa-clock"></i> April 29, 2026</span>
                                                    <a class="auth" href="#"><i class="fas fa-user-circle"></i> P3M</a>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 top-right-area">
                                <div id="exTab2">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a class="nav-link active" href="#">Latest</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Popular</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Trending</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tan-main-banner-latest-trending-popular-recent" class="tab-pane active fade show">
                                            <div class="mg-posts-sec mg-posts-modul-2">
                                                <div class="mg-posts-sec-inner row">
                                                    <div class="small-list-post col-lg-12">
                                                        <div class="small-post">
                                                            <div class="img-small-post"><a href="#"><img src="https://p2m.polibatam.ac.id/wp-content/uploads/2023/06/Pengumuman-Penerima-Bantuan-Dana-Penelitian-dan-Pengabdian-Masyarakat-Usulan-Baru-bagi-Perguruan-Tinggi-Pengelola-Program-Studi-Pendidikan-Tinggi-Vokasi-Tahun-Anggaran-2023-2-300x169.png" alt="Pengumuman Hasil Seleksi Penelitian dan Pengabdian ..."></a></div>
                                                            <div class="small-post-content">
                                                                <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                                                <div class="title_small_post"><h5 class="title"><a href="#">Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026</a></h5></div>
                                                            </div>
                                                        </div>
                                                        <div class="small-post">
                                                            <div class="img-small-post"><a href="#"><img src="https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/BUKU-PANDUAN-300x212.jpg" alt="Panduan Penelitian dan Pengabdian ..."></a></div>
                                                            <div class="small-post-content">
                                                                <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                                                <div class="title_small_post"><h5 class="title"><a href="#">Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026</a></h5></div>
                                                            </div>
                                                        </div>
                                                        <div class="small-post">
                                                            <div class="img-small-post"><a href="#"><img src="https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/111-1-300x200.png" alt="P3M Polibatam Gelar Expert Talk Series ..."></a></div>
                                                            <div class="small-post-content">
                                                                <div class="mg-blog-category"><a class="newsup-categories category-color-1" href="#">INFORMASI</a></div>
                                                                <div class="title_small_post"><h5 class="title"><a href="#">P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)</a></h5></div>
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
                    </div>
                </div>
            </section>

            <div id="content" class="container-fluid home">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mg-posts-sec mg-posts-modul-6">
                            <div class="mg-posts-sec-inner">
                                <article class="d-md-flex mg-posts-sec-post align-items-center post">
                                    <div class="col-12 col-md-6">
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

                                <article class="d-md-flex mg-posts-sec-post align-items-center post">
                                    <div class="col-12 col-md-6">
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

                                <article class="d-md-flex mg-posts-sec-post align-items-center post">
                                    <div class="col-12 col-md-6">
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
                        <div class="col-md-12">
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
                        <div class="missed-card">
                            <span class="missed-tag">Informasi</span>
                            <h4>Pengumuman Hasil Seleksi Penelitian dan Pengabdian...</h4>
                            <div class="missed-date">June 15, 2026</div>
                        </div>
                        <div class="missed-card">
                            <span class="missed-tag">Informasi</span>
                            <h4>Buku Panduan Penelitian dan Pengabdian kepada Masyarakat...</h4>
                            <div class="missed-date">April 29, 2026</div>
                        </div>
                        <div class="missed-card">
                            <span class="missed-tag">Informasi</span>
                            <h4>P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi...</h4>
                            <div class="missed-date">April 20, 2026</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif (($page ?? 'home') === 'penelitian') : ?>
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
        <?php elseif (($page ?? 'home') === 'publikasi') : ?>
            <div class="page article-layout">
                <div class="article-head">TAHUN 2025</div>
                <div class="publication-shell">
                    <div class="publication-side">
                        <a class="year active" href="/tahun-2026">TAHUN 2026</a>
                        <a class="year" href="/tahun-2025">TAHUN 2025</a>
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
            </div>
        </footer>
    </div>

    <script>
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
    </script>
</body>
</html>
