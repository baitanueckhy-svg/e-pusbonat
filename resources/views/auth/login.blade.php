<x-guest-layout>

    <div class="ep-login-page">

        <div class="ep-login-card">

            {{-- BRANDING --}}
            <section class="ep-login-brand">

                <div class="ep-brand-orb"></div>
                <div class="ep-brand-orb-2"></div>

                <div class="ep-brand-content">

                    <div class="ep-medical-icon">
                        🏥
                    </div>

                    <h1 class="ep-brand-title">
                        E-PUSBONAT
                    </h1>

                    <p class="ep-brand-subtitle">
                        Puskesmas Naibonat
                    </p>

                    <div class="ep-brand-line"></div>

                    <p class="ep-brand-motto">
                        KAMI SIAP MELAYANI ANDA DENGAN RAPI.
                    </p>

                </div>

                {{-- ECG PREMIUM --}}
                <div class="ep-ecg-wrap">

                    <div class="ep-ecg-glow"></div>

                    <svg
                        class="ep-ecg"
                        viewBox="0 0 1400 130"
                        preserveAspectRatio="none"
                        aria-hidden="true"
                    >
                        <path
                            class="ep-ecg-base"
                            d="M0 72
                               L110 72
                               L145 72
                               L165 52
                               L184 95
                               L205 72
                               L245 72
                               L270 72
                               L292 72
                               L310 20
                               L330 112
                               L351 72
                               L390 72
                               L440 72
                               L465 72
                               L487 51
                               L507 94
                               L528 72
                               L570 72
                               L595 72
                               L617 72
                               L637 21
                               L657 112
                               L679 72
                               L720 72
                               L770 72
                               L795 72
                               L817 52
                               L837 94
                               L858 72
                               L900 72
                               L930 72
                               L950 72
                               L972 20
                               L992 112
                               L1014 72
                               L1055 72
                               L1100 72
                               L1130 72
                               L1150 52
                               L1170 94
                               L1190 72
                               L1400 72"
                        />

                        <path
                            class="ep-ecg-line"
                            d="M0 72
                               L110 72
                               L145 72
                               L165 52
                               L184 95
                               L205 72
                               L245 72
                               L270 72
                               L292 72
                               L310 20
                               L330 112
                               L351 72
                               L390 72
                               L440 72
                               L465 72
                               L487 51
                               L507 94
                               L528 72
                               L570 72
                               L595 72
                               L617 72
                               L637 21
                               L657 112
                               L679 72
                               L720 72
                               L770 72
                               L795 72
                               L817 52
                               L837 94
                               L858 72
                               L900 72
                               L930 72
                               L950 72
                               L972 20
                               L992 112
                               L1014 72
                               L1055 72
                               L1100 72
                               L1130 72
                               L1150 52
                               L1170 94
                               L1190 72
                               L1400 72"
                        />
                    </svg>

                    <div class="ep-ecg-dot"></div>

                </div>

            </section>


            {{-- LOGIN --}}
            <section class="ep-login-form-panel">

                <h2 class="ep-login-heading">
                    Selamat Datang
                </h2>

                <p class="ep-login-description">
                    Masuk ke sistem informasi E-PUSBONAT
                </p>

                @if ($errors->any())
                    <div class="ep-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="ep-field">
                        <label class="ep-label" for="username">
                            Username
                        </label>

                        <input
                            id="username"
                            class="ep-input"
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            required
                            autofocus
                            autocomplete="username"
                        >
                    </div>

                    <div class="ep-field">
                        <label class="ep-label" for="password">
                            Password
                        </label>

                        <div class="ep-input-wrap">

                            <input
                                id="password"
                                class="ep-input"
                                type="password"
                                name="password"
                                placeholder="Masukkan password"
                                required
                                autocomplete="current-password"
                                style="padding-right:55px;"
                            >

                            <button
                                type="button"
                                class="ep-password-toggle"
                                onclick="togglePassword()"
                                aria-label="Tampilkan password"
                            >
                                👁
                            </button>

                        </div>
                    </div>

                    <label class="ep-remember">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >

                        <span>Ingat saya</span>
                    </label>

                    <button
                        type="submit"
                        class="ep-submit"
                    >
                        MASUK KE E-PUSBONAT
                        <span style="font-size:18px;margin-left:7px;">→</span>
                    </button>

                </form>

                <div class="ep-footer">
                    E-PUSBONAT • Puskesmas Naibonat
                </div>

            </section>

        </div>

    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const button = document.querySelector('.ep-password-toggle');

            if (password.type === 'password') {
                password.type = 'text';
                button.textContent = '🙈';
            } else {
                password.type = 'password';
                button.textContent = '👁';
            }
        }
    </script>

</x-guest-layout>
