<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class NavigationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateComplainLink()
    {
        $user = new User(array('name' => 'rusdi'));
        $this->be ($user);
        $this->visit('http://aduanict.dev/complain/create')
            ->see('Hantar Aduan');
    }
    public function testCreateIndexLink()
    {
        $user = new User(array('name' => 'rusdi'));
        $this->be ($user);
        $this->visit('http://aduanict.dev/complain')
            ->see('Senarai Aduan');
    }

    public function testComplainShowLink()
    {
        $user = new User(array('name' => 'rusdi'));
        $this->be ($user);
        $this->visit('http://aduanict.dev/complain/15670')
            ->see('Maklumat Aduan');
    }

    public function testKemaskiniLink()
    {
        $user = new User(array('name' => 'rusdi'));
        $this->be ($user);
        $this->visit('http://aduanict.dev/complain/15673/edit')
            ->see('Maklumat Aduan');
    }

    public function testPaginateLink()
    {
        $user = new User(array('name' => 'rusdi'));
        $this->be ($user);
        $this->visit('http://aduanict.dev/complain?page=2')
            ->see('Senarai Aduan')
            ->seePageIs('http://aduanict.dev/complain?page=2');
    }
}
