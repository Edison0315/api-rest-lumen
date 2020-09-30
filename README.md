// ***********
// Primer paso
// ***********

1) Descomentar las lineas de:

$app->withFacades();

$app->withEloquent();

en el archivo ubicado en: /boostrap/app

// ************
// Segundo paso
// ************

2) Crear migraciones y seeder (No olvidar llamar el seeder del database seeder)

php artisan make:migration nombre
php artisan make:seeder seedername

En el archivo del DatabaseSeeder:
$this→call(DirectorioSeeder::class);

php artisan migrate:fresh –seed

// ************
// Tercer paso
// ************

3) Crear modelo, y controlador y el resto ya OK
