<?php

namespace App\Http\Controllers;

use App\Mail\KontakMail;
use Illuminate\Http\Request;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class KontakController extends Controller
{
    public function index()
    {
        return view('pages.kontak');
    }

    public function sendMail(Request $request)
    {

        try {
            $request->validate([
                'email' => ['required', 'email'],
                'nama' => ['required', 'string'],
                'subjek' => ['required', 'string'],
                'pesan' => ['required', 'string'],
            ]);

            // Kirim langsung (sync) untuk sementara:
            Mail::to($request->email)->send(new KontakMail($request->nama, $request->email, $request->subjek, $request->pesan));

            //TODO:: Antrikan untuk kebutuhan production ya ganteng:
            // Mail::to($request->email)->queue(new KontakMail($request->nama, $request->email, $request->subjek, $request->pesan));

            return back()->with('success', 'Pesan anda berhasil terkirim!');
        } catch (\Throwable $th) {
            return back()->with('success', $th->getMessage());
        }
    }

    public function kirim(Request $request)
    {
        // validasi sederhana
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        // sementara simpan ke log / session (dummy)
        // nanti bisa diganti simpan DB atau kirim email
        // contoh simpan sementara ke session
        return redirect()->route('kontak')
            ->with('success', 'Pesan berhasil dikirim!');
    }
}
