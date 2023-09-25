<x-guest-layout>

    <div class="authentication register widget py-4">
      <div class="logo">
        <x-logos.logo-with-name />
      </div>
      <div class="text-center mt-2">
        <h4>SIGN UP</h4>
        <p>You register in {{env('APP_NAME')}}</p>
      </div>


      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row g-3">

          <!-- Start name-->
          <div class="col-md-12">
            <label for="name" class="form-label required">Name</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control @error('name') is-invalid @enderror"  placeholder="Ex: Musab" name="name"
                id="name" value="{{old('name')}}" required>
              <div class="valid-tooltip">
                Looks good!
              </div>
            </div>

            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
          <!-- End name-->


          <!-- Start email-->
          <div class="col-md-12">
            <label for="email" class="form-label required">Email address</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Ex: access@example.com" name="email"
                id="email" value="{{ old('email') }}" required>
            </div>

             @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          <!-- End email-->

            <!-- Start mobile-->
          <div class="col-md-12">
            <label for="phone" class="form-label required">Phone</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-telephone"></i></span>
              <input type="number" class="form-control @error('phone') is-invalid @enderror" placeholder="Ex: 01xxxxxxxxx" name="phone"
                id="phone" value="{{ old('phone') }}" required>
            </div>

             @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          <!-- End mobile-->


          <!-- Start Password -->
          <div class="col-12">
            <label for="password" class="form-label required">Password</label>
            <div class="input-group toggle-password-fill">
              <span class="input-group-text"><i class="bi bi-unlock"></i></span>
              <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Ex: password" name="password" id="password" onkeydown="capsLock(event)" required>
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
            <label for="password-confirmation" class="form-label required">Retype password</label>
            <div class="input-group toggle-password-fill">
              <span class="input-group-text"><i class="bi bi-unlock"></i></span>
              <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Ex: password" name="password_confirmation" id="password_confirmation" onkeydown="capsLock(event)" required>
              <button type="button" class="pass-eye" onclick="show(event, password_confirmation)"><i class="bi bi-eye-fill"></i></button>
            </div>
            <small id="capsLockText" class="d-none text-danger">Caps lock is on</small>

             @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          <!-- End Password -->


          <!-- Start accept checkbox -->
          <div class="col-12">
            <div class="form-check">
              <input type="checkbox" name="#" class="form-check-input" id="accept" value="">
              <label class="form-check-label" for="accept">I accept the <a href="#">Terms</a> of use & <a href="#">Privacy policy</a>.</label>
            </div>
          </div>
          <!-- End accept checkbox -->

          <!-- Start login button -->
          <div class="col-12">
            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right"></i> Sign up</button>
          </div>
          <!-- End login button -->
        </div>

      </form>

       @if(Route::has('login'))
            <div class="mt-3 text-center">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>
        @endif

    </div>



    {{-- <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="mx-auto" style="width: 200px; height: 200px;">
                <a href="{{ url('/') }}">
                    <x-application-logo/>
                </a>
            </div>
            <div class="card mx-auto shadow-sm">
                <div class="card-header text-center">
                    <h4>Register</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                   name="name"
                                   placeholder="Enter name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="email" class="form-label required">Email address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                           name="email"
                                           placeholder="Enter email address" value="{{ old('email') }}">
                                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label required">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                           name="phone"
                                           placeholder="Enter phone number" value="{{ old('phone') }}">
                                    <div id="phoneHelp" class="form-text">We'll never share your phone with anyone else.</div>
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="password" class="form-label required">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password"
                                           placeholder="Enter password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password-confirmation" class="form-label required">Confirm Password</label>
                                    <input type="password"
                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                           id="password-confirmation" name="password_confirmation"
                                           placeholder="Retype password">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
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
</x-guest-layout>
