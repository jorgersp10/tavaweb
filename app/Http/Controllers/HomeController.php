<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use DB;
use Carbon\Carbon;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        
        if (view()->exists($request->path())) {
            $cheques_emitidos=DB::table('cheques_emitido as ch')
            ->join('bancos as b','b.id','=','ch.banco_id')
            ->join('clientes as c','c.id','=','ch.librador_id')
            //->join('clientes as c2','c2.id','=','ch.endosante_id')
            ->join('tipo_cheques as tc','tc.id','=','ch.tipo_cheque')
            ->join('users as u','u.id','=','ch.user_id')
            ->select('ch.id','ch.nro_cheque','b.descripcion as banco','c.nombre as librador',
            'ch.importe_cheque','ch.fec_venc','ch.estado as estado',
            'tc.id as tipo_cheque_id','tc.tipo_cheque',
            'u.name as usuario','ch.cuenta_corriente')
            ->where('ch.estado','=',1)
            ->orderBy('ch.fec_venc','asc')
            ->get();

            $cheques_recibidos=DB::table('cheques as ch')
            ->join('bancos as b','b.id','=','ch.banco_id')
            ->join('clientes as c','c.id','=','ch.librador_id')
            ->join('clientes as c2','c2.id','=','ch.endosante_id')
            ->join('tipo_cheques as tc','tc.id','=','ch.tipo_cheque')
            ->join('users as u','u.id','=','ch.user_id')
            ->select('ch.id','ch.nro_cheque','b.descripcion as banco','c.nombre as librador',
            'ch.importe_cheque','ch.fec_venc','c2.nombre as endosante','ch.estado as estado',
            'tc.id as tipo_cheque_id','tc.tipo_cheque',
            'u.name as usuario','ch.cuenta_corriente')
            ->where('ch.estado','=',1)
            ->orderBy('ch.fec_venc','asc')
            ->get();

            $now = Carbon::now();

            // $date1 = Carbon::now();
            // $date2 = "2015-02-16";
            // $diff = $date1->diffInDays($date2);
            //DB::select("CALL sp_update_pagos()");
            //dd( $diff);
            //FACTURAS PENDIENTES DE COBRO POR CAJA
            $cuotas_pagar = DB::table('cuotas as c')
            ->join('cuotas_det as cdet','cdet.cuota_id','=','c.id')
            ->join('clientes as cli','cli.id','=','c.cliente_id')
            //->join('ventas as v','v.id','=','c.factura_id')
            ->select('c.id','c.cliente_id','c.precio_inm as total','c.pagos_cuo as pagado','c.saldo_cuo as saldo',
            'cli.nombre as nombre','cdet.fec_vto as fecha','c.factura')
            ->where('cdet.estado_cuota','=',"P")
            ->orderby('cdet.fec_vto','desc')
            ->get();

            //dd($cuotas_pagar);

            return view($request->path(),["cheques_recibidos"=>$cheques_recibidos,
            "cheques_emitidos"=>$cheques_emitidos,"cuotas_pagar"=>$cuotas_pagar,"now"=>$now]);
        }
        return abort(404);
    }

    public function root()
    {
         $cheques_emitidos=DB::table('cheques_emitido as ch')
            ->join('bancos as b','b.id','=','ch.banco_id')
            ->join('clientes as c','c.id','=','ch.librador_id')
            //->join('clientes as c2','c2.id','=','ch.endosante_id')
            ->join('tipo_cheques as tc','tc.id','=','ch.tipo_cheque')
            ->join('users as u','u.id','=','ch.user_id')
            ->select('ch.id','ch.nro_cheque','b.descripcion as banco','c.nombre as librador',
            'ch.importe_cheque','ch.fec_venc','ch.estado as estado',
            'tc.id as tipo_cheque_id','tc.tipo_cheque',
            'u.name as usuario','ch.cuenta_corriente')
            ->where('ch.estado','=',1)
            ->orderBy('ch.fec_venc','asc')
            ->get();
            
            $cheques_recibidos=DB::table('cheques as ch')
            ->join('bancos as b','b.id','=','ch.banco_id')
            ->join('clientes as c','c.id','=','ch.librador_id')
            ->join('clientes as c2','c2.id','=','ch.endosante_id')
            ->join('tipo_cheques as tc','tc.id','=','ch.tipo_cheque')
            ->join('users as u','u.id','=','ch.user_id')
            ->select('ch.id','ch.nro_cheque','b.descripcion as banco','c.nombre as librador',
            'ch.importe_cheque','ch.fec_venc','c2.nombre as endosante','ch.estado as estado',
            'tc.id as tipo_cheque_id','tc.tipo_cheque',
            'u.name as usuario','ch.cuenta_corriente')
            ->where('ch.estado','=',1)
            ->orderBy('ch.fec_venc','asc')
            ->get();
           // DB::select("CALL sp_update_pagos()");
            $now = Carbon::now();

             //FACTURAS PENDIENTES DE COBRO POR CAJA
            $cuotas_pagar = DB::table('cuotas as c')
            ->join('cuotas_det as cdet','cdet.cuota_id','=','c.id')
            ->join('clientes as cli','cli.id','=','c.cliente_id')
            //->join('ventas as v','v.id','=','c.factura_id')
            ->select('c.id','c.cliente_id','c.precio_inm as total','c.pagos_cuo as pagado','c.saldo_cuo as saldo',
            'cli.nombre as nombre','cdet.fec_vto as fecha','c.factura')
            ->where('cdet.estado_cuota','=',"P")
            ->orderby('cdet.fec_vto','desc')
            ->get();
            //dd($cuotas_pagar);

        return view('index',["cheques_recibidos"=>$cheques_recibidos,
            "cheques_emitidos"=>$cheques_emitidos,"now"=>$now,"cuotas_pagar"=>$cuotas_pagar]);
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->dob = date('Y-m-d', strtotime($request->get('dob')));

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            if (file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
            $user->avatar = '/images/' . $avatarName;
        }
        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'isSuccess' => true,
                'Message' => "User Details Updated successfully!"
            ], 200); // Status code here
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json([
                'isSuccess' => true,
                'Message' => "Something went wrong!"
            ], 200); // Status code here
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code 
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }
}
