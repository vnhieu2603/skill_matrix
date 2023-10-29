<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\MemSkill;
use App\Models\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemSkillController extends Controller
{
    public function show(Request $request)
    {

        // $levels = Level::select('level.*')->get();
        // $memSkills = DB::select('SELECT
        //                             m.memCode,
        //                             s.Id as skillId,
        //                             ms.levelNumber
        //                         FROM
        //                             member AS m
        //                         CROSS JOIN
        //                             skill AS s
        //                         LEFT JOIN
        //                             memSkill AS ms ON m.memCode = ms.memCode AND s.Id = ms.skillId
        //                         ORDER BY m.memCode, s.Id');

        $memSkills = Member::crossJoin('skill as s')
            ->leftJoin('memSkill as ms', function ($join) {
                $join->on('member.memCode', '=', 'ms.memCode')
                    ->on('s.Id', '=', 'ms.skillId');
            })
            ->select('member.memCode', 's.Id as skillId', 'ms.levelNumber')
            ->orderBy('member.memCode');
        if ($request->sortBy) {
            $sortBy = $request->sortBy;
        } else {
            $sortBy = 's.Position';
        }
        if ($request->sortOrder) {
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = "asc";
        }
        return response()->json($memSkills->orderBy($sortBy, $sortOrder)->get());;
    }

    public function showMemCodesortBylevelNumberOfSkill(Request $request, $skillId)
    {
        $query = Memskill::select('memCode', 'skillId', 'levelNumber')
            ->where(function ($query) use ($skillId) {
                $query->where('skillId', $skillId)
                    ->orWhereNull('skillId');
            });

        $query2 = Member::select('member.memCode', DB::raw('NULL as skillId'), DB::raw('NULL as levelNumber'))
            ->whereNotIn('member.memCode', function ($subquery) use ($skillId) {
                $subquery->select('memCode')
                    ->from('memskill')
                    ->where(function ($query) use ($skillId) {
                        $query->where('skillId', $skillId)
                            ->orWhereNull('skillId');
                    });
            });

        if ($request->sortBy) {
            $memskill = $query->unionAll($query2)
                ->orderByRaw('CASE WHEN levelNumber IS NULL THEN 1 ELSE 0 END, levelNumber desc');
        } else {
            $memskill = $query->unionAll($query2)
                ->orderByRaw('CASE WHEN levelNumber IS NULL THEN 1 ELSE 0 END, levelNumber');
        }
        return response()->json($memskill->get());
    }

    public function store(Request $request)
    {
        $memCodes = $request->codeOfMember;
        $skillIds = $request->idOfSkill;
        $memSkill = Memskill::where('memCode', $memCodes)->where('skillId', $skillIds)->get();

        if (count($memSkill) > 0) {
            MemSkill::where('memCode', $request->codeOfMember)->where('skillId', $request->idOfSkill)
                ->update(['levelNumber' => $request->numberOfLevel, 'timeSkillUp' => $request->timeSkillUp]);
        } else {

            MemSkill::create([
                'memCode' => $request->codeOfMember,
                'skillId' => $request->idOfSkill,
                'levelNumber' => $request->numberOfLevel,
                'timeSkillUp' => $request->timeSkillUp
            ]);
        }
    }
}
