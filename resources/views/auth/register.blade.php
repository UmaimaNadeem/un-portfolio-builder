<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="block mt-1 w-full">
                <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Country -->
        <div class="mt-4">
            <x-input-label for="country" :value="__('Country')" />
            <select id="country" name="country" class="block mt-1 w-full" onchange="updateMobilePrefix()">
                @foreach ($countries as $code => $country)
                    <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>{{ $country['name'] }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
        </div>

        <!-- Mobile Number -->
        <div class="mt-4">
            <x-input-label for="mobile_no" :value="__('Mobile Number')" />
            <div class="flex">
                <span id="mobile_prefix" class="mt-1 mr-2 w-16 text-gray-600">+1</span>
                <x-text-input id="mobile_no" class="block mt-1 w-full" type="text" name="mobile_no" :value="old('mobile_no')" />
            </div>
            <x-input-error :messages="$errors->get('mobile_no')" class="mt-2" />
        </div>

          <!-- Password -->
          <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Status -->
        <div class="mt-4">
            <x-input-label for="status" :value="__('Status')" />
            <input id="status" type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} />
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        const countries = @json($countries);
        function updateMobilePrefix() {
            const countryCode = document.getElementById('country').value;
            const prefix = countries[countryCode].prefix;
            document.getElementById('mobile_prefix').textContent = prefix;
        }

        document.addEventListener('DOMContentLoaded', updateMobilePrefix);
    </script>
</x-guest-layout>
