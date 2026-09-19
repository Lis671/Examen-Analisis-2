<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VerificarEntorno extends Command
{
    protected $signature = 'citas:verificar-entorno';

    protected $description = 'Verifica conexion MySQL (Docker), migraciones y datos semilla. Uso para evidencia de RQNF-01/02.';

    public function handle(): int
    {
        $this->newLine();
        $this->line('=== Verificacion del entorno (RQNF-01/02) ===');

        $this->table(['Atributo', 'Valor'], [
            ['Driver', config('database.default')],
            ['Host', config('database.connections.mysql.host')],
            ['Puerto', config('database.connections.mysql.port')],
            ['Base de datos', config('database.connections.mysql.database')],
            ['Usuario', config('database.connections.mysql.username')],
        ]);

        $this->newLine();
        $this->line('1) Conexion MySQL (contenedor Docker)...');
        try {
            $ver = DB::selectOne('SELECT VERSION() AS v');
            $this->info("   OK - MySQL server version: {$ver->v}");
        } catch (\Throwable $e) {
            $this->error('   Fallo de conexion. Ejecute: docker compose up -d');
            $this->error('   ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->line('2) Migraciones aplicadas...');
        try {
            $totalMigs = collect(DB::select(
                'SELECT COUNT(*) AS n FROM information_schema.tables WHERE table_schema = ? AND table_name IN ("doctores","pacientes","citas")',
                [config('database.connections.mysql.database')]
            ))->first()->n;
            if ((int) $totalMigs === 3) {
                $this->info('   OK - tablas doctores, pacientes y citas presentes');
            } else {
                $this->warn('   Advertencia: se esperaban 3 tablas, se encontraron ' . $totalMigs);
            }
        } catch (\Throwable $e) {
            $this->warn('   No se pudo inspeccionar tablas: ' . $e->getMessage());
        }

        $this->line('3) Datos semilla...');
        $counts = [];
        foreach (['doctores', 'pacientes', 'citas'] as $t) {
            $counts[] = [$t, DB::table($t)->count()];
        }
        $this->table(['Tabla', 'Registros'], $counts);

        $this->newLine();
        $this->info('Listo. El entorno esta operativo.');
        return self::SUCCESS;
    }
}
