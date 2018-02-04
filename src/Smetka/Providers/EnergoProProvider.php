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

        $options = $this->options;
        $crawler = $this->doRequest();

        $crawler->filter('#content > table tr:nth-child(n+3)')->each(function($node) use (&$bills, $options) {
            $tdNodes = $node->filter('td');

            $bill = [
                'amount' => (float) $tdNodes->eq(3)->text(),
                'subscriber_number' => $tdNodes->eq(1)->text(),
                'invoice_date' => $tdNodes->eq(2)->text(),
                'invoice_due_date' => $tdNodes->eq(4)->text(),
            ];

            if (isset($options['subscriber_number']) && $options['subscriber_number'] != $bill['subscriber_number']) {
                return;
            }

            $bills[] = $bill;
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
