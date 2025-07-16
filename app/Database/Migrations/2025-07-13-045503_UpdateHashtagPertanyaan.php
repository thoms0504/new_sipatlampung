<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateHashtagPertanyaan extends Migration
{
    public function up()
    {
        $fields = [
            'hashtags' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'Hashtag dalam format JSON array'
            ]
        ];
        $this->forge->addColumn('pertanyaan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pertanyaan', 'hashtags');
    }
}
