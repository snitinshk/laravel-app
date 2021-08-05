<?php

namespace App\Exports;

use App\Models\Leads;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LeadExport implements FromView
{
    public function __construct(int $query_id)
    {
        $this->query_id = $query_id;
    }

    public function view(): View
    {
        return view('leads.export', [
            'leads' => Leads::query()->where('query_id', $this->query_id)->get()
        ]);
    }
}
