<?php

namespace Smetka\Providers;

use Goutte\Client;

class EnergoProProvider extends AbstractProvider
{
    /**
     * The request url.
     *
     * @var string
     */
    const REQUEST_URL = 'https://www.energo-pro.bg/bg/proverka-na-smetka-za-elektroenergiya';

    /**
     * Get all bills for the provider.
     *
     * @return array
     */
    public function getBills()
    {
        $bills = [];

        $crawler = $this->doRequest();

        $crawler->filter('#content > table tr:nth-child(n+3)')->each(function($node) use (&$bills) {
            $tdNodes = $node->filter('td');

            $bills[] = [
                'amount' => $tdNodes->eq(3)->text(),
                'invoice_date' => $tdNodes->eq(2)->text(),
                'invoice_due_date' => $tdNodes->eq(4)->text(),
            ];
        });

        return $bills;
    }

    /**
     * Make a request to the target URL.
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function doRequest()
    {
        $client = new Client;

        return $client->request('POST', static::REQUEST_URL, [
            'kin' => $this->options['client_number'],
        ]);
    }
}
