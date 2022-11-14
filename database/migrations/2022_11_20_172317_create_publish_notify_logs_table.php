<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishNotifyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publish_notify_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('發送者');
            $table->string('message')->comment('發送內容');
            $table->string('chat_name')->comment('群組名稱');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publish_notify_logs');
    }
}
