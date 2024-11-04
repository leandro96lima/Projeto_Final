<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipment;

class GenerateEquipmentTypeEnum extends Command
{
    protected $signature = 'generate:equipment-type-enum';
    protected $description = 'Gera um enum de tipos de equipamento a partir dos tipos aprovados';

    public function handle()
    {
        // Obter todos os tipos únicos de equipamentos aprovados
        $types = Equipment::where('is_approved', true)->pluck('type')->unique()->toArray();

        // Combina os tipos existentes do enum
        $officialTypes = array_column(\App\Enums\EquipmentType::cases(), 'value');
        $allTypes = array_merge($officialTypes, $types);

        // Gera o conteúdo do enum
        $enumContent = $this->generateEnumContent($allTypes);

        // Escreve o novo enum em um arquivo
        file_put_contents(app_path('Enums/EquipmentType.php'), $enumContent);

        $this->info('Enum de tipos de equipamento gerado com sucesso!');
    }

    protected function generateEnumContent(array $types): string
    {
        $cases = implode(",\n        ", array_map(fn($type) => "    case " . strtoupper(str_replace(' ', '_', $type)) . " = '$type';", $types));

        return "<?php\n\nnamespace App\Enums;\n\nenum EquipmentType: string\n{\n        $cases\n}\n";
    }
}
