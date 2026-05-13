<x-guest-layout>
    <div class="w-full max-w-[360px] flex flex-col items-center pb-12">
        <div class="w-full glass-panel rounded-xl p-8 pt-12 relative mt-12 mb-4">
            
            <!-- Profile Icon Overlapping Top -->
            <div class="absolute -top-[35px] left-1/2 transform -translate-x-1/2 bg-[#3f92a3] rounded-full w-[70px] h-[70px] flex items-center justify-center shadow-lg border-[3px] border-white/20">
                <svg class="w-[32px] h-[32px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>

            <!-- Title -->
            <div class="text-center mb-8 mt-2">
                <h2 class="text-[#5a6a70] text-3xl font-light tracking-wide">Sign In</h2>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf



                <!-- Email Address (Username) -->
                <div class="mb-4 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-[18px] h-[18px] text-[#9e9e9e]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Username"
                           class="w-full pl-10 pr-3 py-3 border-none rounded-[5px] text-[#5a6a70] bg-white focus:ring-2 focus:ring-[#3f92a3] focus:outline-none transition placeholder-[#bfbfbf] font-light shadow-sm text-[14px]" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs text-center" />
                </div>

                <!-- Password -->
                <div class="mb-6 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-[18px] h-[18px] text-[#9e9e9e]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password"
                           class="w-full pl-10 pr-3 py-3 border-none rounded-[5px] text-[#5a6a70] bg-white focus:ring-2 focus:ring-[#3f92a3] focus:outline-none transition placeholder-[#bfbfbf] font-light shadow-sm text-[14px]" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs text-center" />
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-[#3f92a3] hover:bg-[#347b8a] text-white font-light py-[10px] rounded-[5px] shadow text-[18px] tracking-wide transition mb-4">
                    Login
                </button>

                <!-- Links Row -->
                <div class="flex justify-between items-center text-[11px] text-white/90 font-light px-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded-[3px] border-white/50 text-[#3f92a3] focus:ring-[#3f92a3] shadow-sm bg-white border-none w-[14px] h-[14px]" name="remember">
                        <span class="ml-2">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="hover:text-white transition" href="{{ route('password.request') }}">
                            Forgot, Password?
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- Registration Text Outside Card -->
        <div class="w-full px-2">
            <div class="border-t border-white/50 w-full mb-3 mt-4"></div>
            <p class="text-[11px] text-white/90 font-light text-center">Don't have a account ? <a href="/register" class="text-white font-semibold tracking-wide">REGISTER HERE</a></p>
        </div>
    </div>
</x-guest-layout>
