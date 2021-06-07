<template>
    <main class="main">
    <br><br>
    <div class="container-fluid">
    <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Area Completo
                <button v-if="listado" type="button" @click="ModalAgregarEditar('area','registrar')" class="btn btn-secondary">
                <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
                <label v-else></label>
            </div>
            <!--Listado-->
            <template v-if="listado">
            <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                  <input type="text" readonly class="form-control" placeholder="Nombre">  
                                    <input type="text" v-model="buscar" @keyup.enter="listarArea(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArea(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="area in arrayArea" :key="area.id">
                                    <td>
                                        <button type="button" @click="ModalAgregarEditar('area','actualizar',area)" class="btn btn-success btn-sm">
                                          <i class="icon-eye"></i>
                                        </button> &nbsp;
                                        <template v-if="area.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarArea(area.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarProducto(area.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="area.nombre"></td>
                                    <td v-text="area.descripcion"></td>
                                    <td>
                                        <div v-if="area.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
            </div>
            </template>
            <!--FinListado-->
            <!--Detalle-->
            <template v-else>
            <!--Agregar-->
            <div v-if="listado2" class="card-body">
                <!--Datos de area-->
                <div class="form-group row border">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Nombree</label>
                            <input type="text" class="form-control" v-model="nombre">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="">Descripcion</label>
                            <input type="text" class="form-control" v-model="descripcion">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div v-show="errorIngreso" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin datos de area-->
                <!--Inicio agregar producto-->
                <div class="form-group row border">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Producto <span style="color:red;" v-show="idproducto==0">Seleccione un producto</span></label>
                            <div class="form-inline">
                                <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarProducto()"  placeholder="Ingrese codigo de producto">
                                <button @click="abrirModal()" class="btn btn-primary">...</button>
                                <input type="text" readonly class="form-control" v-model="producto">                
                                <button @click="agregarDetalleProducto()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin agregar producto-->
                <!--Lista de productos agregados-->
                <div class="form-group row border">
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Codigo</th>
                                    <th>Producto</th>
                                    <th>Clase Producto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayDetalleProducto.length">
                                <tr v-for="(detallep,index) in arrayDetalleProducto" :key="detallep.id">
                                    <td>
                                        <button @click="eliminarDetalleProducto(index)" type="button" class="btn btn-danger btn-sm">
                                            <i class="icon-close"></i>
                                        </button>
                                    </td>
                                    <td v-text="detallep.codigo"></td>
                                    <td v-text="detallep.producto"></td>
                                    <td v-text="detallep.clase"></td>
                                    <td>
                                        <div v-if="detallep.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="5">
                                        No hay producto agregado
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Fin de lista de productos agregados-->
                <!--Inicio agregar sucursal-->
                <div class="form-group row border">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Sucursal <span style="color:red;" v-show="idsucursal==0">Seleccione un sucursal</span></label>
                            <div class="form-inline">
                                <input type="text" class="form-control" v-model="alias" @keyup.enter="buscarSucursal()"  placeholder="Ingrese alias de sucursal">
                                <button @click="abrirModal2()" class="btn btn-primary">...</button>
                                <input type="text" readonly class="form-control" v-model="sucursal">                
                                <button @click="agregarDetalleSucursal()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin agregar sucursal-->
                <!--Lista de productos agregados-->
                <div class="form-group row border">
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Alias</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayDetalleSucursal.length">
                                <tr v-for="(detalles,index) in arrayDetalleSucursal" :key="detalles.id">
                                    <td>
                                        <button @click="eliminarDetalleSucursal(index)" type="button" class="btn btn-danger btn-sm">
                                            <i class="icon-close"></i>
                                        </button>
                                    </td>
                                    <td v-text="detalles.sucursal"></td>
                                    <td v-text="detalles.alias"></td>
                                    <td v-text="detalles.tipo"></td>
                                    <td>
                                        <div v-if="detalles.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="5">
                                        No hay sucursales agregado
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Fin de lista de productos agregados-->
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="registrarIngreso2()">Guardar</button>
                    </div>
                </div>
            </div>
            <!--Editar-->
            <div v-else class="card-body">
                <!--Datos de area-->
                <div class="form-group row border">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input type="text" readonly class="form-control" v-model="nombre">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="">Descripcion</label>
                            <input type="text" readonly class="form-control" v-model="descripcion">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div v-show="errorIngreso" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin datos de area-->
                <!--Inicio agregar producto-->
                <!--
                <div class="form-group row border">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Producto <span style="color:red;" v-show="idproducto==0">Seleccione un producto</span></label>
                            <div class="form-inline">
                                <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarProducto()"  placeholder="Ingrese codigo de producto">
                                <button @click="abrirModal()" class="btn btn-primary">...</button>
                                <input type="text" readonly class="form-control" v-model="producto">                
                                <button @click="agregarDetalleProducto()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <!--Fin agregar producto-->
                <!--Lista de productos agregados-->
                <div class="form-group row border">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Producto</label>
                        </div>
                    </div>

                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Producto</th>
                                    <th>Clase Producto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayDetalleProducto.length">
                                <tr v-for="detallep in arrayDetalleProducto" :key="detallep.id">
                                    <td v-text="detallep.codigo"></td>
                                    <td v-text="detallep.producto"></td>
                                    <td v-text="detallep.clase"></td>
                                    <td>
                                        <div v-if="detallep.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="5">
                                        No hay producto agregado
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Fin de lista de productos agregados-->
                <!--Inicio agregar sucursal-->
                <!--
                <div class="form-group row border">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Sucursal <span style="color:red;" v-show="idsucursal==0">Seleccione un sucursal</span></label>
                            <div class="form-inline">
                                <input type="text" class="form-control" v-model="alias" @keyup.enter="buscarSucursal()"  placeholder="Ingrese alias de sucursal">
                                <button @click="abrirModal2()" class="btn btn-primary">...</button>
                                <input type="text" readonly class="form-control" v-model="sucursal">                
                                <button @click="agregarDetalleSucursal()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <!--Fin agregar sucursal-->
                <!--Lista de sucursales agregados-->
                <div class="form-group row border">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Sucursal</label>
                        </div>
                    </div>
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Alias</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayDetalleSucursal.length">
                                <tr v-for="detalles in arrayDetalleSucursal" :key="detalles.id">
                              <!--      <td>
                                        <button @click="eliminarDetalleSucursal(index)" type="button" class="btn btn-danger btn-sm">
                                            <i class="icon-close"></i>
                                        </button>
                                    </td>
                                -->
                                    <td v-text="detalles.sucursal"></td>
                                    <td v-text="detalles.alias"></td>
                                    <td v-text="detalles.tipo"></td>
                                    <td>
                                        <div v-if="detalles.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="5">
                                        No hay sucursales agregado
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Fin de lista de productos agregados-->
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>
                     <!--   <button type="button" class="btn btn-primary" @click="actualizarAreaPrueba(),actualizarPrueba2()">Actualizar</button>  -->
                    </div>
                </div>
            </div>
            </template>
            <!--Fin detalle-->

        </div>
                <!-- Fin ejemplo de tabla Listado -->
    </div>
            <!--Inicio del modal producto-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="codigo">Codigo</option>
                                        <option value="idclase">Clase</option>
                                        </select>
                                        <select v-if="criterioA==='idclase'" class="form-control col-md-6" v-model="buscarA" @click="listarProducto(buscarA,criterioA)">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="clas in arrayClase" :key="clas.id" :value="clas.id" v-text="clas.nombre"></option>
                                        </select>
                                        
                                        <input v-else type="text" v-model="buscarA" @keyup.enter="listarProducto(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarProducto(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Clase Producto</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="producto in arrayProducto" :key="producto.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleProductoModal(producto)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="producto.codigo"></td>
                                            <td v-text="producto.nombre"></td>
                                            <td v-text="producto.nombre_clase"></td>
                                            <td>
                                                <div v-if="producto.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <!--Fin del modal-->
             <!--Inicio del modal sucursal-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal2}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal2"></h4>
                            <button type="button" class="close" @click="cerrarModal2()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioB">
                                        <option value="nombre">Nombre</option>
                                        <option value="alias">Alias</option>
                                        <option value="tipo">Tipo</option>
                                        </select>     
                                        <select v-if="criterioB==='tipo'" class="form-control col-md-6" v-model="buscarB" @click="listarSucursal(buscarB,criterioB)">
                                        <option value="Sucursal">Sucursal</option>
                                        <option value="Franquicia">Franquicia</option>
                                        </select>     
                                        <input v-else type="text" v-model="buscarB" @keyup.enter="listarSucursal(buscarB,criterioB)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarSucursal(buscarB,criterioB)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Nombre</th>
                                            <th>Alias</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="sucursal in arraySucursal" :key="sucursal.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleSucursalModal(sucursal)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="sucursal.nombre"></td>
                                            <td v-text="sucursal.alias"></td>
                                            <td v-text="sucursal.tipo"></td>
                                            <td>
                                                <div v-if="sucursal.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal2()">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            
