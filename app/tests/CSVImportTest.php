<?php

namespace sasky\catchTest\tests;

use SilverStripe\Dev\FunctionalTest;
use sasky\catchTest\app\Customer;

class CSVImportTest extends FunctionalTest
{
    protected static $fixture_file = 'CSVImportTest.yml';
    protected static $use_draft_site = true;


    public function test_csv_import_task()
    {
        //GIVEN we have a csv file with data to import
        //WHEN we run the import task
        $response = $this->get('dev/tasks/CSVImportTask');
        //THEN the Customers Table should be have 1000 records
        $this->assertEquals(1000, Customer::get()->count());
        // THEN the Third Record form the CSV should match up with the Third Customers record in the DB
        
        $third = Customer::get()->byID(3);
        $this->assertEquals('Craig', $third->FirstName);
        $this->assertEquals('Mccoy', $third->LastName);
        $this->assertEquals('cmccoy2@bluehost.com', $third->Email);
        $this->assertEquals('Male', $third->Gender);
        $this->assertEquals('75.162.167.180', $third->IPAddress);
        $this->assertEquals('Quatz', $third->Company);
        $this->assertEquals('Srpska Crnja', $third->City);
        $this->assertEquals('Senior Sales Associate', $third->Title);
        $this->assertEquals('https://cdc.gov/iaculis.png?vulputate=sapien&justo=varius&in=ut&blandit=blandit&ultrices=non&enim=interdum&lorem=in&ipsum=ante', $third->Website);

        // WHEN we run the task again
        $response = $this->get('dev/tasks/CSVImportTask');
        // THEN no more Customers should be added
        $this->assertEquals(1000, Customer::get()->count());
    }
}
