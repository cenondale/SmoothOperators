<div>
    <x-input-label for="full_name" value="Full name" />
    <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $customer->full_name)" required maxlength="100" />
    <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
</div>

<div>
    <x-input-label for="email" value="Email" />
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $customer->email)" required maxlength="100" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<div>
    <x-input-label for="phone" value="Phone (optional)" />
    <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $customer->phone)" maxlength="20" />
    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
</div>
