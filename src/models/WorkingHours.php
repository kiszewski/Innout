<?php 
class WorkingHours extends Model {
    protected static $tableName = 'working_hours';
    protected static $columns = [
        'id', 
        'user_id',
        'work_date',
        'time1',
        'time2',
        'time3',
        'time4',
        'worked_time'
    ];

    public static function loadFromUserAndDate($userId, $workDate) {
        $registry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);

        if(!$registry->id) {
            $registry = new WorkingHours([
                'user_id' => $userId,
                'work_date' => $workDate,
                'worked_time' => 0
            ]);
        }

        return $registry;
    }

    public function getExitTime() {
        [$t1, , , $t4] = $this->getTimes();

        $workDay = DateInterval::createFromDateString('8 hours');

        if(!$t1) {
            return (new DateTimeImmutable())->add($workDay);
        } elseif ($t4) {
            return $t4;
        } else {
            $total = sumIntervals($workDay, $this->getLunchInterval());
            return $t1->add($total);
        }
    }

    public function getLunchInterval() {
        [, $t2, $t3,] = $this->getTimes();

        $breakInterval = new DateInterval('PT0S');

        if($t2) $breakInterval = $t2->diff(new DateTime());
        if($t3) $breakInterval = $t2->diff($t3);

        return $breakInterval;
    }

    public function getWorkedInterval() {
        [$t1, $t2, $t3, $t4] = $this->getTimes();

        $part1 = new DateInterval('PT0S');
        $part2 = new DateInterval('PT0S');

        if($t1) $part1 = $t1->diff(new DateTime());
        if($t2) $part1 = $t1->diff($t2);
        if($t3) $part2 = $t3->diff(new DateTime());
        if($t4) $part2 = $t3->diff($t4);

        return sumIntervals($part1, $part2);
    }

    private function getTimes() {
        $times = [];

        $this->time1 ? array_push($times, getDateAsDateTime($this->time1)) : array_push($times, null);
        $this->time2 ? array_push($times, getDateAsDateTime($this->time2)) : array_push($times, null);
        $this->time3 ? array_push($times, getDateAsDateTime($this->time3)) : array_push($times, null);
        $this->time4 ? array_push($times, getDateAsDateTime($this->time4)) : array_push($times, null);

        return $times;
    }

    public function getNextTime() {
        if(!$this->time1) return 'time1';
        if(!$this->time2) return 'time2';
        if(!$this->time3) return 'time3';
        if(!$this->time4) return 'time4';
        else return null;
    }

    public function innout($time) {
        $currentColumn = $this->getNextTime();
        if(!$currentColumn) {
            throw new AppException('Voce já fez os 4 batimentos do dia!');
        }

        $this->$currentColumn = $time;
        if($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }
}