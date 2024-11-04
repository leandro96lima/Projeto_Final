# Caminho para o arquivo de configuração

$configFile = "config\phpstorm\bookmarks.zip"

# Verifica se o arquivo existe

if (Test-Path $configFile) {
    Write-Host "Importando configurações do PHPStorm..."
    
    # Extrai o arquivo

    Expand-Archive -Path $configFile -DestinationPath "$env:USERPROFILE\.PhpStorm*\config" -Force  # Altere conforme necessário
    
    Write-Host "Configurações importadas com sucesso!"
} else {
    Write-Host "Arquivo de configuração não encontrado: $configFile"
}