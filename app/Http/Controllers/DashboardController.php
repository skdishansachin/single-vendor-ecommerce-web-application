<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        // Get time period from query string, default to 'week'
        $period = $request->query('period', 'week');

        // Define date ranges based on the selected period
        $dateRanges = [
            'today' => [now()->startOfDay(), now()->endOfDay()],
            'week' => [now()->startOfWeek(), now()->endOfWeek()],
            'month' => [now()->startOfMonth(), now()->endOfMonth()],
            'year' => [now()->startOfYear(), now()->endOfYear()],
        ];

        // Get the start and end dates for the selected period
        $dates = $dateRanges[$period] ?? $dateRanges['week'];
        [$startDate, $endDate] = $dates;

        // Count completed and paid orders for the selected period
        $thisPeriodOrdersCount = Order::query()
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Calculate count for the previous period
        $previousPeriodDates = $this->getPreviousPeriodDates($period, $startDate, $endDate);
        [$startPreviousPeriod, $endPreviousPeriod] = $previousPeriodDates;

        $previousPeriodOrdersCount = Order::query()
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startPreviousPeriod, $endPreviousPeriod])
            ->count();

        // Calculate the percentage change in order count
        $thisPeriodOrdersPercentage = $previousPeriodOrdersCount > 0
            ? (($thisPeriodOrdersCount - $previousPeriodOrdersCount) / $previousPeriodOrdersCount) * 100
            : ($thisPeriodOrdersCount > 0 ? 100 : 0);

        // Determine the trend in order count
        $orderTrend = $thisPeriodOrdersCount > $previousPeriodOrdersCount ? 'increased' : 'decreased';

        // Calculate total income for the selected period
        $thisPeriodTotalIncome = Cart::query()
            ->whereHas('order', function (Builder $query) {
                $query
                    ->where('payment_status', 'paid')
                    ->where('status', 'completed');
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');

        // Calculate total income for the previous period
        $previousPeriodTotalIncome = Cart::query()
            ->whereHas('order', function (Builder $query) {
                $query
                    ->where('payment_status', 'paid')
                    ->where('status', 'completed');
            })
            ->whereBetween('created_at', [$startPreviousPeriod, $endPreviousPeriod])
            ->sum('total');

        // Calculate the percentage change in income
        $incomePercentageChange = $previousPeriodTotalIncome > 0
            ? (($thisPeriodTotalIncome - $previousPeriodTotalIncome) / $previousPeriodTotalIncome) * 100
            : ($thisPeriodTotalIncome > 0 ? 100 : 0);

        // Ensure income percentage change is non-negative
        $incomePercentageChange = max($incomePercentageChange, 0);

        // Determine the trend in income
        $incomeTrend = $thisPeriodTotalIncome > $previousPeriodTotalIncome ? 'increased' : 'decreased';

        // Count users for the selected period and the previous period
        $thisPeriodUsers = User::query()
            ->whereHas('roles', function (Builder $query) {
                $query->where('name', 'customer');
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $previousPeriodUsers = User::query()
            ->whereHas('roles', function (Builder $query) {
                $query->where('name', 'customer');
            })
            ->whereBetween('created_at', [$startPreviousPeriod, $endPreviousPeriod])
            ->count();

        // Calculate the percentage change in user count
        $thisPeriodUserPercentage = $previousPeriodUsers > 0
            ? (($thisPeriodUsers - $previousPeriodUsers) / $previousPeriodUsers) * 100
            : ($thisPeriodUsers > 0 ? 100 : 0);

        // Determine the trend in user count
        $userTrend = $thisPeriodUsers > $previousPeriodUsers ? 'increased' : 'decreased';

        // Pass data to the view
        return view('dashboard.index', [
            'thisPeriodOrdersCount' => $thisPeriodOrdersCount,
            'previousPeriodOrdersCount' => $previousPeriodOrdersCount,
            'thisPeriodOrdersPercentage' => $thisPeriodOrdersPercentage,
            'orderTrend' => $orderTrend,
            'thisPeriodTotalIncome' => $thisPeriodTotalIncome,
            'previousPeriodTotalIncome' => $previousPeriodTotalIncome,
            'incomePercentageChange' => $incomePercentageChange,
            'incomeTrend' => $incomeTrend,
            'thisPeriodUsers' => $thisPeriodUsers,
            'previousPeriodUsers' => $previousPeriodUsers,
            'thisPeriodUserPercentage' => $thisPeriodUserPercentage,
            'userTrend' => $userTrend,
            'selectedPeriod' => $period, // Pass the selected period to the view
        ]);
    }

    /**
     * Get the start and end dates for the previous period.
     */
    private function getPreviousPeriodDates(string $currentPeriod, Carbon $startDate, Carbon $endDate): array
    {
        switch ($currentPeriod) {
            case 'today':
                return [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()];
            case 'week':
                return [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()];
            case 'month':
                return [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()];
            case 'year':
                return [now()->subYear()->startOfYear(), now()->subYear()->endOfYear()];
            default:
                return [now()->startOfWeek(), now()->endOfWeek()]; // Default to 'week'
        }
    }
}
