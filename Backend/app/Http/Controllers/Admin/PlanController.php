<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use App\Models\investmentplan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    // // Display all plans
    // public function index()
    // {
    //     $plans = Plan::orderBy('created_at', 'desc')->get(); // Get all plans ordered by the latest
    //     return view('Adminview.plans.index', compact('plans'));
    // }

    // Show the form for creating a new plan
    // public function create()
    // {
    //     return view('Adminview.plans.create');
    // }

    // Store a newly created plan in the database
    public function store(Request $request)
    {
        $request->validate([
            'plan_name' => 'required|string|max:255',
            'plan_amount_min' => 'required|numeric',
            'plan_amount_max' => 'required|numeric',
            'plan_duration' => 'required|integer',
            'plan_roi' => 'required|numeric',
        ]);

        Plan::create([
            'name' => $request->plan_name,
            'min_amount' => $request->plan_amount_min,
            'max_amount' => $request->plan_amount_max,
            'duration' => $request->plan_duration,
            'roi' => $request->plan_roi,
        ]);

        return redirect()->back()->with('admin.plans.index')->with('success', 'Plan created successfully!');
    }

    // Delete a plan
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()->back()->with('success', 'Plan deleted successfully!');
    }

    public function subscribe(Request $request, $id)

    {
        $plan = Plan::findOrFail($id);
        $user = auth()->user();

        // Validate the request
        $request->validate([
            'amount' => "required|numeric|min:{$plan->min_amount}|max:{$plan->max_amount}",
        ]);

        $investmentAmount = $request->amount;
        $profit = $plan->roi * $investmentAmount;

        // Check if user has sufficient balance
        $minAmount = $plan->min_amount;

        if ($user->walletbalance < $minAmount) {
            return redirect()->back()->withErrors(['message' => 'Insufficient wallet balance!']);
        }

        // Deduct the minimum amount from wallet balance
        $user->walletbalance -= $minAmount;
        $user->save();

        // Create a new subscription
        $startDate = Carbon::now();
        investmentplan::create([
            'fullname' => $user->fullname,
            'email' => $user->email,
            'amount' => $investmentAmount,
            'profit' => $profit,
            'plan' => $plan->name,
            'transid' => Str::uuid()->toString(),
            'Withdrawaldate' => Carbon::now()->addDays($plan->duration), // Set withdrawal date
            'dateadd' => $startDate,
        ]);

        return redirect()->back()->with('success', 'You have successfully subscribed to the plan!');
    }
}
