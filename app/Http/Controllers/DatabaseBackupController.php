<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseBackupController extends Controller
{
    public function index()
    {
        return view('database/Export');
    }
    public function export()
    {
        $db_host = env('DB_HOST');
        $db_name = env('DB_DATABASE');
        $db_user = env('DB_USERNAME');
        $db_pass = env('DB_PASSWORD');
    
        $timestamp = date('Y-m-d-H-i-s');
        $backup_file = storage_path("app/backup_{$timestamp}.sql");
    
        \Log::info("Generando respaldo: {$backup_file}");
    
        $command = "\"C:\\xampp\\mysql\\bin\\mysqldump\" " .
            "--host=" . escapeshellarg($db_host) . " " .
            "--user=" . escapeshellarg($db_user) . " " .
            "--password=" . escapeshellarg($db_pass) . " " .
            escapeshellarg($db_name) . " > " . escapeshellarg($backup_file) . " 2>&1";
    
        $output = [];
        $return_var = null;
        exec($command, $output, $return_var);
    
        if ($return_var === 0) {
            return response()->download($backup_file)->deleteFileAfterSend(true);
        } else {
            $error_message = implode("\n", $output);
            \Log::error('Error en la exportación de la base de datos', ['output' => $error_message]);
            return response()->json(['error' => 'Error al generar la copia de seguridad.', 'details' => $error_message], 500);
        }
    }
    
public function import(Request $request)
    {
       // Validar que el archivo sea un archivo .sql o .txt
    $request->validate([
        'database_file' => 'required|file|max:2048', // Validación básica para el tamaño
        'option' => 'required|in:clear,append,clear_data', // Validación de las opciones
    ]);

    $file = $request->file('database_file');
    $fileName = $file->getClientOriginalName();
    $filePath = $file->getRealPath();
    $fileMime = $file->getMimeType(); // Esto estará vacío si no se detecta el MIME

    // Validar extensión manualmente si el MIME está vacío
    if ($fileMime === null || $fileMime === '') {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($ext !== 'sql') {
            return response()->json(['error' => 'El archivo debe ser un archivo SQL (.sql).'], 400);
        }
    }

    // Obtener la opción seleccionada
    $option = $request->input('option');

    // Obtener credenciales desde .env
    $db_host = env('DB_HOST');
    $db_name = env('DB_DATABASE');
    $db_user = env('DB_USERNAME');
    $db_pass = env('DB_PASSWORD');

    // Ruta completa al ejecutable de MySQL (ajusta esta ruta si usas otro sistema)
    $mysqlPath = "C:\\xampp\\mysql\\bin\\mysql";

    try {
        // Comando inicial para importar el archivo
        $command = "\"{$mysqlPath}\" -h {$db_host} -u {$db_user} " . (!empty($db_pass) ? "-p'{$db_pass}' " : "") . "{$db_name} < \"{$filePath}\"";

        switch ($option) {
            case 'clear':
                // Eliminar todo antes de importar (Drop DB y crear de nuevo)
                $this->dropAndCreateDatabase($db_name, $db_host, $db_user, $db_pass, $mysqlPath);
                break;

            case 'append':
                // Mantener lo anterior y agregar datos nuevos (solo insert)
                break;

            case 'clear_data':
                // Borrar solo los datos pero mantener las tablas (TRUNCATE)
                $this->clearData($db_name, $db_host, $db_user, $db_pass, $mysqlPath);
                break;
        }

        // Ejecutar el comando para importar el archivo SQL
        $process = Process::fromShellCommandline($command);
        $process->run();

        // Verificar si la ejecución fue exitosa
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json(['message' => 'Base de datos importada correctamente.'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al importar la base de datos: ' . $e->getMessage()], 500);
    }
}

    /**
     * Elimina la base de datos y la recrea.
     */
    private function dropAndCreateDatabase($db_name, $db_host, $db_user, $db_pass, $mysqlPath)
    {
        // Eliminar la base de datos y crearla de nuevo
        $dropCommand = "\"{$mysqlPath}\" -h {$db_host} -u {$db_user} " . (!empty($db_pass) ? "-p'{$db_pass}' " : "") . "-e \"DROP DATABASE IF EXISTS {$db_name}; CREATE DATABASE {$db_name};\"";
        $process = Process::fromShellCommandline($dropCommand);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * Borrar solo los datos de las tablas pero mantener la estructura.
     */
    private function clearData($db_name, $db_host, $db_user, $db_pass, $mysqlPath)
    {
        // Obtener la lista de tablas en la base de datos
        $listTablesCommand = "\"{$mysqlPath}\" -h {$db_host} -u {$db_user} " . (!empty($db_pass) ? "-p'{$db_pass}' " : "") . "-e \"USE {$db_name}; SHOW TABLES;\"";
        $process = Process::fromShellCommandline($listTablesCommand);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Obtener el resultado de las tablas
        $tables = explode("\n", trim($process->getOutput()));
        array_shift($tables); // Remover el encabezado

        foreach ($tables as $table) {
            // Ejecutar TRUNCATE para cada tabla
            $clearDataCommand = "\"{$mysqlPath}\" -h {$db_host} -u {$db_user} " . (!empty($db_pass) ? "-p'{$db_pass}' " : "") . "-e \"USE {$db_name}; TRUNCATE TABLE {$table};\"";
            $process = Process::fromShellCommandline($clearDataCommand);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        }
    }
  
    
}
