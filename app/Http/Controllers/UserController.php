<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Pest\Support\Str;
use App\Models\User;
use App\Models\Review;
use App\Models\Propiedad;

class UserController extends Controller
{
    /** Mostrar formulario de edición */
    public function edit()
    {
        return view('perfil');
    }

    /** Guardar cambios del perfil */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|min:6|confirmed'
        ]);

        // Actualizar datos básicos
        $user->name = $request->name;
        $user->email = $request->email;

        // Subir imagen si viene
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/perfiles'), $filename);
            $user->profile_photo = $filename;
        }

        // Cambiar password solo si se escribió algo
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Redirigir según rol
        // Redirigir según rol
if ($user->rol === 'arrendador') {
    return redirect()->route('arrendador.index')
        ->with('success', 'Perfil actualizado correctamente.');
}

if ($user->rol === 'inquilino') {
    return redirect()->route('inquilino.index')
        ->with('success', 'Perfil actualizado correctamente.');
}

if ($user->rol === 'admin') {
    return redirect()->route('admin.index')
        ->with('success', 'Perfil actualizado correctamente.');
}

// Si no tiene rol definido, ir a home
return redirect()->route('home')
    ->with('success', 'Perfil actualizado correctamente.');

    }

    public function Login(Request $request) {
        //intentamos hacer el inicio de sesión
        if (Auth::attempt(['email' => $request->e, 'password' => $request->p])){
            //si los datos fueron correctos podemos obtener el usuario
            $usuario = Auth::user();

            //generaremos la llave (token) para las api´s
            $token = Str::random(60);
            $usuario->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();

            //se envia una respuesta en formato json con el token y los datos del usuario
            return json_encode(['respuesta' => 'Bienvenido', 'token' => $token, 'datos' => $usuario]);
        }

        return '{"respuesta": "Denegado"}';
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}

public function favoritos()
{
    return $this->belongsToMany(Propiedad::class, 'favoritos');
}

public function index()
    {
        $users = User::all();
        return view('admin.usuarios.index', compact('users'));
    }


    public function editar($id)
    {
        $user = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('user'));
    }


    public function actualizar(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return redirect()->route('user.index')
            ->with('success', 'Usuario actualizado correctamente');
    }


    public function eliminar($id)
    {
        User::destroy($id);

        return redirect()->route('admin.index')
            ->with('success', 'Usuario eliminado correctamente');
    }




}