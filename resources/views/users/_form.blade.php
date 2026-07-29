<!-- Input Nama -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
    <input 
        type="text" 
        name="name" 
        value="{{ old('name', $user->name ?? '') }}" 
        required 
        class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('name') border-rose-500 @else border-gray-300 @enderror"
        placeholder="Masukkan nama..."
    >
    @error('name') 
        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> 
    @enderror
</div>

<!-- Input Email -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
    <input 
        type="email" 
        name="email" 
        value="{{ old('email', $user->email ?? '') }}" 
        required 
        class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('email') border-rose-500 @else border-gray-300 @enderror"
        placeholder="contoh@domain.com"
    >
    @error('email') 
        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> 
    @enderror
</div>

<!-- Input Password -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Password 
        @if(isset($user)) 
            <span class="text-xs font-normal text-gray-400">(Kosongkan jika tidak ingin diubah)</span> 
        @endif
    </label>
    <input 
        type="password" 
        name="password" 
        {{ isset($user) ? '' : 'required' }} 
        class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('password') border-rose-500 @else border-gray-300 @enderror"
        placeholder="******"
    >
    @error('password') 
        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> 
    @enderror
</div>

<!-- Select Role -->
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
    <select 
        name="role_id" 
        required 
        class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('role_id') border-rose-500 @else border-gray-300 @enderror"
    >
        <option value="">-- Pilih Role --</option>
        @foreach($roles as $role)
            <option 
                value="{{ $role->id }}" 
                {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}
            >
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
    @error('role_id') 
        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> 
    @enderror
</div>