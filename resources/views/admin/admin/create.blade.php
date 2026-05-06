@extends('layouts.admin')
@section('title','Tambah Admin')

@section('content')

<h1 class="text-xl font-bold mb-6">Tambah Admin</h1>

<form method="POST" action="{{ route('admin.admin.store') }}">
@csrf

<input name="name" placeholder="Nama" class="w-full mb-3 p-3 border rounded">
<input name="email" placeholder="Email" class="w-full mb-3 p-3 border rounded">
<input type="password" name="password" placeholder="Password" class="w-full mb-3 p-3 border rounded">

<select name="role" class="w-full mb-3 p-3 border rounded">
    <option value="admin">Admin</option>
    <option value="superadmin">Super Admin</option>
</select>

<button class="bg-rose-600 text-white px-6 py-2 rounded">
    Simpan
</button>

</form>

@endsection