<?php

namespace App\Filament\Resources\SuggestionResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Suggestion;
use Illuminate\Support\Facades\DB;

class TopSuggestionsChart extends ChartWidget
{
    protected static ?string $heading = 'En Çok Önerilen 5 İsim';
    protected static ?int $sort = 2; 

    protected function getData(): array
    {
        $data = Suggestion::select('name', DB::raw('count(*) as total'))
            ->groupBy('name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Oy Sayısı',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => '#3b82f6', // Mavi renk
                    'borderColor' => '#1d4ed8',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // <-- Burası 'bar' olduğu sürece grafik çubuk olur.
    }
}