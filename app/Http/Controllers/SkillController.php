<?php

namespace App\Http\Controllers;

use App\Skill;
use App\Superhero;
use Illuminate\Http\Request;

class SkillController extends Controller
{

	public function index()
	{
		return view('skills.index');
	}

	public function update(Request $request, $id)
	{
		$skill = Skill::where('id', $id)->first();
		$skill->update([
			'name' => $request->name ?? $skill->name,
		]);

		return response()->json([
			'message' => 'skill was updated'
		]);
	}

    public function attach(Request $request)
	{
		$superhero = Superhero::where('id', $request->superhero_id)->first();
		$skill = Skill::firstOrCreate(['name' => $request->skill], ['name' => $request->skill]);
		$superhero->skills()->syncWithoutDetaching($skill);
		return response()->json(['message' => 'skill was added']);
	}

	public function datatablesSkillSuperhero(Request $request)
	{
		$superhero = Superhero::where('id', $request->superhero_id)->first();
		$skills = $superhero->skills;
		$datatables = datatables($skills)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '';
            $btn .= '<a href="#" data-id="'.$row->id.'" class="btn btn-delete btn-sm btn-danger">Delete</a>';
            return $btn;
        })
        ->rawColumns(['action']);
        return $datatables->toJson();
	}

	public function delete($id)
	{
		$skill = Skill::find($id);
		$skill->superheroes()->detach();
		$skill->delete();

		return response()->json([
			'message' => 'skill was deleted'
		]);
	}

	public function datatables(Request $request)
	{
		if($request->key){
			$skills = Skill::where('name', 'like', '%' .$request->key. '%')->get();
		}else{
			$skills = Skill::all();
		}
        $datatables = datatables($skills)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '';
            $btn .= '<a href="'.route('skills.detail', $row->id).'" class="btn mr-2 btn-edit btn-sm btn-primary">View Detail</a>';
            $btn .= '<a href="#" data-id="'.$row->id.'" class="btn btn-delete btn-sm btn-danger">Delete</a>';
            return $btn;
        })
        ->rawColumns(['action']);
        return $datatables->toJson();
	}

	public function detail($id)
	{
		$skill = Skill::findOrFail($id);
		return view('skills.detail', [
			'skill' => $skill
		]);
	}

}
