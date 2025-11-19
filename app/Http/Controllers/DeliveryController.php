<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DeliveryController extends Controller
{
    public function showDeliveryList()
    {
        $deliverys = Delivery::all();

        return view('admin.deliveryList', compact('deliverys'));
    }

    public function editDelivery(Request $request)
    {
        $delivery = Delivery::find($request->delivery_id);

        return view('admin.editDelivery', compact('delivery'));
    }

    public function editDeliveryPost(Request $request, $delivery_id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $delivery = Delivery::find($delivery_id);
        $delivery->status = $request->status;
        $delivery->save();
        return redirect()->route('admin.editDelivery',['delivery_id' => $delivery->delivery_id])->with('success', 'Delivery updated successfully.');    
    }

    public function destroy(string $delivery)
    {
        $deleteDelivery = Delivery::findOrFail($delivery);
        $deleteDelivery->delete();

        return redirect()->back()->with('success', 'Delivery Removed successfully');
    }

}
