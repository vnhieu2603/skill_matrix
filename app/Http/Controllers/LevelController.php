<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Memskill;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Type\Integer;
use Symfony\Contracts\Service\Attribute\Required;

class LevelController extends Controller
{
    private $levels;
    public function __construct()
    {
        $this->levels = new Level();
    }

    public function show()
    {

        // $levels = DB::table('level')->get();
        $levels = Level::all();
        return response()->json($levels);;
    }

    public function levelDetail($levelNumber)
    {
        $levels = Level::where('levelNumber', $levelNumber)->first();
        return response()->json($levels);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            "levelNumber" => "required|integer|unique:level,levelNumber",
            "description" => "required",
            "color" => "required|unique:level,color",
        ], [
            "levelNumber.integer" => "Level number là số",
            "levelNumber.required" => "Nhập level number",
            "levelNumber.unique" => "level number đã tồn tại",
            "description.required" => "Nhập description",
            "color.required" => "Chọn color",
            "color.unique" => "Color đã tồn tại"
        ]);

        $data = [
            'levelNumber' => $request->levelNumber,
            'description' => $request->description,
            'color' => $request->color,
        ];
        Level::create($data);
        return $request;
    }

    public function update(Request $request, $id)
    {
        $levels = Level::where('levelNumber', $id)->first();
        $request->validate([
            // Rule::unique('level')->ignore($levels->color, 'color'),
            'levelNumber' => [
                'required',
                "integer",
                Rule::unique('level')->ignore($levels->levelNumber, 'levelNumber'),
            ],
            'description' => [
                'required',
                Rule::unique('level')->ignore($levels->description, 'description'),
            ],
            'color' => [
                'required',
                Rule::unique('level')->ignore($levels->color, 'color'),
            ]

        ], [
            "levelNumber.integer" => "Level number là số",
            "levelNumber.required" => "Nhập level number",
            "levelNumber.unique" => "Level number đã tồn tại",
            "description.required" => "Nhập description",
            "description.unique" => "Description đã tồn tại",
            "color.required" => "Color đã tồn tại",
            "color.unique" => "Color đã tồn tại"
        ]);


        if ($id == $request->levelNumber) {
            $data = [
                'description' => $request->description,
                'color' => $request->color,
            ];
            Level::where('levelNumber', $id)->update($data);
        } else {
            $membersWithThisLevel = Memskill::where('levelNumber', '=', $id)->get();
            //reset memskil with this levelNumber
            $idToReset[] = $id;
            Memskill::where('levelNumber', $id)->update(['levelNumber' => NULL]);
            $data = [
                'levelNumber' => $request->levelNumber,
                'description' => $request->description,
                'color' => $request->color,
            ];
            Level::where('levelNumber', $id)->update($data);
            for ($i = 0; $i < count($membersWithThisLevel); $i++) {
                $memCode = $membersWithThisLevel[$i]->memCode;
                $skillId = (string)$membersWithThisLevel[$i]->skillId;
                $timeSkillUp = $membersWithThisLevel[$i]->timeSkillUp;
                $dataUpdateMemSkill = [
                    'levelNumber' => $request->levelNumber,
                    'timeSkillUp' => $timeSkillUp,
                ];
                Memskill::where('memCode', $memCode)->where('skillId', $skillId)
                    ->update($dataUpdateMemSkill);
            }
        }
    }

    public function delete($id)
    {
        // DB::update('update memskill set levelNumber = NULL where levelNumber =?', $data);
        Memskill::where('levelNumber', $id)->update(['levelNumber' => NULL]);
        Level::where('levelNumber', $id)->delete();
    }
}
