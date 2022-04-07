<?php

use Phinx\Migration\AbstractMigration;

class ChangeUserTableColumnType extends AbstractMigration
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
        if ($this->table('user')->hasColumn('email'))
            $this->table('user')->changeColumn('email', 'string',['limit'=>319])->update();

        if ($this->table('user')->hasColumn('password'))
            $this->table('user')->changeColumn('password', 'binary',['limit'=>60])->update();
    }
}
