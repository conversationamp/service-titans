<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Titans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'titan:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     *
     * 
     * @return int
     */

    //excute every minute

    public function getValue($settings, $key)
    {
        $value = null;
        foreach ($settings as $setting) {
            if ($setting->key == $key) {
                $value = $setting->value;
            }
        }
        return $value;
    }

    public function createObject($settings, $key, $value)
    {
        $object = new \stdClass();
        $object->key = $key;
        $object->value = $value;
        $settings[] = $object;
        return $settings;
    }


    public function handle()
    {
       
    }
}
