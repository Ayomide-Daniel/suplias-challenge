<?php

namespace App;

class PseudoCrud
{
    public static $_db = array();

    public static function create($value_dictionary)
    {
        $c = count(Self::$_db);

        $new_id = $c + 1;

        $new_object = $value_dictionary;
        $new_object['id'] = $new_id;

        Self::$_db[] = $new_object;

        return $new_id;
    }

    public static function read($id)
    {
        $object_found = null;

        foreach (Self::$_db as $obj) {
            if ($obj['id'] == $id) {
                $object_found = $obj;
                return $object_found;
            }
        }
        return $object_found;
    }

    public static function read_by($key, $value)
    {
        $objects_found = array();

        foreach (Self::$_db as $obj) {
            if ($obj[$key] == $value) {
                $objects_found[] = $obj;
            }
        }
        return $objects_found;
    }

    public static function read_all()
    {
        return Self::$_db;
    }

    public static function update($id, $value_dictionary)
    {
        $update = false;
        $c = count(Self::$_db);

        for ($i = 0; $i < $c; ++$i) {
            if (Self::$_db[$i]['id'] == $id) {
                foreach ($value_dictionary as $key => $value) {
                    Self::$_db[$i][$key] = $value;
                }
                $update = true;
                return $update;
            }
        }

        return $update;
    }

    public static function delete($id)
    {
        $deleted = false;
        $c = count(Self::$_db);

        for ($i = 0; $i < $c; ++$i) {
            if (Self::$_db[$i]['id'] == $id) {
                unset(Self::$_db[$i]);
                $deleted = true;
                return $deleted;
            }
        }
        return $deleted;
    }

    public static function view()
    {
        $json_representative = json_encode(Self::$_db);

        return $json_representative;
    }
}

//create examples
$new_id = pseudocrud::create([
    'username' => 'a_username',
    'email' => 'some@email',
    'name' => 'John Q. Citizen',
    'password' => 'some_password'
]);

$another_new_id = pseudocrud::create([
    'username' => 'another_username',
    'email' => 'another@email',
    'name' => 'Jane Doe',
    'password' => 'some_other_password'
]);

//create test

//read test

//read_by test

//update tes

//delete test

//view

echo 'You have ' . count(pseudocrud::read_all()) . ' users: ';
echo pseudocrud::view();
