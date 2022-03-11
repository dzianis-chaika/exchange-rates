<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Repositories\CbrRepositoryInterface;
use Illuminate\Console\Command;
use Throwable;

class SeedCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed last 30 days exchange rates from cbr.ru service.';

    /**
     * Execute the console command.
     *
     * @param  \App\Repositories\CbrRepositoryInterface $cbrRepository
     * @return int
     */
    public function handle(CbrRepositoryInterface $cbrRepository)
    {
        try {
            $dailyRates = $cbrRepository->getDailyRates();
        } catch (Throwable $e) {
            $this->error($e->getMessage());
        }

        foreach ($dailyRates as $dailyRate) {
            $this->line(
                "Seeding last 30 days exchange rates for currency {$dailyRate['charCode']}..."
            );

            sleep(1);

            try {
                $dynamicRates = $cbrRepository->getDynamicRates($dailyRate['valuteID']);
            } catch (Throwable $e) {
                $this->error($e->getMessage());
            }

            foreach ($dynamicRates as $dynamicRate) {
                try {
                    Currency::create([
                        'valuteID' => $dailyRate['valuteID'],
                        'numCode' => $dailyRate['numCode'],
                        'charCode' => $dailyRate['charCode'],
                        'name' => $dailyRate['name'],
                        'value' => $dynamicRate['value'],
                        'date' => $dynamicRate['date'],
                    ]);
                } catch (Throwable $e) {
                    $this->error($e->getMessage());
                }
            }

            $this->info('Done.');
        }
    }
}
