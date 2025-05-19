<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsedToFramesTable extends Migration
{
    public function up()
    {
        Schema::table('frames', function (Blueprint $table) {
            $table->unsignedBigInteger('used')->default(0)->after('price');
        });
    }

    public function down()
    {
        Schema::table('frames', function (Blueprint $table) {
            $table->dropColumn('used');
        });
    }
}
