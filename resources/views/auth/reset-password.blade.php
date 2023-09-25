<x-guest-layout>
    {{-- <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="mx-auto" style="width: 200px; height: 200px;">
                <a href="{{ url('/') }}">
                    <x-application-logo/>
                </a>
            </div>
            <div class="card mx-auto shadow-sm">
                <div class="card-header text-center">
                    <h4>Password Reset</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="mb-3">
                            <label for="email" class="form-label required">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                   name="email" value="{{ old('email', $request->email) }}"
                                   placeholder="Enter email address" required readonly>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label required">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Enter password" autofocus required>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirmation" class="form-label required">Confirm Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password-confirmation" name="password_confirmation"
                                   placeholder="Retype password" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="authentication widget py-4">
      <div class="logo">
        <x-logos.logo-with-name />
      </div>
      <div class="text-center mt-2">
        <h4>RESET PASSWORD</h4>
      </div>

        {{-- message handler area --}}
        <x-alert-handler/>

      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="row g-3">
          <!-- Start user ID -->
               <div class="col-12">
            <label for="email" class="form-label required">Email address</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" placeholder="Ex: access@example.com" name="email"
                id="email" required autofocus>
              <div class="valid-tooltip">
                Looks good!
              </div>
            </div>
             @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
          <!-- End user ID -->

          <!-- Start Password -->
          <div class="col-12">
            <label for="password" class="form-label required">Password</label>
            <div class="input-group toggle-password-fill">
              <span class="input-group-text"><i class="bi bi-unlock"></i></span>
              <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Ex: ******" name="password" id="password" onkeydown="capsLock(event)" required autofocus>
              <button type="button" class="pass-eye" onclick="show(event, password)"><i class="bi bi-eye-fill"></i></button>
            </div>
            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
          <!-- End Password -->


          <!-- Start Password -->
          <div class="col-12">
            <label for="password_confirmation" class="form-label required">Retype password</label>
            <div class="input-group toggle-password-fill">
              <span class="input-group-text"><i class="bi bi-unlock"></i></span>
              <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Ex: ******" name="password_confirmation" id="password_confirmation" onkeydown="capsLock(event)" required>
              <button type="button" class="pass-eye" onclick="show(event, password_confirmation)"><i class="bi bi-eye-fill"></i></button>
            </div>
            <small id="capsLockText" class="d-none text-danger">Caps lock is on</small>
          </div>
          <!-- End Password -->

          <!-- Start login button -->
          <div class="col-12">
            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-hand-index-thumb"></i> Reset Password</button>
          </div>
          <!-- End login button -->
        </div>

      </form>

  @if (Route::has('login'))
        <div class="text-center mt-3">
            <p><a href="{{ route('login') }}">Back to sign in</a></p>
       </div>
      @endif

      <div class="footer">
        <small>
          <span> &copy; 2020 -
            <script>document.write(new Date().getFullYear())</script>
          </span>
          <a href="https://maxsop.com/" class="text-small" target="_blank">MaxSOP</a>.
          <span> All rights reserved.</span>
        </small>
      </div>




    </div>
</x-guest-layout>
