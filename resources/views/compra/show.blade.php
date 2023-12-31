@extends('layouts.master')

@section('title') Detalle Compra @endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') Tables @endslot
        @slot('title') LABPROF GROUP @endslot
    @endcomponent
<main class="main">
 <!-- Breadcrumb -->
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <h2>Estado de Cuenta</h2><br/>                     
            </div>

            <div class="card-body">
                <h4 class="text-left">Detalle de Compra</h4><br/>
                <form id="form_venta" action="{{route('update_compra')}}" method="POST">
                    {{csrf_field()}} 
                    <input type="hidden" id="id_compra" name="id_compra" class="form-control" value="{{$compras->id_compra}}">  
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label"><b>Proveedor:</b></label>
                        <div class="col-md-3">
                                <p>{{$compras->nombre}}</p>     
                        </div>
                        <label class="col-md-2 form-control-label"><b>RUC:</b></label>
                        <div class="col-md-3">
                                <p>{{$compras->ruc}}</p>     
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label"><b>Factura N°:</b></label>
                        <div class="col-md-2">
                            <input type="text" id="fact_compra" name="fact_compra" class="form-control" value="{{$compras->fact_compra}}">              
                        </div>
                        <label class="col-md-2 form-control-label"><b>Timbrado N°:</b></label>
                        <div class="col-md-2">
                            <input type="text" id="timbrado" name="timbrado" class="form-control" value="{{$compras->timbrado}}">              
                        </div>  
                        <label class="col-md-2 form-control-label"><b>Fecha Timbrado:</b></label>
                        <div class="col-md-2">
                            <input type="date" id="fecha_timbrado" name="fecha_timbrado" class="form-control" value="{{$compras->fecha_timbrado}}">              
                        </div>                      
                    </div><br>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label"><b>Fecha de Compra:</b></label>
                        <div class="col-md-3">
                            <input type="date" id="fecha" name="fecha" class="form-control" value="{{$compras->fecha}}">             
                        </div>
                        <label class="col-md-2 form-control-label"><b>Cargado a:</b></label>
                        <div class="col-md-3">
                            <select class="form-control" name="empresa_id" id="empresa_id">
                                @foreach($empresas as $e)
                                    <option value="{{$e->id}}" @php
                                            echo ($e->id==$empresa_id)?"selected":"";
                                        @endphp>{{$e->nombre}}</option>  
                                @endforeach  
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
        <div class="form-group row border">

              <h3>Detalle de Compras</h3>

              <div class="table-responsive col-md-12">
                <table id="detalles" class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr class="bg-info">
                            <th>Cantidad</th>
                            <th>Producto</th>
                            <th>Precio (Gs.)</th>     
                            <th>Descuento (Gs.)</th>                    
                            <th>SubTotal (Gs.)</th>
                        </tr>
                    </thead>
                    
                    <tfoot>

                        <tr>
                            <th  colspan="4"><p align="right">TOTAL:</p></th>
                            <th><p align="right">Gs. {{number_format(($compras->total), 0, ",", ".")}}</p></th>
                        </tr>

                        <tr>
                            <th colspan="4"><p align="right">TOTAL IMPUESTO (5%):</p></th>
                            <th><p align="right">Gs. {{number_format(($compras->iva5), 0, ",", ".")}}</p></th>
                        </tr>

                        <tr>
                            <th colspan="4"><p align="right">TOTAL IMPUESTO (10%):</p></th>
                            <th><p align="right">Gs. {{number_format(($compras->iva10), 0, ",", ".")}}</p></th>
                        </tr>

                        <tr>
                            <th colspan="4"><p align="right">TOTAL EXENTA:</p></th>
                            <th><p align="right">Gs. {{number_format(($compras->exenta), 0, ",", ".")}}</p></th>
                        </tr>

                        <tr>
                            <th  colspan="4"><p align="right">TOTAL PAGAR:</p></th>
                            <th><p align="right">Gs. {{number_format($compras->total, 0, ",", ".")}}</p></th>
                        </tr> 

                    </tfoot>

                    <tbody>
                    
                    @foreach($detalles as $det)

                        <tr>
                        <td>{{$det->cantidad}}</td>
                        <td>{{$det->producto}}</td>
                        <td>Gs. {{number_format(($det->precio), 0, ",", ".")}}</td>
                        <td>Gs. {{number_format(($det->descuento), 0, ",", ".")}}</td>
                        <td>Gs. {{number_format((($det->cantidad*$det->precio)- $det->descuento), 0, ",", ".")}}</td>
                        </tr> 

                    @endforeach
                    
                    </tbody>
                     
                </table>
              </div>
            
            </div>

               
            </div> 
             <div class="card-body">
                 <h4 class="text-left">Detalle de Pagos</h4><br/>
                  <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">                               
                                    <thead>                               
                                        <tr>
                                            <th data-priority="1">Fecha</th>
                                            <th data-priority="1">Tot. Pag</th>
                                            <th data-priority="1">Efectivo</th>
                                            <th data-priority="1">Transf</th>
                                            <th data-priority="1">Cheque</th>
                                            <th data-priority="1">T. Debito</th>
                                            <th data-priority="1">T. Crédito</th>
                                        </tr>    
                                    </thead>
                                    @php
                                        $totaldia = 0;
                                        $totalefe = 0;
                                        $totaltran = 0;
                                        $totalche = 0;
                                        $totaltd = 0;
                                        $totaltc = 0;   
                                        $saldopago = 0;                
                                    @endphp
                                    <tbody>
                                    @if($pagos=="Vacio")
                                        <tr><td><h3>NO HUBO PAGOS</h3></td></tr>
                                        </tbody>
                                        @else
                                            @foreach($pagos as $ar)
                                                <tr>                                    
                                                    <td>{{ date('d-m-Y', strtotime($ar->fec_pag)) }}</td>
                                                    <td>{{number_format(($ar->total_pag), 0, ",", ".")}} </td>  
                                                    <td>{{number_format($ar->total_pagf, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagtr, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagch, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagtd, 0, ",", ".")}}</td>
                                                    <td>{{number_format($ar->total_pagtc, 0, ",", ".")}}</td>                          
                                                </tr>  
                                                @php
                                                    $totaldia=$totaldia + $ar->total_pag;  
                                                    $totalefe=$totalefe + $ar->total_pagf; 
                                                    $totaltran=$totaltran + $ar->total_pagtr; 
                                                    $totalche=$totalche + $ar->total_pagch; 
                                                    $totaltd=$totaltd + $ar->total_pagtd; 
                                                    $totaltc=$totaltc + $ar->total_pagtc;                                                       
                                                @endphp
                                        @endforeach
                                        <tr class="table-dark">  
     
                                            <td>Total</td>                                                 
                                            <td>Gs. {{number_format(($totaldia), 0, ",", ".")}}</td>  
                                            <td>Gs. {{number_format(($totalefe), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltran), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totalche), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltd), 0, ",", ".")}}</td> 
                                            <td>Gs. {{number_format(($totaltc), 0, ",", ".")}}</td>                                               
                                        </tr>
                                    </tbody>
                                    @endif

                                    @php
                                        $saldopago = $compras->total - $totaldia;
                                    @endphp
                                    <tr class="table-dark">  
                                            <td>Saldo a Pagar</td>                                                 
                                            <td>Gs. {{number_format(($saldopago), 0, ",", ".")}}</td>                                              
                                        </tr>
                                </table>
                            </div>
                        </div>
            </div>
        </div>  
    </div>
    <!-- Fin ejemplo de tabla Listado -->    
</main>

@endsection