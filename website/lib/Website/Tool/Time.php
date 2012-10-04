<?php
/**
 * a small Helper becouse the actual Timestamp is never the Same --> Caching !
 *
 *
 * Created by elements.at New Media Solutions GmbH
 * Nikolaus Flamann
 * File: Time.php
 * User: nflamann
 * Date: 04.07.12
 * Time: 18:01
 * @var $this Pimcore_View
 */


class Website_Tool_Time
{

    public static function getStartDate()
    {
        $date = new Zend_Date();
        $date->setHour(0);
        $date->setMinute(0);
        $date->setSecond(0);

        return $date;
    }

    public static function getEndDate()
    {
        $date = new Zend_Date();
        $date->setHour(23);
        $date->setMinute(50);
        $date->setSecond(59);

        return $date;
    }
}
