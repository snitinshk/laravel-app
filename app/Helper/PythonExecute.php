<?php
namespace App\Helper;

class PythonExecute
{
    public function pythonExecute($urlString, $searchName, $linkedInLogin, $linkedInPassword)
    {
        // should run main script
        $process = new Process(['python3', 'app/Scraper/SalesScraper.py', $urlString, $linkedInLogin, $linkedInPassword ]);
        $process->run();

// executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $data = $process->getOutput();


    }
}
