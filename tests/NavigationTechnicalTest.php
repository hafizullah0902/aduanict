<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class NavigationTechnicalTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateComplainLink()
    {
        $user = User::whereName('fidaus')->first();
        $this->actingAs($user);
        $this->visit('/complain/create')
            ->see('Hantar Aduan');
    }
    public function testCreateIndexLink()
    {
        $user = User::whereName('fidaus')->first();
        $this->actingAs($user);
        $this->visit('/complain')
            ->see('Senarai Aduan');
    }

    public function testComplainShowLink()
    {
        $user = User::whereName('fidaus')->first();
        $this->actingAs($user);
        $this->visit('/complain/15670')
            ->see('Maklumat Aduan');
    }

    public function testKemaskiniLink()
    {
        $user = User::whereName('fidaus')->first();
        $this->actingAs($user);
        $this->visit('/complain/15673/edit')
            ->see('Maklumat Aduan');
    }

    public function testPaginateLink()
    {
        $user = User::whereName('fidaus')->first();
        $this->actingAs($user);
        $this->visit('/complain?page=2')
            ->see('Senarai Aduan')
            ->seePageIs('/complain?page=2');
    }

    public function testTechnicalLink()
    {
        $user = User::whereName('fidaus')->first();
        $this->actingAs($user);
        $this->visit('/complain/15611/technical_action')
            ->see('Maklumat Aduan');
    }

}
