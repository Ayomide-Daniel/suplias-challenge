<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\PseudoCrud;
use PHPUnit\Framework\Error\Notice;

class PseudoCrudTest extends TestCase
{
    protected $pseudo_crud;
    protected static $pseudo_crud_read_all;

    public function setUp():void
    {
        $this->pseudo_crud = new PseudoCrud();
        self::$pseudo_crud_read_all = $this->pseudo_crud::read_all();
    }

    // public function tearDown():void
    // {
    //     self::$pseudo_crud_read_all = array();
    // }


    /**
     * @test 
     */

    // Note that after this first case runs, PseudoCrud::$_db will still retain the inserted values. If displeased by this, uncomment the tearDown function above which resets PseudoCrud::$_db for every test case

    public function test_if_pseudo_crud_can_create(): void
    {
        $value_dictionary = [
            'username' => 'a_username',
            'email' => 'some@email',
            'name' => 'John Q. Citizen',
            'password' => 'some_password'
        ];

        $pseudo_crud_create = $this->pseudo_crud::create($value_dictionary);

        $this->assertEquals($pseudo_crud_create, count(self::$pseudo_crud_read_all) + 1);
    }



    /**
     * @test
     */
    public function test_if_pseudo_crud_can_read(): void
    {
        $id = 1;

        $pseudo_crud_read = $this->pseudo_crud::read($id);
        $obj = null;
        foreach (self::$pseudo_crud_read_all as $key => $item) {
            if ($item['id'] == $id) {
                $obj = $item;
            }
        }

        $this->assertSame($pseudo_crud_read, $obj);
    }

    /**
     * @test
     */
    public function test_if_pseudo_crud_can_read_by(): void
    {
        $key = 'name';
        $value = 'John Q. Citizen';

        $pseudo_crud_read_by = $this->pseudo_crud::read_by($key, $value);

        $objects_found = [];

        foreach (self::$pseudo_crud_read_all as $item) {
            if ($item[$key] == $value) {
                $objects_found[] = $item;
            }
        }

        $this->assertSameSize($objects_found, $pseudo_crud_read_by);
        $this->assertSame($objects_found, $pseudo_crud_read_by);
    }

    /**
     * @test
     */
    public function test_if_pseudo_crud_can_update()
    {
        $status = false;

        $id = 9;
        $value_dictionary = [
            'username' => 'another_username',
            'email' => 'another@email',
            'name' => 'Jane Doe',
            'password' => 'some_other_password'

        ];

        $pseudo_crud_update = $this->pseudo_crud::update($id, $value_dictionary);

        foreach (self::$pseudo_crud_read_all as $key => $item) {
            if ($item['id'] == $id) {
                foreach ($value_dictionary as $key => $value) {
                    $item[$key] = $value;
                }
                $status = true;
            }
        }

        $count_pseudo_crud = count(self::$pseudo_crud_read_all);
        $this->assertSame($status, $pseudo_crud_update);


        if ($id > $count_pseudo_crud) {

            $this->expectNotice(Notice::class);

            $this->assertIsArray(self::$pseudo_crud_read_all[$id - 1], "assert if \$_db element with \$id of " . $id . " exits (as an array)");
        }
    }

    /**
     * @test
     */
    public function test_if_pseudo_crud_can_delete()
    {
        $id = 1;
        $pseudo_crud_items = self::$pseudo_crud_read_all;
        $pseudo_crud_delete = $this->pseudo_crud::delete($id);

        if ($pseudo_crud_delete == true) {
            $this->assertCount(count($pseudo_crud_items) -1 , $this->pseudo_crud::read_all());
        }else{
            $this->assertCount(count($pseudo_crud_items) , $this->pseudo_crud::read_all());
        }
    }

    /**
     * @test
     */
    public function test_if_pseudo_crud_can_view()
    {
        $this->assertSame(json_encode(self::$pseudo_crud_read_all), $this->pseudo_crud::view());
    }
}
