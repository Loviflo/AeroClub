<?php

namespace Calendar;

class Activities
{

    /**
     * Recupère les évenements commençant entre deux dates
     * @param DateTime start
     * @param DateTime end
     * @return array
     */

    public function getActivitiesBetween(\DateTime $start, \DateTime $end): array
    {
        $db = getDatabaseConnection();
        $sql = "SELECT * From activities WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' ORDER BY start";
        $req = $db->query($sql);
        $results = $req->fetchAll();
        return $results;
    }

    /**
     * Recupère les évenements commençant entre deux dates indexés par jour
     * @param DateTime start
     * @param DateTime end
     * @return array
     */

    public function getActivitiesBetweenByDay(\DateTime $start, \DateTime $end): array
    {
        $activities = $this->getActivitiesBetween($start, $end);
        $days = [];
        foreach ($activities as $activity) {
            $date = explode(' ', $activity['start'])[0];
            if (!isset($days[$date])) {
                $days[$date] = [$activity];
            } else {
                $days[$date][] = $activity;
            }
        }
        return $days;
    }

    /**
     * Récupère un évenement
     * @param int $id
     * @return array
     * @throws \Exception
     */

    public function find(int $id): array
    {
        $db = getDatabaseConnection();
        $result = $db->query("SELECT * From activities WHERE id = $id LIMIT 1")->fetch();
        if ($result === false) {
            throw new \Exception("Aucun résultat n'a été trouvé.");
        }
        return $result;
    }
}
