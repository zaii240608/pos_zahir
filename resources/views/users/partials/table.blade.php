<div class="overflow-x-auto">
    <table class="min-w-[680px] w-full text-left text-xs text-slate-600">
        <thead class="bg-teal-900/5 border-b border-teal-900/10 text-[11px] uppercase font-black text-teal-900 tracking-wider">
            <tr>
                <th scope="col" class="px-6 py-4 text-center w-16">#</th>
                <th scope="col" class="px-6 py-4">Nama Pengguna</th>
                <th scope="col" class="px-6 py-4">Alamat Email</th>
                <th scope="col" class="px-6 py-4">Role / Hak Akses</th>
                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 font-medium">
            @forelse($users as $index => $user)
                <tr class="hover:bg-teal-50/30 transition-colors">
                    <td class="px-6 py-4 text-center font-bold text-slate-400">
                        {{ $users->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-900">
                        <div class="flex items-center gap-2">
                            <span>{{ $user->name }}</span>
                            @if(auth()->id() === $user->id)
                                <span class="px-2 py-0.5 text-[10px] font-black bg-teal-500 text-white rounded-md shadow-xs">Anda</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 font-black text-slate-700 uppercase tracking-wide">
                            {{ $user->role->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="px-3.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-900 font-extrabold rounded-lg border border-amber-200 transition shadow-2xs active:scale-95">
                                Edit
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="delete-user-form-{{ $user->id }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete('delete-user-form-{{ $user->id }}', 'Apakah Anda yakin ingin menghapus user {{ $user->name }}?')" 
                                        class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-extrabold rounded-lg border border-rose-200 transition shadow-2xs active:scale-95">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">
                        <div class="w-12 h-12 mx-auto mb-3 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        Data pengguna tidak ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination Footer -->
@if($users->hasPages())
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 pagination-wrapper">
        {{ $users->links() }}
    </div>
@endif