<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('event_code_format', [$this, 'formatEventCode']),
        ];
    }

    public function formatEventCode($value)
    {
        return trim(preg_replace('/\d{2}/', '\0 ', $value));
    }
}
