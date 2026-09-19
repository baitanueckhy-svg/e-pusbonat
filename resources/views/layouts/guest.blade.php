cd ~/e-keswa
nano resources/views/layouts/guest.blade.php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-PUSBONAT | Login</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 10% 10%, rgba(75, 220, 205, .25), transparent 30%),
                radial-gradient(circle at 90% 90%, rgba(7, 58, 83, .45), transparent 35%),
                linear-gradient(135deg, #075e5a 0%, #087f78 50%, #06445f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #173b4d;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1050px;
            min-height: 620px;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            background: rgba(255,255,255,.96);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,.25);
        }

        .brand-panel {
            position: relative;
            padding: 55px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            background:
                radial-gradient(circle at 85% 15%, rgba(90,240,222,.30), transparent 28%),
                linear-gradient(145deg, #075e5a 0%, #087f78 55%, #06445f 100%);
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.14);
            right: -120px;
            bottom: -120px;
        }

        .brand-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin-bottom: 28px;
            backdrop-filter: blur(10px);
        }

        .brand-title {
            font-size: 42px;
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -.8px;
            margin: 0 0 12px;
        }

        .brand-subtitle {
            font-size: 17px;
            opacity: .9;
            margin-bottom: 38px;
        }

        .motto {
            max-width: 440px;
            font-size: 19px;
            line-height: 1.7;
            font-weight: 600;
            letter-spacing: .2px;
        }

        .motto-line {
            width: 70px;
            height: 4px;
            border-radius: 99px;
            background: #5eead4;
            margin-bottom: 18px;
        }

        .login-panel {
            padding: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .login-box {
            width: 100%;
            max-width: 390px;
        }

        .login-title {
            font-size: 30px;
            font-weight: 800;
            color: #123b4d;
            margin: 0 0 8px;
        }

        .login-description {
            color: #718096;
            margin: 0 0 32px;
            font-size: 14px;
        }

        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #315466;
            margin-bottom: 8px;
        }

        .field input {
            width: 100%;
            height: 50px;
            border: 1px solid #d5e3e8;
            border-radius: 12px;
            padding: 0 15px;
            font-size: 15px;
            outline: none;
            transition: .2s ease;
            background: #f9fcfd;
        }

        .field input:focus {
            border-color: #0f9f92;
            box-shadow: 0 0 0 4px rgba(15,159,146,.12);
            background: white;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 4px 0 24px;
            font-size: 13px;
            color: #64748b;
        }

        .remember input {
            accent-color: #0f766e;
        }

        .login-button {
            width: 100%;
            height: 52px;
            border: 0;
            border-radius: 13px;
            background: linear-gradient(135deg, #0f766e, #087f78);
            color: white;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: .4px;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(15,118,110,.22);
            transition: .2s ease;
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(15,118,110,.28);
        }

        .error-box {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 28px;
            color: #94a3b8;
            font-size: 12px;
        }

        @media (max-width: 800px) {
            body {
                padding: 15px;
            }

            .login-wrapper {
                grid-template-columns: 1fr;
                min-height: auto;
                max-width: 480px;
            }

            .brand-panel {
                padding: 35px 30px;
                min-height: 270px;
            }

            .brand-title {
                font-size: 32px;
            }

            .brand-subtitle {
                margin-bottom: 20px;
            }

            .motto {
                font-size: 15px;
            }

            .login-panel {
                padding: 32px 25px 35px;
            }
        }

        @media (max-width: 480px) {
            .brand-panel {
                padding: 28px 24px;
            }

            .brand-icon {
                width: 58px;
                height: 58px;
                font-size: 27px;
                margin-bottom: 20px;
            }

            .brand-title {
                font-size: 28px;
            }

            .login-panel {
                padding: 28px 20px 30px;
            }

            .login-title {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <div class="brand-panel">

            <div class="brand-icon">
                🏥
            </div>

            <h1 class="brand-title">
                E-PUSBONAT
            </h1>

            <div class="brand-subtitle">
                Puskesmas Naibonat
            </div>

            <div class="motto-line"></div>

            <div class="motto">
                KAMI SIAP MELAYANI ANDA DENGAN RAPI.
            </div>

        </div>

        <div class="login-panel">

            <div class="login-box">

                <h2 class="login-title">
                    Selamat Datang
                </h2>

                <p class="login-description">
                    Masuk ke sistem informasi E-PUSBONAT
                </p>

                @if ($errors->any())
                    <div class="error-box">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{ $slot }}

                <div class="footer">
                    E-PUSBONAT • Puskesmas Naibonat
                </div>

            </div>

        </div>

    </div>

</body>
</html>

