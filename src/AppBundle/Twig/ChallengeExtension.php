<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Challenge;
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;

class ChallengeExtension extends Twig_Extension
{

    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('challenge_datediff', array($this, 'dateDiff'))
        ];
    }

    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('currency', array($this, 'currencyFilter'))
        ];
    }

    public function dateDiff(Challenge $challenge): string
    {
        $now = new \DateTime('now');
        $diff = $challenge->getFinishDate()->diff($now);

        $date_order = ['y', 'm', 'd', 'h', 'i', 's'];
        $date_strings = ['year', 'month', 'day', 'hour', 'minute', 'second'];


        $i = 0;
        #                                   // prevent infinite loop
        while ($diff->{$date_order[$i]} === 0 && $i < count($date_order) - 1) {
            $i++;
        }

        $d = $diff->{$date_order[$i]};

        return $d . " " . $date_strings[$i] . ($d > 1 ? "s" : "");
    }

    public function currencyFilter(int $amount): string
    {
        return '€ ' . number_format($amount, 2, ',', '.');
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName(): string
    {
        return "challenge_extension";
    }
}