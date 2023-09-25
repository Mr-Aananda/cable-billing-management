<x-guest-layout>
    {{-- <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="mx-auto" style="width: 200px; height: 200px;">
                <a href="{{ url('/') }}">
                    <x-application-logo/>
                </a>
            </div>

            <x-alert
                message="Thanks for signing up! Before getting started,
                 could you verify your email address by clicking on the link we just emailed to you?
                  If you didn't receive the email,
                   we will gladly send you another."></x-alert>

            @if (session('status') == 'verification-link-sent')
                <x-alert
                    message="A new verification link has been sent to the email address you provided during registration."
                    type="info" dismissable></x-alert>
            @else
                <x-alert :message="session('status')" type="info"></x-alert>
            @endif

            <div class="card mx-auto shadow-sm">
                <div class="card-header text-center">
                    <h4>Verify Email</h4>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="d-grid">
                            <button class="btn btn-dark">Resend Verification Email</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="mt-5">
                        @csrf
                        <div class="text-center">
                            <button class="btn btn-secondary">Logout</button>
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
        <h4>VERIFY YOUR EMAIL</h4>
      </div>

        <x-alert
            message="Thanks for signing up! Before getting started,
                could you verify your email address by clicking on the link we just emailed to you?
                If you didn't receive the email,
                we will gladly send you another."></x-alert>

        @if (session('status') == 'verification-link-sent')
            <x-alert
                message="A new verification link has been sent to the email address you provided during registration."
                type="info" dismissable></x-alert>
        @else
            <x-alert :message="session('status')" type="info"></x-alert>
        @endif


        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="col-12 mb-5">
                <button class="btn btn-primary w-100" type="submit"><i class="bi bi-send"></i> Resend Verification Email </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <div class="text-center mb-3">
                <button class="btn btn-secondary" type="submit">Logout</button>
            </div>

        </form>

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
