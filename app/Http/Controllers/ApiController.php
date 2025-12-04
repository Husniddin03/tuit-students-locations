<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function status() 
    {
        $students = Student::with(['dormitory', 'rent'])->paginate(10);
        return response()->json([
            'students' => $students
        ]);
    }

    // Dashboard Card 06 uchun - Donut Chart
    public function dashboardCard06() 
    {
        try {
            // Yotoqxonada yashovchilar
            $dormitoryCount = Student::whereNotNull('dormitory_id')->count();
            
            // Rentda yashovchilar  
            $rentCount = Student::whereNotNull('rent_id')->count();

            return response()->json([
                'labels' => ['Yotoqxonada', 'Rentda'],
                'data' => [$dormitoryCount, $rentCount],
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'labels' => ['Yotoqxonada', 'Rentda'],
                'data' => [0, 0],
            ], 500);
        }
    }

    // Dashboard Card 04 uchun - Bar Chart
    public function dashboardCard04() 
    {
        try {
            // Oxirgi 6 oylik statistika
            $months = [];
            $dormitoryData = [];
            $rentData = [];

            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $months[] = $date->format('m-d-Y');
                
                // Har oyda yotoqxonaga kirganlar
                $dormitoryData[] = Student::whereNotNull('dormitory_id')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
                
                // Har oyda rentga kirganlar
                $rentData[] = Student::whereNotNull('rent_id')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            }

            // Bar chart uchun data formati
            $combinedData = array_merge($dormitoryData, $rentData);

            return response()->json([
                'labels' => $months,
                'data' => $combinedData,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'labels' => [],
                'data' => [],
            ], 500);
        }
    }
}