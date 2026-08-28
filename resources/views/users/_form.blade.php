<div class="space-y-5">
    <div>
        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
            Nama Lengkap <span class="text-rose-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <input 
                type="text" 
                id="name"
                name="name" 
                value="{{ old('name', $user->name ?? '') }}" 
                required 
                placeholder="Masukkan nama lengkap..."
                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('name') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror"
            >
        </div>
        @error('name') 
            <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ $message }}</span>
            </p> 
        @enderror
    </div>

    <div>
        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
            Alamat Email <span class="text-rose-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <input 
                type="email" 
                id="email"
                name="email" 
                value="{{ old('email', $user->email ?? '') }}" 
                required 
                placeholder="contoh@domain.com"
                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('email') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror"
            >
        </div>
        @error('email') 
            <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ $message }}</span>
            </p> 
        @enderror
    </div>

    <div>
        <div class="flex items-center justify-between mb-2">
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                Kata Sandi 
                @if(!isset($user))
                    <span class="text-rose-500">*</span>
                @endif
            </label>
            @if(isset($user)) 
                <span class="text-[10px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200/60">Biarkan kosong jika tidak diubah</span> 
            @endif
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <input 
                type="password" 
                id="password"
                name="password" 
                {{ isset($user) ? '' : 'required' }} 
                placeholder="••••••••"
                class="w-full pl-10 pr-10 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('password') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror"
            >
            <button 
                type="button" 
                onclick="togglePasswordVisibility()" 
                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition"
            >
                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </button>
        </div>
        @error('password') 
            <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ $message }}</span>
            </p> 
        @enderror
    </div>

    <div>
        <label for="role_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
            Role / Hak Akses <span class="text-rose-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <select 
                id="role_id"
                name="role_id" 
                required 
                class="w-full pl-10 pr-10 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 appearance-none @error('role_id') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror"
            >
                <option value="" disabled {{ old('role_id', $user->role_id ?? '') == '' ? 'selected' : '' }}>-- Pilih Hak Akses --</option>
                @foreach($roles as $role)
                    <option 
                        value="{{ $role->id }}" 
                        {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}
                    >
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        @error('role_id') 
            <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ $message }}</span>
            </p> 
        @enderror
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>