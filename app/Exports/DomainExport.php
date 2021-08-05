<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DomainExport implements FromView
{
    public function __construct(int $company_scheduler_id)
    {
        $this->company_scheduler_id = $company_scheduler_id;
    }

    public function view(): View
    {
        return view('domains.export', [
            'domains' => $CompanyEmails = DB::table('companies')
                ->select("companies.name", "companies.domain", "company_emails.*")
                ->join("company_emails", "companies.id", "=", "company_emails.company_id")
                ->where('companies.company_scheduler_id', '=', $this->company_scheduler_id)
                ->get()
        ]);
    }
}
