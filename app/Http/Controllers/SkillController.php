<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkillController extends Controller
{
    public function show()
    {
        $skills = Skill::orderBy('Position')->get();
        return response()->json($skills);;
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            "Id" => "required|unique:skill,Id",
            "Name" => "required|unique:skill,Name",

        ], [
            "Id.required" => "Nhập Id",
            "Id.unique" => "Id đã tồn tại",
            "Name.required" => "Nhập name",
            "Name.unique" => "Name đã tồn tại",
        ]);
        // $maxPosition = DB::table('skill')->max('Position'); //querry builder
        $maxPosition = Skill::max('Position'); //eloquent

        // DB::table('skill')->insert([
        // 'Id' => $request->Id,
        // 'Name' => $request->Name,
        // 'Position' => ($maxPosition + 1)
        // ]);

        Skill::create([
            'Id' => $request->Id,
            'Name' => $request->Name,
            'Position' => ($maxPosition + 1)
        ]);
        return $request;
    }

    public function updatePosition(Request $request)
    {
        Skill::where('Position', $request->skill1Position)
            ->update(['Position' => 0]);

        // Cập nhật vị trí của skill2 thành vị trí của skill1
        Skill::where('Position', $request->skill2Position)
            ->update(['Position' => $request->skill1Position]);

        // Cập nhật vị trí của skill1 thành vị trí của skill2
        Skill::where('Position', 0)
            ->update(['Position' => $request->skill2Position]);

        return $request;
    }
}
