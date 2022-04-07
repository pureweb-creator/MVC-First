<?php

use Phinx\Seed\AbstractSeed;

class Category extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'name'=>'T-shirts',
                'slug'=>'t_shirts'
            ],
            [
                'name'=>'sweaters',
                'slug'=>'sweaters'
            ],
            [
                'name'=>'sneakers',
                'slug'=>'sneakers'
            ]
        ];

        $this->table('category')
            ->insert($data)
            ->update();
    }
}
