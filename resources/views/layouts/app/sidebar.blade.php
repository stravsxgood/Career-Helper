@php
    $user = auth()->user();
    $displayName = $user?->name ?? 'Career Seeker';
    $email = $user?->email ?? 'career@helper.app';
    $initials =
        collect(explode(' ', trim($displayName)))
            ->filter()
            ->map(fn($part) => mb_substr($part, 0, 1))
            ->take(2)
            ->implode('') ?:
        'CH';

    $navigation = [
        [
            'label' => 'Dashboard',
            'href' => route('dashboard'),
            'match' => 'dashboard*',
            'icon' =>
                '<path d="M3 10.75L12 3l9 7.75V21a1 1 0 0 1-1 1h-5.25v-6.25h-5.5V22H4a1 1 0 0 1-1-1V10.75Z"/><path d="M9.25 22v-6.25h5.5V22"/>',
        ],
        [
            'label' => 'Analyze AI',
            'href' => route('analysis'),
            'match' => 'analysis*',
            'icon' =>
                '<path d="m21 21-4.35-4.35"/><circle cx="10.5" cy="10.5" r="6.5"/><path d="M8 10.5h5"/><path d="M10.5 8v5"/>',
        ],
        [
            'label' => 'History',
            'href' => route('history'),
            'match' => 'history*',
            'icon' =>
                '<path d="M4 19V5"/><path d="M4 19h17"/><path d="M8 16V9"/><path d="M13 16V6"/><path d="M18 16v-4"/>',
        ],
        [
            'label' => 'Trash',
            'href' => route('trash'),
            'match' => 'career/trash*',
            'icon' =>
                '<path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/>',
        ],
    ];
@endphp

@once
    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes careerPulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(66, 133, 244, 0.22);
            }

            50% {
                transform: scale(1.035);
                box-shadow: 0 0 0 10px rgba(66, 133, 244, 0);
            }
        }

        .career-logo-pulse {
            animation: careerPulse 3.8s ease-in-out infinite;
        }
    </style>
@endonce

