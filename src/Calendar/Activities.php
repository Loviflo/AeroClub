<?php

namespace Calendar;

class Activities
{

    /**
     * Recupère les évenements commençant entre deux dates
     * @param DateTime start
     * @param DateTime end
     * @param String $type
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
     * @param DateTime $start
     * @param DateTime $end
     * @param String $type
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

    /**
     * Retourne les évenements et les jours fériés
     * @param DateTime $start
     * @param DateTime $end
     * @param String $type
     * @param String $year
     * @param String $week
     * @return array
     */

    public function getActivitiesByHour(\DateTime $start, \DateTime $end, ?String $type, ?String $year, ?String $week, String $idUser): array
    {
        $activities = $this->getActivitiesBetween($start, $end, $type);
        for ($days = 1; $days < 8; $days++) {
            for ($hours = 1; $hours < 6; $hours++) {
                $reserved[$days][$hours] = 0;
            }
        }

        $db = getDatabaseConnection();

        foreach ($activities as $activity) {
            $activityStart = new \DateTime($activity['start']); 
            $activityHour = $activityStart->format('H'); // Heure du jour

            // Attribuer un nombre en fonction de l'heure du jour
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

            // Renvoie un nombre en fonction des disponibilités
            $activityDay = $activityStart->format('N'); // Numéro du jour de la semaine. Entre 1 et 7
            if ($activity['id_member'] == $_SESSION['user']['id']) {
                $reserved[$activityDay][$activityHour] = 2; // Si l'utilisateur a déjà une réservation
            } else if ($type == 3 || $type == 9) {
                switch ($reserved[$activityDay][$activityHour]) {
                    case 0:
                        $reserved[$activityDay][$activityHour] = 3; // S'il reste encore une place
                        break;
                    case 3:
                        $reserved[$activityDay][$activityHour] = 1; // S'il n'y a plus de place
                        break;
                }
            } else {
                $reserved[$activityDay][$activityHour] = 1; // S'il n'y a plus de place
            }

        }
        
        // Multiples vérifications permettant de voir si il y a bien un avion libre ou si il y a un formateur de libre mais également de vérifier que l'utilisateur n'a pas déjà une réservation à cette heure.
        $dateWeek2 = new \DateTime();
        $dateWeek2->setISODate("{$year}", "{$week}"); // Pour récupérer la date à partir du numéro de semaine et du numéro de l'année
        for ($days = 1; $days < 8; $days++) {
            $dateWeekFormat = $dateWeek2->format('Y-m-d');
            for ($hours = 1; $hours < 6; $hours++) {
                // Vérification des avions libres pour l'ULM
                if ($type == 3) {
                    $sql = "SELECT count(*) as count FROM `schedule` WHERE start = '". $dateWeekFormat . " " . strval(10+($hours-1)*2) . ":00:00" ."' and id_plane in (3,4)";
                    $freePlaneULM = $db->query($sql)->fetch();
                    if ($freePlaneULM['count'] == 2 && $reserved[$days][$hours] != 2){
                        $reserved[$days][$hours] = 1;
                    }
                // Vérification des avions libres pour le saut en parachute et le baptême de l'air
                } else if ($type == 4 || $type == 9) {
                    $sql = "SELECT count(*) as count,max(id_activity) as type FROM `schedule` WHERE start = '". $dateWeekFormat . " " . strval(10+($hours-1)*2) . ":00:00" ."' and id_plane = 2";
                    $freePlane2 = $db->query($sql)->fetch();
                    if ($freePlane2['count'] == 1 && $reserved[$days][$hours] != 2 && ($type != 9 || ($type == 9 && $freePlane2['type'] != 9))) {
                        $reserved[$days][$hours] = 1;
                    }
                }
                // Vérification de la disponibilité du membre
                $sql = "SELECT count(*) as count FROM `schedule` WHERE start = '". $dateWeekFormat . " " . strval(10+($hours-1)*2) . ":00:00" ."' and id_member = " . $idUser . "";
                $freeMember = $db->query($sql)->fetch();
                if ($freeMember['count'] > 0 && $reserved[$days][$hours] != 2){
                    $reserved[$days][$hours] = 1;
                }
                // Vérification de la disponibilité du formateur
                $sql = "SELECT COUNT(trainers.id) as count FROM trainers WHERE NOT EXISTS (SELECT * FROM schedule WHERE start = '". $dateWeekFormat . " " . strval(10+($hours-1)*2) . ":00:00" ."' AND id_trainer = trainers.id)";
                $freeTrainers = $db->query($sql)->fetch();
                if ($freeTrainers['count'] == 0 && $reserved[$days][$hours] != 2){
                    $reserved[$days][$hours] = 1;
                }
            }
            $dateWeek2->modify('+ 1 days'); // Pour passer au jour suivant
        }

        // Calcul des jours ouverts hors période estival
        // Récupération du jour de pâques
        $easterDate = new \DateTime();
        $easterDate->setTimestamp(easter_date($year));
        $easterDate->format('U = Y-m-d'); // Passage d'un timestamp à un format Y-m-d

        $base = new \DateTime("$year-03-21");
        $days = easter_days($year);
        $easter = $base->add(new \DateInterval("P{$days}D"));
        // Liste des jours fériés
        $holidays = array(
            // Jours fériés fixes
            date_format(new \DateTime($year.'-01-01'),'Y-m-d'), // 1er janvier
            date_format(new \DateTime($year.'-05-01'),'Y-m-d'), // Fête du travail
            date_format(new \DateTime($year.'-05-08'),'Y-m-d'), // Victoire des alliés
            date_format(new \DateTime($year.'-07-14'),'Y-m-d'), // Fête nationale
            date_format(new \DateTime($year.'-08-15'),'Y-m-d'), // Assomption
            date_format(new \DateTime($year.'-11-01'),'Y-m-d'), // Toussaint
            date_format(new \DateTime($year.'-11-11'),'Y-m-d'), // Armistice
            date_format(new \DateTime($year.'-12-25'),'Y-m-d'), // Noël

            // Jours fériés dépendant de pâques
            (clone $easter)->modify('+ 1 days')->format('Y-m-d'), // Lundi de pâques
            (clone $easter)->modify('+ 39 days')->format('Y-m-d'), // Ascension
            (clone $easter)->modify('+ 49 days')->format('Y-m-d') // Pentecôte
        );

        
        $todayHour = date_format(new \DateTime(),'H');

        $dateWeek = new \DateTime();
        $dateWeek->setISODate("{$year}", "{$week}");
        for ($j=1; $j < 8; $j++) { 
            for ($h=1; $h < 6; $h++) { 
                // Si c'est dans le passé
                if ($dateWeek->format('Y-m-d') < date_format(new \DateTime(),'Y-m-d')) {
                    $reserved[$j][$h] = 1;
                }
                // Pour gérer les heures
                if ($dateWeek->format('Y-m-d') == date_format(new \DateTime(),'Y-m-d') && (10+($h-1)*2) <= $todayHour)  {
                    $reserved[$j][$h] = 1;
                }
                // Si c'est hors période estival, que c'est le samedi ou le dimanche et si c'est un jour férié
                if ($j < 6 && ($dateWeek < new \DateTime(''. $year .'-04-14') || $dateWeek > new \DateTime(''. $year .'-10-16'))) {
                    $bankHoliday = false;
                    // Boucle sur les jours fériés
                    foreach ($holidays as $holiday) {
                        // Si la date correspond à un jour férié alors $bankHoliday = true
                        if ($dateWeek->format('Y-m-d') == $holiday) {
                            $bankHoliday = true;
                        }
                    }
                    // Si bankHoliday = false
                    if (!$bankHoliday) { 
                        $reserved[$j][$h] = 1; // Passage de la cellule au gris pour indiquer que c'est fermé ou qu'il n'y a plus de place
                    }
                }
            }
            $dateWeek->modify('+ 1 days'); // Pour passer au jour suivant
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
