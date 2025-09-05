<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberRegisterController extends Controller
{
    public function showRegistrationForm()
    {

        return Inertia::render('Member/Auth/Register');
    }

    public function register(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:members',
            'password'          => 'required|string|min:8|confirmed',
            'phone'             => 'nullable|string|max:15',
            'address'           => 'nullable|string|max:500',
            'date_of_birth'     => 'nullable|date',
            'emergency_contact' => 'nullable|string|max:255',
            'membership_date'   => 'nullable|date',
            'id_proof'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Start DB transaction
        DB::beginTransaction();

        try {
            // Handle file upload
            $idProofPath = null;
            if ($request->hasFile('id_proof')) {
                $idProofPath = $request->file('id_proof')->store('id_proofs', 'public');
            }

            // Create member
            $member = Member::create([
                'name'              => $validated['name'],
                'email'             => $validated['email'],
                'password'          => Hash::make($validated['password']),
                'phone'             => $validated['phone'] ?? null,
                'address'           => $validated['address'] ?? null,
                'date_of_birth'     => $validated['date_of_birth'] ?? null,
                'emergency_contact' => $validated['emergency_contact'] ?? null,
                'membership_fee'    => 200.00,
                'membership_date'   => $validated['membership_date'] ?? now(),
                'id_proof'          => $idProofPath,
                'status'            => 'pending',
                'remember_token'    => Str::random(10),
            ]);

            // Commit transaction
            DB::commit();

            // Optionally log the member in
            Auth::guard('member')->login($member);

            return redirect()->route('member.login')
                ->with('success', 'Registration successful! Please wait for admin approval.');
        } catch (\Exception $e) {
            // Rollback if anything fails
            DB::rollBack();

            // Show exact error
            dd('Error inserting member:', $e->getMessage());
        }
    }
}
