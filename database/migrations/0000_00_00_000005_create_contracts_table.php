<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(Config::get('amethyst.contract.data.contract.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->text('notes')->nullable();

            $table->integer('target_id')->unsigned();
            $table->foreign('target_id')->references('id')->on(Config::get('amethyst.target.data.target.table'));

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on(Config::get('amethyst.customer.data.customer.table'));

            $table->integer('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')->references('id')->on(Config::get('amethyst.tax.data.tax.table'));

            $table->string('country');
            $table->string('locale');
            $table->string('currency');

            $table->integer('payment_method_id')->unsigned()->nullable();
            $table->foreign('payment_method_id')->references('id')->on(Config::get('amethyst.taxonomy.data.taxonomy.table'));

            $table->date('started_at')->nullable();
            $table->date('suspended_at')->nullable();
            $table->date('terminated_at')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(Config::get('amethyst.contract.data.contract-product.table'), function (Blueprint $table) {
            $table->increments('id');

            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on(Config::get('amethyst.contract.data.contract.table'));
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on(Config::get('amethyst.product.data.product.table'));
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on(Config::get('amethyst.taxonomy.data.taxonomy.table'));

            $table->date('started_at')->nullable();
            $table->date('suspended_at')->nullable();
            $table->date('terminated_at')->nullable();

            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(Config::get('amethyst.contract.data.contract-product-consume.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on(Config::get('amethyst.contract.data.contract.table'));

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on(Config::get('amethyst.product.data.product.table'));

            $table->integer('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')->references('id')->on(Config::get('amethyst.tax.data.tax.table'));

            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on(Config::get('amethyst.taxonomy.data.taxonomy.table'));

            $table->float('price');
            $table->integer('value')->default(1);

            $table->text('notes')->nullable();
            $table->timestamp('billed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(Config::get('amethyst.contract.data.contract.table'));
        Schema::dropIfExists(Config::get('amethyst.contract.data.contract-product.table'));
        Schema::dropIfExists(Config::get('amethyst.contract.data.contract-product-consume.table'));
    }
}
