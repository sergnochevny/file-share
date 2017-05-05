<?php


namespace backend\models;


use yii\db\Expression;

class Graph
{
    /** @var \DateInterval  */
    private $interval;

    /** @var DateTime  */
    private $endDate;

    /** @var DateTime  */
    private $startDate;

    /** @var \DatePeriod  */
    private $period;

    public function __construct(\DateInterval $interval, \DateInterval $step)
    {
        $this->interval = $interval;
        $this->endDate = new DateTime();
        $this->endDate->setTime(23, 59, 59);

        $this->startDate = $this->endDate->minus($interval);
        $this->startDate->setTime(0, 0, 0);

        $this->period = new \DatePeriod($this->startDate, $step, $this->endDate);
    }

    public function getDays()
    {
        $days = [];
        foreach ($this->period as $date) {
            /** @var $date DateTime */
            $days[] = $date->format('m.d');
        }

        return $days;
    }

    /**
     * @return array
     */
    public function getApplicants()
    {
        $today = $this->endDate->getTimestamp();
        $applicants = Investigation::find()
            ->select(new Expression('COUNT(*) AS count, [[created_at]]'))
            ->andWhere(['>=', 'created_at', $this->startDate->getTimestamp()])
            ->groupBy(new Expression("FLOOR([[created_at]]/86400)"))
            ->asArray()
            ->all();

        return array_column($applicants, 'count', 'created_at');
    }

    /**
     * @todo refactor
     * @return array
     */
    public function getDataForGraph()
    {
        $applicantCount = [];
        foreach ($this->getApplicants() as $timestamp => $count) {
            $dateTime = DateTime::createFromFormat('U', $timestamp);
            if ($dateTime) {
                $monthDay = $dateTime->format('m.d');
                $applicantCount[$monthDay] = $count;
            }
        }

        $data = [];
        foreach ($this->getDays() as $monthDay) {
            $data[$monthDay] = isset($applicantCount[$monthDay]) ? $applicantCount[$monthDay] : 0;
        }

        return $data;
    }
}