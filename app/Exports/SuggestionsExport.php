<?php

namespace App\Exports;

use App\Models\Suggestion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class SuggestionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // İsimleri gruplayıp, en çok önerilenden en aza doğru sıralar
        return Suggestion::select('name', DB::raw('count(*) as total'))
                 ->groupBy('name')
                 ->orderByDesc('total')
                 ->get();
    }

    public function headings(): array
    {
        return ['Önerilen İsim', 'Oy Sayısı'];
    }
}