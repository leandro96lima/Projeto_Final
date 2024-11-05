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
        // Remove tipos duplicados
        $types = array_unique($types);

        // Função para normalizar o tipo
        $normalizeType = fn($type) => strtoupper(str_replace([' ', 'ã'], ['_', 'A'], $type));

        // Cria os casos do enum
        $cases = array_map(fn($type) => "    case " . $normalizeType($type) . " = '$type';", $types);

        // Usa implode sem vírgula final
        $casesString = implode("\n", $cases);

        return "<?php\n\nnamespace App\Enums;\n\nenum EquipmentType: string\n{\n$casesString\n}\n";
    }
}
