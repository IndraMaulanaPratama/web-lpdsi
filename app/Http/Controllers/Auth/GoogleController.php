<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{

    // fungsi kanggo nangtoskeun nami driver nu bade di anggo ku plugin socialite
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    // Proses Login
    public function handleGoogleCallback()
    {
        try {
            // Inisialisasi plugin
            $googleUser = Socialite::driver('google')->user();

            // Milari user dumasar kana email nu di anggo ku semah
            $user = User::where('email', $googleUser->getEmail())->first();


            /**
             * Kondisi kanggo nangtoskeun berhasil atau gagalna login
             * -> Upami proses berhasil: update data user teras redirect ka dashboard
             * -> Upami gagal: Kumpulkeun data kesalahan teras redirect ka halaman login
             */

            // Update Google ID jika user sudah ada
            if ($user) {

                $role = $user->roles->first();
                $menus = $role->menus;


                // Update id google dan avatar
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

                // Simpen data pengguna nu login
                Auth::login($user);
                session()->put('menus', $menus);
                session()->put('role', $role);
                session()->put('divisi', $user->divisi->description);
            } else {
                session()->flash('warning', 'Data pengguna tidak ditemukan');
                return redirect()->route('login');
            }

            // Arahkeun user ka halaman dashboard
            return redirect()->intended('/admin/dashboard');

            /** Tungtung tinu kondisi */

        } catch (\Exception $e) {
            session()->flash('warning', 'Data pengguna tidak ditemukan');
            return redirect()->route('login')->withErrors('Login dengan Google gagal: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
