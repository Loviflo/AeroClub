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

    public function getActivitiesBetween(\DateTime $start, \DateTime $end, ?String $type = null): array
    {
        $db = getDatabaseConnection();
        if ($type !== null) {
            $sql = "SELECT * From schedule WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' AND id_activity = '$type' ORDER BY start";
        } else {
            $sql = "SELECT * From schedule WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' ORDER BY start";
        }
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

    public function getActivitiesBetweenByDay(\DateTime $start, \DateTime $end, ?String $type): array
    {
        $activities = $this->getActivitiesBetween($start, $end, $type);
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

    public function getActivitiesByHour(\DateTime $start, \DateTime $end, ?String $type): array
    {
        $activities = $this->getActivitiesBetween($start, $end, $type);
        for ($days = 1; $days < 8; $days++) {
            for ($hours = 1; $hours < 6; $hours++) {
                $reserved[$days][$hours] = 0;
            }
        }
        foreach ($activities as $activity) {
            $date = new \DateTime($activity['start']);
            $date = $date->format('H');
            $activityStart = new \DateTime($activity['start']);
            $activityHour = $activityStart->format('H');
            switch ($activityHour) {
                case '10':
                    $activityHour = 1;
                    break;
                case '12':
                    $activityHour = 2;
                    break;
                case '14':
                    $activityHour = 3;
                    break;
                case '16':
                    $activityHour = 4;
                    break;
                case '18':
                    $activityHour = 5;
                    break;
            }
            $activityDay = $activityStart->format('N');
            if ($activity['id_member'] == $_SESSION['user']['id']) {
                $reserved[$activityDay][$activityHour] = 2;
            } else if ($type == 3) {
                switch ($reserved[$activityDay][$activityHour]) {
                    case 0:
                        $reserved[$activityDay][$activityHour] = 3;
                        break;
                    case 3:
                        $reserved[$activityDay][$activityHour] = 1;
                        break;
                }
            } else {
                $reserved[$activityDay][$activityHour] = 1;
            }
        }
        return $reserved;
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
        $result = $db->query("SELECT * From schedule WHERE id = $id LIMIT 1")->fetch();
        if ($result === false) {
            throw new \Exception("Aucun résultat n'a été trouvé.");
        }
        return $result;
    }
}
