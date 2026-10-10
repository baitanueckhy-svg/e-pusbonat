<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-PUSBONAT • Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 15% 20%, rgba(45, 212, 191, .25), transparent 28%),
                radial-gradient(circle at 85% 80%, rgba(14, 116, 144, .35), transparent 32%),
                linear-gradient(135deg, #0b7773 0%, #087f78 48%, #064e68 100%);
        }

        .ep-login-page {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 34px;
            position: relative;
            overflow: hidden;
        }

        .ep-login-page::before {
            content: "";
            position: absolute;
            width: 700px;
            height: 700px;
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 50%;
            left: -350px;
            top: -280px;
        }

        .ep-login-page::after {
            content: "";
            position: absolute;
            width: 800px;
            height: 800px;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 50%;
            right: -450px;
            bottom: -450px;
        }

        .ep-login-card {
            position: relative;
            z-index: 2;
            width: min(1180px, 100%);
            min-height: 650px;
            display: grid;
            grid-template-columns: 1.08fr .92fr;
            overflow: hidden;
            border-radius: 30px;
            background: rgba(255,255,255,.96);
            box-shadow:
                0 35px 100px rgba(0, 35, 48, .35),
                0 8px 30px rgba(0,0,0,.12);
        }

        /* =========================
           BRANDING PANEL
           ========================= */

        .ep-login-brand {
            position: relative;
            overflow: hidden;
            padding: 68px 62px 42px;
            color: white;
            background:
                radial-gradient(circle at 78% 16%, rgba(45,212,191,.30), transparent 30%),
                radial-gradient(circle at 15% 80%, rgba(45,212,191,.15), transparent 35%),
                linear-gradient(145deg, #075e5a 0%, #087f78 52%, #07556b 100%);
        }

        .ep-brand-orb {
            position: absolute;
            width: 560px;
            height: 560px;
            right: -300px;
            top: -250px;
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 50%;
        }

        .ep-brand-orb-2 {
            position: absolute;
            width: 760px;
            height: 760px;
            left: -520px;
            bottom: -520px;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 50%;
        }

        .ep-brand-content {
            position: relative;
            z-index: 3;
        }

        .ep-medical-icon {
            width: 76px;
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 22px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.20);
            font-size: 37px;
            margin-bottom: 28px;
        }

        .ep-brand-title {
            margin: 0;
            font-size: clamp(42px, 4.2vw, 62px);
            line-height: .98;
            letter-spacing: -2px;
            font-weight: 850;
        }

        .ep-brand-subtitle {
            margin: 15px 0 0;
            font-size: 22px;
            font-weight: 500;
            color: rgba(255,255,255,.90);
        }

        .ep-brand-line {
            width: 74px;
            height: 4px;
            border-radius: 999px;
            background: #5eead4;
            margin: 35px 0 28px;
            box-shadow: 0 0 18px rgba(94,234,212,.55);
        }

        .ep-brand-motto {
            margin: 0;
            font-size: 18px;
            line-height: 1.5;
            font-weight: 750;
            letter-spacing: .2px;
        }

        /* =========================
           ECG
           ========================= */

        .ep-ecg-wrap {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 32px;
            height: 150px;
            z-index: 2;
            overflow: hidden;
        }

        .ep-ecg-glow {
            position: absolute;
            left: -5%;
            right: -5%;
            bottom: 15px;
            height: 100px;
            background:
                radial-gradient(
                    ellipse at center,
                    rgba(45,212,191,.25),
                    transparent 68%
                );
            filter: blur(12px);
        }

        .ep-ecg {
            position: absolute;
            width: 200%;
            height: 130px;
            left: 0;
            top: 5px;
        }

        .ep-ecg-line {
            fill: none;
            stroke: #b6fff4;
            stroke-width: 4;
            stroke-linecap: round;
            stroke-linejoin: round;
            filter:
                drop-shadow(0 0 4px rgba(94,234,212,.95))
                drop-shadow(0 0 13px rgba(45,212,191,.75));
            stroke-dasharray: 1250;
            stroke-dashoffset: 1250;
            animation: epEcgMove 4.5s linear infinite;
        }

        @keyframes epEcgMove {
            0% {
                stroke-dashoffset: 1250;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }

        .ep-ecg-base {
            fill: none;
            stroke: rgba(255,255,255,.12);
            stroke-width: 1;
        }

        .ep-ecg-dot {
            position: absolute;
            width: 14px;
            height: 14px;
            right: 7%;
            top: 57px;
            border-radius: 50%;
            background: #c9fff8;
            box-shadow:
                0 0 7px #c9fff8,
                0 0 22px rgba(94,234,212,.95);
            animation: epPulse 1.4s ease-in-out infinite;
        }

        @keyframes epPulse {
            0%,100% {
                transform: scale(.8);
                opacity: .7;
            }
            50% {
                transform: scale(1.35);
                opacity: 1;
            }
        }

        /* =========================
           LOGIN FORM
           ========================= */

        .ep-login-form-panel {
            background: #ffffff;
            padding: 76px 68px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .ep-login-heading {
            margin: 0;
            color: #123b50;
            font-size: 38px;
            line-height: 1.1;
            font-weight: 850;
            letter-spacing: -1px;
        }

        .ep-login-description {
            margin: 10px 0 38px;
            color: #71869a;
            font-size: 16px;
        }

        .ep-field {
            margin-bottom: 22px;
        }

        .ep-label {
            display: block;
            margin-bottom: 9px;
            color: #274e63;
            font-size: 14px;
            font-weight: 750;
        }

        .ep-input-wrap {
            position: relative;
        }

        .ep-input {
            width: 100%;
            height: 58px;
            border: 1px solid #d7e3e9;
            border-radius: 15px;
            background: #fbfdfe;
            color: #183c4e;
            padding: 0 17px;
            outline: none;
            font-size: 15px;
            transition: .2s ease;
        }

        .ep-input:focus {
            border-color: #0f9d92;
            box-shadow: 0 0 0 4px rgba(15,157,146,.10);
            background: #ffffff;
        }

        .ep-input::placeholder {
            color: #9aabb7;
        }

        .ep-password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #78909f;
            cursor: pointer;
            font-size: 19px;
        }

        .ep-remember {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #647b8d;
            font-size: 14px;
            margin: 3px 0 28px;
        }

        .ep-remember input {
            width: 18px;
            height: 18px;
            accent-color: #0f8f87;
        }

        .ep-submit {
            width: 100%;
            height: 58px;
            border: 0;
            border-radius: 15px;
            background:
                linear-gradient(135deg, #087f78, #0f938b);
            color: white;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: .3px;
            cursor: pointer;
            box-shadow:
                0 13px 25px rgba(8,127,120,.20);
            transition: .2s ease;
        }

        .ep-submit:hover {
            transform: translateY(-1px);
            box-shadow:
                0 17px 30px rgba(8,127,120,.27);
        }

        .ep-submit:active {
            transform: translateY(0);
        }

        .ep-error {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
            font-size: 13px;
        }

        .ep-footer {
            margin-top: 35px;
            padding-top: 21px;
            border-top: 1px solid #e5edf1;
            text-align: center;
            color: #91a4b2;
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================
           RESPONSIVE
           ========================= */

        @media (max-width: 900px) {

            .ep-login-page {
                padding: 22px;
            }

            .ep-login-card {
                grid-template-columns: 1fr;
                max-width: 620px;
                min-height: auto;
            }

            .ep-login-brand {
                min-height: 390px;
                padding: 42px 38px 28px;
            }

            .ep-brand-title {
                font-size: 45px;
            }

            .ep-brand-subtitle {
                font-size: 18px;
            }

            .ep-ecg-wrap {
                bottom: 5px;
            }

            .ep-login-form-panel {
                padding: 44px 38px 35px;
            }
        }

        @media (max-width: 520px) {

            .ep-login-page {
                padding: 0;
                align-items: stretch;
            }

            .ep-login-card {
                width: 100%;
                min-height: 100vh;
                border-radius: 0;
                display: flex;
                flex-direction: column;
            }

            .ep-login-brand {
                min-height: 330px;
                padding: 34px 25px 20px;
            }

            .ep-medical-icon {
                width: 58px;
                height: 58px;
                border-radius: 17px;
                font-size: 28px;
                margin-bottom: 19px;
            }

            .ep-brand-title {
                font-size: 37px;
                letter-spacing: -1.5px;
            }

            .ep-brand-subtitle {
                margin-top: 9px;
                font-size: 16px;
            }

            .ep-brand-line {
                margin: 23px 0 17px;
            }

            .ep-brand-motto {
                font-size: 14px;
            }

            .ep-ecg-wrap {
                height: 105px;
                bottom: 0;
            }

            .ep-ecg {
                height: 100px;
                top: 5px;
            }

            .ep-ecg-dot {
                top: 45px;
                width: 10px;
                height: 10px;
            }

            .ep-login-form-panel {
                padding: 35px 23px 28px;
                flex: 1;
            }

            .ep-login-heading {
                font-size: 29px;
            }

            .ep-login-description {
                font-size: 14px;
                margin-bottom: 28px;
            }

            .ep-input {
                height: 54px;
            }

            .ep-submit {
                height: 55px;
            }
        }
    </style>
</head>

<body>

    {{ $slot }}

</body>
</html>
