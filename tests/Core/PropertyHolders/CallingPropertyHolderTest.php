<?php

declare(strict_types=1);

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Callings\Calling;
use Phrantiques\Security\Core\PropertyHolders\CallingPropertyHolder;

class CallingPropertyHolderTest extends TestCase
{
    public function testCallingPropertyHolder(): void
    {
        $calling = new Calling();
        $calling->id = 1;
        $calling->created_at = Carbon::now();
        $calling->address = 'Some random address';
        $calling->id_creator = 11;
        $calling->id_spec = 12;
        $calling->last_stat = 'status';
        $calling->complaint = 'Whoops! Something went wrong.';
        $calling->id_prov = 15;
        $calling->id_user = 16;
        $calling->id_patient = 17;

        $propertyHolder = new CallingPropertyHolder($calling);

        $this->assertEquals($calling->created_at->format(Carbon::DEFAULT_TO_STRING_FORMAT), $propertyHolder->getProperty('created_at'));
        $this->assertEquals($calling->id, $propertyHolder->getProperty('id'));
        $this->assertEquals($calling->address, $propertyHolder->getProperty('address'));
        $this->assertEquals($calling->id_creator, $propertyHolder->getProperty('id_creator'));
        $this->assertEquals($calling->id_spec, $propertyHolder->getProperty('id_spec'));
        $this->assertEquals($calling->last_stat, $propertyHolder->getProperty('last_stat'));
        $this->assertEquals($calling->complaint, $propertyHolder->getProperty('complaint'));
        $this->assertEquals($calling->id_prov, $propertyHolder->getProperty('id_prov'));
        $this->assertEquals($calling->id_user, $propertyHolder->getProperty('id_user'));
        $this->assertEquals($calling->id_patient, $propertyHolder->getProperty('id_patient'));
    }
}
