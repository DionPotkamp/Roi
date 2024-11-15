<?php
namespace App\Controllers\Calendar;

use App\Models\Calendar\LeapYear;
use Symfony\Component\HttpFoundation\Request;

class LeapYearController
{
    public function index(Request $request, $year)
    {
        $leapYear = new LeapYear();

        if ($leapYear->isLeapYear($year)) {
            return 'Yep, this is a leap year!';
        }

        return 'Nope, this is not a leap year.';
    }
}
