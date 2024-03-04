<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

use App\Models\Project;
use App\Models\Employee;
use Illuminate\Support\Facades\Http;


class SendFileToOpenAI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employees = Employee::select()
            ->select([
                'id as `Employee ID`',
                'name as `Employee Name`',
                'latest_role as `Role`',
                'summary as `Career Summary`',
                'work_experience as `Work Experience`',
                'extra_curricular as `Extracurricular`',
                'education as `Education`',
                'volunteer_work as `Volunteer Work`',
                // 'raw_data as `Employee Data`'
            ])
            ->get();

        // create file
        Storage::put('result/employees.json', json_encode($employees));

        $projects = Project::select([
                'id as `Project ID`',
                'company_name as `Project Name`',
                'status',
                'url',
                'company_slug as `Project Nickname`',
                'project as `Project`',
                'project_type as `Project Type`',
                'date_started',
                'date_completed',
                'description as `Detailed Description`',
                'short_description as `Short Description`',
                'country as `Country`',
                'location as `City`',
                'industry as `Industry`',
                'sub_industry as `Other Industry`',
                'tech_stack as `Tech Stack`',
                'problem_statement as `Problem Statement`',
                'solution_summary as `Solution Summary`',
                'feedback as `Feedback or Review`',
                'team_info as `Team Information`',
                'blurb as `Blurb or Excerpt`',
                // 'raw_data as `Project Data`'
            ])
            ->get()->toArray();
        // create file
        Storage::put('result/projects.json', json_encode($projects));
    }
}
