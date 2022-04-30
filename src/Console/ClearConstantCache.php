<?php

namespace LaravelExportConstants\Console;

use Illuminate\Console\Command;
use LaravelExportConstants\LaravelExportConstants;

class ClearConstantCache extends Command
{
    protected $signature = 'constants:clear';

    protected $description = 'Clear the cached class constants.';

    public function __construct(private LaravelExportConstants $exporter)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->exporter->clearCache();

        $this->info('Cleared the class constants.');
    }

}
