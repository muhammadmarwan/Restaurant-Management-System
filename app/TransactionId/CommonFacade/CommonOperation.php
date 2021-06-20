<?php
/**
 * Created by PhpStorm.
 * User: beacon
 * Date: 19/9/19
 * Time: 2:17 PM
 */

namespace App\TransactionId\CommonFacade;

use App\AcademicYear;
use App\Common\StatusDetails;
use App\Syncronization;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;

class CommonOperation extends Facade
{

    public static function getCurrentAcademicYear(){


        $academicYearId = AcademicYear::where('status', '=', StatusDetails::ACTIVE)->value('academic_year_id');
        return $academicYearId;

    }

    public static function listAcademicYear($academicYearId)
    {

        if ($academicYearId == null) {
            return $academicYearId = AcademicYear::where('status', '=', StatusDetails::ACTIVE)->value('academic_year_id');
        }
        else
        {
            return $academicYearId = $academicYearId;
        }

    }


}