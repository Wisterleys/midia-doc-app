<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accessory;
use App\Models\Notebook;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accessories = [
            [
                'name' => 'Mouse sem fio Logitech MX Master 3',
                'description' => 'Mouse ergonômico sem fio com scroll ultrarrápido e compatibilidade multi-device',
                'brand' => 'Logitech'
            ],
            [
                'name' => 'Teclado mecânico Keychron K8',
                'description' => 'Teclado mecânico Bluetooth/USB com switches Gateron e retroiluminação RGB',
                'brand' => 'Keychron'
            ],
            [
                'name' => 'Cabo HDMI 2.1 Ultra High Speed',
                'description' => 'Cabo HDMI suportando 8K@60Hz e 4K@120Hz com ethernet e ARC',
                'brand' => 'Belkin'
            ],
            [
                'name' => 'Dock Station Thunderbolt 4',
                'description' => 'Hub com 4 portas Thunderbolt 4, saída 8K, carregamento de 90W e slots SD',
                'brand' => 'CalDigit'
            ],
            [
                'name' => 'Mochila para Notebook Targus',
                'description' => 'Mochila executiva com compartimento à prova d\'água para notebook até 17"',
                'brand' => 'Targus'
            ],
            [
                'name' => 'Webcam Full HD Logitech C920',
                'description' => 'Webcam com autofoco, microfone estéreo e resolução 1080p',
                'brand' => 'Logitech'
            ],
            [
                'name' => 'Suporte para Notebook Elevador',
                'description' => 'Suporte ergonômico ajustável em alumínio para melhor posicionamento',
                'brand' => 'Nulaxy'
            ],
            [
                'name' => 'Mouse Pad HyperX Fury S',
                'description' => 'Mouse pad extra grande (900x420mm) com superfície de baixo atrito',
                'brand' => 'HyperX'
            ],
            [
                'name' => 'Carregador Portátil 10000mAh',
                'description' => 'Power bank com PD 20W e saída USB-C para carregamento rápido',
                'brand' => 'Anker'
            ],
            [
                'name' => 'Fone de Ouvido Bluetooth Sony WH-1000XM4',
                'description' => 'Fones com cancelamento de ruído e 30h de bateria',
                'brand' => 'Sony'
            ],
            [
                'name' => 'Monitor Portátil 15.6" Full HD',
                'description' => 'Monitor USB-C touchscreen com capa protetora e suporte HDR',
                'brand' => 'ASUS'
            ],
            [
                'name' => 'Adaptador USB-C para HDMI/VGA',
                'description' => 'Conversor digital para múltiplas saídas com suporte a 4K',
                'brand' => 'UGreen'
            ],
            [
                'name' => 'Cooler para Notebook com 6 Ventoinhas',
                'description' => 'Base refrigeradora com ajuste de altura e controle de velocidade',
                'brand' => 'Havit'
            ],
            [
                'name' => 'Pelicula Protetora Anti-Reflexo',
                'description' => 'Pelicula matte para tela de notebook 15.6" com proteção contra riscos',
                'brand' => 'Mr.Shield'
            ],
            [
                'name' => 'Hub USB 3.0 com 7 Portas',
                'description' => 'Hub com portas USB 3.0, leitor de cartões SD e microSD',
                'brand' => 'Sabrent'
            ],
            [
                'name' => 'Cadeira Gamer Ergonômica',
                'description' => 'Cadeira com apoio lombar, reclinável e braços 3D ajustáveis',
                'brand' => 'DXRacer'
            ],
            [
                'name' => 'Kit Limpeza para Eletrônicos',
                'description' => 'Kit com spray limpa-telas, pano de microfibra e escova de precisão',
                'brand' => 'iKlear'
            ],
            [
                'name' => 'SSD Externo Samsung T7 1TB',
                'description' => 'SSD portátil USB 3.2 com velocidades até 1050MB/s e resistente a quedas',
                'brand' => 'Samsung'
            ],
            [
                'name' => 'Cabo de Rede CAT 8',
                'description' => 'Cabo Ethernet blindado 40Gbps com conectores dourados',
                'brand' => 'DbillionDa'
            ],
            [
                'name' => 'Luminária USB para Notebook',
                'description' => 'Luminária LED ajustável com braço flexível e conexão USB',
                'brand' => 'BenQ'
            ]
        ];

        foreach ($accessories as $data) {
            $accessory = Accessory::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}