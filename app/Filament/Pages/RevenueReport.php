<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class RevenueReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.pages.revenue-report';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_report_revenue');
    }

    public function getTitle(): string
    {
        return 'Revenue Report';
    }
}
