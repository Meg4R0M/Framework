<?php
namespace App\Blog\db;

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreatePostsTable extends AbstractMigration
{

    public function change()
    {
        $this->table('posts')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_LONG])
            ->addColumn('updated_at', 'datetime')
            ->addColumn('created_at', 'datetime')
            ->create();
    }
}
