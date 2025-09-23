<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class UsersChart extends ApexChartWidget
{
    protected static ?string $chartId = 'userCountChart';
    protected static ?string $heading = 'Total Users';

    protected function getOptions(): array
    {
        $userCount = User::count();

        return [
            'chart' => [
                'type' => 'area',
                'height' => 100,
                'sparkline' => ['enabled' => true],
            ],
            'series' => [
                ['name' => 'Users', 'data' => [20, 30, 40, 50, $userCount]],
            ],
            'stroke' => ['curve' => 'smooth', 'width' => 2],
            'colors' => ['#10B981'], // hijau
            'xaxis' => ['categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Now']],
            'title' => [
                'text' => $userCount . ' Users',
                'align' => 'left',
                'style' => ['fontSize' => '18px', 'color' => '#fff'],
            ],
            'subtitle' => [
                'text' => $userCount . ' total',
                'align' => 'left',
                'style' => ['fontSize' => '12px', 'color' => '#10B981'],
            ],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 4;
    }
}

class InactiveUsersChart extends ApexChartWidget
{
    protected static ?string $chartId = 'inactiveUserChart';
    protected static ?string $heading = 'Inactive Users';

    protected function getOptions(): array
    {
        $inactiveCount = User::where('state', 'Inactive')->count();

        return [
            'chart' => [
                'type' => 'area',
                'height' => 100,
                'sparkline' => ['enabled' => true],
            ],
            'series' => [
                ['name' => 'Inactive', 'data' => [5, 10, 15, 20, $inactiveCount]],
            ],
            'stroke' => ['curve' => 'smooth', 'width' => 2],
            'colors' => ['#EF4444'], // merah
            'xaxis' => ['categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Now']],
            'title' => [
                'text' => $inactiveCount . ' Inactive',
                'align' => 'left',
                'style' => ['fontSize' => '18px', 'color' => '#fff'],
            ],
            'subtitle' => [
                'text' => $inactiveCount . ' total',
                'align' => 'left',
                'style' => ['fontSize' => '12px', 'color' => '#EF4444'],
            ],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 4;
    }
}

class UnverifiedUsersChart extends ApexChartWidget
{
    protected static ?string $chartId = 'unverifiedUserChart';
    protected static ?string $heading = 'Unverified Users';

    protected function getOptions(): array
    {
        $unverifiedCount = User::whereNull('email_verified_at')->count();

        return [
            'chart' => [
                'type' => 'area',
                'height' => 100,
                'sparkline' => ['enabled' => true],
            ],
            'series' => [
                ['name' => 'Unverified', 'data' => [2, 5, 8, 12, $unverifiedCount]],
            ],
            'stroke' => ['curve' => 'smooth', 'width' => 2],
            'colors' => ['#F59E0B'], // kuning
            'xaxis' => ['categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Now']],
            'title' => [
                'text' => $unverifiedCount . ' Unverified',
                'align' => 'left',
                'style' => ['fontSize' => '18px', 'color' => '#fff'],
            ],
            'subtitle' => [
                'text' => $unverifiedCount . ' total',
                'align' => 'left',
                'style' => ['fontSize' => '12px', 'color' => '#F59E0B'],
            ],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 4;
    }
}
