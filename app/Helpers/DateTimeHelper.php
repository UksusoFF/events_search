<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    /**
     * @param string $string
     *
     * @return string
     */
    private function replaceLocalizedMonthNames(string $string)
    {
        foreach ([
            '01' => ['yan', 'jan', 'января', 'январь'],
            '02' => ['fev', 'feb', 'февраля', 'февраль'],
            '03' => ['mar', 'марта', 'март'],
            '04' => ['apr', 'апреля', 'апрель'],
            '05' => ['may', 'мая', 'май'],
            '06' => ['jun', 'июня', 'июнь'],
            '07' => ['jul', 'июля', 'июль'],
            '08' => ['avg', 'aug', 'августа', 'август'],
            '09' => ['sen', 'sep', 'сентября', 'сентябрь'],
            '10' => ['okt', 'oct', 'октября', 'октябрь'],
            '11' => ['nov', 'ноября', 'ноябрь'],
            '12' => ['dek', 'dec', 'декабря', 'декабрь'],
        ] as $month => $monthNames) {
            $string = str_replace($monthNames, $month, $string);
        }

        return $string;
    }

    /**
     * @param null|string $string
     * @param null|string $format
     * @param null|string $regex
     *
     * @return \Carbon\Carbon|null
     */
    public function getDateFromFormat(?string $string, ?string $format, ?string $regex)
    {
        //TODO: Month required for date format

        if (empty($string) || empty($format)) {
            return null;
        }

        if ($format === 'timestamp') {
            return Carbon::createFromTimestamp($string);
        }

        if (!empty($regex) && preg_match($regex, $string, $matches)) {
            $string = head($matches);
        }

        $string = $this->replaceLocalizedMonthNames($string);

        $date = Carbon::createFromFormat("!$format", $string);

        if (!str_contains($format, [
            'Y', 'y',
        ])) {
            $currentYear = Carbon::now()->year;

            if ((clone($date))->year($currentYear)->endOfMonth()->endOfDay()->isFuture()) {
                $date->year = $currentYear;
            } else {
                $date->year = $currentYear + 1;
            }
        }

        if (!str_contains($format, [
            'd', 'j',
        ])) {
            $date->day($date->daysInMonth);
        }

        if (!str_contains($format, [
            'g', 'h',
            'G', 'H',
        ])) {
            $date->setTime(20, 0, 0);
        }

        return $date;
    }
}