<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Employee;
use Storage;

class ParseJSON extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-json';

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
        $data = json_decode(Storage::get('data.json'), TRUE);
        $projects = $data['Projects'];
        $employees = $data['Employees'];

        foreach ($projects as $key => $project) {
            Project::create([
                'company_name'  => $project['Company Name'],
                'status'        => $project['Status'],
                'url'           => $project['URL / App Store'],
                'company_slug'  => $project['Company Nick'],
                'project'       => $project['Project '],
                'project_type'  => $project['Project Type'],
                'key_notes'     => $project['Key Notes'],
                'description'   => $project['Detailed Description'],
                'short_description' => $project['Short Description'],
                'date_started'      => $project['Date Started'],
                'date_completed'    => $project['Completed Date'],
                'country'           => $project['Country'],
                'location'          => $project['Location Detail'],
                'industry'          => $project['Industry'],
                'sub_industry'      => $project['Industry - Other'],
                'tech_stack'        => (explode(",", $project['Stack'])),
                'problem_statement' => $project['Problem Statement'],
                'solution_summary'  => $project['Solution Summary'],
                'feedback'          => $project['Feedback / Review'],
                'team_info'         => $project['Team Info'],
                'blurb'             => $project['Blurb / Examples'],
                'raw_data'          => ($project),
            ]);
        }

        foreach ($employees as $key => $employee) {
            try {
                Employee::create([
                    'name'              => $employee['name'] ?? $employee['personal_information']['name'],
                    'email'             => $employee['email'] ?? $employee['personal_information']['email'],
                    'latest_role'       => $this->getLatestRole($employee['work_experience']),
                    'summary'           => $employee['summary'] ?? $employee['executive_summary'],
                    'work_experience'   => ($this->formatWorkExperience($employee['work_experience'])),
                    'extra_curricular'  => ($employee['extracurricular'] ?? []),
                    'education'         => ($employee['education'] ?? []),
                    'volunteer_work'    => ($employee['volunteer_work'] ?? []),
                    'raw_data'          => ($employee),
                ]);
            } catch (\Throwable $th) {
                \Log::info($employee);
                \Log::error($th->getMessage());
            }
        }
    }

    protected function formatWorkExperience($experiences)
    {
        for ($i=0; $i < count($experiences); $i++) { 
            $experience = $experiences[$i];
            if (isset($experience['stack']) === FALSE  && isset($experience['technologies']) === FALSE && isset($experience['tools']) === FALSE ) continue;
            $stackList = $experience['stack'] ?? $experience['technologies'] ?? $experience['tools'];

            
            $stacks = [];
            if (is_array($stackList) === FALSE) {
                $stackList = explode(",", $stackList);
            }

            foreach ($stackList as $key => $stack) {
                $stacks[] = [
                    'tech_stack'    => trim($stack),
                    'usage'         => 'Development',
                ];
            }

            $experiences[$i]['stack'] = $stacks;

            // tangina kaseng resume ko di sumunod sa format
            if (isset($experiences[$i]['technologies'])) {
                unset($experiences[$i]['technologies']);
            }
            if (isset($experiences[$i]['tools'])) {
                unset($experiences[$i]['tools']);
            }
        }

        return $experiences;
    }

    protected function getLatestRole($experiences)
    {
        return $experiences[0]['position'] ?? $experiences[0]['role'];
    }
}
