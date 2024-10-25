<?php

namespace App\Enums;

enum EquipmentType: string
{
    case COMPUTER = 'Computador';
    case PRINTER = 'Impressora';
    case TELEPHONE = 'Telefone';
    case TELEVISION = 'Televisão';
    case TABLET = 'Tablet';
    case LAPTOP = 'Laptop';
    case SMARTPHONE = 'Smartphone';
    case SCANNER = 'Scanner';
    case PROJECTOR = 'Projetor';
    case MONITOR = 'Monitor';

    // Você pode adicionar mais equipamentos eletrônicos conforme necessário
}
