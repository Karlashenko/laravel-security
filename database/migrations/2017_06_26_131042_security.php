<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Security extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('security_policies', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name')->unique();
            $table->string('subject');
            $table->string('resource');
            $table->jsonb('properties');
            $table->string('action');
            $table->string('algorithm');
            $table->timestamps();

            $table->index(['subject', 'resource', 'action']);
        });

        Schema::create('security_rules', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name')->unique();
            $table->string('effect');
            $table->jsonb('condition')->index();
            $table->timestamps();
        });

        Schema::create('security_policies_rules', function (Blueprint $table) {
            $table->integer('policy_id')->unsigned();
            $table->integer('rule_id')->unsigned();

            $table->foreign('policy_id')
                  ->references('id')
                  ->on('security_policies')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('rule_id')
                  ->references('id')
                  ->on('security_rules')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->primary(['policy_id', 'rule_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('security_policies_rules');
        Schema::drop('security_policies');
        Schema::drop('security_rules');
    }
}
