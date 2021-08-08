<?php

namespace Calendar;

class Week
{

    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $week;
    public $year;

    /**
     * Month constructor
     * @param int $month Le mois compris entre 1 et 12
     * @param int $year L'année
     * @throws Exception
     */

    public function __construct(?int $year = null, ?int $week = null)
    {
        if ($year === null) {
            $year = intval(date('Y'));
        }

        if ($week === null || $week < 1 || $week > 53) {
            $week = intval(date('W'));
        }

        $this->year = $year;
        $this->week = $week;
    }

    /**
     * Retourne le premier jour du mois
     */

    public function getFirstDay(): \DateTime
    {
        $dateWeek = new \DateTime();
        return $dateWeek->setISODate("{$this->year}", "{$this->week}");
    }

    /**
     * Retourne le mois en toute lettre
     * @return string
     */

    public function toString(): string
    {
        return $this->year . ' Semaine ' . $this->week;
    }

    /**
     * Retourne le nombre de semaine dans le mois
     * @return int
     */

    public function getWeeks(): int
    {
        $start = $this->getFirstDay();
        $end = (clone $start)->modify('+1 month -1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
        if ($weeks < 0) {
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }

    /**
     * Renvoie la semaine suivante
     * @return Week
     */

    public function nextWeek(): Week
    {
        $lastWeek = new \DateTime("{$this->year}-12-31");
        $lastWeek = $lastWeek->format("W");
        $week = $this->week + 1;
        $year = $this->year;
        if ($week > intval($lastWeek)) {
            $week = 1;
            $year += 1;
        }
        return new Week($year, $week);
    }

    /**
     * Renvoie la semaine précédente
     * @return Week
     */

    public function previousWeek(): Week
    {
        $lastYear = $this->year - 1;
        $lastWeek = new \DateTime("{$lastYear}-12-31");
        $lastWeek = $lastWeek->format("W");
        $week = $this->week - 1;
        $year = $this->year;
        if ($week < 1) {
            $week = intval($lastWeek);
            $year -= 1;
        }
        return new Week($year, $week);
    }
}
