<?php

namespace LaravelExportConstants\Generators;

use LaravelExportConstants\LaravelExportConstants;

class ConstantGenerator extends \Illuminate\Console\Command
{
    private const PATH = './resources/constants.js';

    protected $signature = 'constants:generate';

    protected $description = 'Generate a static JavaScript file.';

    public function __construct(private LaravelExportConstants $exporter)
    {
        parent::__construct();
    }

    public function generate(): void
    {
        $constants = $this->exporter->generate();
        // @todo: export to self::PATH
    }

}
