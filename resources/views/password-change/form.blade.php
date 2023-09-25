@section('title', 'Change Password')

<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header text-center fs-4">
                    Change Password
                </div>
                <div class="card-body">
                    <form action="{{ route('password.change') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current-password" class="form-label required">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current-password" name="current_password" value="{{ old('current_password') }}"
                                placeholder="Enter current password">
                            @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="new-password" class="form-label required">New Password</label>
                                    <input type="password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        id="new-password" name="new_password" placeholder="Enter new password">
                                    <div class="form-text">Password must be at least 8 characters.</div>

                                    @error('new_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm-new-password" class="form-label required">Confirm New
                                        Password</label>
                                    <input type="password" class="form-control" id="confirm-new-password"
                                        name="new_password_confirmation" placeholder="Retype new password">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
