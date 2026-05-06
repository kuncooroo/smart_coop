@extends('layouts.admin)
@section('title','Edit Admin')

@section('content')

<h1 class="text-xl font-bold mb-6">Edit Admin</h1>

<form method="POST" action="{{ route('admin.admin.update',$admin->id) }}">
@csrf @method('PUT')

<input name="name" value="{{ $admin->name }}" class="w-full mb-3 p-3 border rounded">
<input name="email" value="{{ $admin->email }}" class="w-full mb-3 p-3 border rounded">

<input type="password" name="password" placeholder="Password baru (opsional)"
       class="w-full mb-3 p-3 border rounded">

<select name="role" class="w-full mb-3 p-3 border rounded">
    <option value="admin" {{ $admin->role=='admin'?'selected':'' }}>Admin</option>
    <option value="superadmin" {{ $admin->role=='superadmin'?'selected':'' }}>Super Admin</option>
</select>

<button class="bg-rose-600 text-white px-6 py-2 rounded">
    Update
</button>

</form>

@endsection