<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout($id) {
        $propiedad = Propiedad::findOrFail($id);
        
        return view('inquilino.checkout', compact('propiedad'));
    }

    public function store(Request $request) {
        $propiedad = Propiedad::findOrFail($request->propiedad_id);
        
        // VALIDACIÓN: Si ya no está libre, regresamos con error
        if ($propiedad->status !== 'libre') {
            return redirect()->back()->with('error', 'Lo sentimos, esta propiedad ya ha sido rentada.');
        }
        
        Stripe::setApiKey(config('services.stripe.secret'));
        
        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'MXN',
                    'product_data' => ['name' => $propiedad->titulo],
                    'unit_amount' => $propiedad->precio * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            // Pasamos el ID de la propiedad por la URL para procesarlo al volver
            'success_url' => route('checkout.success') . '?propiedad_id=' . $propiedad->id . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.index', ['id' => $propiedad->id]),
        ]);
        
        return redirect()->away($session->url);
    }

    public function success(Request $request) {
        // 1. Validar que recibimos el ID de la propiedad desde la URL
        $propiedadId = $request->query('propiedad_id');
        $propiedad = \App\Models\Propiedad::findOrFail($propiedadId);

        // 2. Crear la renta con fechas automáticas
        \App\Models\Renta::create([
            'propiedad_id'  => $propiedad->id,
            'user_id'       => auth()->id(),
            'arrendador_id' => $propiedad->user_id, // El dueño original
            'monto'         => $propiedad->precio,
            'fecha_inicio'  => now(),              // Fecha actual
            'fecha_fin'     => now()->addMonth(),  // Dentro de un mes
            'stripe_id'     => $request->query('session_id'),
        ]);

        // 3. Actualizar el estado de la propiedad
        $propiedad->update(['status' => 'ocupado']);

        return redirect()->route('inquilino.rentas')->with('success', 'Pago exitoso. ¡Bienvenido a tu nuevo hogar!');
    }

    public function cancel() {
        return redirect()->back()->with('info', 'El pago fue cancelado.');
    }
}