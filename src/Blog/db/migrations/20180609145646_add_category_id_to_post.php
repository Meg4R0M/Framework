<?php


use Phinx\Migration\AbstractMigration;

class AddCategoryIdToPost extends AbstractMigration
{

    public function change()
    {
        $this->table('posts')
            ->addColumn('categoryId', 'integer', ['null' => true])
            ->addForeignKey('categoryId', 'categories', 'id', [
                'delete' => 'SET NULL'
            ])
            ->update();
    }
}
