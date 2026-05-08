<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Smart Farm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #be123c;
            margin: 0;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-h-screen;
        }

        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.4;
        }

        .input-custom {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: white;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .input-custom::placeholder {
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
        }
    </style>
</head>

<body class="min-h-screen">

    <svg class="bg-pattern" viewBox="0 0 1440 800" xmlns="http://www.w3.org/2000/svg">
        <path fill="#e11d48"
            d="M0,128L80,117.3C160,107,320,85,480,112C640,139,800,213,960,224C1120,235,1280,181,1360,154.7L1440,128L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
        </path>
        <circle cx="100" cy="700" r="300" fill="#fb7185" opacity="0.2" />
        <circle cx="1400" cy="100" r="400" fill="#fb7185" opacity="0.1" />
    </svg>

    <div class="w-full max-w-sm flex flex-col items-center z-10 p-6">

        <div class="mb-10 text-white flex flex-col items-center">
            <div class="relative mb-4">
                <i class="fas fa-warehouse text-5xl"></i>
                <i class="fas fa-arrow-up absolute -top-2 left-1/2 -translate-x-1/2 text-lg"></i>
            </div>
            <h1 class="text-white font-black tracking-[0.3em] text-xs uppercase opacity-80">Smart Farm System</h1>
        </div>

        <form method="POST" action="{{ route('admin.login.post') }}" class="w-full space-y-4">
            @csrf

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <i class="far fa-user text-white text-xs opacity-70"></i>
                </div>
                <input type="email" name="email" placeholder="USERNAME" required
                    class="input-custom w-full pl-11 pr-4 py-3.5 rounded-md focus:outline-none focus:border-white transition-all">
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <i class="fas fa-lock text-white text-xs opacity-70"></i>
                </div>
                <input type="password" name="password" id="password" placeholder="PASSWORD" required
                    class="input-custom w-full pl-11 pr-12 py-3.5 rounded-md focus:outline-none focus:border-white transition-all">

                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/50 hover:text-white transition-colors z-10">
                    <i id="eye-icon" class="fas fa-eye text-xs"></i>
                </button>
            </div>

            <button type="submit"
                class="w-full mt-4 bg-white text-rose-700 py-3.5 rounded-md font-bold text-sm uppercase tracking-widest shadow-2xl hover:bg-rose-50 transition-all active:scale-95">
                Login
            </button>

            <div class="text-center mt-6">
                <a href="#"
                    class="text-white/70 text-[10px] uppercase tracking-widest font-bold hover:text-white transition-all">
                    Forgot password?
                </a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'fas fa-eye-slash text-xs';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'fas fa-eye text-xs';
            }
        }
    </script>

</body>

</html>
