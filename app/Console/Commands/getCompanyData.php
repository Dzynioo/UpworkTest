<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Psr7\Request;
use App\Models\Company;
use App\Models\CompanyIncome;


class getCompanyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modeling:get_company_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://financialmodelingprep.com/api/v4/company-outlook?symbol=AAPL&apikey=becdde2694dc926c60f873878b412efb');
                    
        $responseStatus = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();
        $responseDecode = json_decode($responseBody, true);
        
        $company = Company::firstOrCreate([
            'symbol' => $responseDecode['profile']['symbol'],
            'companyName' => $responseDecode['profile']['companyName'],
            'price' => $responseDecode['profile']['price'],
            'mktCap' => $responseDecode['profile']['mktCap'],
            'cik' => $responseDecode['profile']['cik'],
        ]);
        
        $incomes = $responseDecode['financialsAnnual']['income'];
        
        foreach($incomes as $income){
            
            $company = CompanyIncome::firstOrCreate([
                'symbol' => $income['symbol'],
                'date' => $income['date'],
                'revenue' => $income['revenue'],
                'eps' => $income['eps'],
                'link' => $income['link'],
            ]); 
        }
        

        
        
        
        
    }
}
