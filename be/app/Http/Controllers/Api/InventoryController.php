<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->get("per_page", 5);
        $search = $request->get("search", "");

        $query = Inventory::query()->with(["product", "member"]);

        if ($query) {
            $query->where(function ($q) use ($search) {
                $q->where("serial_number", "like", "%{$search}%");
            });
        }

        $inventories = $query->latest()->paginate($per_page);
        return new InventoryResource(true, "List Inventories", $inventories);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "product_id" => "required|exists:products,id",
            "member_id" => "required|exists:members,id",
            "serial_number" => "required|integer|min:1",
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

        return new InventoryResource(true, "Inventory added", $inventory);
    }

    public function show($id)
    {
        $inventory = Inventory::find($id);
        return new InventoryResource(true, "Detail inventory", $inventory);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "product_id" => "required|exists:products,id",
            "member_id" => "required|exists:members,id",
            "serial_number" => "required|integer|min:1",
            "status" => "required|in:baik,rusak,tidak dipakai,dilelang",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $inventory = Inventory::find($id);
        $inventory->update([
            "product_id" => $request->product_id,
            "member_id" => $request->member_id,
            "serial_number" => $request->serial_number,
            "status" => $request->status,
        ]);

        return new InventoryResource(true, "Inventory changed", $inventory);
    }

    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();
        return new InventoryResource(true, "Inventory deleted", null);
    }
}
