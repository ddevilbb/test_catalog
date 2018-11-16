<?php

use App\Core\Services\ImportFromJsonService;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run()
    {
        /** @var ImportFromJsonService $importService */
        $importService = App::make(ImportFromJsonService::class);

        $importService->run();
    }
}