<?php

namespace App\Http\Controllers;

use App\Models\CommissionRate;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommissionRateController extends Controller
{
    public function index()
    {
        $pageTitle = 'Commission Rates';
        $commissionRates = CommissionRate::with('employee')
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->get();
        $employees = Employee::where(['status' => 1, 'deleted_at' => null])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.commission_rate.index', compact('pageTitle', 'commissionRates', 'employees'));
    }

    public function store(Request $request)
    {
        $validators = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        $commissionRate = CommissionRate::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'rate' => $request->rate
        ]);

        if ($commissionRate) {
            return back()->with('message', 'Commission rate added successfully!');
        } else {
            return back()->withErrors($validators);
        }
    }

    public function update(Request $request, CommissionRate $commissionRate)
    {
        $validators = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        $commissionRate->employee_id = $request->employee_id;
        $commissionRate->name = $request->name;
        $commissionRate->rate = $request->rate;

        if ($commissionRate->save()) {
            return back()->with('message', 'Commission rate updated successfully!');
        } else {
            return back()->withErrors($validators);
        }
    }

    public function destroy(CommissionRate $commissionRate)
    {
        if ($commissionRate->delete()) {
            return back()->with('message', 'Commission rate deleted successfully!');
        } else {
            return back()->with('message', 'Error deleting commission rate');
        }
    }

    public function getCommissionRates(Request $request)
    {
        try {
            $employeeId = $request->employee_id;
            if (!$employeeId) {
                return response()->json(['error' => 'Employee ID is required'], 400);
            }
            // Check if the employee exists
            $employee = Employee::find($employeeId);
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $commissionRates = CommissionRate::where('employee_id', $employeeId)
                ->whereNull('deleted_at')
                ->select('id', 'name', 'rate')
                ->get();

            if ($commissionRates->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'No commission rates found for this employee'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $commissionRates
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching commission rates: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while fetching commission rates'
            ], 500);
        }
    }
}
