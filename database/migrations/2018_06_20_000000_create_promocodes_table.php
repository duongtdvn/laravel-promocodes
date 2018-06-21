<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/20/18
 * Time: 4:56 PM
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->decimal('reward', 12, 2);
            $table->json('data')->nullable();
            $table->boolean('is_disposable')->default(false);
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });

        Schema::create('promocode_user', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('promocode_id');
            $table->timestamp('used_at');
            $table->primary(['user_id', 'promocode_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('promocode_id')->references('id')->on('promocodes');
        });
    }
}