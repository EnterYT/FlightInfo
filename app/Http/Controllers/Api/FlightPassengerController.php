<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlightPassenger;
use Illuminate\Http\Request;

class FlightPassengerController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'category' => 'nullable|in:internal,international,all',
            'from' => 'nullable|date_format:Y-m',
            'to' => 'nullable|date_format:Y-m|after_or_equal:from',
        ]);

        $category = $validated['category'] ?? null;
        if ($category === 'all') $category = null;

        $q = FlightPassenger::query();

        if ($category) {
            $q->where('category', $category);
        }

        // Фильтры по периоду (формат 'YYYY-MM')
        if (!empty($validated['from'])) {
            [$fy, $fm] = explode('-', $validated['from']);
            $q->where(function($x) use ($fy, $fm) {
                $x->where('year', '>', (int)$fy)
                    ->orWhere(function($y) use ($fy, $fm){
                        $y->where('year', (int)$fy)->where('month', '>=', (int)$fm);
                    });
            });
        }
        if (!empty($validated['to'])) {
            [$ty, $tm] = explode('-', $validated['to']);
            $q->where(function($x) use ($ty, $tm) {
                $x->where('year', '<', (int)$ty)
                    ->orWhere(function($y) use ($ty, $tm){
                        $y->where('year', (int)$ty)->where('month', '<=', (int)$tm);
                    });
            });
        }

        // Агрегируем на случай, если вдруг когда-то будут несколько записей на месяц
        $data = $q->selectRaw('year, month, category, SUM(passenger_count) as passenger_count')
            ->groupBy('year','month','category')
            ->orderBy('year')->orderBy('month')
            ->get()
            ->map(function($row){
                return [
                    'period' => sprintf('%04d-%02d', $row->year, $row->month),
                    'year' => (int)$row->year,
                    'month' => (int)$row->month,
                    'category' => $row->category,
                    'passenger_count' => (int)$row->passenger_count,
                ];
            });

        return response()->json(['data' => $data]);
    }
}
