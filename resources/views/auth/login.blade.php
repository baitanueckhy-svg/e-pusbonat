<x-guest-layout>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label for="username">Username</label>
            <input
                id="username"
                type="text"
                name="username"
                value="{{ old('username') }}"
                placeholder="Masukkan username"
                required
                autofocus
                autocomplete="username"
            >
            @error('username')
                <div class="error-box" style="margin-top:8px;margin-bottom:0;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
                autocomplete="current-password"
            >
            @error('password')
                <div class="error-box" style="margin-top:8px;margin-bottom:0;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <label class="remember">
            <input
                type="checkbox"
                name="remember"
                {{ old('remember') ? 'checked' : '' }}
            >
            <span>Ingat saya</span>
        </label>

        <button type="submit" class="login-button">
            MASUK KE E-PUSBONAT
        </button>

    </form>

</x-guest-layout>
