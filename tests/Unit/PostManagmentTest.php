<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class PostManagmentTest extends TestCase
{    
    /** @test */
    public function a_post_can_be_created(){

        $response = $this->post('/api/tareas', [
            'titulo' => 'Aqui va el titulo',
            'tarea'  => 'Aqui va la tarea',            
            'fecha'  => '2013-12-01 12:00:00',            
            'user_id'  => 1,            
        ]);

        $response->assertStatus(201);

    }
}
