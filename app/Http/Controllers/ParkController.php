<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suggestion;
use App\Rules\ProfanityCheck; // Oluşturduğumuz kuralı çağırıyoruz

class ParkController extends Controller
{
    /**
     * Form sayfasını gösterir.
     */
    public function index()
    {
        return view('form');
    }

    /**
     * Formdan gelen veriyi işler ve veritabanına kaydeder.
     */
    public function store(Request $request)
    {
        // 1. Doğrulama (Validation)
        $request->validate([
            'name' => [
                'required',             // Zorunlu
                'string',               // Metin
                'max:100',              // Max 100 karakter
                'min:3',                // Min 3 karakter
                new ProfanityCheck()    // <-- Config dosyasındaki listeyi kontrol eder
            ],
        ], [
            'name.required' => 'Lütfen bir park ismi giriniz.',
            'name.min'      => 'Park ismi en az 3 karakter olmalıdır.',
            'name.max'      => 'Park ismi çok uzun.',
        ]);

        // 2. İsmi Formatlama (İlk harfler büyük)
        $formattedName = mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8");

        // 3. Veritabanına Kayıt
        Suggestion::create([
            'name'       => $formattedName,
            'ip_address' => $request->ip(),
        ]);

        // 4. Başarılı Sonuç Dönüşü
        return back()->with('success', 'Öneriniz başarıyla kaydedildi. Teşekkür ederiz!');
    }
}