<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\ProviderFirst;
use App\Services\ProviderSecond;
use App\Services\ProviderThird;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class UserSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:user {name} {company} {linked_in}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search the user based on name, company and linked_in';

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle()
    {
        $name = $this->argument('name');
        $company = $this->argument('company');
        $linked_in = $this->argument('linked_in');

        $user = User::firstOrCreate(['name' => $name, 'company' => $company, 'linked_in' => $linked_in]);

        $providers = $user->getProviders();
        if (count($providers) === 0) {
            throw new Exception('You can not search anymore.');
        }
        foreach ($providers as $item) {
            switch ($item) {
                case ('provider1'):
                    $provider = new ProviderFirst($name, $company, $linked_in);
                    break;
                case ('provider2'):
                    $provider = new ProviderSecond($name, $company, $linked_in);
                    break;
                case ('provider3'):
                    $provider = new ProviderThird($name, $company, $linked_in);
                    break;
                default:
                    throw new Exception($item . ' - this provider does not exist.');
            }

            $user->last_provider = $item;
            $user->save();

            try {
                $emails = $provider->handle();
            } catch (Exception $e) {
                $this->info('[Error] ' . $item . ' - there was an error processing your request.');
                $this->info($e->getMessage());
                continue;
            }

            if (count($emails) === 0 && $item !== last($providers)) {
                $this->info($item . ': ' . '0 emails found');
                continue;
            }

            $this->info($item . ': ' . count($emails) . ' emails found');
            $this->info('Emails: ');
            foreach ($emails as $email) {
                $validator = Validator::make(['email' => $email], ['email' => 'email']);
                if ($validator->passes()) {
                    $user->userEmails()->create(['email' => $email, 'provider' => $item]);
                    $this->info($email . ' - email created for provider ' . $item);
                } else {
                    $this->info($email . ' - invalid email from provider ' . $item);
                }
            }
            break;
        }
        return 0;
    }
}
