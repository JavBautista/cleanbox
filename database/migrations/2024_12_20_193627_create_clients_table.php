<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('active')->default(1);
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('movil')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('number_out')->nullable();
            $table->string('number_int')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->string('reference')->nullable();
            $table->string('detail')->nullable();
            $table->text('observations')->nullable();
            $table->string('plan_name')->nullable();
            $table->string('plan_price')->nullable();
            $table->string('plan_cutoff')->nullable();
            $table->unsignedBigInteger('level')->default(1);
            $table->string('location_image')->nullable();
            $table->string('location_latitude')->nullable();
            $table->string('location_longitude')->nullable();
            $table->timestamps();

            // Establecemos la relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
