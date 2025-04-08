<?php

namespace App\Http\Controllers\User;

use App\Models\Adminwallet;
use App\Models\Userwithdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class wfee_payments extends Controller
{
    //
    public function wfee_payment($id){
        $fee = Userwithdraw::findOrFail($id);
        $adminWallet = Adminwallet::first(); // Retrieve the first row from the Adminwallet table (adjust this as needed)
        $coinType = $fee->ptype;
        
        // Determine the appropriate wallet address based on the coin type
        $walletAddress = null; // Default value in case of an unknown coin type
        $QRcode = null;

        if ($coinType === 'Bitcoin') {
            $walletAddress = $adminWallet->btc_address;
            $QRcode = $adminWallet->btc_address_qr;
        } elseif ($coinType === 'Ethereum') {
            $walletAddress = $adminWallet->eth_address;
            $QRcode = $adminWallet->eth_address_qr;
        } elseif ($coinType === 'USDT') {
            $walletAddress = $adminWallet->usdt_address;
            $QRcode = $adminWallet->usdt_address_qr;
        }
        return view('Userview.fee_payment', compact('fee', 'QRcode', 'walletAddress'));
    }

    public function wfee_payment_upload(Request $request,$id){
        
        // Validate the uploaded image (you can add more validation rules as needed)
        $validatedData = $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif', // Example validation rules
        ]);

        $fee = Userwithdraw::findOrFail($id);

        // Get the uploaded image file
        $uploadedImage = $request->file('proof_image');

        // Generate a unique filename for the uploaded image
        $filename = time() . '_' . $uploadedImage->getClientOriginalName();

        // // Store the image in a location within the 'public' disk
        // $imagePath = $uploadedImage->store('proof_images', 'public');
        // Store the image in a location within the 'public' disk with a custom filename
        $imagePath = $uploadedImage->storeAs('fee_payment', $filename, 'public');

        // Update the deposit record and set status to 'unconfirmed'
        $fee->proof = $filename;
        $fee->status = 'unconfirmed';
        $fee->save();

        return redirect()
        ->back()
        ->with('success', 'Proof uploaded successfully.')
        ->with('imagePath', $imagePath);
    }
}
