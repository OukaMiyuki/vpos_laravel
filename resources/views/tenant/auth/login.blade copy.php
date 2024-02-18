<x-tenant-layout>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary">
                        <h4 class="text-white">Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('tenant.login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" />
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" />
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="remember_me">
                                    <input type="checkbox" name="remember" id="remember_me" />
                                    Remember Me
                                </label>
                            </div>
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                                <div class="mt-3">
                                    <a href="{{ route('tenant.register') }}">Don't have account? register now</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-tenant-layout>