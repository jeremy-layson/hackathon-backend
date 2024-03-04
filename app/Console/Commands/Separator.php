<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class Separator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:separator';

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
        
        $content = [];
        
        for ($i=0; $i < count($projects); $i++) { 
            $content[] = $projects[$i];
            break;
        }
        Storage::put('/result/project', json_encode($content));
        
        $content = [];
        
        for ($i=0; $i < count($employees); $i++) { 
            $content[] = $employees[$i]; 
            break;
        }
        Storage::put('/result/employee', json_encode($content));
    }
}
