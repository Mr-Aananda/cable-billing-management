<x-guest-layout>
    {{-- <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="mx-auto" style="width: 200px; height: 200px;">
                <a href="{{ url('/') }}">
                    <x-application-logo/>
                </a>
            </div>

            <x-alert message="This is a secure area of the application.
             Please confirm your password before continuing."
                     type="info"></x-alert>

            <div class="card mx-auto shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label required">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Enter password" required>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Confirm</button>
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

     <x-alert message="This is a secure area of the application.
             Please confirm your password before continuing."
                     type="info"></x-alert>

            <div class="card mx-auto">
                <div class="card-body">
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label required">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Enter password" required>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>

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
