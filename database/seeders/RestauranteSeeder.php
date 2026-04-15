<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\ItemPedido;

class RestauranteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fornecedores
        $f1 = Fornecedor::create([
            'nome' => 'Distribuidora de Carnes Gourmet',
            'cnpj' => '12.345.678/0001-90',
            'email' => 'contato@carnesgourmet.com',
            'telefone' => '(11) 98888-7777',
            'status' => 'Ativo'
        ]);

        $f2 = Fornecedor::create([
            'nome' => 'Hortifruti Fresco do Dia',
            'cnpj' => '98.765.432/0001-10',
            'email' => 'vendas@hortifritifresco.com',
            'telefone' => '(11) 97777-6666',
            'status' => 'Ativo'
        ]);

        $f3 = Fornecedor::create([
            'nome' => 'Adega e Bebidas Importadas',
            'cnpj' => '55.444.333/0001-22',
            'email' => 'comercial@adegaimport.com',
            'telefone' => '(11) 96666-5555',
            'status' => 'Ativo'
        ]);

        // 2. Produtos
        $p1 = Produto::create(['nome' => 'Picanha Argentina (kg)', 'descricao' => 'Corte premium maturada', 'codigo_interno' => 'CAR001', 'status' => 'Ativo']);
        $p2 = Produto::create(['nome' => 'Filé Mignon Premium (kg)', 'descricao' => 'Limpo e porcionado', 'codigo_interno' => 'CAR002', 'status' => 'Ativo']);
        $p3 = Produto::create(['nome' => 'Tomate Cereja (Bandeja)', 'descricao' => 'Docinho e fresco', 'codigo_interno' => 'HOR001', 'status' => 'Ativo']);
        $p4 = Produto::create(['nome' => 'Alface Hidropônica (Un)', 'descricao' => 'Direto do produtor', 'codigo_interno' => 'HOR002', 'status' => 'Ativo']);
        $p5 = Produto::create(['nome' => 'Azeite Trufado (500ml)', 'descricao' => 'Essência de trufas negras', 'codigo_interno' => 'BEB001', 'status' => 'Ativo']);
        $p6 = Produto::create(['nome' => 'Vinho Tinto Reserva (750ml)', 'descricao' => 'Safra 2019 Cabernet', 'codigo_interno' => 'BEB002', 'status' => 'Ativo']);

        // 3. Vincular Produtos aos Fornecedores
        $f1->produtos()->attach([$p1->id, $p2->id]);
        $f2->produtos()->attach([$p3->id, $p4->id]);
        $f3->produtos()->attach([$p5->id, $p6->id]);

        // 4. Pedidos
        // Pedido 1 - Carnes
        $ped1 = Pedido::create([
            'fornecedor_id' => $f1->id,
            'data_pedido' => now()->subDays(2),
            'status' => 'Concluído',
            'observacoes' => 'Entrega realizada no período da manhã.'
        ]);
        $ped1->itens()->create(['produto_id' => $p1->id, 'quantidade' => 10, 'valor_unitario' => 85.00, 'valor_total' => 850.00]);
        $ped1->itens()->create(['produto_id' => $p2->id, 'quantidade' => 5, 'valor_unitario' => 110.00, 'valor_total' => 550.00]);

        // Pedido 2 - Hortifruti
        $ped2 = Pedido::create([
            'fornecedor_id' => $f2->id,
            'data_pedido' => now()->subDay(),
            'status' => 'Aberto',
            'observacoes' => 'Pedir tomates bem maduros.'
        ]);
        $ped2->itens()->create(['produto_id' => $p3->id, 'quantidade' => 20, 'valor_unitario' => 7.50, 'valor_total' => 150.00]);
        $ped2->itens()->create(['produto_id' => $p4->id, 'quantidade' => 30, 'valor_unitario' => 3.20, 'valor_total' => 96.00]);

        // Pedido 3 - Bebidas
        $ped3 = Pedido::create([
            'fornecedor_id' => $f3->id,
            'data_pedido' => now(),
            'status' => 'Processando',
            'observacoes' => 'Urgente para o final de semana.'
        ]);
        $ped3->itens()->create(['produto_id' => $p5->id, 'quantidade' => 6, 'valor_unitario' => 145.00, 'valor_total' => 870.00]);
        $ped3->itens()->create(['produto_id' => $p6->id, 'quantidade' => 12, 'valor_unitario' => 98.00, 'valor_total' => 1176.00]);
    }
}
