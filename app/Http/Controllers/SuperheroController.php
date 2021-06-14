<?php

namespace App\Http\Controllers;

use App\Skill;
use App\Superhero;
use Illuminate\Http\Request;

class SuperheroController extends Controller
{
    public function index()
	{;
		return view('superheroes.index');
	}

	public function update(Request $request, $id)
	{
		$superhero = Superhero::where('id', $id)->first();
		$superhero->update([
			'name' => $request->name ?? $superhero->name,
			'gender' => $request->gender ?? $superhero->gender,
		]);

		return response()->json([
			'message' => 'superhero was updated'
		]);
	}

	public function datatables(Request $request)
	{
		if($request->key){
			$superheroes = Superhero::where('name', 'like', '%' .$request->key. '%')->get();
		}else{
			$superheroes = Superhero::all();
		}
        $datatables = datatables($superheroes)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '';
            $btn .= '<a href="'.route('superheroes.detail', $row->id).'" class="btn mr-2 btn-edit btn-sm btn-primary">View Detail</a>';
            $btn .= '<a href="#" data-id="'.$row->id.'" class="btn btn-delete btn-sm btn-danger">Delete</a>';
            return $btn;
        })
        ->rawColumns(['action']);
        return $datatables->toJson();
	}

	public function detail($id)
	{
		$superhero = Superhero::findOrFail($id);
		return view('superheroes.detail', [
			'superhero' => $superhero
		]);
	}

	public function delete($id)
	{
		$superhero = Superhero::find($id);
		$superhero->skills()->detach();
		$superhero->delete();

		return response()->json([
			'message' => 'superhero was deleted'
		]);
	}

	public function attach(Request $request)
	{
		$skill = Skill::where('id', $request->skill_id)->first();
		$superhero = Superhero::firstOrCreate(['name' => $request->name], ['name' => $request->name, 'gender' => $request->gender]);
		$skill->superheroes()->syncWithoutDetaching($superhero);
		return response()->json(['message' => 'superhero was added']);
	}

	public function datatablesSuperheroSkill(Request $request)
	{
		$skill = Skill::where('id', $request->skill_id)->first();
		$superheroes = $skill->superheroes;
		$datatables = datatables($superheroes)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '';
            $btn .= '<a href="#" data-id="'.$row->id.'" class="btn btn-delete btn-sm btn-danger">Delete</a>';
            return $btn;
        })
        ->rawColumns(['action']);
        return $datatables->toJson();
	}
}
