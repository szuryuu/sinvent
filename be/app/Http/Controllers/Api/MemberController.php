<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(5);
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
        return new MemberResource(true, "Detail member data", $member);
    }
}
