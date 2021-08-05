<?php

namespace App\Exports;

use App\Models\Companies;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyExport implements FromView
{
    public function __construct(int $query_id)
    {
        $this->query_id = $query_id;
    }

    public function view(): View
    {
        return view('companies.export', [
            'companies' => Companies::query()->where('query_id', $this->query_id)->get()
        ]);
    }
}
