<?php

use Phinx\Seed\AbstractSeed;

class Product extends AbstractSeed
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
                'name'=>'BOYS\' CREW NECK COTTON JERSEY SWEATER',
                'category_id'=>2,
                'price'=>270,
                'pub_date'=>'2022-03-31 14:00:00',
                'image'=>'/phptutor/mvcproj/static/img/6ec339c6-68e5-4e3c-96bf-eaf0cf2247b8_size2000x2000_cropCenter.jpg'
            ],
            [
                'name'=>'KIDS\' SWEATER',
                'category_id'=>2,
                'price'=>250,
                'pub_date'=>'2022-03-31 14:00:00',
                'image'=>'/phptutor/mvcproj/static/img/3ffe53a5-0380-4bbe-9a54-537419234d0f_size2000x2000_cropCenter.jpg'
            ],
            [
                'name'=>'MEN\'S T-SHIRT',
                'category_id'=>1,
                'price'=>120,
                'pub_date'=>'2022-03-31 14:00:00',
                'image'=>'/phptutor/mvcproj/static/img/28c6cd45-3083-4eac-a548-7d235efb2602_size2000x2000_cropCenter.jpg'
            ],
            [
                'name'=>'WOMEN\'S T-SHIRT',
                'category_id'=>1,
                'price'=>110,
                'pub_date'=>'2022-03-31 14:00:00',
                'image'=>'/phptutor/mvcproj/static/img/8c16e3db-99b3-4e62-b7a5-50a9ef1eb1af_size2000x2000_cropCenter.jpg'
            ],
            [
                'name'=>'WOMEN\'S V-NECK T-SHIRT',
                'category_id'=>1,
                'price'=>110,
                'pub_date'=>'2022-03-31 14:00:00',
                'image'=>'/phptutor/mvcproj/static/img/cc8f3f97-a5e0-47dd-816c-a6c4a56f438e_size2000x2000_cropCenter.jpg'
            ],
            [
                'name'=>'CARNABY EVO TRI 1 MEN\'S SNEAKERS',
                'category_id'=>3,
                'price'=>150,
                'pub_date'=>'2022-03-31 14:00:00',
                'image'=>'/phptutor/mvcproj/static/img/1dc0f0cc-be80-4718-b8eb-8d28f4cd57e8_size2000x2000_cropCenter.jpg'
            ],
            [
                'name'=>'LA PIQUÉE 120 1 WOMEN\'S TEXTILE SNEAKERS',
                'category_id'=>3,
                'price'=>150,
                'pub_date'=>'2022-03-31 14:00:00',
                'image'=>'/phptutor/mvcproj/static/img/2487aceb-b49f-490a-ad4a-7c135d8d8a41_size2000x2000_cropCenter.jpg'
            ]
        ];

        $this->table('product')
            ->insert($data)
            ->update();
    }
}
