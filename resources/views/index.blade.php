@extends('layouts.master')

@section('title') @lang('translation.Dashboards') @endsection
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
        @slot('li_1') Sistema de Gestión de Cobros @endslot
        @slot('title') TAVA @endslot
    @endcomponent
   
    <main class="main">
            <!-- Breadcrumb -->
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <h2>Bienvenido</h2><br/>
                </div>
            </div>
                <div class="card-body">
                    <h4>Facturas por cobrar por caja</h4><br/>
                    <div class="table-rep-plugin">
                        <div id="encabezado" class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>                            
                                        <tr>                              
                                        <th  data-priority="1">N° Fact</th>
                                        <th  data-priority="1">Cliente</th> 
                                        <th  data-priority="1">Fecha</th> 
                                        <th  data-priority="1">Total Fact</th>
                                        <th  data-priority="1">Total Pagado</th>
                                        <th  data-priority="1">Saldo a Pagar</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($cuotas_pagar as $c)                                       
                                        <tr style ='color:red' >
                                            <td>{{$c->factura}}</td>
                                            <td>{{$c->nombre}}</td>
                                            <td>{{$c->fecha}}</td>
                                            <td>{{number_format(($c->total), 0, ",", ".")}}</td>
                                            <td>{{number_format(($c->pagado), 0, ",", ".")}}</td>
                                            <td>{{number_format(($c->saldo), 0, ",", ".")}}</td>
                                        </tr>
                                @endforeach                                
                                </tbody>
                            </table>                                
                        </div> 
                    </div>  
                </div>  
                <div class="card-body">
                    <h4>Totales de Compras y Ventas del Mes</h4><br/>
                    <div class="table-rep-plugin">
                        <div id="encabezado" class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>                            
                                        <tr>                              
                                        <th  data-priority="1">N° Fact</th>
                                        <th  data-priority="1">Cliente</th> 
                                        <th  data-priority="1">Fecha</th> 
                                        <th  data-priority="1">Total Fact</th>
                                        <th  data-priority="1">Total Pagado</th>
                                        <th  data-priority="1">Saldo a Pagar</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($cuotas_pagar as $c)                                       
                                        <tr style ='color:red' >
                                            <td>{{$c->factura}}</td>
                                            <td>{{$c->nombre}}</td>
                                            <td>{{$c->fecha}}</td>
                                            <td>{{number_format(($c->total), 0, ",", ".")}}</td>
                                            <td>{{number_format(($c->pagado), 0, ",", ".")}}</td>
                                            <td>{{number_format(($c->saldo), 0, ",", ".")}}</td>
                                        </tr>
                                @endforeach                                
                                </tbody>
                            </table>                                
                        </div> 
                    </div>  
                </div>                        
            </div>
        </div>
    </main>

@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/rwd-table/rwd-table.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/table-responsive.init.js')}}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/producto/show.js') }}"></script>
    {{-- <script src="{{ URL::asset('/assets/js/inmueble/cuotas.js') }}"></script> --}}
    <script src="{{ URL::asset('/assets/js/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
        <!-- Table Editable plugin -->
    <script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/table-editable.int.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/producto/show_tab.js') }}" defer></script>
    <script src="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" defer></script>
        
@endsection
