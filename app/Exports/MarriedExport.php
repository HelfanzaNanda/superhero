<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class MarriedExport implements FromView
{
	private $results, $husband, $wife;

	public function __construct(array $results, string $husband, string $wife) 
    {
        $this->results = $results;
        $this->husband = $husband;
        $this->wife = $wife;
    }

	public function view(): View
    {
        return view('married.excell', [
			'datas' => $this->results,
			'husband' => $this->husband,
			'wife' => $this->wife,
		]);
    }
}
