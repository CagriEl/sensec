<?php

namespace App\Filament\Resources\SuggestionResource\Widgets;

use App\Models\Suggestion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // En çok önerilen ismi buluyoruz
        $topSuggestion = Suggestion::select('name', DB::raw('count(*) as total'))
            ->groupBy('name')
            ->orderByDesc('total')
            ->first();

        // Toplam başvuru sayısı
        $totalCount = Suggestion::count();

        return [
            Stat::make('Toplam Başvuru', $totalCount)
                ->description('Sisteme girilen tüm öneriler')
                ->color('success'),

            Stat::make('En Çok İstenen İsim', $topSuggestion ? $topSuggestion->name : '-')
                ->description($topSuggestion ? $topSuggestion->total . ' adet oy aldı' : 'Veri yok')
                ->color('primary'),
        ];
    }
}