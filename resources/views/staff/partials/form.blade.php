<div>
    <x-input-label for="username" value="Username" />
    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $staffMember->username)" required maxlength="50" />
    <x-input-error :messages="$errors->get('username')" class="mt-2" />
</div>

<div>
    <x-input-label for="full_name" value="Full name" />
    <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $staffMember->full_name)" required maxlength="100" />
    <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
</div>

<div>
    <x-input-label for="password" :value="$staffMember->exists ? 'New password (optional)' : 'Password'" />
    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :required="! $staffMember->exists" minlength="8" />
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<div>
    <x-input-label for="password_confirmation" value="Confirm password" />
    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" :required="! $staffMember->exists" minlength="8" />
    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>

<div>
    <x-input-label for="avatar" value="Avatar (optional)" />
    <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp" class="mt-1 block w-full" />
    <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
</div>
