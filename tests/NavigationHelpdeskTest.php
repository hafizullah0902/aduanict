<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class NavigationHelpdeskTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateComplainLink()
    {
       $user = User::whereName('Nargis Ismail')->first();
        $this->actingAs($user);
        $this->visit('/complain/create')
            ->see('Hantar Aduan');
    }
    public function testCreateIndexLink()
    {
       $user = User::whereName('Nargis Ismail')->first();
        $this->actingAs($user);
        $this->visit('/complain')
            ->see('Senarai Aduan');
    }

    public function testComplainShowLink()
    {
       $user = User::whereName('Nargis Ismail')->first();
        $this->actingAs($user);
        $this->visit('/complain/15670')
            ->see('Maklumat Aduan');
    }

    public function testKemaskiniLink()
    {
       $user = User::whereName('Nargis Ismail')->first();
        $this->actingAs($user);
        $this->visit('/complain/15673/action')
            ->see('Maklumat Aduan');
    }

    public function testPaginateLink()
    {
       $user = User::whereName('Nargis Ismail')->first();
        $this->actingAs($user);
        $this->visit('/complain?page=2')
            ->see('Senarai Aduan')
            ->seePageIs('/complain?page=2');
    }
    
}
