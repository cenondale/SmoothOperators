<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index(): View
    {
        return view('staff.index', [
            'staff' => User::orderBy('full_name')->orderBy('username')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('staff.create', ['staffMember' => new User()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['password'] = Hash::make($data['password']);
        $data['created_at'] = now();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('staff.index')->with('success', 'Staff member added successfully.');
    }

    public function edit(User $staff): View
    {
        return view('staff.edit', ['staffMember' => $staff]);
    }

    public function update(Request $request, User $staff): RedirectResponse
    {
        $data = $request->validate($this->rules($staff));

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($staff->avatar) {
                Storage::disk('public')->delete($staff->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $staff->update($data);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(User $staff): RedirectResponse
    {
        if ($staff->sales()->exists()) {
            return redirect()->route('staff.index')
                ->with('error', 'This staff member has sales history and cannot be deleted.');
        }

        if ($staff->avatar) {
            Storage::disk('public')->delete($staff->avatar);
        }

        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
    }

    private function rules(?User $staff = null): array
    {
        return [
            'username' => [
                'required', 'string', 'max:50',
                Rule::unique('users', 'username')->ignore($staff?->id),
            ],
            'full_name' => ['required', 'string', 'max:100'],
            'password' => $staff
                ? ['nullable', 'string', 'min:8', 'confirmed']
                : ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
