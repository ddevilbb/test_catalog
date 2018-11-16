<?php

namespace App\Core\Console\Commands;

use App\Core\Services\ImportFromJsonService;
use Illuminate\Console\Command;

class ImportCron extends Command
{
    /**
     * @var string
     */
    protected $signature = 'import:cron';

    /**
     * @var string
     */
    protected $description = 'Catalog import from https://markethot.ru';

    /**
     * @var ImportFromJsonService
     */
    protected $service;

    /**
     * ExportCron constructor.
     *
     * @param ImportFromJsonService $service
     */
    public function __construct(ImportFromJsonService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    public function handle()
    {
        $this->service->run();
    }
}