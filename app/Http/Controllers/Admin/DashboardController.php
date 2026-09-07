<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboard,
    ) {}

    public function index(): View
    {
        return view('admin.dashboard', [
            'overview' => $this->dashboard->overview(),
            'jobsByStatus' => $this->dashboard->jobsByStatus(),
            'appsByStatus' => $this->dashboard->applicationsByStatus(),
            'perMonth' => $this->dashboard->jobsPerMonth(),
            'topCompanies' => $this->dashboard->topCompanies(),
            'topJobs' => $this->dashboard->topJobs(),
            'hireRate' => $this->dashboard->hireRate(),
        ]);
    }
}
