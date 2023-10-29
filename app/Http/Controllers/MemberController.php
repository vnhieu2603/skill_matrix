<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function show()
    {

        // $members = DB::table('member')->get();
        $members =  Member::all();
        return response()->json($members);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            "MemCode" => "required|unique:member,MemCode",
            "Name" => "required",

        ], [
            "MemCode.required" => "Nhập code",
            "MemCode.unique" => "Member code đã tồn tại",
            "Name.required" => "Nhập name",
        ]);

        $data = [
            'MemCode' => $request->MemCode,
            'Name' => $request->Name,

        ];
        Member::create($data);
        return $request;
    }
}
