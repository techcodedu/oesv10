<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckFileExists extends Command
{
    protected $signature = 'check:file-exists';
    protected $description = 'Check if a file exists in storage';

    public function handle()
    {
        $fileExists = Storage::disk('public')->exists('enrollment/53/Test3.pdf');

        if ($fileExists) {
            $this->info('File exists');
        } else {
            $this->error('File does not exist');
        }
    }
}
