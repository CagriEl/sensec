<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suggestion;
use App\Rules\ProfanityCheck; 

class ParkController extends Controller
{
    /**
     * Form sayfasını gösterir.
     */
    public function index()
    {
        $totalCount = \App\Models\Suggestion::count();
        return view('form', compact('totalCount'));
    }

    /**
     * Formdan gelen veriyi işler ve veritabanına kaydeder.
     */
    public function store(Request $request)
    {
        // -----------------------------------------------------------
        // 1. ADIM: IP KISITLAMASI (Maksimum 3 Başvuru)
        // -----------------------------------------------------------
        // Bu kodu en başa koyuyoruz ki, limit dolduysa validasyonla uğraşmasın.
        $clientIp = $request->ip();
        
        $existingCount = Suggestion::where('ip_address', $clientIp)->count();

        if ($existingCount >= 3) {
            return back()->withErrors(['limit' => 'Bu cihazdan/IP adresinden en fazla 3 adet isim önerisi gönderebilirsiniz.']);
        }

        // -----------------------------------------------------------
        // 2. ADIM: VALIDASYON (Senin belirlediğin kurallar)
        // -----------------------------------------------------------
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:5', // En az 5 karakter
                'max:100',
                // Kural 1: En az bir sesli harf içermeli
                'regex:/[aeıioöuüAEIİOÖUÜ]/', 
                // Kural 2: Aynı karakter 3 kez yan yana gelemez
                'not_regex:/(.)\1{2,}/',
                // Kural 3: Sadece harf, rakam, boşluk ve temel noktalama
                'regex:/^[a-zA-ZğüşıöçĞÜŞİÖÇ0-9\s\.\-]+$/',
            ]
        ], [
            'name.required'  => 'Lütfen bir isim giriniz.',
            'name.min'       => 'Önerilen isim en az 5 karakter olmalıdır.',
            'name.regex'     => 'Lütfen geçerli ve okunabilir bir isim giriniz (Sadece sessiz harf veya geçersiz karakter olamaz).',
            'name.not_regex' => 'Lütfen ardışık tekrarlayan harfler (örn: aaaa) kullanmayınız.',
        ]);

        // -----------------------------------------------------------
        // 3. ADIM: FORMATLAMA VE KAYIT
        // -----------------------------------------------------------
        
        // İsmi Formatlama (İlk harfler büyük)
        $formattedName = mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8");

        // Veritabanına Kayıt
        Suggestion::create([
            'name'       => $formattedName,
            'ip_address' => $clientIp, // IP adresini kaydediyoruz
        ]);

        // -----------------------------------------------------------
        // 4. ADIM: SONUÇ
        // -----------------------------------------------------------
        return back()->with('success', 'Değerli katkınız için teşekkür ederiz. İsim öneriniz değerlendirilmek üzere sistemimize kaydedilmiştir.');
    }
}