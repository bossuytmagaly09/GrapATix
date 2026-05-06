<div x-data="{ isRegister: @entangle('isRegister') }" 
     class="relative w-screen h-screen bg-[#001E2B] overflow-hidden font-sans"
     :class="isRegister ? 'show-register' : 'show-login'">
    
    <style>
        .auth-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .show-register .sign-in-container {
            transform: translateX(100%);
            opacity: 0;
        }

        .show-register .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .show-register .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
            background: linear-gradient(135deg, #00ED64 0%, #00684A 100%);
            color: #001E2B;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .show-register .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 80px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .show-register .overlay-left {
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .show-register .overlay-right {
            transform: translateX(20%);
        }

        /* Forms Styling */
        .auth-form {
            background-color: #001E2B;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 80px;
            height: 100%;
        }

        .auth-form h1 {
            text-align: center;
        }

        .auth-form .w-full {
            text-align: left;
        }

        .welcome-title {
            font-size: 72px;
            font-weight: 900;
            line-height: 0.9;
            letter-spacing: -4px;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }

        .welcome-desc {
            font-size: 18px;
            margin-bottom: 3rem;
            opacity: 0.8;
        }

        .ghost-button {
            background-color: transparent;
            border: 2px solid #001E2B;
            color: #001E2B;
            padding: 1rem 3rem;
            border-radius: 99px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
        }

        .ghost-button:hover {
            background-color: #001E2B;
            color: #00ED64;
        }

        .flux-underline-custom input,
        .auth-container input,
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            display: block !important;
            background-color: transparent !important;
            background: transparent !important;
            border: none !important;
            border-bottom: 2px solid rgba(255,255,255,0.1) !important;
            border-radius: 0 !important;
            color: white !important;
            -webkit-text-fill-color: white !important;
            width: 100% !important;
            min-width: 100% !important;
            padding: 12px 0 !important;
            margin-bottom: 20px;
            box-shadow: 0 0 0px 1000px #001E2B inset !important;
            -webkit-box-shadow: 0 0 0px 1000px #001E2B inset !important;
            transition: all 0.3s, background-color 5000s ease-in-out 0s;
            text-align: left !important;
            caret-color: #00ED64 !important;
        }

        .flux-underline-custom input:focus {
            border-bottom-color: #00ED64 !important;
            background: linear-gradient(to top, rgba(0, 237, 100, 0.05), transparent) !important;
        }
    </style>

    <div class="auth-container">
        <!-- Sign Up Form -->
        <div class="form-container sign-up-container">
            <form method="POST" action="{{ route('register.store') }}" class="auth-form">
                @csrf
                <h1 class="text-5xl font-black text-white mb-8 tracking-tighter uppercase">Account Maken</h1>
                <div class="w-full max-w-sm space-y-4 text-left">
                    <flux:input name="name" :label="__('Naam')" type="text" required class="flux-underline-custom" />
                    <flux:input name="email" :label="__('E-mail')" type="email" required class="flux-underline-custom" />
                    <flux:input name="password" :label="__('Wachtwoord')" type="password" required class="flux-underline-custom" />
                    <flux:input name="password_confirmation" :label="__('Bevestig')" type="password" required class="flux-underline-custom" />
                    <flux:button type="submit" variant="primary" class="w-full bg-[#00ED64] text-[#001E2B] font-black py-4 rounded-full mt-4">
                        REGISTREREN
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Sign In Form -->
        <div class="form-container sign-in-container">
            <form method="POST" action="{{ route('login.store') }}" class="auth-form">
                @csrf
                <h1 class="text-5xl font-black text-white mb-8 tracking-tighter uppercase">Inloggen</h1>
                <div class="w-full max-w-sm space-y-6 text-left">
                    <flux:input name="email" :label="__('E-mail')" type="email" required class="flux-underline-custom" />
                    <div class="space-y-2">
                        <flux:input name="password" :label="__('Wachtwoord')" type="password" required class="flux-underline-custom" />
                        <div class="text-right">
                            <a href="{{ route('password.request') }}" class="text-xs text-[#00ED64] hover:underline uppercase font-bold tracking-wider">Wachtwoord vergeten?</a>
                        </div>
                    </div>
                    <flux:button type="submit" variant="primary" class="w-full bg-[#00ED64] text-[#001E2B] font-black py-4 rounded-full mt-4">
                        INLOGGEN
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Overlay Container -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h2 class="welcome-title">WELKOM!</h2>
                    <p class="welcome-desc text-xl">Al een account? Log dan direct in om je events te bekijken.</p>
                    <button class="ghost-button" @click="isRegister = false">INLOGGEN</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h2 class="welcome-title">WELKOM TERUG!</h2>
                    <p class="welcome-desc text-xl">Nog geen account? Registreer dan hier en begin direct!</p>
                    <button class="ghost-button" @click="isRegister = true">REGISTREREN</button>
                </div>
            </div>
        </div>
    </div>
</div>
