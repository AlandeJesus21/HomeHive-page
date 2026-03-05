    <?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Barryvdh\DomPDF\Facade\Pdf;
    use Illuminate\Http\Request;

    class AdminController extends Controller
    {

        public function index()
        {
            $users = User::all();
            return view('admin.usuarios.index', compact('users'));
        }

        public function reporteuser() {
            $users = User::where('rol', 'inquilino')    
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();

            $pdf = Pdf::loadView('admin.reporte.reporteuser', [
                'users' => $users
            ]);

            return $pdf->stream();

        }

        public function indexad() 
        {
            $users = User::all();
            return view('admin.index', compact('users'));
        }

        public function edit($id)
        {
            $user = User::findOrFail($id);
            return view('admin.usuarios.edit', compact('user'));
        }


        public function update(Request $request, $id)
        {
            $user = User::findOrFail($id);

            $user->update($request->all());

            return redirect()->route('admin.index')
                ->with('success', 'Usuario actualizado correctamente');
        }


        public function destroy($id)
        {
            User::destroy($id);

            return redirect()->route('admin.index')
                ->with('success', 'Usuario eliminado correctamente');
        }
    }