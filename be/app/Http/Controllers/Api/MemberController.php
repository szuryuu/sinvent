<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(5);
        return new MemberResource(true, "List Member", $members);
    }
}
