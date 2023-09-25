<x-guest-layout>
    {{-- <div class="row">
        <div class="col-lg-6 offset-lg-3">

            <div class="mx-auto" style="width: 200px; height: 200px;">
                <a href="{{ url('/') }}">
                    <x-application-logo/>
                </a>
            </div>

            <x-alert :message="session('status')" type="success"></x-alert>

            <x-alert type="info" message="Forgot your password? No problem.
             Just let us know your email address,
              and we will email you a password reset link that will allow you to choose a new one."/>

            <div class="card mx-auto shadow-sm">
                <div class="card-body">


                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label required">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="Enter email address" required autofocus>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark">Email Password Reset Link</button>
                        </div>

                        @if(Route::has('login'))
                            <div class="mt-2 text-center">
                                Already have an account? <a href="{{ route('login') }}">Login</a>
                            </div>
                        @endif
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
        <h4>FORGOT PASSWORD</h4>
      </div>

      {{-- message handler area --}}
        <x-alert-handler/>

        {{-- <x-alert :message="session('status')" type="success"></x-alert> --}}

            <x-alert type="info" message="Forgot your password? No problem.
             Just let us know your email address,
              and we will email you a password reset link that will allow you to choose a new one."/>

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="row g-3">

          <!-- Start user ID -->
          <div class="col-12">
            <label for="email" class="form-label required">Email address</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email','admin@maxsop.com') }}"  placeholder="Ex: access@example.com" name="email"
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

          <!-- Start login button -->
          <div class="col-12">
            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-send"></i> Email Password Reset Link</button>
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
