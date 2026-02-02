<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Propiedad;
use App\Models\Propropiedad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PropiedadController
 */
final class PropiedadControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $propiedads = Propiedad::factory()->count(3)->create();

        $response = $this->get(route('propiedads.index'));

        $response->assertOk();
        $response->assertViewIs('arrendador.index');
        $response->assertViewHas('propiedad');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('propiedads.create'));

        $response->assertOk();
        $response->assertViewIs('froms.registrarprop');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropiedadController::class,
            'store',
            \App\Http\Requests\PropiedadStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $titulo = fake()->word();
        $tipo_prop = fake()->word();
        $barrio = fake()->word();
        $calle = fake()->word();
        $numero_calle = fake()->word();
        $precio = fake()->randomFloat(/** decimal_attributes **/);
        $forma_pago = fake()->word();
        $servicio = fake()->word();
        $reglas = fake()->word();
        $cercanias = fake()->word();
        $imagen = fake()->word();
        $descripcion = fake()->text();

        $response = $this->post(route('propiedads.store'), [
            'titulo' => $titulo,
            'tipo_prop' => $tipo_prop,
            'barrio' => $barrio,
            'calle' => $calle,
            'numero_calle' => $numero_calle,
            'precio' => $precio,
            'forma_pago' => $forma_pago,
            'servicio' => $servicio,
            'reglas' => $reglas,
            'cercanias' => $cercanias,
            'imagen' => $imagen,
            'descripcion' => $descripcion,
        ]);

        $propiedads = Propiedad::query()
            ->where('titulo', $titulo)
            ->where('tipo_prop', $tipo_prop)
            ->where('barrio', $barrio)
            ->where('calle', $calle)
            ->where('numero_calle', $numero_calle)
            ->where('precio', $precio)
            ->where('forma_pago', $forma_pago)
            ->where('servicio', $servicio)
            ->where('reglas', $reglas)
            ->where('cercanias', $cercanias)
            ->where('imagen', $imagen)
            ->where('descripcion', $descripcion)
            ->get();
        $this->assertCount(1, $propiedads);
        $propiedad = $propiedads->first();

        $response->assertRedirect(route('arrendador.index'));
        $response->assertSessionHas('Propiedad.titulo', $Propiedad->titulo);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $propiedad = Propiedad::factory()->create();
        $propiedad = Propropiedad::factory()->create();

        $response = $this->get(route('propiedads.edit', $propiedad));

        $response->assertOk();
        $response->assertViewIs('arrendador.forms.');
        $response->assertViewHas('propiedad', $propiedad);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropiedadController::class,
            'update',
            \App\Http\Requests\PropiedadUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $propiedad = Propiedad::factory()->create();
        $titulo = fake()->word();
        $tipo_prop = fake()->word();
        $barrio = fake()->word();
        $calle = fake()->word();
        $numero_calle = fake()->word();
        $precio = fake()->randomFloat(/** decimal_attributes **/);
        $forma_pago = fake()->word();
        $servicio = fake()->word();
        $reglas = fake()->word();
        $cercanias = fake()->word();
        $imagen = fake()->word();

        $response = $this->put(route('propiedads.update', $propiedad), [
            'titulo' => $titulo,
            'tipo_prop' => $tipo_prop,
            'barrio' => $barrio,
            'calle' => $calle,
            'numero_calle' => $numero_calle,
            'precio' => $precio,
            'forma_pago' => $forma_pago,
            'servicio' => $servicio,
            'reglas' => $reglas,
            'cercanias' => $cercanias,
            'imagen' => $imagen,
        ]);

        $propiedad->refresh();

        $response->assertRedirect(route('arrendador.index'));
        $response->assertSessionHas('Propiedad.titulo', $Propiedad->titulo);

        $this->assertEquals($titulo, $propiedad->titulo);
        $this->assertEquals($tipo_prop, $propiedad->tipo_prop);
        $this->assertEquals($barrio, $propiedad->barrio);
        $this->assertEquals($calle, $propiedad->calle);
        $this->assertEquals($numero_calle, $propiedad->numero_calle);
        $this->assertEquals($precio, $propiedad->precio);
        $this->assertEquals($forma_pago, $propiedad->forma_pago);
        $this->assertEquals($servicio, $propiedad->servicio);
        $this->assertEquals($reglas, $propiedad->reglas);
        $this->assertEquals($cercanias, $propiedad->cercanias);
        $this->assertEquals($imagen, $propiedad->imagen);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $propiedad = Propiedad::factory()->create();

        $response = $this->delete(route('propiedads.destroy', $propiedad));

        $response->assertRedirect(route('arrendador.index'));

        $this->assertModelMissing($propiedad);
    }
}
