<?php

namespace App\Http\Controllers;

use App\Exports\MarriedExport;
use App\Superhero;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class MarriedController extends Controller
{
    public function index()
	{
		$males = Superhero::where('gender', 'Laki-Laki')->get();
		$females = Superhero::where('gender', 'Perempuan')->get();
		return view('married.index', [
			'males' => $males,
			'females' => $females
		]);
	}

	public function searchSkills(Request $request)
	{
		$husband_id = $request->husband_id;
		$wife_id = $request->wife_id;
		$superheroes = Superhero::whereIn('id', [$husband_id, $wife_id])->get();
		$results = [];
		foreach ($superheroes as $superhero) {
			$skills = $superhero->skills()->get()->pluck('name')->toArray();
			foreach ($skills as $skill) {
				if(!in_array($skill, $results)){
					array_push($results, $skill);
				}
			}
		}

		return $results;
	}

	public function pdf(Request $request)
	{
		$datas = $this->searchSkills($request);
		$husband = Superhero::where('id', $request->husband_id)->pluck('name')->first();
		$wife = Superhero::where('id', $request->wife_id)->pluck('name')->first();
		$pdf = PDF::loadView('married.pdf', [
			'datas' => $datas,
			'husband' => $husband,
			'wife' => $wife,
		]);
		return $pdf->download('married.pdf');
	}

	public function excell(Request $request)
	{
		$datas = $this->searchSkills($request);
		$husband = Superhero::where('id', $request->husband_id)->pluck('name')->first();
		$wife = Superhero::where('id', $request->wife_id)->pluck('name')->first();
		return Excel::download(new MarriedExport($datas, $husband, $wife), 'married.xlsx');
	}
}
