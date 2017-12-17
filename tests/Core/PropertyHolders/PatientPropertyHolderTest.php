<?php

declare(strict_types=1);

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Callings\CallingPatients;
use Phrantiques\Security\Core\PropertyHolders\PatientPropertyHolder;

class PatientPropertyHolderTest extends TestCase
{
    public function testPatientPropertyHolder(): void
    {
        $patient = new CallingPatients();
        $patient->id = 1;
        $patient->id_prov = 2;
        $patient->email = 'user@mail.com';
        $patient->fio = 'User User User';
        $patient->phone = '1-11-111-1111';
        $patient->born = Carbon::now();

        $propertyHolder = new PatientPropertyHolder($patient);

        $this->assertEquals($patient->id, $propertyHolder->getProperty('id'));
        $this->assertEquals($patient->id_prov, $propertyHolder->getProperty('id_prov'));
        $this->assertEquals($patient->email, $propertyHolder->getProperty('email'));
        $this->assertEquals($patient->fio, $propertyHolder->getProperty('fio'));
        $this->assertEquals($patient->phone, $propertyHolder->getProperty('phone'));
        $this->assertEquals($patient->born->format(Carbon::DEFAULT_TO_STRING_FORMAT), $propertyHolder->getProperty('born'));
    }
}
