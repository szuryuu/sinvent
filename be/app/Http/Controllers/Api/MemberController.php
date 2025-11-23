<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function all()
    {
        $members = Member::all();
        return new MemberResource(true, "All Members", $members);
    }

    public function index(Request $request)
    {
        $per_page = $request->get("per_page", 5);
        $search = $request->get("search", "");

        $query = Member::query();

        if ($query) {
            $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%{$search}%");
            });
        }

        $members = $query->latest()->paginate($per_page);
        return new MemberResource(true, "List Member", $members);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "position" => "required",
            "department" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $member = Member::create([
            "name" => $request->name,
            "position" => $request->position,
            "department" => $request->department,
        ]);

        return new MemberResource(true, "Member added", $member);
    }

    public function show($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Member not found",
                ],
                404,
            );
        }

        return new MemberResource(true, "Detail member", $member);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "position" => "required",
            "department" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $member = Member::find($id);

        if (!$member) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Member not found",
                ],
                404,
            );
        }

        $member->update([
            "name" => $request->name,
            "position" => $request->position,
            "department" => $request->department,
        ]);

        return new MemberResource(true, "Member changed", $member);
    }

    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Member not found",
                ],
                404,
            );
        }

        $member->delete();
        return new MemberResource(true, "Member deleted", null);
    }
}
