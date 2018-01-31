<?php

namespace Smetka\Providers;

interface ProviderInterface
{
    /**
     * Get all bills for the provider.
     *
     * @return array
     */
    public function getBills();
}
