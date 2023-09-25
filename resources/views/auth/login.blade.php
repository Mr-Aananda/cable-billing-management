<x-guest-layout>

     <div class="authentication widget py-4">
        {{-- message handler area --}}
         {{-- <x-alert-handler/> --}}

        <div class="logo">
            <x-logos.logo-with-name />
        </div>

        <div class="text-center mt-2">
            <h4>SIGN IN</h4>
            <p>You login in {{env('APP_NAME')}}</p>
        </div>
        {{-- error msg --}}
        <x-alert-handler />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="row g-3">

                <!-- Start user ID -->
                <div class="col-12">
                    <label for="email" class="form-label required">Email address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror " placeholder="Ex: access@example.com" name="email"
                            id="email" required>

                        {{-- error msg --}}
                        {{-- @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror --}}
                    </div>
                </div>
                <!-- End user ID -->

                <!-- Start Password -->
                <div class="col-12">
                    <label for="password" class="form-label required">Password</label>
                    <div class="input-group toggle-password-fill">
                        <span class="input-group-text"><i class="bi bi-unlock"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Ex: ******" name="password" id="password" onkeydown="capsLock(event)" required>
                        <button type="button" class="pass-eye" onclick="show(event, password)"><i class="bi bi-eye-fill"></i></button>
                    </div>
                        {{-- error msg --}}
                        {{-- @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror --}}
                    <small id="capsLockText" class="d-none text-danger">Caps lock is on</small>
                </div>
                <!-- End Password -->


                <!-- Start Remember checkbox -->
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember" value="">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                </div>
                <!-- End Remember checkbox -->

                <!-- Start login button -->
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right"></i> Sign in</button>
                </div>
            <!-- End login button -->
            </div>

        </form>

        {{-- <div class="text-center mt-3">
            <p class="mb-1">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">I forgot my user ID or Password</a>

                @endif
            </p>
            @if (Route::has('register'))
                <p>New to the system? <a href="{{ route('register') }}">Sign up</a> </p>
            @endif
        </div> --}}

        <div class="footer">
            <small>
                <span> &copy; 2020 -
                    {{-- <script>document.write(new Date().getFullYear())</script> --}}
                </span>
                <a href="https://maxsop.com/" class="text-small" target="_blank">MaxSOP</a>.
                <span> All rights reserved.</span>
            </small>
        </div>

     </div>

</x-guest-layout>
