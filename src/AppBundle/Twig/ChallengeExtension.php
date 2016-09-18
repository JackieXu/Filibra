<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Challenge;
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;
use Symfony\Component\Translation\Translator;

class ChallengeExtension extends Twig_Extension
{

    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('challenge_datediff', array($this, 'dateDiff'))
        ];
    }

    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('currency', array($this, 'currencyFilter'), array('is_safe' => array('html')))
        ];
    }

    public function dateDiff(Challenge $challenge): string
    {
        $now = new \DateTime('now');
        $diff = $challenge->getFinishDate()->diff($now);

        $date_order = ['y', 'm', 'd', 'h', 'i', 's'];
        $i18n_keys = ['years', 'months', 'days', 'hours', 'minutes', 'seconds'];


        $i = 0;
        #                                   // prevent infinite loop
        while ($diff->{$date_order[$i]} === 0 && $i < count($date_order) - 1) {
            $i++;
        }

        $d = $diff->{$date_order[$i]};

        return $d . " " . $this->translator->transChoice($i18n_keys[$i], $d);
    }

    public function currencyFilter(int $amount): string
    {
        return '<bold>fds</bold> ' . number_format($amount, 2, ',', '.');
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