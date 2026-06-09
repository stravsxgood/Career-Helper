<x-app-layout>
    @php
        $hasDeleteError = $errors->userDeletion->isNotEmpty();
        $hasPasswordError = $errors->updatePassword->isNotEmpty();

        $activeTab = $hasDeleteError
            ? 'danger'
            : ($hasPasswordError || session('status') === 'password-updated'
                ? 'security'
                : 'profile');

        $user = auth()->user();
    @endphp

    <main
        class="min-h-screen bg-slate-50 px-4 py-8 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100 sm:px-6 lg:px-8"
        style="color-scheme: light;">
        <section class="mx-auto max-w-6xl">
            <header
                class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-slate-900/80">
                <div class="relative p-6 sm:p-8">
                    <div
                        class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#4285F4]/10 blur-3xl">
                    </div>
                    <div
                        class="pointer-events-none absolute -bottom-24 left-16 h-72 w-72 rounded-full bg-[#34A853]/10 blur-3xl">
                    </div>

                    <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-16 w-16 shrink-0 items-center justify-center rounded-[1.35rem] bg-slate-950 text-xl font-black text-white shadow-lg dark:bg-white dark:text-slate-950">
                                {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                            </div>

                            <div>
                                <p
                                    class="inline-flex items-center gap-2 rounded-full bg-[#34A853]/10 px-3 py-1 text-xs font-bold text-[#188038] dark:text-green-300">
                                    <span class="h-2 w-2 rounded-full bg-[#34A853]"></span>
                                    Account active
                                </p>

                                <h1
                                    class="mt-3 text-3xl font-bold tracking-[-0.04em] text-slate-950 dark:text-white sm:text-4xl">
                                    Profile settings
                                </h1>

                                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-300">
                                    Kelola identitas akun, keamanan password, dan preferensi profil Career Helper dalam
                                    satu tempat.
                                </p>
                            </div>
                        </div>

                        <nav class="grid grid-cols-3 gap-2 rounded-2xl border border-slate-200 bg-slate-50 p-1 dark:border-white/10 dark:bg-slate-950/70"
                            aria-label="Profile sections">
                            <button type="button" data-tab-button="profile"
                                class="rounded-xl px-4 py-2 text-sm font-bold transition-all duration-300">
                                Profile
                            </button>

                            <button type="button" data-tab-button="security"
                                class="rounded-xl px-4 py-2 text-sm font-bold transition-all duration-300">
                                Security
                            </button>

                            <button type="button" data-tab-button="danger"
                                class="rounded-xl px-4 py-2 text-sm font-bold transition-all duration-300">
                                Danger
                            </button>
                        </nav>
                    </div>
                </div>
            </header>

            <section class="mt-6 grid gap-6 lg:grid-cols-[300px_minmax(0,1fr)]">
                <aside
                    class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-slate-900/80 lg:sticky lg:top-8 lg:self-start">
                    <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">
                            Account quality
                        </p>

                        <div class="mt-4 flex items-end justify-between">
                            <span class="text-4xl font-black tracking-[-0.06em] text-slate-950 dark:text-white">
                                86%
                            </span>

                            <span
                                class="rounded-full bg-[#FBBC05]/15 px-3 py-1 text-xs font-bold text-[#a46b00] dark:text-yellow-300">
                                Good
                            </span>
                        </div>

                        <div class="mt-4 h-2 rounded-full bg-slate-200 dark:bg-white/10">
                            <div class="h-full w-[86%] rounded-full bg-[#34A853]"></div>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2 text-sm">
                        <button type="button" data-tab-button="profile"
                            class="flex w-full items-center justify-between rounded-2xl px-4 py-3 font-bold transition hover:bg-slate-50 dark:hover:bg-slate-950/60">
                            Personal information <span>→</span>
                        </button>

                        <button type="button" data-tab-button="security"
                            class="flex w-full items-center justify-between rounded-2xl px-4 py-3 font-bold transition hover:bg-slate-50 dark:hover:bg-slate-950/60">
                            Password security <span>→</span>
                        </button>

                        <button type="button" data-tab-button="danger"
                            class="flex w-full items-center justify-between rounded-2xl px-4 py-3 font-bold transition hover:bg-red-50 dark:hover:bg-red-950/20">
                            Delete account <span>→</span>
                        </button>
                    </div>
                </aside>

                <div class="space-y-6">
                    {{-- PROFILE TAB --}}
                    <section data-tab-panel="profile"
                        class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-slate-900/80 sm:p-8">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <h2 class="text-xl font-bold tracking-[-0.02em] text-slate-950 dark:text-white">
                                    Profile information
                                </h2>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Update nama, username, dan email yang digunakan di Career Helper.
                                </p>
                            </div>

                            @if (session('status') === 'profile-updated')
                                <span
                                    class="rounded-full bg-[#34A853]/10 px-3 py-1 text-xs font-bold text-[#188038] dark:text-green-300">
                                    Saved
                                </span>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
                            @csrf
                            @method('PATCH')

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="relative">
                                    <input id="name" name="name" type="text"
                                        value="{{ old('name', $user?->name) }}" required autofocus autocomplete="name"
                                        placeholder=" "
                                        class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                                        style="color-scheme: light;">

                                    <label for="name"
                                        class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                                        Full Name
                                    </label>

                                    @error('name')
                                        <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <input id="username" name="username" type="text"
                                        value="{{ old('username', $user?->username) }}" autocomplete="username"
                                        placeholder=" "
                                        class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                                        style="color-scheme: light;">

                                    <label for="username"
                                        class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                                        Username
                                    </label>

                                    @error('username')
                                        <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative sm:col-span-2">
                                    <input id="email" name="email" type="email"
                                        value="{{ old('email', $user?->email) }}" required autocomplete="email"
                                        placeholder=" "
                                        class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                                        style="color-scheme: light;">

                                    <label for="email"
                                        class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                                        Email Address
                                    </label>

                                    @error('email')
                                        <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div
                                    class="rounded-2xl border border-[#FBBC05]/30 bg-[#FBBC05]/10 p-4 text-sm text-slate-700 dark:text-slate-200">
                                    Email kamu belum diverifikasi.

                                    @if (Route::has('verification.send'))
                                        <button form="send-verification"
                                            class="font-bold text-[#4285F4] underline decoration-[#4285F4]/30 underline-offset-4">
                                            Kirim ulang verification email.
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-slate-950/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#4285F4] dark:bg-white dark:text-slate-950 dark:hover:bg-[#4285F4] dark:hover:text-white">
                                    Save changes
                                </button>
                            </div>
                        </form>

                        @if (Route::has('verification.send'))
                            <form id="send-verification" method="POST" action="{{ route('verification.send') }}"
                                class="hidden">
                                @csrf
                            </form>
                        @endif
                    </section>

                    {{-- SECURITY TAB --}}
                    <section data-tab-panel="security"
                        class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-slate-900/80 sm:p-8">
                        <div>
                            <h2 class="text-xl font-bold tracking-[-0.02em] text-slate-950 dark:text-white">
                                Update password
                            </h2>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Masukkan password baru dan konfirmasi password baru.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">
                            @csrf
                            @method('PUT')

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="relative">
                                    <input id="update_password_password" name="password" type="password" required
                                        autocomplete="new-password" placeholder=" "
                                        class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                                        style="color-scheme: light;">

                                    <label for="update_password_password"
                                        class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                                        New Password
                                    </label>

                                    @error('password', 'updatePassword')
                                        <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <input id="update_password_password_confirmation" name="password_confirmation"
                                        type="password" required autocomplete="new-password" placeholder=" "
                                        class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                                        style="color-scheme: light;">

                                    <label for="update_password_password_confirmation"
                                        class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                                        Confirm New Password
                                    </label>

                                    @error('password_confirmation', 'updatePassword')
                                        <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                @if (session('status') === 'password-updated')
                                    <p class="text-sm font-bold text-[#34A853]">
                                        Password updated.
                                    </p>
                                @else
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        Password baru akan langsung digunakan untuk login berikutnya.
                                    </p>
                                @endif

                                <button type="submit"
                                    class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-slate-950/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#4285F4] dark:bg-white dark:text-slate-950 dark:hover:bg-[#4285F4] dark:hover:text-white">
                                    Update password
                                </button>
                            </div>
                        </form>
                    </section>

                    {{-- DANGER TAB --}}
                    <section data-tab-panel="danger"
                        class="rounded-[2rem] border border-[#EA4335]/20 bg-white p-5 shadow-sm dark:bg-slate-900/80 sm:p-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-xl font-bold tracking-[-0.02em] text-slate-950 dark:text-white">
                                    Delete account
                                </h2>

                                <p class="mt-1 max-w-2xl text-sm text-slate-500 dark:text-slate-400">
                                    Setelah akun dihapus, semua data akan terhapus permanen. Pastikan kamu sudah
                                    mengekspor data penting.
                                </p>
                            </div>

                            <button type="button" id="open-delete-account-modal"
                                class="rounded-2xl bg-[#EA4335] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-[#EA4335]/20 transition-all duration-300 hover:-translate-y-0.5 hover:bg-red-600">
                                Delete account
                            </button>
                        </div>
                    </section>
                </div>
            </section>
        </section>

        {{-- DELETE ACCOUNT MODAL --}}
        <div id="delete-account-modal"
            class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm">
            <section id="delete-account-card"
                class="w-full max-w-lg rounded-[2rem] border border-slate-200 bg-white p-6 shadow-2xl shadow-slate-950/20 dark:border-white/10 dark:bg-slate-900">
                <div class="flex items-start justify-between gap-4">
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#EA4335]/10 text-[#EA4335]">
                        <svg viewBox="0 0 24 24" fill="none" class="h-7 w-7">
                            <path
                                d="M12 9v4m0 4h.01M10.3 4.7 2.8 18a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 4.7a2 2 0 0 0-3.4 0Z"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>

                    <button type="button" data-close-delete-modal
                        class="grid h-10 w-10 place-items-center rounded-2xl border border-slate-200 text-slate-400 transition hover:border-[#EA4335]/30 hover:bg-[#EA4335]/10 hover:text-[#EA4335] dark:border-white/10"
                        aria-label="Close modal">
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                            <path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" />
                        </svg>
                    </button>
                </div>

                <div class="mt-5">
                    <p class="inline-flex rounded-full bg-[#EA4335]/10 px-3 py-1 text-xs font-black text-[#EA4335]">
                        Dangerous action
                    </p>

                    <h3 class="mt-4 text-2xl font-black tracking-[-0.03em] text-slate-950 dark:text-white">
                        Delete account?
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                        Setelah akun dihapus, kamu akan logout dan akun tidak bisa digunakan lagi. Masukkan password
                        untuk konfirmasi.
                    </p>
                </div>

                <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6 space-y-5">
                    @csrf
                    @method('DELETE')

                    <div class="relative">
                        <input id="delete_account_password" name="password" type="password" required
                            autocomplete="current-password" placeholder=" "
                            class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#EA4335] focus:bg-white focus:ring-4 focus:ring-[#EA4335]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                            style="color-scheme: light;">

                        <label for="delete_account_password"
                            class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#EA4335]">
                            Current Password
                        </label>

                        @error('password', 'userDeletion')
                            <p class="mt-2 text-xs font-semibold text-[#EA4335]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div
                        class="rounded-2xl border border-[#EA4335]/20 bg-[#EA4335]/10 px-4 py-3 text-xs font-semibold leading-5 text-[#EA4335]">
                        Tindakan ini menghapus akun secara permanen. Pastikan data penting sudah kamu export sebelum
                        melanjutkan.
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button" data-close-delete-modal
                            class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50 dark:border-white/10 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-900">
                            Cancel
                        </button>

                        <button type="submit"
                            class="rounded-2xl bg-[#EA4335] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#EA4335]/20 transition hover:-translate-y-0.5 hover:bg-red-600">
                            Yes, delete account
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const activeTab = @json($activeTab);
            const hasDeleteError = @json($hasDeleteError);

            const tabButtons = document.querySelectorAll('[data-tab-button]');
            const tabPanels = document.querySelectorAll('[data-tab-panel]');

            function activateTab(tab) {
                tabPanels.forEach(function(panel) {
                    panel.hidden = panel.dataset.tabPanel !== tab;
                });

                tabButtons.forEach(function(button) {
                    const isActive = button.dataset.tabButton === tab;
                    const isDanger = button.dataset.tabButton === 'danger';

                    button.classList.remove(
                        'bg-white',
                        'shadow-sm',
                        'text-[#4285F4]',
                        'text-[#EA4335]',
                        'bg-[#4285F4]/10',
                        'bg-[#EA4335]/10',
                        'text-slate-600',
                        'text-slate-500'
                    );

                    if (isActive) {
                        button.classList.add(
                            isDanger ? 'text-[#EA4335]' : 'text-[#4285F4]',
                            isDanger ? 'bg-[#EA4335]/10' : 'bg-[#4285F4]/10'
                        );
                    } else {
                        button.classList.add('text-slate-600');
                    }
                });
            }

            tabButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    activateTab(button.dataset.tabButton);
                });
            });

            activateTab(activeTab);

            const modal = document.getElementById('delete-account-modal');
            const openButton = document.getElementById('open-delete-account-modal');
            const closeButtons = document.querySelectorAll('[data-close-delete-modal]');
            const passwordInput = document.getElementById('delete_account_password');

            function openModal() {
                if (!modal) return;

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                setTimeout(function() {
                    passwordInput?.focus();
                }, 80);
            }

            function closeModal() {
                if (!modal) return;

                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            openButton?.addEventListener('click', openModal);

            closeButtons.forEach(function(button) {
                button.addEventListener('click', closeModal);
            });

            modal?.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });

            if (hasDeleteError) {
                activateTab('danger');
                openModal();
            }

            @if (session('toast_message'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: @json(session('toast_message')),
                    showConfirmButton: false,
                    timer: 4500,
                    timerProgressBar: true,
                    background: '#ffffff',
                    color: '#0f172a',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/70',
                        title: 'text-sm font-black text-slate-950',
                        timerProgressBar: 'bg-[#34A853]',
                    },
                });
            @endif
        });
    </script>

    @once
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endonce

</x-app-layout>
