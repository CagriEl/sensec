<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProfanityCheck implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Config dosyasından listeyi çekiyoruz.
        // Eğer config dosyası okunamazsa boş dizi döner.
        $badWords = config('badwords.list');

        // HATA AYIKLAMA (DEBUG): 
        // Eğer liste boş geliyorsa ekrana hata basıp durur. 
        // Test ettikten sonra aşağıdaki 3 satırı silebilirsiniz.
        if (empty($badWords)) {
            dd('HATA: Yasaklı kelime listesi yüklenemedi! Lütfen "php artisan config:clear" komutunu çalıştırın.');
        }

        // 2. Girilen metni küçült (Türkçe karakter destekli)
        $text = mb_strtolower($value, 'UTF-8');

        foreach ($badWords as $word) {
            // Yasaklı kelimeyi de küçült
            $badWord = mb_strtolower($word, 'UTF-8');

            // Eğer kelime çok kısaysa (3 harf veya daha az, örn: "am", "oç")
            // Sadece TAM KELİME olarak geçiyorsa engelle.
            if (mb_strlen($badWord, 'UTF-8') <= 3) {
                // Regex: Kelime sınırları (\b) içinde tam eşleşme
                if (preg_match('/\b' . preg_quote($badWord, '/') . '\b/u', $text)) {
                    $fail('Girdiğiniz isim genel ahlaka uygun olmayan ifadeler içeriyor.');
                    return;
                }
            } 
            // Uzun kelimeler için (örn: "şerefsiz") içinde geçmesi yeterli
            else {
                if (str_contains($text, $badWord)) {
                    $fail('Girdiğiniz isim genel ahlaka uygun olmayan ifadeler içeriyor.');
                    return;
                }
            }
        }
    }
}