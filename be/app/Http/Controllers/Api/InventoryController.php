<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::latest()->paginate(5);
        return new InventoryResource(true, "List Inventories", $inventories);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "product_id" => "required|exists:products,id",
            "member_id" => "required|exists:members,id",
            "serial_number" => "required|integer",
            "status" => "required|in:baik,rusak,tidak dipakai,dilelang",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $inventory = Inventory::create([
            "product_id" => $request->product_id,
            "member_id" => $request->member_id,
            "serial_number" => $request->serial_number,
            "status" => $request->status,
        ]);

        return new InventoryResource(true, "Added to inventory", $inventory);
    }
}
