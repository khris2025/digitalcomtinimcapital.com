<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Signal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class SignalController extends Controller
{
    //



    // Store the signal in the database
    public function store(Request $request)
    {
        $request->validate([
            'signal_name' => 'required|string|max:255',
            'signal_amount' => 'required|numeric|min:0',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        Signal::create([
            'name' => $request->signal_name,
            'amount' => $request->signal_amount,
            'percentage' => $request->percentage,
        ]);

        return redirect()->back()->with('success', 'Signal created successfully');
    }



    public function subscribe($signalId)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Find the signal by ID
        $signal = Signal::findOrFail($signalId);

        // Check if the user has enough balance
        if ($user->walletbalance < $signal->amount) {
            return redirect()->back()->withErrors(['message' => 'You do not have enough funds to subscribe to this signal.']);
        }

        // Deduct the amount from the user's wallet balance
        $user->walletbalance -= $signal->amount;
        $user->signal = $signal->percentage;
        $user->save();

        // Optionally, you can store the subscription in a 'subscriptions' table
        // Subscription::create([
        //     'user_id' => $user->id,
        //     'signal_id' => $signal->id,
        //     'amount' => $signal->amount,
        // ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'You have successfully subscribed to the signal!');
    }

    public function destroy($id)
    {
        $signal = Signal::findOrFail($id); // Find the signal by ID

        // Delete the signal
        $signal->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Signal deleted successfully!');
    }
}