</main>
            <!--Fin del modal-->
</template>

<script>
    export default {
        data (){
            return {
                arrayArea : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                listado:1,
                listado2:1,
                //Datos de areea
                id:0,
                descripcion:'',
                nombre:'',
                //Datos de producto
                arrayProducto:[],
                idproducto:0,
                producto:'', //Nombre del producto
                codigo:'', 
                condicion:0,
                arrayDetalleProducto:[],
                //Datos de clase
                idclase:0,
                clase:'', //Nombre de clase
                //Datos de modal listar producto
                modal : 0,
                tituloModal : '',
                criterioA:'nombre',
                buscarA:'',

                tipoAccion : 0,
                preciosucursal : 0,
                preciofranquicia : 0,
                condiciontemporada: 0,
                producto_id: 0,
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
                prueba:1,

                idsucursal:0,
                sucursal:'',
                alias:'',
                ubicaion:'',
                tipo:'',
                estadosucursal:0,
                arraySucursal:[],
                arrayDetalleSucursal:[],
                modal2 : 0,
                tituloModal2 : '',
                criterioB:'nombre',
                buscarB:''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarProducto(page,buscar,criterio);
            },
            listarArea(page,buscar,criterio){
                let me=this;
                var url= '/area?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArea = respuesta.areas.data;
                    me.pagination= respuesta.pagination;
                /*    me.arrayDetalleProducto=[];
                    me.arrayDetalleSucursal=[];
                    me.producto='';
                    me.sucursal='';*/
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            //Inicio Producto
            buscarProducto(){
                let me =this;
                var url='/producto/buscarProducto?filtro=' + me.codigo;
                axios.get(url).then(function(response){
                    var respuesta=response.data;
                    me.arrayProducto=respuesta.productos;
                    if(me.arrayProducto.length>0){
                        me.producto=me.arrayProducto[0]['nombre'];
                        me.idproducto=me.arrayProducto[0]['id'];
                        me.idclase=me.arrayProducto[0]['idclase'];
                        me.clase=me.arrayProducto[0]['nombre_clase']
                        me.condicion=me.arrayProducto[0]['condicion']
                    }
                    else{
                        me.producto='no existe producto';
                        me.idproducto=0;
                        me.idclase=0;
                        me.clase='';
                        me.condicion=0;
                    }
                })
            },
            selectClase(){
                let me=this;
                var url= '/clase/selectClase';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayClase = respuesta.clases;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            encuentraDetalleP(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalleProducto.length;i++){
                    if(this.arrayDetalleProducto[i].idproducto==id){
                        sw=true;
                    }
                }
                return sw;
            },
            agregarDetalleProducto(){
                let me = this;

                if(me.idproducto==0 || me.idclase==0){
                //if(me.idproducto==0){
                }
                else{
                    if(me.encuentraDetalleP(me.idproducto)){
                        swal({
                            type:'error',
                            title:'error...',
                            text: 'Producto ya ingresado',
                        })
                    }
                    else{
                        me.arrayDetalleProducto.push({
                        idproducto: me.idproducto,
                        producto: me.producto,
                        idclase: me.idclase,
                        clase: me.clase,
                        codigo: me.codigo,
                        condicion:me.condicion
                        });
                        me.codigo="",
                        me.idproducto=0,
                        me.producto="",
                        me.idclase=0,
                        me.clase="",
                        me.condicion=0
                    }                    

                }
            },
            eliminarDetalleProducto(index){
                let me= this;
                me.arrayDetalleProducto.splice(index,1);
            },
            listarProducto (buscar,criterio){
                let me=this;
                var url= '/producto/listar?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            agregarDetalleProductoModal(data=[]){
                let me = this;
                if(me.encuentraDetalleP(data['id'])){
                        swal({
                            type:'error',
                            title:'error...',
                            text: 'Producto ya ingresado',
                        })
                    }
                    else{
                        me.arrayDetalleProducto.push({
                        idproducto: data['id'],
                        producto: data['nombre'],
                        idclase: data['idclase'],
                        clase: data['nombre_clase'],
                        codigo: data['codigo'],
                        condicion: data['condicion']
                        });
                    } 

            },
            registrarIngreso(){
                if (this.validarIngreso()){
                    return;
                }
                
                let me = this;

                axios.post('/area/registrar',{
                    'nombre': this.nombre,
                    'descripcion':this.descripcion,
                    'data':this.arrayDetalleProducto,
                    'data2':this.arrayDetalleSucursal
                }).then(function (response) {
                    me.listado=1;
                    me.listarArea(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });

            },
            validarIngreso(){
                this.errorIngreso=0;
                this.errorMostrarMsjIngreso =[];
                
                if (!this.nombre) this.errorMostrarMsjIngreso.push("El nombre no puede estar vacío.");
                if (!this.descripcion) this.errorMostrarMsjIngreso.push("La descripcion no puede estar vacío.");
                if (this.arrayDetalleProducto.length<=0) this.errorMostrarMsjIngreso.push("Ingrese producto")
                if (this.arrayDetalleSucursal.length<=0) this.errorMostrarMsjIngreso.push("Ingrese sucursal")
                if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

                return this.errorIngreso;
            },
            registrarIngreso2(){
                    if (this.validarIngreso()){
                        return;
                    }

               swal({
                title: '¿Esta seguro de crear el area?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    let me = this;
                    axios.post('/area/registrar',{
                    'nombre': this.nombre,
                    'descripcion':this.descripcion,
                    'data':this.arrayDetalleProducto,
                    'data2':this.arrayDetalleSucursal
                    }).then(function (response) {
                        me.listado=1;
                        me.listarArea(1,'','nombre');
                        me.nombre='';
                        me.descripcion='';
                        swal(
                        '¡Creado!',
                        'El registro ha sido creado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });  
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) { 
                }
                }) 
            },
            /*
            actualizarArea(){
                //    if (this.validarIngreso()){
                //        return;
                 //   }

               swal({
                title: '¿Esta seguro de actualizar el area?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    let me = this;
                    axios.put('/area/actualizar',{
                    'nombre': this.nombre,
                    'descripcion':this.descripcion,
                    'id':this.id,
                    'data':this.arrayDetalleProducto,
                    'data2':this.arrayDetalleSucursal
                    }).then(function (response) {
                        me.listado=1;
                        me.listarArea(1,'','nombre');
                        me.nombre='';
                        me.descripcion='';
                        swal(
                        '¡Actualizado!',
                        'El registro ha sido modificado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });  
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) { 
                }
                }) 
            },
            actualizarAreaPrueba(){

            if (this.validarIngreso()){
                    return;
               }
                let me = this;

                axios.put('/area/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'id': this.id
                }).then(function (response) {
                    me.listado=1;
                    me.listarArea(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            actualizarPrueba2(){

                let me = this;

                axios.post('/area/actualizar2',{
                    'datas':this.arrayDetalleProducto,
                    'datas2':this.arrayDetalleSucursal,
                    'id': this.id
                }).then(function (response) {
                }).catch(function (error) {
                    console.log(error);
                }); 
            },*/
            ocultarDetalle(){
                this.listado=1;
                this.arrayDetalleProducto=[];
                this.arrayDetalleSucursal=[];
                this.producto='';
                this.sucursal='';
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },
            abrirModal(){
                this.arrayProducto=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios productos';
            },
            //Fin Producto
            

            //Inicio Sucursal
            buscarSucursal(){
                let me =this;
                var url='/sucursal/buscarSucursal?filtro=' + me.alias;
                axios.get(url).then(function(response){
                    var respuesta=response.data;
                    me.arraySucursal=respuesta.sucursales;
                    if(me.arraySucursal.length>0){
                        me.idsucursal=me.arraySucursal[0]['id'];
                        me.sucursal=me.arraySucursal[0]['nombre'];
                        me.alias=me.arraySucursal[0]['alias'];
                        me.tipo=me.arraySucursal[0]['tipo'];
                        me.estadosucursal=me.arraySucursal[0]['condicion'];
                    }
                    else{
                        me.sucursal='no existe sucursal';
                        me.idsucursal=0;
                        me.sucursal='';
                        me.alias='';
                        me.tipo='';
                        me.estadosucursal=0;
                    }
                })
            },
            encuentraDetalleS(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalleSucursal.length;i++){
                    if(this.arrayDetalleSucursal[i].idsucursal==id){
                        sw=true;
                    }
                }
                return sw;
            },
            agregarDetalleSucursal(){
                let me = this;

                if(me.idsucursal==0){
                }
                else{
                    if(me.encuentraDetalleS(me.idsucursal)){
                        swal({
                            type:'error',
                            title:'error...',
                            text: 'Sucursal ya ingresado',
                        })
                    }
                    else{
                        me.arrayDetalleSucursal.push({
                        idsucursal: me.idsucursal,
                        sucursal: me.sucursal,
                        alias: me.alias,
                        tipo: me.tipo,
                        estado: me.estadosucursal
                        });
                        me.sucursal="",
                        me.idsucursal=0,
                        me.alias="",
                        me.estadosucursal=0
                    }                    

                }
            },
            eliminarDetalleSucursal(index){
                let me= this;
                me.arrayDetalleSucursal.splice(index,1);
            },
            listarSucursal (buscar,criterio){
                let me=this;
                var url= '/sucursal/listar?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySucursal = respuesta.sucursales.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            agregarDetalleSucursalModal(data=[]){
                let me = this;
                if(me.encuentraDetalleS(data['id'])){
                        swal({
                            type:'error',
                            title:'error...',
                            text: 'Sucursal ya ingresado',
                        })
                    }
                    else{
                        me.arrayDetalleSucursal.push({
                        idsucursal: data['id'],
                        sucursal: data['nombre'],
                        alias: data['alias'],
                        tipo: data['tipo'],
                        estado: data['condicion']
                        });
                    } 

            },
            cerrarModal2(){
                this.modal2=0;
                this.tituloModal2='';
            },
            abrirModal2(){
                this.arraySucursal=[];
                this.modal2 = 1;
                this.tituloModal2 = 'Seleccione uno o varias sucursales';
            },

            buscarSucursalData(){
                let me =this;
                var url='/area/obtenerdetalle?id=' + me.id;
                axios.get(url).then(function(response){
                    var respuesta=response.data;
                    me.arrayDetalleSucursal=respuesta.detalles;
                })
                
            },
            buscarProductoData(){
                let me =this;
                var url='/area/obtenerdetalle2?id=' + me.id;
                axios.get(url).then(function(response){
                    var respuesta=response.data;
                    me.arrayDetalleProducto=respuesta.detalles;
                })
                
            },
            ModalAgregarEditar(modelo, accion, data = []){
                switch(modelo){
                    case "area":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.listado=0;
                                this.listado2=1;
                                this.nombre= '';
                                this.descripcion = '';
                                this.arrayDetalleProducto=[];
                                this.arrayDetalleSucursal=[];
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.listado=0;
                                this.listado2=0;
                                this.id = data['id'];
                                this.nombre = data['nombre'];
                                this.descripcion=data['descripcion'];
                                this.buscarSucursalData();
                                this.buscarProductoData();
                                break;
                            }
                        }
                    }
                }
            },
            desactivarArea(id){
               swal({
                title: '¿Esta seguro de Eliminar esta Area?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/area/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listado=1;
                        me.listarArea(1,'','nombre');
                        swal(
                        '¡Eliminado!',
                        'El registro ha sido eliminado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });  
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) { 
                }
                }) 
            }


        },
        mounted() {
            this.listarArea(1,this.buscar,this.criterio);
            this.selectClase();
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 300px){
        .btnagregar{
            margin-top: 0rem;
        }
    }
</style>
