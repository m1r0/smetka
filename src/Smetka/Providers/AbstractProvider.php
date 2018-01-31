<?php

namespace Smetka\Providers;

abstract class AbstractProvider implements ProviderInterface
{
    /**
     * The provider options.
     *
     * @var array
     */
    protected $options;

    /**
     * Create a new provider instance.
     *
     * @param  array  $options
     * @return void
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
}
