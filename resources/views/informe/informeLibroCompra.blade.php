@extends('layouts.master')

@section('title') Libro IVA Compras Ley 125/91 - Contribuyente: {{$empresa}} - 
    Periodo: 
    @if($date1 == "No Determinado" || $date2 == "No Determinado")
        "No Determinado"
    @else
        {{ date('d-m-Y', strtotime($date1)) }} a {{ date('d-m-Y', strtotime($date2)) }} 
    @endif
@endsection

@section('css') 
        <!-- DataTables -->        
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.css')}}">
        <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <style>
            .btn-toolbar {
                display: none !important;
            }
        </style>
@endsection

@section('content')
@component('components.breadcrumb')
        @slot('li_1') INICIO @endslot
        @slot('title') Libro Iva Compras    @endslot
    @endcomponent
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">                  
                            <form id="fecha_comp" action="{{route('informeLibroCompra')}}" method="POST"> 
                                {{csrf_field()}}      
                                <h4>Rango de fecha</h4><br/>                      
                                <label class="col-md-3 form-control-label" for="loteamiento">Seleccione Fechas</label>
                                <div class="row mb-4">
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Inicio</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha1" name="fecha1" class="form-control">
                                    </div>
                                    <label for="horizontal-firstname-input" class="col-sm-1 col-form-label">Fin</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                    </div>
                                    <input type="hidden" id="bandera" name="bandera" class="form-control" value=1>

                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-primary float-left"><i class="fa fa-file fa-1x"></i> Filtrar</button>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <div class="row mb-2">
                                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Empresa</label>
                                        <div class="col-sm-4">
                                            <select style= "width:280px" class="form-control" name="empresa_id" id="empresa_id">  
                                                <option readonly value="0">Seleccionar</option>                
                                                @foreach($empresas as $s)                                    
                                                    <option value="{{$s->id}}">{{$s->nombre}}</option>                                        
                                                @endforeach
                                            </select>                                
                                        </div>
                                    </div>
                                </div>
                                <br> <br>                                    
                            </form>                         
                        <div>
                        @if($fac != "VACIO")
                            <h3>Libro IVA Compras Ley 125/91</h3>
                            <h4>Contribuyente: {{$empresa}}</h4>
                            @if($date1 == "No Determinado" || $date2 == "No Determinado")
                                <h4>Periodio: No determinado</h4>
                            @else
                                <h4>Periodo: {{ date('d-m-Y', strtotime($date1)) }} a {{ date('d-m-Y', strtotime($date2)) }}</h4>
                            @endif
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100">                                                            
                                        <thead>  
                                            <tr>
                                                <th data-priority="1">Fecha</th>
                                                <th data-priority="1">Documento</th>
                                                <th data-priority="1">Numero</th>
                                                <th data-priority="1">Timbrado</th>
                                                <th data-priority="1">Razón Social</th>
                                                <th data-priority="1">Ruc</th>
                                                <th data-priority="1">Gravada 10%</th>
                                                <th data-priority="1">Gravada 5%</th>
                                                <th data-priority="1">Imp. 10%</th>                                            
                                                <th data-priority="1">Imp. 5%</th>
                                                <th data-priority="1">Exentas</th>
                                                <th data-priority="1">Total</th>
                                                <th data-priority="1">Mon</th>
                                                <th data-priority="1">Condicion</th>
                                                <th data-priority="1">Cuotas</th>
                                            </tr>
                                        </thead>
                                        @php 
                                            $total10 = 0;
                                            $total5 = 0;
                                            $total_iva10 = 0;
                                            $total_iva5 = 0;
                                            $total_exenta = 0;
                                            $total_gral = 0;   
                                        @endphp
                                        <tbody id="comrobantes">
                                            @foreach($fac as $c)
                                            <tr>  
                                                <td>{{ date('d-m-Y', strtotime($c->fecha)) }}</td>   
                                                <td>{{$c->tipo_com}}</td> 
                                                <td>{{$c->fact_compra}}</td>  
                                                <td>{{$c->timbrado}}</td>
                                                <td>{{$c->nombre}}</td>
                                                <td>{{$c->ruc}}</td>
                                                <td>{{number_format(($c->grabado10), 2, ",", ".")}}</td>
                                                <td>{{number_format(($c->grabado5), 2, ",", ".")}}</td>
                                                <td>{{number_format(($c->iva10), 2, ",", ".")}}</td>
                                                <td>{{number_format(($c->iva5), 2, ",", ".")}}</td>
                                                <td>{{number_format(($c->total_exe), 2, ",", ".")}}</td>
                                                <td>{{number_format(($c->total), 2, ",", ".")}}</td>
                                                <td>{{$c->moneda}}</td>
                                                <td>{{$c->condicion}}</td>
                                                <td>1</td>
                                            
                                                @php 
                                                    $total10 = $total10 + $c->grabado10;
                                                    $total5 = $total5 + $c->grabado5;
                                                    $total_iva10 = $total_iva10 + $c->iva10;
                                                    $total_iva5 = $total_iva5 + $c->iva5;
                                                    $total_exenta =  $total_exenta + $c->total_exe;
                                                    $total_gral = $total_gral + $c->total;   
                                                @endphp
                                            </tr>  
                                        @endforeach
                                        <tr class="table-dark">       
                                                <td>Totales</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{number_format(($total10), 2, ",", ".")}}</td>
                                                <td>{{number_format(($total5), 2, ",", ".")}}</td>
                                                <td>{{number_format(($total_iva10), 2, ",", ".")}}</td>
                                                <td>{{number_format(($total_iva5), 2, ",", ".")}}</td>
                                                <td>{{number_format(($total_exenta), 2, ",", ".")}}</td>
                                                <td>{{number_format(($total_gral), 2, ",", ".")}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr> 
                                        </tbody>                                    
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div><br>             
    </main>

@endsection
@section('script')
    
        
   <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script> 
        <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection