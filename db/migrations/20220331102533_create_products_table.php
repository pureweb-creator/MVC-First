<?php

use Phinx\Migration\AbstractMigration;

class CreateProductsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('product')
            ->addColumn('name','string',['limit'=>'50','null'=>false])
            ->addColumn('category_id','integer',['limit'=>'3','null'=>false])
            ->addColumn('price','integer',['limit'=>'5','null'=>false])
            ->addColumn('pub_date','datetime',['null'=>false])
            ->addColumn('image','string',['null'=>false])
            ->create();
    }
}
