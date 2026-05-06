<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-2xl w-full max-w-md shadow-xl">

    <h2 class="text-2xl font-bold mb-6 text-center">Login Admin</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <input type="email" name="email" placeholder="Email"
            class="w-full mb-4 p-3 border rounded-lg">

        <input type="password" name="password" placeholder="Password"
            class="w-full mb-4 p-3 border rounded-lg">

        <button class="w-full bg-rose-600 text-white py-3 rounded-lg">
            Login
        </button>

    </form>

</div>

</body>
</html>