********************************************************* Step : 1 In web.php ************************************************************************************************

Route::get('/create-model-and-migration/{name}', function ($name) {
    Artisan::call('make:model', [
        'name' => $name,
        '--migration' => true, 
    ]);
    dd("Model and migration created successfully for: {$name}");
});




********************************************************** Step : 2 database/migrations/2024_12_12_050641_create_contact_us_table.php *****************************************

  public function up(): void
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email'); 
            $table->string('mobile_no'); 
            $table->string('message'); 
            $table->timestamps();
        });
    }


********************************************************** Step : 3 i run specific migration   ********************************************************************************

Route::get('/run-migrate', function () {
    try {
        Artisan::call('migrate', [
            '--path' => 'database/migrations/2024_12_12_050641_create_contact_us_table.php',
        ]);
        dd("Migration for `contact_us` table ran successfully!");
    } catch (Exception $e) {
        dd("Error running the migration: " . $e->getMessage());
    }
});