<div x-data="{ profileOpen: false, mobileOpen: false }" class="relative z-50">
    <aside
        class="fixed inset-y-0 left-0 hidden w-72 border-r border-white/10 bg-slate-950 text-slate-100 shadow-2xl shadow-slate-950/30 lg:flex lg:flex-col">
        <div class="absolute inset-0 overflow-hidden rounded-r-[2rem]">
            <div class="absolute -left-28 top-24 h-72 w-72 rounded-full bg-blue-500/10 blur-3xl"></div>
            <div class="absolute -bottom-28 right-4 h-72 w-72 rounded-full bg-emerald-400/10 blur-3xl"></div>
        </div>

        <div class="relative flex h-full flex-col px-4 py-5">
            <a href="{{ url('/') }}"
                class="group mb-8 flex items-center gap-3 rounded-3xl border border-white/10 bg-white/[0.045] p-3 transition duration-300 hover:bg-white/[0.075]">
                <span
                    class="career-logo-pulse grid h-11 w-11 place-items-center rounded-2xl bg-white text-slate-950 shadow-lg shadow-blue-500/10">
                    <span class="relative block h-5 w-5 rounded-md bg-[#4285F4]">
                        <span class="absolute -right-1 -top-1 h-2.5 w-2.5 rounded-full bg-[#EA4335]"></span>
                        <span class="absolute -bottom-1 -left-1 h-2.5 w-2.5 rounded-full bg-[#34A853]"></span>
                        <span class="absolute -bottom-1 -right-1 h-2.5 w-2.5 rounded-full bg-[#FBBC05]"></span>
                    </span>
                </span>
                <span class="min-w-0">
                    <span class="block truncate text-base font-semibold tracking-tight text-white">Career Helper</span>
                    <span class="block truncate text-xs font-medium text-slate-400">Career operating system</span>
                </span>
            </a>

            <nav aria-label="Primary navigation" class="relative space-y-1.5">
                @foreach ($navigation as $item)
                    @php $active = request()->is(trim(parse_url($item['href'], PHP_URL_PATH) ?? '', '/') . '*') || request()->routeIs($item['match']); @endphp
                    <a href="{{ $item['href'] }}"
                        class="group flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium transition duration-300 {{ $active ? 'bg-white text-slate-950 shadow-lg shadow-blue-950/20' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                        <span
                            class="grid h-9 w-9 place-items-center rounded-xl transition duration-300 {{ $active ? 'bg-slate-950 text-white' : 'bg-white/[0.06] text-slate-300 group-hover:bg-white/[0.11] group-hover:text-white' }}">
                            <svg class="h-[1.125rem] w-[1.125rem]" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">{!! $item['icon'] !!}</svg>
                        </span>
                        <span>{{ $item['label'] }}</span>
                        @if ($active)
                            <span class="ml-auto h-2 w-2 rounded-full bg-[#34A853]"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <div class="relative mt-auto pt-5">
                <div x-show="profileOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-3 scale-95" @click.outside="profileOpen = false"
                    class="absolute bottom-[5.7rem] left-0 right-0 overflow-hidden rounded-[1.45rem] border border-white/10 bg-slate-900/95 p-2 shadow-2xl shadow-slate-950/60 backdrop-blur-xl">
                    <a href="{{ route('profile.edit') }}"
                        class="group flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-semibold text-slate-200 transition duration-300 hover:bg-white/[0.08] hover:text-white">
                        <span
                            class="grid h-9 w-9 place-items-center rounded-xl bg-white/[0.06] text-[#34A853] transition duration-300 group-hover:bg-emerald-500/[0.15]">
                            <svg class="h-[1.125rem] w-[1.125rem] transition duration-500 group-hover:rotate-90"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                                <path
                                    d="M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06A1.7 1.7 0 0 0 15 19.36a1.7 1.7 0 0 0-1 .64 1.7 1.7 0 0 0-.4 1.1V21a2 2 0 0 1-4 0v-.09A1.7 1.7 0 0 0 8.6 19.36a1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.24 15a1.7 1.7 0 0 0-.64-1 1.7 1.7 0 0 0-1.1-.4H2.4a2 2 0 0 1 0-4h.09A1.7 1.7 0 0 0 4.24 8.6a1.7 1.7 0 0 0-.34-1.87l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 8.6 4.24a1.7 1.7 0 0 0 1-.64 1.7 1.7 0 0 0 .4-1.1V2.4a2 2 0 0 1 4 0v.09A1.7 1.7 0 0 0 15 4.24a1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.36 8.6a1.7 1.7 0 0 0 .64 1 1.7 1.7 0 0 0 1.1.4h.09a2 2 0 0 1 0 4h-.09A1.7 1.7 0 0 0 19.4 15Z" />
                            </svg>
                        </span>
                        <span>Settings Profile</span>
                    </a>
                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : url('/logout') }}">
                        @csrf
                        <button type="submit"
                            class="group flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-left text-sm font-semibold text-slate-300 transition duration-300 hover:bg-red-500/[0.12] hover:text-red-300">
                            <span
                                class="grid h-9 w-9 place-items-center rounded-xl bg-white/[0.06] text-slate-300 transition duration-300 group-hover:bg-red-500/[0.15] group-hover:text-red-300">
                                <svg class="h-[1.125rem] w-[1.125rem] transition duration-300 group-hover:translate-x-0.5"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <path d="m16 17 5-5-5-5" />
                                    <path d="M21 12H9" />
                                </svg>
                            </span>
                            <span>Log Out</span>
                        </button>
                    </form>
                </div>

                <button type="button" @click="profileOpen = ! profileOpen" :aria-expanded="profileOpen.toString()"
                    class="flex w-full items-center gap-3 rounded-[1.45rem] border border-white/10 bg-white/[0.055] p-3 text-left transition duration-300 hover:bg-white/[0.085] focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-semibold text-white">{{ $displayName }}</span>
                        <span class="block truncate text-xs text-slate-400">{{ $email }}</span>
                    </span>
                    <svg class="h-4 w-4 text-slate-400 transition duration-300"
                        :class="profileOpen ? 'rotate-180 text-white' : ''" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
            </div>
        </div>
    </aside>

    <!-- MOBILE APP -->

    <div
        class="fixed inset-x-3 bottom-3 z-50 rounded-[1.7rem] border border-slate-200/80 bg-white/[0.88] p-2 shadow-2xl shadow-slate-950/[0.15] backdrop-blur-xl lg:hidden">
        <div class="grid grid-cols-5 items-center gap-1">
            @foreach (array_slice($navigation, 0, 4) as $item)
                @php $active = request()->is(trim(parse_url($item['href'], PHP_URL_PATH) ?? '', '/') . '*') || request()->routeIs($item['match']); @endphp
                <a href="{{ $item['href'] }}"
                    class="group flex min-h-14 flex-col items-center justify-center rounded-2xl px-1 text-[0.68rem] font-semibold transition duration-300 {{ $active ? 'bg-slate-950 text-white' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="mb-1 h-[1.125rem] w-[1.125rem]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">{!! $item['icon'] !!}</svg>
                    <span class="max-w-[4.3rem] truncate">{{ $item['label'] }}</span>
                </a>
            @endforeach
            <button type="button" @click="mobileOpen = true"
                class="flex min-h-14 flex-col items-center justify-center rounded-2xl px-1 text-[0.68rem] font-semibold text-slate-500 transition duration-300 hover:bg-slate-100 hover:text-slate-900">
                <svg class="mb-1 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="M4 7h16" />
                    <path d="M4 12h16" />
                    <path d="M4 17h16" />
                </svg>
                <span>Menu</span>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-cloak class="fixed inset-0 z-[60] lg:hidden" aria-modal="true" role="dialog">
        <div x-show="mobileOpen" x-transition.opacity class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm"
            @click="mobileOpen = false"></div>
        <section x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-8"
            class="absolute inset-x-3 bottom-3 overflow-hidden rounded-[2rem] bg-slate-950 p-4 text-white shadow-2xl shadow-slate-950/50">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span
                        class="grid h-11 w-11 place-items-center rounded-2xl bg-white text-slate-950 font-bold">CH</span>
                    <div>
                        <p class="text-sm font-semibold">Career Helper</p>
                        <p class="text-xs text-slate-400">Mobile command center</p>
                    </div>
                </div>
                <button type="button" @click="mobileOpen = false"
                    class="grid h-10 w-10 place-items-center rounded-2xl bg-white/[0.07] text-slate-300 transition hover:bg-white/[0.12] hover:text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <nav aria-label="Mobile navigation" class="mt-5 grid gap-2">
                @foreach ($navigation as $item)
                    <a href="{{ $item['href'] }}"
                        class="flex items-center gap-3 rounded-2xl bg-white/[0.055] px-3 py-3 text-sm font-semibold text-slate-200 transition duration-300 hover:bg-white/[0.1] hover:text-white">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/[0.06] text-slate-300">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.9" stroke-linecap="round"
                                stroke-linejoin="round">{!! $item['icon'] !!}</svg>
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="mt-5 rounded-[1.45rem] border border-white/10 bg-white/[0.055] p-3">
                <div class="flex items-center gap-3">
                    <span
                        class="grid h-11 w-11 place-items-center rounded-2xl bg-white text-sm font-bold text-slate-950">{{ $initials }}</span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-white">{{ $displayName }}</p>
                        <p class="truncate text-xs text-slate-400">{{ $email }}</p>
                    </div>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-2">
                    <a href="{{ Route::has('profile.show') ? route('profile.show') : url('/profile') }}"
                        class="rounded-2xl bg-white/[0.07] px-2 py-2 text-center text-xs font-semibold text-slate-200 transition hover:bg-blue-500/[0.15] hover:text-blue-200">View</a>
                    <a href="{{ Route::has('profile.edit') ? route('profile.edit') : url('/profile/settings') }}"
                        class="rounded-2xl bg-white/[0.07] px-2 py-2 text-center text-xs font-semibold text-slate-200 transition hover:bg-emerald-500/[0.15] hover:text-emerald-200">Settings</a>
                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : url('/logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full rounded-2xl bg-white/[0.07] px-2 py-2 text-center text-xs font-semibold text-slate-200 transition hover:bg-red-500/[0.15] hover:text-red-200">Log
                            Out</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
