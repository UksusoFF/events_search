<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

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
            '01' => ['yan', 'jan', 'января', 'январь', 'янв'],
            '02' => ['fev', 'feb', 'февраля', 'февраль', 'фев'],
            '03' => ['mar', 'марта', 'март', 'мар'],
            '04' => ['apr', 'апреля', 'апрель', 'апр'],
            '05' => ['may', 'мая', 'май'],
            '06' => ['jun', 'июня', 'июнь', 'июн'],
            '07' => ['jul', 'июля', 'июль', 'июл'],
            '08' => ['avg', 'aug', 'августа', 'август', 'авг'],
            '09' => ['sen', 'sep', 'сентября', 'сентябрь', 'сен'],
            '10' => ['okt', 'oct', 'октября', 'октябрь', 'окт'],
            '11' => ['nov', 'ноября', 'ноябрь', 'ноя'],
            '12' => ['dek', 'dec', 'декабря', 'декабрь', 'дек'],
        ] as $month => $monthNames) {
            $string = str_replace($monthNames, $month, mb_strtolower($string));
        }

        return $string;
    }

    private function isLocalizedToday(string $string)
    {
        return in_array(mb_strtolower($string), [
            'сегодня',
            'today',
        ]);
    }

    private function isLocalizedTomorrow(string $string)
    {
        return in_array(mb_strtolower($string), [
            'завтра',
            'tomorrow',
        ]);
    }

    /**
     * @param null|string $string
     * @param null|string $format
     * @param null|string $regex
     *
     * @return \Illuminate\Support\Carbon|null
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

        if (!empty($regex)) {
            if (preg_match("/$regex/u", $string, $matches)) {
                $string = head($matches);
            } else {
                return null;
            }
        }

        $string = preg_replace('!\s+!', ' ', $string);

        $string = $this->replaceLocalizedMonthNames($string);

        if ($this->isLocalizedToday($string)) {
            $date = Carbon::today();
        } elseif ($this->isLocalizedTomorrow($string)) {
            $date = Carbon::tomorrow();
        } else {
            $date = Carbon::createFromFormat("!$format", $string);
        }

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