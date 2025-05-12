<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tasks = [
            [
                'title' => 'Comprar pão',
                'description' => 'Pão integral na padaria da esquina',
                'status' => 'pending',
            ],
            [
                'title' => 'Estudar Laravel',
                'description' => 'Assistir vídeos e praticar migrations',
                'status' => 'done',
            ],
            [
                'title' => 'Atualizar currículo',
                'description' => 'Adicionar últimos projetos no GitHub',
                'status' => 'pending',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
