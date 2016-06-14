<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class NavigationManagerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateComplainLink()
    {
        $user = User::whereName('Haji Norman')->first();
        $this->actingAs($user);
        $this->visit('/complain/create')
            ->see('Hantar Aduan');
    }
    public function testCreateIndexLink()
    {
        $user = User::whereName('Haji Norman')->first();
        $this->actingAs($user);
        $this->visit('/complain')
            ->see('Senarai Aduan');
    }

    public function testComplainShowLink()
    {
        $user = User::whereName('Haji Norman')->first();
        $this->actingAs($user);
        $this->visit('/complain/15670')
            ->see('Maklumat Aduan');
    }

    public function testKemaskiniLink()
    {
        $user = User::whereName('Haji Norman')->first();
        $this->actingAs($user);
        $this->visit('/complain/15672/edit')
            ->see('Maklumat Aduan');
    }

    public function testPaginateLink()
    {
        $user = User::whereName('Haji Norman')->first();
        $this->actingAs($user);
        $this->visit('/complain?page=2')
            ->see('Senarai Aduan')
            ->seePageIs('/complain?page=2');
    }

    public function testAssignLink()
    {
        $user = User::whereName('Haji Norman')->first();
        $this->actingAs($user);
         $this->visit('/complain/assign')
            ->see('Senarai Agihan');
    }

    public function testKAgihTugasLink()
    {
        $user = User::whereName('Haji Norman')->first();
        $this->actingAs($user);
        $this->visit('/complain/15670/assign')
            ->see('Agihan Tugas');
    }


}
